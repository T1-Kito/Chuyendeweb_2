<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $this->ensureAdmin();
        
        // Kiểm tra quyền quản lý danh mục
        if (!\App\Helpers\PermissionHelper::hasPermission('categories_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }
        
        $categories = Category::orderBy('sort_order', 'asc')->orderBy('name', 'asc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $this->ensureAdmin();
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();
        
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('status', 'Danh mục đã được tạo thành công!');
    }

    public function edit(Category $category)
    {
        $this->ensureAdmin();
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->ensureAdmin();
        
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('status', 'Danh mục đã được cập nhật thành công!');
    }

    public function destroy(Category $category)
    {
        $this->ensureAdmin();
        
        // Kiểm tra xem có sản phẩm nào thuộc danh mục này không
        if ($category->products()->count() > 0) {
            return back()->withErrors(['error' => 'Không thể xóa danh mục này vì có sản phẩm đang sử dụng.']);
        }
        
        $category->delete();
        return back()->with('status', 'Danh mục đã được xóa thành công!');
    }
}
