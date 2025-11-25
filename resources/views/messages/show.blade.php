@extends('layouts.app')

@section('title', 'Tin nhắn hỗ trợ')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>
                    <i class="fas fa-comments me-2"></i>
                    {{ $conversation->subject ?? 'Hỗ trợ khách hàng' }}
                </h4>
                <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body p-0">
                    <!-- Chat Messages -->
                    <div class="chat-messages p-4" id="chatMessages" style="height: 500px; overflow-y: auto; background: #f8f9fa;">
                        @foreach($conversation->messages as $message)
                            <div class="message-item mb-3 {{ $message->user_id === auth()->id() ? 'text-end' : 'text-start' }}">
                                <div class="d-inline-block {{ $message->user_id === auth()->id() ? 'bg-primary text-white' : 'bg-white border' }} rounded p-3" style="max-width: 70%;">
                                    <div class="d-flex align-items-center mb-1">
                                        <strong class="small">{{ $message->user->name ?? 'Người dùng' }}</strong>
                                        <small class="ms-2 {{ $message->user_id === auth()->id() ? 'text-white-50' : 'text-muted' }}">
                                            {{ $message->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                    <div class="message-content">
                                        {!! nl2br(e($message->content)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Chat Input -->
                    <div class="chat-input p-3 border-top bg-white">
                        <form method="POST" action="{{ route('messages.store', $conversation) }}" id="messageForm">
                            @csrf
                            <div class="input-group">
                                <textarea name="content" class="form-control" rows="2" 
                                          placeholder="Nhập tin nhắn của bạn..." required maxlength="2000"></textarea>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Gửi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.chat-messages {
    scroll-behavior: smooth;
}
.message-item:last-child {
    margin-bottom: 0 !important;
}
</style>

<script>
// Auto scroll to bottom
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chatMessages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Auto refresh every 5 seconds
    setInterval(function() {
        location.reload();
    }, 5000);
});
</script>
@endsection

