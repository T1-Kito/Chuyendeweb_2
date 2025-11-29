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
            // duration received as integer months from form
            'duration' => 'required|integer|min:1|max:60',
            'description' => 'nullable|string|max:500',
            'features' => 'required|array|min:1',
            // allow empty/nullable individual feature inputs; we'll filter them server-side
            'features.*' => 'nullable|string|max:255',
            'icon' => 'required|string|max:255',
            'button_text' => 'required|string|max:50',
            'button_icon' => 'nullable|string|max:255',
            'button_color' => 'required|string|max:255',
            // checkboxes send 'on' when checked; validate as nullable and normalize below
            'is_popular' => 'nullable',
            'is_active' => 'nullable',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->all();
        
        // Make sure duration is formatted correctly for storage (e.g., "6 Tháng")
        if (isset($data['duration'])) {
            // If it's numeric (integer), format as string with ' Tháng'
            if (is_numeric($data['duration'])) {
                $data['duration'] = intval($data['duration']) . ' Tháng';
            } else {
                // in case it's already string, try to extract number then format
                preg_match('/(\d+)/', $data['duration'], $m);
                $num = $m[1] ?? null;
                if ($num) {
                    $data['duration'] = intval($num) . ' Tháng';
                }
            }
        }
        
        $data['is_popular'] = $request->has('is_popular');
        // Default new packages to active so they appear on the homepage immediately unless explicitly unchecked
        $data['is_active'] = $request->has('is_active') ? true : true;

        // Ensure sort_order has a default
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = 0;
        }

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

        // Kiểm tra bản ghi còn tồn tại không (tránh update khi đã bị xóa ở tab khác)

        // Kiểm tra optimistic locking: nếu có trường original_updated_at, so sánh với updated_at hiện tại
        if ($request->has('original_updated_at')) {
            $originalUpdatedAt = $request->input('original_updated_at');
            $fresh = ServicePackage::find($servicePackage->id);
            if (!$fresh) {
                return back()->with('error', 'Gói dịch vụ đã bị xóa. Trang đã được refresh với dữ liệu mới nhất!');
            }
            $currentUpdatedAt = $fresh->updated_at ? $fresh->updated_at->format('Y-m-d H:i:s') : null;
            if ($originalUpdatedAt !== $currentUpdatedAt) {
                // Trả về lại trang hiện tại với thông báo lỗi (giống chức năng xóa)
                return back()->with('error', 'Gói dịch vụ đã được cập nhật gần đây. Trang đã được refresh với dữ liệu mới nhất!');
            }
        } else {
            $fresh = ServicePackage::find($servicePackage->id);
            if (!$fresh) {
                return back()->with('error', 'Gói dịch vụ đã bị xóa. Trang đã được refresh với dữ liệu mới nhất!');
            }
        }

        // Validate dữ liệu đầu vào, kiểm tra khoảng trắng và chiều dài
        $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'unique:service_packages,name,' . $servicePackage->id,
                function($attribute, $value, $fail) {
                    if (trim($value) === '' || preg_match('/^\s+$/u', $value)) {
                        $fail('Tên gói không được chỉ chứa khoảng trắng.');
                    }
                }
            ],
            'duration' => 'required|integer|min:1|max:60',
            'description' => ['nullable','string','max:500'],
            'features' => 'required|array|min:1',
            'features.*' => ['nullable','string','max:255',function($attribute, $value, $fail){if(trim($value)==='' && $value!==null){$fail('Tính năng không được chỉ chứa khoảng trắng.');}}],
            'icon' => ['required','string','max:255',function($attribute, $value, $fail){if(trim($value)==='' || preg_match('/^\s+$/u',$value)){$fail('Icon không được chỉ chứa khoảng trắng.');}}],
            'button_text' => ['required','string','max:50',function($attribute, $value, $fail){if(trim($value)==='' || preg_match('/^\s+$/u',$value)){$fail('Nút không được chỉ chứa khoảng trắng.');}}],
            'button_icon' => ['nullable','string','max:255'],
            'button_color' => ['required','string','max:255',function($attribute, $value, $fail){if(trim($value)==='' || preg_match('/^\s+$/u',$value)){$fail('Màu nút không được chỉ chứa khoảng trắng.');}}],
            'is_popular' => 'nullable',
            'is_active' => 'nullable',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->all();
        $data['is_popular'] = $request->has('is_popular');
        $data['is_active'] = $request->has('is_active');

        // Lọc bỏ tính năng trống và reindex array
        if (isset($data['features'])) {
            $data['features'] = array_values(array_filter($data['features'], function($feature) {
                return $feature !== null && $feature !== '' && trim($feature) !== '';
            }));
        }

        // Kiểm tra trùng tính năng
        if (isset($data['features']) && count($data['features']) !== count(array_unique($data['features']))) {
            return redirect()->back()
                ->withErrors(['features' => 'Tính năng bị trùng nhau. Vui lòng kiểm tra lại.'])
                ->withInput();
        }

        // Make sure duration is formatted correctly for storage (e.g., "6 Tháng")
        if (isset($data['duration'])) {
            if (is_numeric($data['duration'])) {
                $data['duration'] = intval($data['duration']) . ' Tháng';
            } else {
                preg_match('/(\d+)/', $data['duration'], $m);
                $num = $m[1] ?? null;
                if ($num) {
                    $data['duration'] = intval($num) . ' Tháng';
                }
            }
        }

        try {
            $servicePackage->update($data);
            $servicePackage->refresh();
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
    public function destroy($id)
    {
        if (!PermissionHelper::hasPermission('service_packages_manage')) {
            abort(403, 'Bạn không có quyền quản lý gói dịch vụ');
        }

        $servicePackage = ServicePackage::find($id);
        if (!$servicePackage) {
            return back()->with('error', 'Gói dịch vụ đã bị xóa. Trang đã được refresh với dữ liệu mới nhất!');
        }

        try {
            $servicePackage->delete();
            return back()->with('success', 'Gói dịch vụ đã được xóa thành công!');
        } catch (\Illuminate\Database\QueryException $qe) {
            \Log::warning('Failed to delete service package due to DB constraint', ['id' => $id, 'error' => $qe->getMessage()]);
            return back()->with('error', 'Không thể xóa gói dịch vụ vì nó đang được sử dụng ở nơi khác.');
        } catch (\Exception $e) {
            \Log::error('Failed to delete service package', ['id' => $id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Có lỗi xảy ra khi xóa gói dịch vụ. Vui lòng thử lại sau.');
        }
    }
}
