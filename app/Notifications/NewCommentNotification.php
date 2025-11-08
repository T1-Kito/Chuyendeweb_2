<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Comment;

class NewCommentNotification extends Notification
{
    use Queueable;
    
    protected $comment;
    
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
    
    public function via($notifiable)
    {
        return ['database'];
    }
    
    public function toDatabase($notifiable)
    {
        return [
            'type' => 'new_comment',
            'message' => ($this->comment->user->name ?? 'Người dùng') . ' đã bình luận sản phẩm ' . ($this->comment->product->name ?? ''),
            'user_name' => $this->comment->user->name ?? 'Người dùng',
            'product_name' => $this->comment->product->name ?? '',
            'product_id' => $this->comment->product_id,
            'product_url' => route('products.show', $this->comment->product->slug ?? $this->comment->product_id),
            'comment_content' => $this->comment->content,
            'comment_id' => $this->comment->id,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}

