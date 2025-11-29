@extends('layouts.admin')

@section('title', 'Quản lý thông báo')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Quản lý thông báo</h1>
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

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Bộ lọc</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.notifications.index') }}" class="row g-3" id="filterForm">
                <div class="col-md-3">
                    <label for="search" class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Tìm kiếm...">
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">Loại thông báo</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">Tất cả</option>
                        @foreach($notificationTypes as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="read_status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="read_status" name="read_status">
                        <option value="">Tất cả</option>
                        <option value="read" {{ request('read_status') == 'read' ? 'selected' : '' }}>Đã đọc</option>
                        <option value="unread" {{ request('read_status') == 'unread' ? 'selected' : '' }}>Chưa đọc</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 me-2">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                    @if(request()->hasAny(['search', 'type', 'read_status']))
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($notifications->count())
            <div class="table-responsive">
                <table class="table align-middle table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Người nhận</th>
                            <th>Loại</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Thời gian</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $index => $notification)
                        <tr>
                            <td>{{ $notifications->firstItem() + $index }}</td>
                            <td>
                                @if(isset($notification->user))
                                    <strong>{{ $notification->user->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $notification->user->email ?? '' }}</small>
                                @else
                                    <span class="text-muted">User ID: {{ $notification->notifiable_id }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $notification->type_display ?? $notification->type }}</span>
                            </td>
                            <td style="max-width:400px;word-break:break-word;">
                                {{ $notification->message ?? 'Thông báo' }}
                                @if(isset($notification->data_array['product_url']))
                                    <br><a href="{{ $notification->data_array['product_url'] }}" target="_blank" class="btn btn-sm btn-link p-0">
                                        <i class="fas fa-external-link-alt"></i> Xem chi tiết
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($notification->read_at)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Đã đọc
                                    </span>
                                    <br><small class="text-muted">{{ \Carbon\Carbon::parse($notification->read_at)->format('d/m/Y H:i') }}</small>
                                @else
                                    <span class="badge bg-warning text-dark">Chưa đọc</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y H:i') }}<br>
                                {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.notifications.destroy', $notification->id) }}" 
                                      onsubmit="return confirm('Bạn chắc chắn muốn xoá thông báo này?')"
                                      class="delete-notification-form d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" data-notification-id="{{ $notification->id }}">
                                        <i class="fas fa-trash me-1"></i>Xoá
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
            @else
                <div class="text-muted py-5 text-center">
                    <i class="fas fa-bell-slash fa-3x mb-3"></i>
                    <p>Chưa có thông báo nào.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Test case 1: Xóa mục không tồn tại - Tự động reload khi có lỗi "đã được xóa"
    const errorAlert = document.getElementById('errorAlert');
    if (errorAlert) {
        const errorText = errorAlert.textContent || errorAlert.innerText;
        if (errorText.includes('đã được xóa') || errorText.includes('tải lại trang')) {
            setTimeout(function() {
                window.location.reload();
            }, 2000);
        }
    }
    
    // Test case 9: Trùng lặp dữ liệu - Prevent double submit cho form xóa
    const deleteForms = document.querySelectorAll('.delete-notification-form');
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
            
            // Re-enable after 3 seconds in case of error
            setTimeout(() => { 
                isSubmitting = false;
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            }, 3000);
        });
    });

    // Test case 10: Kiểm tra URL parameters - Validate filter form
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            // Có thể thêm validation ở đây nếu cần
        });
    }
});
</script>
@endsection

