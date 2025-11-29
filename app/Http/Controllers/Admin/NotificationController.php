<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        // Validate pagination parameter (Test case 10: URL parameters)
        $perPage = $request->input('per_page', 20);
        if (!is_numeric($perPage) || $perPage < 1 || $perPage > 100) {
            $perPage = 20;
        }

        // Lấy tất cả notifications từ tất cả users
        $query = DB::table('notifications')
            ->orderByDesc('created_at');

        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Filter by read status
        if ($request->has('read_status') && $request->read_status != '') {
            if ($request->read_status == 'read') {
                $query->whereNotNull('read_at');
            } elseif ($request->read_status == 'unread') {
                $query->whereNull('read_at');
            }
        }

        // Search by user (notifiable)
        if ($request->has('search') && $request->search != '') {
            $search = trim($request->search);
            // Kiểm tra khoảng trắng (Test case 6)
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('notifiable_type', 'like', "%{$search}%")
                      ->orWhere('notifiable_id', 'like', "%{$search}%");
                });
            }
        }

        $notifications = $query->paginate((int)$perPage)->withQueryString();

        // Lấy thông tin user cho mỗi notification
        $notifications->getCollection()->transform(function ($notification) {
            $data = json_decode($notification->data, true);
            $notification->data_array = $data;
            $notification->message = $data['message'] ?? 'Thông báo';
            $notification->type_display = $this->getTypeDisplay($notification->type);
            
            // Lấy user info nếu có
            if ($notification->notifiable_type === 'App\\Models\\User') {
                $user = \App\Models\User::find($notification->notifiable_id);
                $notification->user = $user;
            }
            
            return $notification;
        });

        // Lấy danh sách các loại notification để filter
        $notificationTypes = DB::table('notifications')
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        return view('admin.notifications.index', compact('notifications', 'notificationTypes'));
    }

    public function destroy($id)
    {
        try {
            // Test case 1: Xóa mục không tồn tại (concurrent delete)
            // Test case 3: ID không tồn tại
            // Validate ID (notification ID là UUID)
            if (empty($id) || !is_string($id)) {
                return back()->with('error', 'ID không hợp lệ.');
            }

            $notification = DB::table('notifications')->where('id', $id)->first();
            
            // Kiểm tra xem notification có tồn tại không
            if (!$notification) {
                return back()->with('error', 'Thông báo này đã được xóa. Vui lòng tải lại trang.');
            }

            // Xóa notification
            DB::table('notifications')->where('id', $id)->delete();

            return back()->with('success', 'Đã xóa thông báo thành công.');
        } catch (\Exception $e) {
            \Log::error('Error deleting notification', [
                'error' => $e->getMessage(),
                'notification_id' => $id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Có lỗi xảy ra khi xóa thông báo. Vui lòng tải lại trang.');
        }
    }

    /**
     * Lấy tên hiển thị cho loại notification
     */
    private function getTypeDisplay($type)
    {
        $types = [
            'App\\Notifications\\NewCommentNotification' => 'Bình luận mới',
            'App\\Notifications\\NewRatingNotification' => 'Đánh giá mới',
            'App\\Notifications\\NewMessageNotification' => 'Tin nhắn mới',
            'App\\Notifications\\RatingApprovedNotification' => 'Đánh giá được duyệt',
            'App\\Notifications\\OrderApprovedNotification' => 'Đơn hàng được duyệt',
            'App\\Notifications\\NewCartNotification' => 'Giỏ hàng mới',
        ];

        return $types[$type] ?? $type;
    }
}

