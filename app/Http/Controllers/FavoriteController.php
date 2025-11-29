<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Toggle favorite status for a product
     */
    public function toggle(Request $request, $product)
    {
        try {
            // Find product by ID or slug
            $productModel = Product::where('id', $product)
                ->orWhere('slug', $product)
                ->firstOrFail();

            $user = auth()->user();
            
            // Check if already favorited
            $favorite = Favorite::where('user_id', $user->id)
                ->where('product_id', $productModel->id)
                ->first();

            if ($favorite) {
                // Remove from favorites
                $favorite->delete();
                $isFavorited = false;
                $message = 'Đã bỏ yêu thích sản phẩm.';
            } else {
                // Add to favorites
                Favorite::create([
                    'user_id' => $user->id,
                    'product_id' => $productModel->id,
                ]);
                $isFavorited = true;
                $message = 'Đã thêm vào yêu thích.';
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'is_favorited' => $isFavorited,
                    'message' => $message
                ]);
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Favorite toggle error: ' . $e->getMessage(), [
                'product' => $product,
                'user_id' => auth()->id(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra. Vui lòng thử lại.'
                ], 500);
            }

            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
        }
    }

    /**
     * Display user's favorite products
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $favorites = Favorite::where('user_id', $user->id)
            ->with(['product.category'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }
}
