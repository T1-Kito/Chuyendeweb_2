<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function markAllRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Đã đánh dấu tất cả thông báo đã đọc!');
    }
    
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            return back()->with('success', 'Đã đánh dấu đã đọc!');
        }
        return back()->with('error', 'Không tìm thấy thông báo!');
    }
}

