<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureAdmin();
        
        // Kiểm tra quyền quản lý sản phẩm
        if (!\App\Helpers\PermissionHelper::hasPermission('products_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }

        $query = Product::with('category');

        // Tìm kiếm theo tên / model / mô tả
        if ($search = trim((string) $request->get('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Lọc theo danh mục
        if ($categoryId = $request->get('category_id')) {
            $query->where('category_id', $categoryId);
        }

        // Lọc theo trạng thái kích hoạt
        if ($status = $request->get('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sắp xếp
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('name');
                break;
            case 'price':
                // ưu tiên price_6_months, fallback monthly_price nếu cần
                $query->orderByRaw('COALESCE(price_6_months, monthly_price, 0) asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        // Phân trang: 10 sản phẩm / trang
        $products = $query->paginate(10)->withQueryString();

        // Kiểm tra nếu trang không tồn tại
        // Lấy tham số page từ request
        $page = $request->input('page');

        // Kiểm tra xem page có hợp lệ không (phải là số nguyên dương)
        if ($request->has('page') && (!is_numeric($page) || $page < 1)) {
            return redirect()->route('admin.products.index', [
                'search' => $request->search,
                'category_id' => $request->category_id,
                'status' => $request->status,
                'sort' => $request->sort,
                'page' => 1
            ])->with('error', 'Giá trị trang không hợp lệ. Đã chuyển về trang đầu tiên.');
        }

        // Nếu page là số hợp lệ nhưng vượt quá trang cuối
        if ($request->has('page') && $products->currentPage() > $products->lastPage()) {
            return redirect()->route('admin.products.index', [
                'search' => $request->search,
                'category_id' => $request->category_id,
                'status' => $request->status,
                'sort' => $request->sort,
                'page' => $products->lastPage() ?: 1
            ])->with('error', 'Trang không tồn tại. Đã chuyển về trang cuối cùng.');
        }

        // Thống kê tổng quan
        $totalProducts   = Product::count();
        $activeProducts  = Product::where('is_active', true)->count();
        $featuredProducts = Product::where('is_featured', true)->count();

        $categories = Category::where('is_active', true)->get();
        return view('admin.products.index', compact(
            'products',
            'categories',
            'totalProducts',
            'activeProducts',
            'featuredProducts'
        ));
    }

    public function create()
    {
        $this->ensureAdmin();
        
        // Kiểm tra quyền quản lý sản phẩm
        if (!\App\Helpers\PermissionHelper::hasPermission('products_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }
        
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2500',
            'features' => 'nullable|string|max:2500',
            'category_id' => 'required|exists:categories,id',
            'model' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'daily_price' => 'nullable|numeric|min:0|max:99999999.99',
            'weekly_price' => 'nullable|numeric|min:0|max:99999999.99',
            'monthly_price' => 'nullable|numeric|min:0|max:99999999.99',
            'stock_quantity' => 'required|integer|min:0|max:99999999',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            
            // Thông tin thuê mới
            'min_rental_months' => 'required|integer|min:1|max:60',
            'price_1_month' => 'nullable|numeric|min:0|max:99999999.99',
            'price_6_months' => 'nullable|numeric|min:0|max:99999999.99',
            'price_12_months' => 'nullable|numeric|min:0|max:99999999.99',
            'price_18_months' => 'nullable|numeric|min:0|max:99999999.99',
            'price_24_months' => 'nullable|numeric|min:0|max:99999999.99',
            
            // Khuyến mãi
            'promotion_badge' => 'nullable|string|min:0|max:100',
            'promotion_description' => 'nullable|string|max:2500',
            'promotion_start_date' => 'nullable|date|before_or_equal:promotion_end_date',
            'promotion_end_date' => 'nullable|date|after_or_equal:promotion_start_date',
            
            // Bảo hành
            'warranty_info' => 'nullable|string|max:2500',
            'has_warranty_support' => 'boolean',
            
            // Thông tin bổ sung
            'rental_terms' => 'nullable|string|max:2500',
            'delivery_info' => 'nullable|string|max:255',
            'specs' => 'nullable|string|max:2500',
            'serial_number' => 'nullable|string|max:255|unique:products,serial_number',
        ]);

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = '/storage/' . $path;
        }

        // Tạo slug duy nhất
        $data['slug'] = Product::generateUniqueSlug($data['name']);

        // Xử lý boolean fields
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');
        $data['has_warranty_support'] = $request->has('has_warranty_support');

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'Sản phẩm đã được tạo thành công!');
    }

    public function edit(Product $product)
    {
        $this->ensureAdmin();
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->ensureAdmin();
        
        // Kiểm tra xem sản phẩm có bị thay đổi gần đây không (optimistic locking)
        if ($request->has('original_updated_at')) {
            $originalUpdatedAt = $request->input('original_updated_at');
            
            // Refresh product từ database để lấy dữ liệu mới nhất
            $product->refresh();
            $currentUpdatedAt = $product->updated_at->format('Y-m-d H:i:s');
            
            if ($originalUpdatedAt !== $currentUpdatedAt) {
                // Redirect về trang edit để load dữ liệu mới từ database
                return redirect()->route('admin.products.edit', $product)
                    ->with('error', 'Sản phẩm đã được cập nhật gần đây. Trang đã được refresh với dữ liệu mới nhất!');
            }
        }
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2500',
            'features' => 'nullable|string|max:2500',
            'category_id' => 'required|exists:categories,id',
            'model' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_image' => 'nullable|boolean',
            'daily_price' => 'nullable|numeric|min:0|max:99999999.99',
            'weekly_price' => 'nullable|numeric|min:0|max:99999999.99',
            'monthly_price' => 'nullable|numeric|min:0|max:99999999.99',
            'stock_quantity' => 'required|integer|min:0|max:99999999',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            
            // Thông tin thuê mới
            'min_rental_months' => 'required|integer|min:1|max:60',
            'price_1_month' => 'nullable|numeric|min:0|max:99999999.99',
            'price_6_months' => 'nullable|numeric|min:0|max:99999999.99',
            'price_12_months' => 'nullable|numeric|min:0|max:99999999.99',
            'price_18_months' => 'nullable|numeric|min:0|max:99999999.99',
            'price_24_months' => 'nullable|numeric|min:0|max:99999999.99',
            
            // Khuyến mãi
            'promotion_badge' => 'nullable|string|min:0|max:100',
            'promotion_description' => 'nullable|string|max:2500',
            'promotion_start_date' => 'nullable|date|before_or_equal:promotion_end_date',
            'promotion_end_date' => 'nullable|date|after_or_equal:promotion_start_date',
            
            // Bảo hành
            'warranty_info' => 'nullable|string|max:2500',
            'has_warranty_support' => 'boolean',
            
            // Thông tin bổ sung
            'rental_terms' => 'nullable|string|max:2500',
            'delivery_info' => 'nullable|string|max:255',
            'specs' => 'nullable|string|max:2500',
            'serial_number' => 'nullable|string|max:255|unique:products,serial_number,' . $product->id,
        ]);

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($product->image && Storage::disk('public')->exists(str_replace('/storage/', '', $product->image))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $product->image));
            }
            
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = '/storage/' . $path;
        } elseif ($request->has('remove_image')) {
            // Xóa ảnh hiện tại
            if ($product->image && Storage::disk('public')->exists(str_replace('/storage/', '', $product->image))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $product->image));
            }
            $data['image'] = null;
        }

        // Tạo slug duy nhất, bỏ qua chính sản phẩm hiện tại
        $data['slug'] = Product::generateUniqueSlug($data['name'], $product->id);

        // Xử lý boolean fields
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');
        $data['has_warranty_support'] = $request->has('has_warranty_support');

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'Sản phẩm đã được cập nhật thành công!');
    }

    public function destroy($productId)
    {
        $this->ensureAdmin();
        
        // Kiểm tra sản phẩm có tồn tại không
        $product = Product::find($productId);
        if (!$product) {
            return back()->with('error', 'Sản phẩm đã bị xóa. Trang đã được refresh với dữ liệu mới nhất!');
        }
        
        // Xóa ảnh
        if ($product->image && Storage::disk('public')->exists(str_replace('/storage/', '', $product->image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $product->image));
        }
        
        $product->delete();
        return back()->with('status', 'Sản phẩm đã được xóa thành công!');
    }

    public function deleteNotAllowed()
    {
        abort(404);
    }

}
