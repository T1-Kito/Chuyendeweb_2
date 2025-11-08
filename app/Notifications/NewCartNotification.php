<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Cart;

class NewCartNotification extends Notification
{
    use Queueable;
    
    protected $cart;
    
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }
    
    public function via($notifiable)
    {
        return ['database'];
    }
    
    public function toDatabase($notifiable)
    {
        return [
            'type' => 'new_cart',
            'message' => ($this->cart->user->name ?? 'Người dùng') . ' đã thêm sản phẩm vào giỏ hàng',
            'user_name' => $this->cart->user->name ?? 'Người dùng',
            'product_name' => $this->cart->product->name ?? '',
            'product_id' => $this->cart->product_id,
            'product_url' => route('products.show', $this->cart->product->slug ?? $this->cart->product_id),
            'quantity' => $this->cart->quantity,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}

