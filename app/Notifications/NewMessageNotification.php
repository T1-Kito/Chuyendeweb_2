<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Message;
use Illuminate\Support\Str;

class NewMessageNotification extends Notification
{
    
    protected $message;
    
    public function __construct(Message $message)
    {
        $this->message = $message;
    }
    
    public function via($notifiable)
    {
        return ['database'];
    }
    
    public function toDatabase($notifiable)
    {
        // Xác định URL dựa trên người nhận notification
        $chatUrl = ($notifiable->is_admin ?? false)
            ? route('admin.messages.show', $this->message->conversation_id)
            : route('messages.show', $this->message->conversation_id);

        return [
            'type' => 'new_message',
            'message' => ($this->message->user->name ?? 'Người dùng') . ' đã gửi tin nhắn: ' . Str::limit($this->message->content, 50),
            'user_name' => $this->message->user->name ?? 'Người dùng',
            'conversation_id' => $this->message->conversation_id,
            'message_id' => $this->message->id,
            'content' => Str::limit($this->message->content, 100),
            'chat_url' => $chatUrl,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}

