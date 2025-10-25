<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePackage;
use Illuminate\Http\Request;
use App\Helpers\PermissionHelper;

class ServicePackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->ensureAdmin();
            return $next($request);
        });
    }

    protected function ensureAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!PermissionHelper::hasPermission('service_packages_manage')) {
            abort(403, 'Bạn không có quyền quản lý gói dịch vụ');
        }

        $packages = ServicePackage::ordered()->get();
        return view('admin.service-packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!PermissionHelper::hasPermission('service_packages_manage')) {
            abort(403, 'Bạn không có quyền quản lý gói dịch vụ');
        }

        return view('admin.service-packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!PermissionHelper::hasPermission('service_packages_manage')) {
            abort(403, 'Bạn không có quyền quản lý gói dịch vụ');
        }

        \Log::info('=== SERVICE PACKAGE CREATE START ===');

        $request->validate([
            'name' => 'required|string|min:3|max:100|unique:service_packages,name',
            'duration' => 'required|string',
            'description' => 'nullable|string|max:500',
            'features' => 'required|array|min:1',
            // allow empty/nullable individual feature inputs; we'll filter them server-side
            'features.*' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'button_text' => 'required|string|max:50',
            'button_icon' => 'nullable|string|max:255',
            'button_color' => 'required|string|max:255',
            // checkboxes send 'on' when checked; validate as nullable and normalize below
            'is_popular' => 'nullable',
            'is_active' => 'nullable',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->all();
        
        // Make sure duration is formatted correctly
        if (!str_contains($data['duration'], 'Tháng')) {
            $data['duration'] = $data['duration'] . ' Tháng';
        }
        
        $data['is_popular'] = $request->has('is_popular');
        $data['is_active'] = $request->has('is_active');

        // Lọc bỏ tính năng trống và reindex array
        if (isset($data['features'])) {
            \Log::info('Features before filter:', $data['features']);
            $data['features'] = array_values(array_filter($data['features'], function($feature) {
                return $feature !== null && $feature !== '' && trim($feature) !== '';
            }));
            \Log::info('Features after filter:', $data['features']);
        }

        // Sau khi lọc, đảm bảo còn ít nhất 1 tính năng hợp lệ
        if (empty($data['features']) || count($data['features']) < 1) {
            return redirect()->back()
                ->withErrors(['features' => 'Vui lòng nhập ít nhất một tính năng hợp lệ.'])
                ->withInput();
        }

        // Kiểm tra trùng tính năng
        if (isset($data['features']) && count($data['features']) !== count(array_unique($data['features']))) {
            return redirect()->back()
                ->withErrors(['features' => 'Tính năng bị trùng nhau. Vui lòng kiểm tra lại.'])
                ->withInput();
        }

        try {
            $package = ServicePackage::create($data);
            \Log::info('Service package created successfully:', ['id' => $package->id, 'name' => $package->name]);
            return redirect()->route('admin.service-packages.index')
                ->with('success', 'Gói dịch vụ đã được tạo thành công!');
        } catch (\Exception $e) {
            \Log::error('Failed to create service package:', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withErrors(['error' => 'Có lỗi xảy ra khi tạo gói dịch vụ. Vui lòng thử lại.'])
                ->withInput();
        }
    }

    /**
     * AJAX endpoint to check if a package name already exists.
     */
    public function checkName(Request $request)
    {
        $name = $request->query('name');
        if (!$name) {
            return response()->json(['exists' => false]);
        }
        $exists = ServicePackage::where('name', $name)->exists();
        return response()->json(['exists' => $exists]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServicePackage $servicePackage)
    {
        if (!PermissionHelper::hasPermission('service_packages_manage')) {
            abort(403, 'Bạn không có quyền quản lý gói dịch vụ');
        }

        return view('admin.service-packages.show', compact('servicePackage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServicePackage $servicePackage)
    {
        if (!PermissionHelper::hasPermission('service_packages_manage')) {
            abort(403, 'Bạn không có quyền quản lý gói dịch vụ');
        }

        // Debug: Log features when loading edit form
        \Log::info('=== LOADING EDIT FORM ===');
        \Log::info('Service Package ID: ' . $servicePackage->id);
        \Log::info('Features in edit form:', $servicePackage->features);
        \Log::info('=== END LOADING EDIT ===');

        return view('admin.service-packages.edit', compact('servicePackage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServicePackage $servicePackage)
    {
        if (!PermissionHelper::hasPermission('service_packages_manage')) {
            abort(403, 'Bạn không có quyền quản lý gói dịch vụ');
        }

        // Debug: Log request data
        \Log::info('=== UPDATE REQUEST RECEIVED ===');
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request data:', $request->all());

        try {
            $request->validate([
                'name' => 'required|string|min:3|max:100|unique:service_packages,name,' . $servicePackage->id,
                'duration' => 'required|string',
                'description' => 'nullable|string|max:500',
                'features' => 'required|array|min:1',
                'features.*' => 'nullable|string|max:255',
                'icon' => 'nullable|string|max:255',
                'button_text' => 'required|string|max:50',
                'button_icon' => 'nullable|string|max:255',
                'button_color' => 'required|string|max:255',
                'is_popular' => 'nullable',
                'is_active' => 'nullable',
                'sort_order' => 'integer|min:0'
            ]);
            \Log::info('Validation passed');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            throw $e;
        }

        try {
            $data = $request->all();
            $data['is_popular'] = $request->has('is_popular');
            $data['is_active'] = $request->has('is_active');

            // Lọc bỏ tính năng trống và reindex array
            if (isset($data['features'])) {
                \Log::info('Features before filter:', $data['features']);
                $data['features'] = array_values(array_filter($data['features'], function($feature) {
                    return $feature !== null && $feature !== '' && trim($feature) !== '';
                }));
                \Log::info('Features after filter:', $data['features']);
            }

            // Make sure duration is formatted correctly
            if (!str_contains($data['duration'], 'Tháng')) {
                $data['duration'] = $data['duration'] . ' Tháng';
            }

            \Log::info('=== UPDATING SERVICE PACKAGE ===');
            \Log::info('Original features from DB:', $servicePackage->features);
            \Log::info('Request features:', $request->input('features', []));
            \Log::info('Processed features after filter:', $data['features'] ?? []);

            $servicePackage->update($data);
            
            // Debug: Log after update
            $servicePackage->refresh();
            \Log::info('Features after update:', $servicePackage->features);
            \Log::info('=== END UPDATE ===');

            return redirect()->route('admin.service-packages.index')
                ->with('success', 'Gói dịch vụ đã được cập nhật thành công!');
        } catch (\Exception $e) {
            \Log::error('Failed to update service package:', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withErrors(['error' => 'Có lỗi xảy ra khi cập nhật gói dịch vụ. Vui lòng thử lại.'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServicePackage $servicePackage)
    {
        if (!PermissionHelper::hasPermission('service_packages_manage')) {
            abort(403, 'Bạn không có quyền quản lý gói dịch vụ');
        }

        $servicePackage->delete();

        return redirect()->route('admin.service-packages.index')
            ->with('success', 'Gói dịch vụ đã được xóa thành công!');
    }
}
