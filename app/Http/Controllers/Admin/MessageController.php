<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\NewMessageNotification;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $conversations = Conversation::with(['user', 'latestMessage'])
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('admin.messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        // Đánh dấu tin nhắn đã đọc
        $conversation->messages()
            ->where('user_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $conversation->load(['user', 'messages.user']);
        
        return view('admin.messages.show', compact('conversation'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'is_read' => false,
        ]);

        // Load relationships
        $message->load(['user', 'conversation']);

        // Cập nhật thời gian tin nhắn cuối
        $conversation->update(['last_message_at' => now()]);

        // Gửi notification cho user
        if ($conversation->user) {
            $conversation->user->notify(new NewMessageNotification($message));
        }

        return back()->with('success', 'Tin nhắn đã được gửi!');
    }

    public function updateStatus(Request $request, Conversation $conversation)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:open,closed,pending'],
        ]);

        $conversation->update(['status' => $validated['status']]);

        return back()->with('success', 'Trạng thái cuộc trò chuyện đã được cập nhật!');
    }
}

