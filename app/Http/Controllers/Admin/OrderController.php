<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\OrderApprovedNotification;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureAdmin();

        // Kiểm tra quyền xem đơn hàng
        if (!\App\Helpers\PermissionHelper::hasPermission('orders_view')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }

        $query = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->paginate(15)->withQueryString();
        $statuses = ['pending', 'confirmed', 'processing', 'completed', 'cancelled'];

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    // Thêm method mới để quản lý khách thuê
    public function rentals(Request $request)
    {
        $this->ensureAdmin();

        // Truy vấn danh sách đơn hàng theo thời gian thuê để hiển thị cho quản trị
        $query = Order::with(['user', 'items.product'])
            ->orderBy('rental_start_date', 'desc');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Rental status filter
        if ($request->filled('rental_status')) {
            switch($request->rental_status) {
                case 'active':
                    $query->where('rental_start_date', '<=', now())
                          ->where('rental_end_date', '>=', now());
                    break;
                case 'expired':
                    $query->where('rental_end_date', '<', now());
                    break;
                case 'upcoming':
                    $query->where('rental_start_date', '>', now());
                    break;
                case 'expiring_soon':
                    $query->where('rental_end_date', '>=', now())
                          ->where('rental_end_date', '<=', now()->addDays(7));
                    break;
            }
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('rental_start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('rental_end_date', '<=', $request->date_to);
        }

        $orders = $query->paginate(15);
        $rentalStatuses = [
            'active' => 'Đang thuê',
            'expired' => 'Hết hạn',
            'upcoming' => 'Chưa bắt đầu',
            'expiring_soon' => 'Sắp hết hạn (7 ngày)'
        ];

        return view('admin.orders.rentals', compact('orders', 'rentalStatuses'));
    }

    public function show(Order $order)
    {
        $this->ensureAdmin();

        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->ensureAdmin();

        // Kiểm tra quyền chỉnh sửa đơn hàng
        if (!\App\Helpers\PermissionHelper::hasPermission('orders_edit')) {
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền chỉnh sửa đơn hàng!'
                ], 403);
            }
            return back()->with('error', 'Bạn không có quyền chỉnh sửa đơn hàng!');
        }

        try {
            $request->validate([
                'status' => 'required|in:pending,confirmed,processing,completed,cancelled',
                'notes' => 'nullable|string|max:1000'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Gửi notification cho user khi đơn hàng được duyệt (confirmed, processing, completed)
        if (in_array($request->status, ['confirmed', 'processing', 'completed']) && $oldStatus !== $request->status) {
            if ($order->user) {
                $order->user->notify(new OrderApprovedNotification($order));
            }
        }

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái đơn hàng thành công'
            ]);
        }

        return back()->with('status', 'Cập nhật trạng thái đơn hàng thành công');
    }

    public function updateRental(Request $request, Order $order)
    {
        $this->ensureAdmin();

        // Kiểm tra quyền chỉnh sửa đơn hàng
        if (!\App\Helpers\PermissionHelper::hasPermission('orders_edit')) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền chỉnh sửa đơn hàng!'
                ], 403);
            }
            return back()->with('error', 'Bạn không có quyền chỉnh sửa đơn hàng!');
        }

        $request->validate([
            'rental_start_date' => 'required|date',
            'rental_end_date' => 'required|date|after_or_equal:rental_start_date',
            'notes' => 'nullable|string|max:1000'
        ]);

        $oldStartDate = $order->rental_start_date;
        $oldEndDate = $order->rental_end_date;

        $order->update([
            'rental_start_date' => $request->rental_start_date,
            'rental_end_date' => $request->rental_end_date,
            'total_months' => \Carbon\Carbon::parse($request->rental_start_date)
                ->diffInMonths(\Carbon\Carbon::parse($request->rental_end_date)),
            'notes' => $request->notes ? ($order->notes ? $order->notes . "\n\n[Gia hạn] " . $request->notes : "[Gia hạn] " . $request->notes) : $order->notes
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thời gian thuê thành công'
            ]);
        }

        return back()->with('status', 'Cập nhật thời gian thuê thành công');
    }

    public function destroy(Order $order)
    {
        $this->ensureAdmin();

        // Kiểm tra quyền xóa đơn hàng
        if (!\App\Helpers\PermissionHelper::hasPermission('orders_delete')) {
            return back()->with('error', 'Bạn không có quyền xóa đơn hàng!');
        }

        // Chỉ cho phép xóa đơn hàng có trạng thái "Chờ xác nhận"
        if ($order->status !== 'pending') {
            return back()->with('error', 'Chỉ có thể xóa đơn hàng ở trạng thái "Chờ xác nhận"');
        }

        try {
            DB::beginTransaction();

            // Delete order items first
            $order->items()->delete();

            // Delete order
            $order->delete();

            DB::commit();

            return redirect()->route('admin.orders.index')->with('status', 'Xóa đơn hàng thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting order: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi xóa đơn hàng: ' . $e->getMessage());
        }
    }

    protected function ensureAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }
    }
}
