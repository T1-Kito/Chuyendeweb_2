<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        // Hiển thị danh sách đơn thuê dựa trên bảng orders của người dùng hiện tại
        // Hiển thị tất cả đơn hàng không phân biệt trạng thái
        $query = Order::with('items.product')
            ->where('user_id', auth()->id())
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

        // Status filter - lọc theo trạng thái đơn hàng
        if ($request->filled('status')) {
            // Lọc theo trạng thái đơn hàng (pending, confirmed, processing, completed, cancelled)
            if (in_array($request->status, ['pending', 'confirmed', 'processing', 'completed', 'cancelled'])) {
                $query->where('status', $request->status);
            } else {
                // Lọc theo trạng thái thuê (active, expired) - giữ lại để tương thích
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

        $orders = $query->paginate(10)->withQueryString();

        return view('rentals.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Kiểm tra quyền truy cập
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        // Truyền backUrl để quay lại trang rentals khi truy cập từ rentals
        $backUrl = route('rentals.index');

        return view('orders.show', compact('order', 'backUrl'));
    }

    public function cancel(Request $request, Order $order)
    {
        // Kiểm tra quyền truy cập
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Chỉ cho phép hủy đơn hàng ở trạng thái pending
        if ($order->status !== 'pending') {
            return back()->with('error', 'Chỉ có thể hủy đơn hàng đang chờ xác nhận.');
        }

        $request->validate([
            'cancel_reason' => 'nullable|string|max:500'
        ]);

        // Cập nhật trạng thái và ghi chú
        $notes = $order->notes ? $order->notes . "\n\n[Hủy bởi khách hàng] " . ($request->cancel_reason ?: 'Khách hàng yêu cầu hủy đơn hàng') :
                 '[Hủy bởi khách hàng] ' . ($request->cancel_reason ?: 'Khách hàng yêu cầu hủy đơn hàng');

        $order->update([
            'status' => 'cancelled',
            'notes' => $notes
        ]);

        return back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }
}
