<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SerialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        // Chỉ admin có quyền quản lý sản phẩm mới có thể truy cập
        $this->middleware('permission:products_manage');
    }

    /**
     * Display the serial numbers management page
     */
    public function index()
    {
        // Kiểm tra quyền quản lý sản phẩm
        if (!\App\Helpers\PermissionHelper::hasPermission('products_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }
        
        // Lấy tất cả sản phẩm có số seri
        $products = Product::whereNotNull('serial_number')
            ->where('serial_number', '!=', '')
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Thống kê
        $stats = [
            'total_with_serial' => Product::whereNotNull('serial_number')
                ->where('serial_number', '!=', '')
                ->count(),
            'total_products' => Product::count(),
            'without_serial' => Product::where(function($query) {
                $query->whereNull('serial_number')
                      ->orWhere('serial_number', '');
            })->count()
        ];

        return view('admin.serials.index', compact('products', 'stats'));
    }

    /**
     * Show product details with serial number
     */
    public function show(Product $product)
    {
        // Kiểm tra quyền quản lý sản phẩm
        if (!\App\Helpers\PermissionHelper::hasPermission('products_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }

        // Kiểm tra sản phẩm có số seri không
        if (empty($product->serial_number)) {
            return back()->with('error', 'Sản phẩm này không có số seri!');
        }

        $product->load('category');

        return view('admin.serials.show', compact('product'));
    }

    /**
     * Update serial number for a product
     */
    public function update(Request $request, Product $product)
    {
        // Kiểm tra quyền quản lý sản phẩm
        if (!\App\Helpers\PermissionHelper::hasPermission('products_manage')) {
            return back()->with('error', 'Bạn không có quyền thực hiện thao tác này!');
        }

        $request->validate([
            'serial_number' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255'
        ]);

        try {
            $product->update([
                'serial_number' => $request->serial_number,
                'model' => $request->model
            ]);

            return back()->with('status', 'Cập nhật thông tin sản phẩm thành công!');
        } catch (\Exception $e) {
            \Log::error('Serial update error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Search products by serial number
     */
    public function search(Request $request)
    {
        // Kiểm tra quyền quản lý sản phẩm
        if (!\App\Helpers\PermissionHelper::hasPermission('products_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }

        $query = $request->get('q');
        
        if (empty($query)) {
            return redirect()->route('admin.serials.index');
        }

        $products = Product::whereNotNull('serial_number')
            ->where('serial_number', '!=', '')
            ->where(function($q) use ($query) {
                $q->where('serial_number', 'like', '%' . $query . '%')
                  ->orWhere('name', 'like', '%' . $query . '%')
                  ->orWhere('model', 'like', '%' . $query . '%');
            })
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_with_serial' => Product::whereNotNull('serial_number')
                ->where('serial_number', '!=', '')
                ->count(),
            'total_products' => Product::count(),
            'without_serial' => Product::where(function($query) {
                $query->whereNull('serial_number')
                      ->orWhere('serial_number', '');
            })->count()
        ];

        return view('admin.serials.index', compact('products', 'stats', 'query'));
    }
}

