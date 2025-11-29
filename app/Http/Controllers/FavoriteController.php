<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggle(Request $request, $product)
    {
        try {
            // Tìm product theo ID hoặc slug
            if (is_numeric($product)) {
                $product = Product::findOrFail($product);
            } else {
                $product = Product::where('slug', $product)->orWhere('id', $product)->firstOrFail();
            }
            
            $user = auth()->user();
            
            // Kiểm tra xem đã yêu thích chưa
            $favorite = Favorite::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->first();

            if ($favorite) {
                // Nếu đã yêu thích thì xóa
                $favorite->delete();
                $isFavorited = false;
                $message = 'Đã bỏ yêu thích sản phẩm.';
            } else {
                // Nếu chưa yêu thích thì thêm
                Favorite::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                ]);
                $isFavorited = true;
                $message = 'Đã thêm vào danh sách yêu thích.';
            }

            // Luôn trả về JSON cho AJAX requests
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'is_favorited' => $isFavorited,
                    'message' => $message,
                ]);
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('Error toggling favorite', [
                'error' => $e->getMessage(),
                'product_id' => $product->id ?? null,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra. Vui lòng thử lại.',
                ], 500);
            }

            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
        }
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Validate pagination
        $perPage = $request->input('per_page', 20);
        if (!is_numeric($perPage) || $perPage < 1 || $perPage > 100) {
            $perPage = 20;
        }

        // Lấy danh sách sản phẩm yêu thích
        $favorites = $user->favoriteProducts()
            ->with(['category'])
            ->orderBy('favorites.created_at', 'desc')
            ->paginate((int)$perPage)
            ->withQueryString();

        return view('favorites.index', compact('favorites'));
    }
}
