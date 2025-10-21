<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        // Hiển thị danh sách đơn thuê dựa trên bảng orders của người dùng hiện tại
        $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('rentals.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }
}
