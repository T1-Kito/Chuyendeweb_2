<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Rating;

class RatingApprovedNotification extends Notification
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
            'type' => 'rating_approved',
            'message' => 'Đánh giá của bạn cho sản phẩm "' . ($this->rating->product->name ?? '') . '" đã được duyệt!',
            'product_name' => $this->rating->product->name ?? '',
            'product_id' => $this->rating->product_id,
            'product_url' => route('products.show', $this->rating->product->slug ?? $this->rating->product_id),
            'rating_id' => $this->rating->id,
            'stars' => $this->rating->stars,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}

