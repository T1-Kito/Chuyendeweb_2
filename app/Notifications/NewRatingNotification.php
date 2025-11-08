<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Rating;

class NewRatingNotification extends Notification
{
    use Queueable;
    
    protected $rating;
    
    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
    }
    
    public function via($notifiable)
    {
        return ['database'];
    }
    
    public function toDatabase($notifiable)
    {
        return [
            'type' => 'new_rating',
            'message' => ($this->rating->user->name ?? 'Người dùng') . ' đã đánh giá ' . $this->rating->stars . ' sao cho sản phẩm ' . ($this->rating->product->name ?? ''),
            'user_name' => $this->rating->user->name ?? 'Người dùng',
            'product_name' => $this->rating->product->name ?? '',
            'product_id' => $this->rating->product_id,
            'product_url' => route('products.show', $this->rating->product->slug ?? $this->rating->product_id),
            'stars' => $this->rating->stars,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}

