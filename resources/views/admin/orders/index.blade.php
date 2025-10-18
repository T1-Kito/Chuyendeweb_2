@extends('layouts.admin')

@section('title', 'Quản Lý Đơn Hàng')

@section('page-title', 'Quản Lý Đơn Hàng')
@section('page-description', 'Xem và quản lý tất cả đơn hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-shopping-cart me-2"></i>Danh Sách Đơn Hàng</h2>
</div>

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Mã đơn hàng, tên KH, SĐT...">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Tất cả</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ match($status) {
                                    'pending' => 'Chờ xác nhận',
                                    'confirmed' => 'Đã xác nhận',
                                    'processing' => 'Đang xử lý',
                                    'completed' => 'Hoàn thành',
                                    'cancelled' => 'Đã hủy',
                                    default => $status
                                } }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="form-label">Từ ngày</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" 
                           value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_to" class="form-label">Đến ngày</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" 
                           value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i>Tìm kiếm
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-refresh me-1"></i>Làm mới
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders List -->
    <div class="card">
        <div class="card-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Thời gian thuê</th>
                                <th>Trạng thái</th>
                                <th>Ngày đặt</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    <strong class="text-primary">{{ $order->order_number }}</strong>
                                    <br><small class="text-muted">{{ $order->items->count() }} sản phẩm</small>
                                </td>
                                <td>
                                    <div><strong>{{ $order->customer_name }}</strong></div>
                                    <div class="text-muted small">{{ $order->customer_phone }}</div>
                                    <div class="text-muted small">{{ $order->customer_email }}</div>
                                </td>
                                <td>
                                    <strong class="text-danger">{{ number_format($order->total_amount) }}đ</strong>
                                </td>
                                <td>
                                    <div>{{ $order->rental_period_text }}</div>
                                    <small class="text-muted">{{ $order->total_months }} tháng</small>
                                    @if($order->is_active_rental)
                                        <br><span class="badge bg-success small">Đang thuê</span>
                                    @elseif($order->is_expired)
                                        <br><span class="badge bg-danger small">Hết hạn</span>
                                    @else
                                        <br><span class="badge bg-warning small">Chưa bắt đầu</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $order->status_badge_class }}">
                                        {{ $order->status_text }}
                                    </span>
                                </td>
                                <td>
                                    <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.orders.show', $order) }}" 
                                           class="btn btn-outline-primary" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" 
                                              class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>


                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có đơn hàng nào</h5>
                    <p class="text-muted">Khi có đơn hàng mới, chúng sẽ xuất hiện ở đây</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}

.badge {
    font-size: 0.75rem;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

/* Fix modal shaking issue */
.modal {
    overflow: hidden;
}

.modal-dialog {
    margin: 1.75rem auto;
    max-width: 500px;
}

.modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.modal-header {
    border-bottom: 1px solid #e9ecef;
    padding: 1rem 1.5rem;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 1rem 1.5rem;
}

/* Fix button hover effects */
.btn {
    transition: all 0.2s ease;
    border-radius: 8px;
}

.btn:hover {
    transform: translateY(-1px);
}

.btn:active {
    transform: translateY(0);
}

/* Fix form controls */
.form-select, .form-control {
    border-radius: 8px;
    border: 1px solid #d1d5db;
    transition: all 0.2s ease;
}

.form-select:focus, .form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* Prevent text selection on buttons */
.btn {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}

/* Smooth transitions for modal */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: translate(0, -50px);
}

.modal.show .modal-dialog {
    transform: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prevent double-clicking on submit buttons
    const submitButtons = document.querySelectorAll('button[type="submit"]');
    submitButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (this.disabled) {
                e.preventDefault();
                return false;
            }
            
            // Disable button to prevent double submission
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
            
            // Re-enable after 3 seconds if form doesn't submit
            setTimeout(() => {
                this.disabled = false;
                this.innerHTML = 'Cập nhật';
            }, 3000);
        });
    });
    
    // Smooth modal animations
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('show.bs.modal', function() {
            this.querySelector('.modal-dialog').style.transform = 'translate(0, -50px)';
        });
        
        modal.addEventListener('shown.bs.modal', function() {
            this.querySelector('.modal-dialog').style.transform = 'none';
        });
    });
});


</script>
@endsection
