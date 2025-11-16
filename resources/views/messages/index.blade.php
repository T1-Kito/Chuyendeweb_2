@extends('layouts.app')

@section('title', 'Tin nhắn hỗ trợ')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-comments me-2"></i>Tin nhắn hỗ trợ</h2>
                <a href="{{ route('messages.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tạo tin nhắn mới
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($conversations->count() > 0)
                        <div class="list-group">
                            @foreach($conversations as $conversation)
                                <a href="{{ route('messages.show', $conversation) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">
                                            <i class="fas fa-comment-dots me-2 text-primary"></i>
                                            {{ $conversation->subject ?? 'Hỗ trợ khách hàng' }}
                                        </h5>
                                        <small class="text-muted">{{ $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : '' }}</small>
                                    </div>
                                    @if($conversation->latestMessage)
                                        <p class="mb-1 text-muted">{{ Str::limit($conversation->latestMessage->content, 100) }}</p>
                                    @endif
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-muted">
                                            <span class="badge bg-{{ $conversation->status === 'open' ? 'success' : ($conversation->status === 'closed' ? 'secondary' : 'warning') }}">
                                                {{ $conversation->status === 'open' ? 'Đang mở' : ($conversation->status === 'closed' ? 'Đã đóng' : 'Chờ xử lý') }}
                                            </span>
                                        </small>
                                        @if($conversation->unreadMessagesCount() > 0)
                                            <span class="badge bg-danger">{{ $conversation->unreadMessagesCount() }} tin nhắn mới</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có cuộc trò chuyện nào.</p>
                            <a href="{{ route('messages.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tạo tin nhắn mới
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

