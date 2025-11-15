@extends('layouts.app')

@section('title', 'Quản lý tin nhắn hỗ trợ')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-envelope me-2"></i>Quản lý tin nhắn hỗ trợ</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($conversations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Chủ đề</th>
                                <th>Tin nhắn cuối</th>
                                <th>Trạng thái</th>
                                <th>Thời gian</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($conversations as $conversation)
                                <tr>
                                    <td>
                                        <strong>{{ $conversation->user->name ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $conversation->user->email ?? '' }}</small>
                                    </td>
                                    <td>{{ $conversation->subject ?? 'Hỗ trợ khách hàng' }}</td>
                                    <td>
                                        @if($conversation->latestMessage)
                                            <small>{{ Str::limit($conversation->latestMessage->content, 50) }}</small>
                                        @else
                                            <small class="text-muted">Chưa có tin nhắn</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $conversation->status === 'open' ? 'success' : ($conversation->status === 'closed' ? 'secondary' : 'warning') }}">
                                            {{ $conversation->status === 'open' ? 'Đang mở' : ($conversation->status === 'closed' ? 'Đã đóng' : 'Chờ xử lý') }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : 'Chưa có' }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.messages.show', $conversation) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i>Xem
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $conversations->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Chưa có cuộc trò chuyện nào.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

