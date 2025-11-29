<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureAdmin();
        
        // Kiểm tra quyền quản lý danh mục
        if (!\App\Helpers\PermissionHelper::hasPermission('categories_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }
        
        // Phân trang: 5 danh mục / trang
        $categories = Category::orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(5)
            ->withQueryString();

        // Kiểm tra nếu trang không tồn tại
        $page = $request->input('page');

        // Kiểm tra xem page có hợp lệ không (phải là số nguyên dương)
        if ($request->has('page') && (!is_numeric($page) || $page < 1)) {
            return redirect()->route('admin.categories.index', ['page' => 1])
                ->with('error', 'Giá trị trang không hợp lệ. Đã chuyển về trang đầu tiên.');
        }

        // Nếu page là số hợp lệ nhưng vượt quá trang cuối
        if ($request->has('page') && $categories->currentPage() > $categories->lastPage()) {
            return redirect()->route('admin.categories.index', ['page' => $categories->lastPage() ?: 1])
                ->with('error', 'Trang không tồn tại. Đã chuyển về trang cuối cùng.');
        }

        // Thống kê tổng quan
        $totalCategories = Category::count();
        $activeCategories = Category::where('is_active', true)->count();
        
        return view('admin.categories.index', compact('categories', 'totalCategories', 'activeCategories'));
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
            'description' => 'nullable|string|max:2500',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0|max:99999999',
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
        
        // Kiểm tra xem danh mục có bị thay đổi gần đây không (optimistic locking)
        if ($request->has('original_updated_at')) {
            $originalUpdatedAt = $request->input('original_updated_at');
            
            // Refresh category từ database để lấy dữ liệu mới nhất
            $category->refresh();
            $currentUpdatedAt = $category->updated_at->format('Y-m-d H:i:s');
            
            if ($originalUpdatedAt !== $currentUpdatedAt) {
                // Redirect về trang edit để load dữ liệu mới từ database
                return redirect()->route('admin.categories.edit', $category)
                    ->with('error', 'Danh mục đã được cập nhật gần đây. Trang đã được refresh với dữ liệu mới nhất!');
            }
        }
        
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:2500',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0|max:99999999',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('status', 'Danh mục đã được cập nhật thành công!');
    }

    public function destroy($categoryId)
    {
        $this->ensureAdmin();
        
        // Kiểm tra danh mục có tồn tại không
        $category = Category::find($categoryId);
        if (!$category) {
            return back()->with('error', 'Danh mục đã bị xóa. Trang đã được refresh với dữ liệu mới nhất!');
        }
        
        // Kiểm tra xem có sản phẩm nào thuộc danh mục này không
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục này vì có sản phẩm đang sử dụng.');
        }
        
        $category->delete();
        return back()->with('status', 'Danh mục đã được xóa thành công!');
    }

    public function deleteNotAllowed()
    {
        abort(404);
    }
}
