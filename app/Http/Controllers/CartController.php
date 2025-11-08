<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $items->sum('total_price');

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            // Allow 1,6,12,18,24 month options (match frontend selectors)
            'rental_duration' => 'required|in:1,6,12,18,24',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($data['product_id']);
        $duration = (int)$data['rental_duration'];
        $quantity = max((int)($data['quantity'] ?? 1), 1);

        $pricePerPeriod = $product->getPriceByMonths($duration) ?: 0;
        $total = $pricePerPeriod; // tổng giá cho cả kỳ (đã là giá theo kỳ)

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $existingCart = Cart::where([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rental_duration' => $duration,
        ])->first();

        if ($existingCart) {
            // Nếu đã có, cập nhật số lượng
            $newQuantity = $existingCart->quantity + $quantity;
            $existingCart->update([
                'quantity' => $newQuantity,
                'total_price' => $pricePerPeriod * $newQuantity,
            ]);
            $item = $existingCart;
        } else {
            // Nếu chưa có, tạo mới
            $item = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'rental_duration' => $duration,
                'quantity' => $quantity,
                'price_per_month' => $pricePerPeriod,
                'total_price' => $total,
            ]);
        }

        if ($existingCart) {
            return redirect()->route('cart.index')->with('success', 'Đã cập nhật số lượng trong giỏ hàng');
        } else {
            return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng');
        }
    }

    public function update(Request $request, Cart $cart)
    {
        $this->authorizeItem($cart);

        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Debug: Log thông tin trước khi update
        \Log::info('Cart update debug', [
            'cart_id' => $cart->id,
            'old_quantity' => $cart->quantity,
            'new_quantity' => $data['quantity'],
            'price_per_month' => $cart->price_per_month,
            'old_total' => $cart->total_price,
            'new_total' => $cart->price_per_month * $data['quantity']
        ]);

        // Cập nhật số lượng và tính lại tổng giá
        $cart->update([
            'quantity' => $data['quantity'],
            'total_price' => $cart->price_per_month * $data['quantity'],
        ]);

        // Refresh cart item để lấy dữ liệu mới
        $cart->refresh();

        return back()->with('success', 'Đã cập nhật giỏ hàng - Số lượng: ' . $data['quantity'] . ', Tổng: ' . number_format($cart->price_per_month * $data['quantity']) . 'đ');
    }

    public function remove(Cart $cart)
    {
        $this->authorizeItem($cart);
        $cart->delete();
        return back()->with('success', 'Đã xóa khỏi giỏ hàng');
    }

    protected function authorizeItem(Cart $cart)
    {
        abort_unless($cart->user_id === Auth::id(), 403);
    }
}
