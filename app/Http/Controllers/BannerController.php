<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $this->ensureAdmin();
        
        // Kiểm tra quyền quản lý banner
        if (!\App\Helpers\PermissionHelper::hasPermission('banners_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }
        
        $banners = Banner::orderBy('sort_order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        $this->ensureAdmin();
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();
        
        \Log::info('Banner creation started', [
            'request_data' => $request->all(),
            'has_file' => $request->hasFile('image'),
            'file_info' => $request->file('image') ? [
                'name' => $request->file('image')->getClientOriginalName(),
                'size' => $request->file('image')->getSize(),
                'mime' => $request->file('image')->getMimeType()
            ] : 'No file'
        ]);
        
        try {
            $data = $request->validate([
                'image' => ['required','image','mimes:jpeg,png,jpg,gif,webp','max:10240'],
                'sort_order' => ['nullable','integer','min:0'],
                'is_active' => ['nullable','boolean'],
            ]);

            \Log::info('Validation passed', $data);

            // Ensure the banners directory exists
            $bannersPath = storage_path('app/public/banners');
            if (!file_exists($bannersPath)) {
                mkdir($bannersPath, 0755, true);
            }

            // Store file using the public disk
            $path = $request->file('image')->store('banners', 'public');
            \Log::info('File stored at: ' . $path);
            \Log::info('Full storage path: ' . storage_path('app/public/' . $path));
            
            // Check if file actually exists
            $fullPath = storage_path('app/public/' . $path);
            if (file_exists($fullPath)) {
                \Log::info('File exists at: ' . $fullPath);
                \Log::info('File size: ' . filesize($fullPath) . ' bytes');
            } else {
                \Log::error('File does not exist at: ' . $fullPath);
            }

            $banner = Banner::create([
                'title' => 'Banner ' . now()->format('Y-m-d H:i'),
                'image_path' => '/storage/' . $path,
                'link_url' => null,
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => $request->has('is_active'),
            ]);

            \Log::info('Banner created successfully', $banner->toArray());

            return redirect()->route('admin.banners.index')->with('status','Đã thêm banner thành công!');
        } catch (\Exception $e) {
            \Log::error('Banner creation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Lỗi tạo banner: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Banner $banner)
    {
        $this->ensureAdmin();
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $this->ensureAdmin();
        $data = $request->validate([
            'title' => ['nullable','string','max:255'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg,gif,webp'],
            'link_url' => ['nullable','url'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_active' => ['nullable','boolean'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $banner->image_path = '/storage/' . $path;
        }
        $banner->title = $data['title'] ?? null;
        $banner->link_url = $data['link_url'] ?? null;
        $banner->sort_order = $data['sort_order'] ?? 0;
        $banner->is_active = $request->has('is_active');
        $banner->save();

        return redirect()->route('admin.banners.index')->with('status','Đã cập nhật banner');
    }

    public function destroy(Banner $banner)
    {
        $this->ensureAdmin();
        $banner->delete();
        return back()->with('status','Đã xóa banner');
    }
}


