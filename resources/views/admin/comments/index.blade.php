@extends('layouts.admin')

@section('title', 'Quản lý bình luận')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Quản lý bình luận sản phẩm</h1>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
            <strong><i class="fas fa-exclamation-triangle me-2"></i>Lỗi:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            @if($comments->count())
            <table class="table align-middle table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Sản phẩm</th>
                        <th>Nội dung</th>
                        <th>Thời gian</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $comment)
                    <tr>
                        <td>
                            <strong>{{ $comment->user->name ?? 'N/A' }}</strong><br>
                            <small>{{ $comment->user->email ?? '' }}</small>
                        </td>
                        <td>
                            @if($comment->product)
                            <a href="{{ route('products.show', $comment->product->slug ?? $comment->product->id) }}" target="_blank">
                                {{ $comment->product->name }}
                            </a>
                            @endif
                        </td>
                        <td style="max-width:360px;word-break:break-word;">{!! nl2br(e($comment->content)) !!}</td>
                        <td><small>{{ $comment->created_at->format('d/m/Y H:i') }}<br>{{ $comment->created_at->diffForHumans() }}</small></td>
                        <td>
                            <form method="POST" action="{{ route('admin.comments.destroy', $comment->id) }}" 
                                  onsubmit="return confirm('Bạn chắc chắn muốn xoá bình luận này?')"
                                  class="delete-comment-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" data-comment-id="{{ $comment->id }}">Xoá</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $comments->links() }}
            </div>
            @else
                <div class="text-muted py-5 text-center">Chưa có bình luận nào.</div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Kiểm tra nếu có thông báo lỗi "đã được xóa" thì tự động reload sau 2 giây
    const errorAlert = document.getElementById('errorAlert');
    if (errorAlert) {
        const errorText = errorAlert.textContent || errorAlert.innerText;
        if (errorText.includes('đã được xóa') || errorText.includes('tải lại trang')) {
            setTimeout(function() {
                window.location.reload();
            }, 2000);
        }
    }
    
    // Prevent double submit
    const deleteForms = document.querySelectorAll('.delete-comment-form');
    deleteForms.forEach(form => {
        let isSubmitting = false;
        form.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }
            isSubmitting = true;
            
            // Disable button để tránh double click
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Đang xóa...';
            }
            
            // Re-enable after 3 seconds in case of error
            setTimeout(() => { 
                isSubmitting = false;
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            }, 3000);
        });
    });
});
</script>
@endsection
