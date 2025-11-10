<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\User;
use App\Notifications\NewCartNotification;

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

        // Suggestions: recommend some active products not already in cart
        $inCartIds = $items->pluck('product_id')->all();
        $suggestions = Product::query()
            ->where('is_active', true)
            ->when(!empty($inCartIds), fn($q) => $q->whereNotIn('id', $inCartIds))
            ->orderByDesc('is_featured')
            ->latest('id')
            ->limit(6)
            ->get();

        // Voucher handling: if applied, re-validate and recalc discount based on current total
        $appliedVoucher = session('applied_voucher');
        $voucher = null;
        $discount = 0;
        $grandTotal = $total;
        if ($appliedVoucher && $total > 0) {
            $voucher = Voucher::where('code', $appliedVoucher['code'] ?? null)->first();
            if ($voucher) {
                $discount = (float) $voucher->calculateDiscount($total);
                if ($discount <= 0) {
                    // Remove invalid voucher silently and notify user
                    session()->forget('applied_voucher');
                    session()->flash('error', 'Voucher không còn hợp lệ và đã được gỡ bỏ.');
                } else {
                    $grandTotal = max(0, $total - $discount);
                }
            } else {
                session()->forget('applied_voucher');
            }
        }

        return view('cart.index', compact('items', 'total', 'suggestions', 'voucher', 'discount', 'grandTotal'));
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
            // Load quan hệ để notification có đủ thông tin
            $item->load(['user', 'product']);
            
            // Gửi notification tới tất cả admin khi có giỏ hàng mới
            try {
                $admins = User::where('is_admin', true)->get();
                \Log::info('Sending cart notification to admins', [
                    'cart_id' => $item->id,
                    'admin_count' => $admins->count()
                ]);
                
                foreach ($admins as $admin) {
                    $admin->notify(new NewCartNotification($item));
                }
            } catch (\Exception $e) {
                \Log::error('Error sending cart notification', ['error' => $e->getMessage()]);
            }
            
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

    /**
     * Áp dụng mã voucher cho giỏ hàng hiện tại
     */
    public function applyVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $code = strtoupper(trim($request->input('code')));

        // Tính tổng hiện tại của giỏ
        $items = Cart::where('user_id', Auth::id())->get();
        $total = (float) $items->sum('total_price');

        if ($items->isEmpty() || $total <= 0) {
            return back()->with('error', 'Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi áp dụng voucher.');
        }

        $voucher = Voucher::whereRaw('UPPER(code) = ?', [$code])->first();

        if (!$voucher || !$voucher->isUsable()) {
            return back()->with('error', 'Mã voucher không hợp lệ hoặc đã hết hạn.');
        }

        $discount = (float) $voucher->calculateDiscount($total);
        if ($discount <= 0) {
            return back()->with('error', 'Đơn hàng chưa đáp ứng điều kiện để áp dụng voucher này.');
        }

        // Lưu thông tin voucher vào session (không tăng used_count đến khi thanh toán)
        session([
            'applied_voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'discount' => $discount,
            ]
        ]);

        return back()->with('success', 'Áp dụng voucher thành công.');
    }

    /**
     * Gỡ voucher khỏi giỏ hàng
     */
    public function removeVoucher(Request $request)
    {
        session()->forget('applied_voucher');
        return back()->with('success', 'Đã gỡ voucher.');
    }

    protected function authorizeItem(Cart $cart)
    {
        abort_unless($cart->user_id === Auth::id(), 403);
    }
}
