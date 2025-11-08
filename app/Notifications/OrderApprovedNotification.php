<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderApprovedNotification extends Notification
{
    use Queueable;
    
    protected $order;
    
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    
    public function via($notifiable)
    {
        return ['database'];
    }
    
    public function toDatabase($notifiable)
    {
        return [
            'type' => 'order_approved',
            'message' => 'Đơn hàng #' . $this->order->id . ' của bạn đã được duyệt!',
            'order_id' => $this->order->id,
            'order_url' => route('orders.show', $this->order->id),
            'created_at' => now()->toDateTimeString(),
        ];
    }
}

