<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\NewMessageNotification;
use Illuminate\Validation\ValidationException;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $conversations = Conversation::with(['user', 'latestMessage'])
            ->where('user_id', auth()->id())
            ->orderByDesc('last_message_at')
            ->get();

        return view('messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        // Kiểm tra quyền truy cập
        if ($conversation->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        // Đánh dấu tin nhắn đã đọc
        $conversation->messages()
            ->where('user_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $conversation->load(['user', 'messages.user']);
        
        return view('messages.show', compact('conversation'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        // Kiểm tra quyền truy cập
        if ($conversation->user_id !== auth()->id() && !auth()->user()->is_admin) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        try {
            $validated = $request->validate([
                'content' => ['required', 'string', 'max:2000'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

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

        // Gửi notification
        if (auth()->user()->is_admin) {
            // Admin trả lời → gửi cho user
            if ($conversation->user) {
                $conversation->user->notify(new NewMessageNotification($message));
            }
        } else {
            // User gửi → gửi cho tất cả admin
            $admins = User::where('is_admin', true)->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewMessageNotification($message));
            }
        }

        // Trả về JSON nếu request là AJAX hoặc JSON
        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('user'),
            ]);
        }

        return back()->with('success', 'Tin nhắn đã được gửi!');
    }

    public function create()
    {
        return view('messages.create');
    }

    public function start(Request $request)
    {
        try {
            $validated = $request->validate([
                'subject' => ['nullable', 'string', 'max:255'],
                'content' => ['required', 'string', 'max:2000'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        // Tạo conversation mới
        $conversation = Conversation::create([
            'user_id' => auth()->id(),
            'subject' => $validated['subject'] ?? 'Hỗ trợ khách hàng',
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        // Tạo tin nhắn đầu tiên
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'is_read' => false,
        ]);

        // Load relationships
        $message->load(['user', 'conversation']);

        // Gửi notification cho tất cả admin
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewMessageNotification($message));
        }

        // Trả về JSON nếu request là AJAX hoặc JSON
        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'conversation_id' => $conversation->id,
                'message' => $message->load('user'),
            ]);
        }

        return redirect()->route('messages.show', $conversation)
            ->with('success', 'Tin nhắn đã được gửi!');
    }

    public function getConversations()
    {
        if (auth()->user()->is_admin) {
            $conversations = Conversation::with(['user', 'latestMessage'])
                ->orderByDesc('last_message_at')
                ->limit(10)
                ->get();
        } else {
            $conversations = Conversation::with(['user', 'latestMessage'])
                ->where('user_id', auth()->id())
                ->orderByDesc('last_message_at')
                ->limit(10)
                ->get();
        }

        return response()->json($conversations->map(function($conv) {
            return [
                'id' => $conv->id,
                'subject' => $conv->subject,
                'user' => $conv->user ? ['name' => $conv->user->name] : null,
                'last_message_at' => $conv->last_message_at ? $conv->last_message_at->toDateTimeString() : null,
                'latest_message' => $conv->latestMessage ? [
                    'content' => $conv->latestMessage->content,
                ] : null,
                'unread_messages_count' => $conv->unreadMessagesCount(),
            ];
        }));
    }

    public function getMessages(Conversation $conversation)
    {
        // Kiểm tra quyền truy cập
        if ($conversation->user_id !== auth()->id() && !auth()->user()->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Đánh dấu tin nhắn đã đọc
        $conversation->messages()
            ->where('user_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $conversation->load(['user', 'messages.user']);
        
        return response()->json([
            'conversation' => $conversation,
            'messages' => $conversation->messages,
        ]);
    }
}
