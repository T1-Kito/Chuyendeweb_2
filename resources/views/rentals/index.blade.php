@extends('layouts.app')

@section('title', 'Quản Lý Đơn Thuê')

@push('styles')
<style>
.page-hero {
    background: #f0e9ea;
    border: 1px solid #eed7da;
}
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
.form-select:focus, .form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}
</style>
@endpush

@section('content')
<section class="py-5">
    <div class="container">
        <div class="page-hero rounded-3 mb-4 px-3 py-3">
            <h2 class="fw-bold mb-0"><i class="fas fa-file-contract me-2"></i>Quản Lý Hợp Đồng</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        <!-- Contracts List -->
        <div class="card">
            <div class="card-body">
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã hợp đồng</th>
                                    <th>Người thuê</th>
                                    <th>Thiết bị</th>
                                    <th>Ngày hết hạn</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian thuê</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $order->order_number }}</strong>
                                        <br><small class="text-muted">#{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</small>
                                    </td>
                                    <td>
                                        <div><strong>{{ $order->customer_name }}</strong></div>
                                        <div class="text-muted small">{{ $order->customer_email }}</div>
                                        <div class="text-muted small">{{ $order->customer_phone }}</div>
                                    </td>
                                    <td>
                                        @if($order->items->isNotEmpty())
                                            @foreach($order->items as $item)
                                                <div class="mb-1">
                                                    <strong>{{ $item->product_name }}</strong>
                                                    @if($item->product && $item->product->serial_number)
                                                        <br><small class="text-muted">S/N: {{ $item->product->serial_number }}</small>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $order->rental_end_date->format('d/m/Y') }}</div>
                                        @if($order->status == 'cancelled' || $order->status == 'pending')
                                            <small class="text-muted">—</small>
                                        @elseif($order->is_expired)
                                            <small class="text-danger">Đã hết hạn</small>
                                        @elseif($order->is_active_rental)
                                            <small class="text-success">Còn {{ $order->days_remaining }} ngày</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $order->status_badge_class }}">
                                            {{ $order->status_text }}
                                        </span>

                                    </td>
                                    <td>
                                        <div>{{ $order->total_months }} tháng</div>
                                        <small class="text-muted">{{ $order->rental_period_text }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <!-- Thông báo trạng thái -->
                                            <div class="small text-muted mb-1">
                                                @if($order->status == 'pending')
                                                    <i class="fas fa-clock text-warning me-1"></i>
                                                    <span>Đơn hàng đang chờ cửa hàng xác nhận.</span>
                                                @elseif($order->status == 'confirmed')
                                                    <i class="fas fa-check-circle text-info me-1"></i>
                                                    <span>Đơn hàng đã được xác nhận. Chúng tôi sẽ xử lý sớm nhất.</span>
                                                @elseif($order->status == 'processing')
                                                    <i class="fas fa-cog text-primary me-1"></i>
                                                    <span>Đơn hàng đang được xử lý.</span>
                                                @elseif($order->status == 'completed')
                                                    <i class="fas fa-check-circle text-success me-1"></i>
                                                    <span>Đơn hàng đã hoàn thành.</span>
                                                @elseif($order->status == 'cancelled')
                                                    <i class="fas fa-times-circle text-danger me-1"></i>
                                                    <span>Đơn hàng đã bị hủy.</span>
                                                    @if($order->notes)
                                                        <br><small class="text-muted">Lý do: {{ Str::limit($order->notes, 100) }}</small>
                                                    @endif
                                                @endif
                                            </div>

                                            <!-- Các nút thao tác -->
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('rentals.show', $order) }}"
                                                   class="btn btn-outline-primary" title="Xem chi tiết">
                                                    <i class="fas fa-eye me-1"></i>Chi tiết
                                                </a>

                                                @if($order->status == 'pending')
                                                    <!-- Chờ xác nhận: Cho phép hủy -->
                                                    <form action="{{ route('rentals.cancel', $order) }}" method="POST" class="d-inline" id="cancelForm{{ $order->id }}">
                                                        @csrf
                                                        <button type="button" class="btn btn-outline-danger"
                                                                title="Hủy đơn hàng"
                                                                onclick="confirmCancel({{ $order->id }})">
                                                            <i class="fas fa-times me-1"></i>Hủy đơn
                                                        </button>
                                                    </form>
                                                @elseif($order->status == 'completed')
                                                    <!-- Hoàn thành: Đánh giá và Đặt lại -->
                                                    @if($order->items->isNotEmpty() && $order->items->first()->product)
                                                        <a href="{{ route('products.show', $order->items->first()->product->slug ?? $order->items->first()->product->id) }}"
                                                           class="btn btn-outline-primary"
                                                           title="Đặt lại">
                                                            <i class="fas fa-redo me-1"></i>Đặt lại
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
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
                        <i class="fas fa-file-contract fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">
                            @if(request()->has('search') || request()->has('status') || request()->has('date_from') || request()->has('date_to'))
                                Không tìm thấy hợp đồng nào
                            @else
                                Bạn chưa có hợp đồng thuê nào
                            @endif
                        </h5>
                        <p class="text-muted">
                            @if(request()->has('search') || request()->has('status') || request()->has('date_from') || request()->has('date_to'))
                                Vui lòng thử lại với bộ lọc khác
                            @else
                                Tất cả các hợp đồng thuê của bạn sẽ được hiển thị ở đây
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<script>
function confirmCancel(orderId) {
    if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')) {
        document.getElementById('cancelForm' + orderId).submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const dateFromInput = document.getElementById('date_from');
    const dateToInput = document.getElementById('date_to');
    const dateFromError = document.querySelector('.date-from-error');
    const dateToError = document.querySelector('.date-to-error');
    const searchForm = document.getElementById('search-form');
    const searchBtn = document.getElementById('search-btn');

    // Validation cho Từ ngày và Đến ngày
    function validateDates() {
        let isValid = true;

        // Ẩn tất cả thông báo lỗi
        if (dateFromError) dateFromError.style.display = 'none';
        if (dateToError) dateToError.style.display = 'none';

        const dateFrom = dateFromInput?.value;
        const dateTo = dateToInput?.value;

        // Kiểm tra Từ ngày không được lớn hơn Đến ngày
        if (dateFrom && dateTo) {
            const fromDate = new Date(dateFrom);
            const toDate = new Date(dateTo);

            if (fromDate > toDate) {
                if (dateFromError) {
                    dateFromError.textContent = 'Từ ngày không được lớn hơn Đến ngày';
                    dateFromError.style.display = 'block';
                }
                isValid = false;
            }
        }

        // Kiểm tra Đến ngày không được nhỏ hơn Từ ngày
        if (dateTo && dateFrom) {
            const fromDate = new Date(dateFrom);
            const toDate = new Date(dateTo);

            if (toDate < fromDate) {
                if (dateToError) {
                    dateToError.textContent = 'Đến ngày không được nhỏ hơn Từ ngày';
                    dateToError.style.display = 'block';
                }
                isValid = false;
            }
        }

        return isValid;
    }

    // Cập nhật min/max khi thay đổi ngày
    if (dateFromInput && dateToInput) {
        dateFromInput.addEventListener('change', function() {
            if (this.value) {
                dateToInput.min = this.value;
            } else {
                dateToInput.removeAttribute('min');
            }
            validateDates();
        });

        dateToInput.addEventListener('change', function() {
            if (this.value) {
                dateFromInput.max = this.value;
            } else {
                dateFromInput.removeAttribute('max');
            }
            validateDates();
        });
    }

    // Validate trước khi submit form
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!validateDates()) {
                e.preventDefault();
                return false;
            }
        });
    }

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
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';

            // Re-enable after 3 seconds if form doesn't submit
            setTimeout(() => {
                this.disabled = false;
                this.innerHTML = originalText;
            }, 3000);
        });
    });
});
</script>
@endsection
