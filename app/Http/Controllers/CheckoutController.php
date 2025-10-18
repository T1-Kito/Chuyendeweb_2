<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function index()
    {
        $this->ensureAdmin();
        
        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();
            
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }
        
        $total = $cartItems->sum('total_price');
        
        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();
        
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'customer_address' => 'required|string',
            'rental_start_date' => 'required|date|after_or_equal:today',
            'payment_method' => 'required|in:cash,bank_transfer',
            'notes' => 'nullable|string',
        ]);

        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();
            
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'customer_address' => $request->customer_address,
                'notes' => $request->notes,
                'subtotal' => $cartItems->sum('total_price'),
                'total_amount' => $cartItems->sum('total_price'),
                'payment_method' => $request->payment_method,
                'rental_start_date' => $request->rental_start_date,
                'rental_end_date' => Carbon::parse($request->rental_start_date)->addMonths($cartItems->max('rental_duration')),
                'total_months' => $cartItems->max('rental_duration'),
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'product_description' => $cartItem->product->description,
                    'product_image' => $cartItem->product->image,
                    'rental_duration_months' => $cartItem->rental_duration,
                    'monthly_price' => $cartItem->product->monthly_price,
                    'total_price' => $cartItem->total_price,
                    'quantity' => $cartItem->quantity,
                ]);
            }

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi tạo đơn hàng. Vui lòng thử lại.');
        }
    }

    public function success(Order $order)
    {
        $this->ensureAdmin();
        
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('checkout.success', compact('order'));
    }

    // User-facing: list orders
    public function myOrders()
    {
        $this->ensureAdmin();
        $orders = Order::with('items.product')->where('user_id', auth()->id())->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // User-facing: show order (not admin route)
    public function show(Order $order)
    {
        $this->ensureAdmin();
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    protected function ensureAdmin(): void
    {
        if (!auth()->check()) {
            abort(403);
        }
    }
}
