<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        // Hiển thị danh sách đơn thuê dựa trên bảng orders của người dùng hiện tại
        // Chỉ hiển thị đơn hàng đã được admin duyệt (confirmed, processing, completed)
        $query = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->whereIn('status', ['confirmed', 'processing', 'completed'])
            ->orderBy('created_at', 'desc');

        // Search filter - tìm kiếm theo mã hợp đồng, tên người thuê, SĐT, email, thiết bị
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhereHas('items.product', function($productQuery) use ($search) {
                      $productQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('model', 'like', "%{$search}%")
                                   ->orWhere('serial_number', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter - lọc theo trạng thái hợp đồng (Đang hiệu lực / Hết hiệu lực)
        if ($request->filled('status')) {
            $now = now();
            if ($request->status === 'active') {
                // Đang hiệu lực: rental_start_date <= now <= rental_end_date
                $query->where('rental_start_date', '<=', $now)
                      ->where('rental_end_date', '>=', $now);
            } elseif ($request->status === 'expired') {
                // Hết hiệu lực: rental_end_date < now
                $query->where('rental_end_date', '<', $now);
            }
        }

        // Date range filter - lọc theo khoảng thời gian hiệu lực hoặc ngày hết hạn
        if ($request->filled('date_from')) {
            $query->where(function($q) use ($request) {
                $q->where('rental_start_date', '>=', $request->date_from)
                  ->orWhere('rental_end_date', '>=', $request->date_from);
            });
        }
        if ($request->filled('date_to')) {
            $query->where(function($q) use ($request) {
                $q->where('rental_start_date', '<=', $request->date_to)
                  ->orWhere('rental_end_date', '<=', $request->date_to);
            });
        }

        $orders = $query->paginate(10);

        return view('rentals.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Kiểm tra quyền truy cập
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Kiểm tra đơn hàng đã được duyệt chưa
        if (!in_array($order->status, ['confirmed', 'processing', 'completed'])) {
            return redirect()->route('rentals.index')
                ->with('error', 'Đơn hàng này chưa được duyệt hoặc đã bị hủy. Vui lòng liên hệ admin để biết thêm chi tiết.');
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }
}
