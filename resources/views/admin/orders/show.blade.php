@extends('layouts.admin')

@section('title', 'Chi Tiết Đơn Hàng - ' . $order->order_number)

@section('page-title', 'Chi Tiết Đơn Hàng')
@section('page-description', 'Mã đơn hàng: ' . $order->order_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-receipt me-2"></i>Chi Tiết Đơn Hàng</h2>
        <p class="text-muted mb-0">Mã đơn hàng: <strong>{{ $order->order_number }}</strong></p>
    </div>
    <div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay Lại
        </a>
    </div>
</div>

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông Tin Đơn Hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mã đơn hàng:</strong><br>
                                <span class="text-primary fs-5">{{ $order->order_number }}</span>
                            </p>
                            <p><strong>Ngày đặt:</strong><br>
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </p>
                            <p><strong>Trạng thái:</strong><br>
                                <span class="badge {{ $order->status_badge_class }} fs-6">{{ $order->status_text }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tổng tiền:</strong><br>
                                <span class="text-danger fs-4 fw-bold">{{ number_format($order->total_amount) }}đ</span>
                            </p>
                            <p><strong>Phương thức thanh toán:</strong><br>
                                @if($order->payment_method === 'cod')
                                    <i class="fas fa-truck text-primary me-1"></i>COD - Thanh toán khi nhận hàng
                                @elseif($order->payment_method === 'cash')
                                    <i class="fas fa-money-bill-wave text-success me-1"></i>Tiền mặt
                                @else
                                    <i class="fas fa-university text-info me-1"></i>Chuyển khoản
                                @endif
                            </p>
                            <p><strong>Thời gian thuê:</strong><br>
                                {{ $order->rental_period_text }} ({{ $order->total_months }} tháng)
                            </p>
                        </div>
                    </div>

                    <!-- Rental Status -->
                    <div class="mt-3 p-3 bg-light rounded">
                        <h6 class="mb-2">Trạng thái thuê:</h6>
                        @if($order->is_active_rental)
                            <span class="badge bg-success fs-6">Đang thuê</span>
                            <small class="text-muted ms-2">Còn {{ $order->days_remaining }} ngày</small>
                        @elseif($order->is_expired)
                            <span class="badge bg-danger fs-6">Hết hạn</span>
                            <small class="text-muted ms-2">Đã hết hạn {{ abs($order->days_remaining) }} ngày</small>
                        @else
                            <span class="badge bg-warning fs-6">Chưa bắt đầu</span>
                            <small class="text-muted ms-2">Bắt đầu từ {{ $order->rental_start_date->format('d/m/Y') }}</small>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Sản Phẩm Đã Đặt</h5>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-center mb-4 pb-4 border-bottom">
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}"
                             class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $item->product_name }}</h6>
                            <p class="text-muted small mb-2">{{ Str::limit($item->product_description, 100) }}</p>
                            <div class="row">
                                <div class="col-md-4">
                                    <small class="text-muted">Thời gian thuê:</small><br>
                                    <strong>{{ $item->rental_duration_months }} tháng</strong>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Số lượng:</small><br>
                                    <strong>{{ $item->quantity }}</strong>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Đơn giá:</small><br>
                                    <strong>{{ number_format($item->monthly_price) }}đ/tháng</strong>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <strong class="text-danger fs-5">{{ number_format($item->total_price) }}đ</strong>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Customer Information & Actions -->
        <div class="col-lg-4">
            <!-- Customer Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Thông Tin Khách Hàng</h5>
                </div>
                <div class="card-body">
                    <p><strong>Họ và tên:</strong><br>{{ $order->customer_name }}</p>
                    <p><strong>Email:</strong><br>{{ $order->customer_email }}</p>
                    <p><strong>Số điện thoại:</strong><br>{{ $order->customer_phone }}</p>
                    <p><strong>Địa chỉ:</strong><br>{{ $order->customer_address }}</p>
                    @if($order->notes)
                        <p><strong>Ghi chú:</strong><br>{{ $order->notes }}</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Thao Tác Nhanh</h5>
                </div>
                <div class="card-body">

                    <!-- Status Update Form -->
                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" id="statusUpdateForm" class="mb-3">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái đơn hàng:</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>Thay đổi trạng thái sẽ tự động cập nhật
                            </small>
                        </div>
                        <div id="statusUpdateMessage" class="alert d-none mb-0"></div>
                    </form>

                    <!-- Contact Actions -->
                    <div class="d-grid gap-2">
                        
                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                              onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>Xóa đơn hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 12px;
    border: 1px solid #e9ecef;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    border-radius: 12px 12px 0 0 !important;
}

.badge {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const statusForm = document.getElementById('statusUpdateForm');
    const statusMessage = document.getElementById('statusUpdateMessage');
    let originalStatus = statusSelect.value;
    let isUpdating = false;

    statusSelect.addEventListener('change', function() {
        if (isUpdating) return;

        const newStatus = this.value;

        // Nếu trạng thái không thay đổi, không làm gì
        if (newStatus === originalStatus) {
            return;
        }

        // Hiển thị loading
        isUpdating = true;
        const originalValue = this.value;
        this.disabled = true;
        statusMessage.className = 'alert alert-info mb-0';
        statusMessage.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang cập nhật trạng thái...';
        statusMessage.classList.remove('d-none');

        // Lấy giá trị status mới
        const newStatusValue = this.value;
        const selectElement = this; // Lưu reference để dùng trong finally

        // Tạo FormData và đảm bảo có đầy đủ các field
        const formData = new FormData();
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        formData.append('_method', 'PATCH');
        formData.append('status', newStatusValue);

        // Gửi request AJAX
        fetch(statusForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            // Kiểm tra status code trước
            if (!response.ok) {
                // Thử parse JSON error
                return response.json().then(err => {
                    // Xử lý lỗi validation
                    let errorMessage = 'Có lỗi xảy ra khi cập nhật trạng thái';
                    if (err.message) {
                        errorMessage = err.message;
                    } else if (err.errors && err.errors.status) {
                        errorMessage = err.errors.status[0];
                    }
                    throw new Error(errorMessage);
                }).catch(() => {
                    // Nếu không parse được JSON, trả về lỗi chung
                    throw new Error(`Lỗi ${response.status}: ${response.statusText}`);
                });
            }

            // Kiểm tra content type
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            } else {
                // Nếu không phải JSON, có thể server trả về HTML (redirect)
                // Trong trường hợp này, reload trang
                window.location.reload();
                return { success: false };
            }
        })
        .then(data => {
            if (data.success) {
                // Thành công
                statusMessage.className = 'alert alert-success mb-0';
                statusMessage.innerHTML = '<i class="fas fa-check-circle me-2"></i>Cập nhật trạng thái thành công!';

                // Cập nhật originalStatus để lần sau không bị lỗi
                originalStatus = newStatusValue;

                // Cập nhật badge trạng thái trên trang
                const statusBadge = document.querySelector('.badge.fs-6');
                if (statusBadge) {
                    const statusTexts = {
                        'pending': 'Chờ xác nhận',
                        'confirmed': 'Đã xác nhận',
                        'processing': 'Đang xử lý',
                        'completed': 'Hoàn thành',
                        'cancelled': 'Đã hủy'
                    };
                    const statusClasses = {
                        'pending': 'bg-warning',
                        'confirmed': 'bg-info',
                        'processing': 'bg-primary',
                        'completed': 'bg-success',
                        'cancelled': 'bg-danger'
                    };
                    statusBadge.className = `badge ${statusClasses[newStatusValue]} fs-6`;
                    statusBadge.textContent = statusTexts[newStatusValue];
                }

                // Ẩn thông báo sau 3 giây
                setTimeout(() => {
                    statusMessage.classList.add('d-none');
                }, 3000);
            } else {
                // Lỗi
                statusMessage.className = 'alert alert-danger mb-0';
                statusMessage.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + (data.message || 'Có lỗi xảy ra khi cập nhật trạng thái');

                // Khôi phục giá trị cũ
                statusSelect.value = originalStatus;
            }
        })
        .catch(error => {
            console.error('Error:', error);

            // Xử lý lỗi validation từ server
            if (error.message) {
                statusMessage.className = 'alert alert-danger mb-0';
                statusMessage.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + error.message;
            } else {
                statusMessage.className = 'alert alert-danger mb-0';
                statusMessage.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>Có lỗi xảy ra fkhi cập nhật trạng thái';
            }

            // Khôi phục giá trị cũ
            statusSelect.value = originalStatus;
        })
        .finally(() => {
            isUpdating = false;
            statusSelect.disabled = false;
        });
    });
});
</script>
@endsection
