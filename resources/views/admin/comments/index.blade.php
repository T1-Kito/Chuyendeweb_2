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
                        <th style="width: 15%;">User</th>
                        <th style="width: 15%;">Sản phẩm</th>
                        <th style="width: 30%;">Nội dung</th>
                        <th style="width: 15%;">Thời gian</th>
                        <th style="width: 25%;">Thao tác</th>
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
                        <td style="max-width:360px;word-break:break-word;">
                            <div>{!! nl2br(e($comment->content)) !!}</div>
                            @if($comment->replies->count() > 0)
                                <div class="mt-2">
                                    <button class="btn btn-sm btn-outline-info" type="button" data-bs-toggle="collapse" data-bs-target="#replies-{{ $comment->id }}" aria-expanded="false">
                                        <i class="fas fa-comments me-1"></i>{{ $comment->replies->count() }} trả lời
                                    </button>
                                </div>
                            @endif
                        </td>
                        <td><small>{{ $comment->created_at->format('d/m/Y H:i') }}<br>{{ $comment->created_at->diffForHumans() }}</small></td>
                        <td>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#replyModal-{{ $comment->id }}">
                                    <i class="fas fa-reply me-1"></i>Trả lời
                                </button>
                                <form method="POST" action="{{ route('admin.comments.destroy', $comment->id) }}" 
                                      onsubmit="return confirm('Bạn chắc chắn muốn xoá bình luận này? Tất cả các trả lời cũng sẽ bị xóa.')"
                                      class="delete-comment-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" data-comment-id="{{ $comment->id }}">
                                        <i class="fas fa-trash me-1"></i>Xoá
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @if($comment->replies->count() > 0)
                    <tr class="collapse" id="replies-{{ $comment->id }}">
                        <td colspan="5" class="bg-light">
                            <div class="ps-4 py-2">
                                <strong class="text-muted small">Các trả lời:</strong>
                                @foreach($comment->replies as $reply)
                                <div class="border-start border-3 border-primary ps-3 py-2 mb-2 bg-white rounded">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <strong class="text-primary">{{ $reply->user->name ?? 'Admin' }}</strong>
                                            <span class="badge bg-info ms-2">Admin</span>
                                            <div class="mt-1">{!! nl2br(e($reply->content)) !!}</div>
                                            <small class="text-muted">{{ $reply->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        <form method="POST" action="{{ route('admin.comments.destroy', $reply->id) }}" 
                                              onsubmit="return confirm('Bạn chắc chắn muốn xoá trả lời này?')"
                                              class="delete-reply-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" data-comment-id="{{ $reply->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Info -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Hiển thị {{ $comments->firstItem() }} đến {{ $comments->lastItem() }} trong {{ $comments->total() }} bình luận
                </div>
            </div>

            <!-- Pagination -->
            @if($comments->hasPages())
            <div class="d-flex justify-content-center mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($comments->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $comments->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($comments->getUrlRange(1, $comments->lastPage()) as $page => $url)
                            @if ($page == $comments->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($comments->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $comments->nextPageUrl() }}" rel="next">&raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">&raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            @endif
            @else
                <div class="text-muted py-5 text-center">Chưa có bình luận nào.</div>
            @endif
        </div>
    </div>
</div>

<!-- Reply Modals -->
@foreach($comments as $comment)
<div class="modal fade" id="replyModal-{{ $comment->id }}" tabindex="-1" aria-labelledby="replyModalLabel-{{ $comment->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel-{{ $comment->id }}">
                    <i class="fas fa-reply me-2"></i>Trả lời bình luận
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.comments.reply', $comment->id) }}" id="replyForm-{{ $comment->id }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Bình luận gốc:</label>
                        <div class="border rounded p-2 bg-light">
                            <strong>{{ $comment->user->name ?? 'N/A' }}</strong>: {!! nl2br(e($comment->content)) !!}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="reply-content-{{ $comment->id }}" class="form-label">Nội dung trả lời <span class="text-danger">*</span></label>
                        <textarea name="content" id="reply-content-{{ $comment->id }}" rows="4" 
                                  class="form-control @error('content') is-invalid @enderror" 
                                  placeholder="Nhập nội dung trả lời..." maxlength="1000" required>{{ old('content') }}</textarea>
                        <div class="form-text">
                            <span id="charCount-{{ $comment->id }}">0</span>/1000 ký tự
                        </div>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="submitReplyBtn-{{ $comment->id }}">
                        <i class="fas fa-paper-plane me-1"></i>Gửi trả lời
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

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
    
    // Prevent double submit cho form xóa comment
    const deleteForms = document.querySelectorAll('.delete-comment-form, .delete-reply-form');
    deleteForms.forEach(form => {
        let isSubmitting = false;
        form.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }
            isSubmitting = true;
            
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang xóa...';
            }
            
            setTimeout(() => { 
                isSubmitting = false;
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            }, 3000);
        });
    });

    // Character counter và prevent double submit cho form reply
    @foreach($comments as $comment)
    (function() {
        const form = document.getElementById('replyForm-{{ $comment->id }}');
        const textarea = document.getElementById('reply-content-{{ $comment->id }}');
        const charCount = document.getElementById('charCount-{{ $comment->id }}');
        const submitBtn = document.getElementById('submitReplyBtn-{{ $comment->id }}');
        
        if (form && textarea && charCount) {
            let isSubmitting = false;
            
            // Character counter
            function updateCharCount() {
                const length = textarea.value.length;
                charCount.textContent = length;
                if (length > 1000) {
                    charCount.style.color = '#dc3545';
                } else if (length > 900) {
                    charCount.style.color = '#ffc107';
                } else {
                    charCount.style.color = '#6c757d';
                }
            }
            
            textarea.addEventListener('input', updateCharCount);
            updateCharCount();
            
            // Prevent double submit
            form.addEventListener('submit', function(e) {
                if (isSubmitting) {
                    e.preventDefault();
                    return false;
                }
                
                // Trim và validate
                const trimmed = textarea.value.trim();
                if (!trimmed || trimmed.length === 0) {
                    e.preventDefault();
                    alert('Nội dung trả lời không được để trống hoặc chỉ chứa khoảng trắng.');
                    textarea.focus();
                    return false;
                }
                
                isSubmitting = true;
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang gửi...';
                }
            });
        }
    })();
    @endforeach

    // Reset form khi đóng modal
    document.querySelectorAll('[id^="replyModal-"]').forEach(modal => {
        modal.addEventListener('hidden.bs.modal', function() {
            const form = this.querySelector('form');
            if (form) {
                form.reset();
                const textarea = form.querySelector('textarea');
                const charCount = form.querySelector('[id^="charCount-"]');
                if (textarea && charCount) {
                    charCount.textContent = '0';
                    charCount.style.color = '#6c757d';
                }
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
            }
        });
    });
});
</script>
@endsection
