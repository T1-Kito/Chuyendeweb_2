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
    public function index()
    {
        $this->ensureAdmin();
        
        // Kiểm tra quyền quản lý sản phẩm
        if (!\App\Helpers\PermissionHelper::hasPermission('products_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }
        
        $products = Product::with('category')->orderBy('created_at', 'desc')->get();
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.index', compact('products', 'categories'));
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
            'description' => 'required|string',
            'features' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'model' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'daily_price' => 'nullable|numeric|min:0',
            'weekly_price' => 'nullable|numeric|min:0',
            'monthly_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            
            // Thông tin thuê mới
            'min_rental_months' => 'required|integer|min:1|max:60',
            'price_1_month' => 'nullable|numeric|min:0',
            'price_6_months' => 'nullable|numeric|min:0',
            'price_12_months' => 'nullable|numeric|min:0',
            'price_18_months' => 'nullable|numeric|min:0',
            'price_24_months' => 'nullable|numeric|min:0',
            
            // Khuyến mãi
            'promotion_badge' => 'nullable|string|max:100',
            'promotion_description' => 'nullable|string',
            'promotion_start_date' => 'nullable|date',
            'promotion_end_date' => 'nullable|date|after_or_equal:promotion_start_date',
            
            // Bảo hành
            'warranty_info' => 'nullable|string|max:255',
            'has_warranty_support' => 'boolean',
            
            // Thông tin bổ sung
            'rental_terms' => 'nullable|string',
            'delivery_info' => 'nullable|string',
            'specs' => 'nullable|string',
            'serial_number' => 'nullable|string|max:255',
        ]);

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = '/storage/' . $path;
        }

        // Tạo slug
        $data['slug'] = Str::slug($data['name']);

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
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'model' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_image' => 'nullable|boolean',
            'daily_price' => 'nullable|numeric|min:0',
            'weekly_price' => 'nullable|numeric|min:0',
            'monthly_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            
            // Thông tin thuê mới
            'min_rental_months' => 'required|integer|min:1|max:60',
            'price_1_month' => 'nullable|numeric|min:0',
            'price_6_months' => 'nullable|numeric|min:0',
            'price_12_months' => 'nullable|numeric|min:0',
            'price_18_months' => 'nullable|numeric|min:0',
            'price_24_months' => 'nullable|numeric|min:0',
            
            // Khuyến mãi
            'promotion_badge' => 'nullable|string|max:100',
            'promotion_description' => 'nullable|string',
            'promotion_start_date' => 'nullable|date',
            'promotion_end_date' => 'nullable|date|after_or_equal:promotion_start_date',
            
            // Bảo hành
            'warranty_info' => 'nullable|string|max:255',
            'has_warranty_support' => 'boolean',
            
            // Thông tin bổ sung
            'rental_terms' => 'nullable|string',
            'delivery_info' => 'nullable|string',
            'specs' => 'nullable|string',
            'serial_number' => 'nullable|string|max:255',
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

        // Tạo slug
        $data['slug'] = Str::slug($data['name']);

        // Xử lý boolean fields
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');
        $data['has_warranty_support'] = $request->has('has_warranty_support');

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'Sản phẩm đã được cập nhật thành công!');
    }

    public function destroy(Product $product)
    {
        $this->ensureAdmin();
        
        // Xóa ảnh
        if ($product->image && Storage::disk('public')->exists(str_replace('/storage/', '', $product->image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $product->image));
        }
        
        $product->delete();
        return back()->with('status', 'Sản phẩm đã được xóa thành công!');
    }


}
