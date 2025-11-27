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

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('rentals.index') }}" class="row g-3" id="search-form">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Hợp đồng</label>
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="Hợp đồng, thiết bị">
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Tất cả</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang hiệu lực</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Hết hiệu lực</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">Từ ngày</label>
                        <input type="date" class="form-control" id="date_from" name="date_from"
                               value="{{ request('date_from') }}" max="{{ request('date_to') ?: '' }}">
                        <small class="text-danger date-from-error" style="display:none;"></small>
                    </div>
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">Đến ngày</label>
                        <input type="date" class="form-control" id="date_to" name="date_to"
                               value="{{ request('date_to') }}" min="{{ request('date_from') ?: '' }}">
                        <small class="text-danger date-to-error" style="display:none;"></small>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2" id="search-btn">
                            <i class="fas fa-search me-1"></i>Tìm kiếm
                        </button>
                        <a href="{{ route('rentals.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh me-1"></i>Làm mới
                        </a>
                    </div>
                </form>
            </div>
        </div>

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
                                        @if($order->is_expired)
                                            <small class="text-danger">Đã hết hạn</small>
                                        @elseif($order->is_active_rental)
                                            <small class="text-success">Còn {{ $order->days_remaining }} ngày</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->is_active_rental)
                                            <span class="badge bg-success">Đang hiệu lực</span>
                                        @elseif($order->is_expired)
                                            <span class="badge bg-secondary">Hết hiệu lực</span>
                                        @else
                                            <span class="badge bg-warning">Chưa bắt đầu</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $order->total_months }} tháng</div>
                                        <small class="text-muted">{{ $order->rental_period_text }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('rentals.show', $order) }}"
                                               class="btn btn-outline-primary" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if($order->is_active_rental)
                                            <button type="button" class="btn btn-outline-success"
                                                    title="Gia hạn hợp đồng"
                                                    onclick="alert('Chức năng gia hạn đang được phát triển')">
                                                <i class="fas fa-calendar-plus"></i>
                                            </button>
                                            @elseif($order->is_expired)
                                            <button type="button" class="btn btn-outline-secondary"
                                                    title="Không thể gia hạn hợp đồng đã hết hiệu lực"
                                                    disabled>
                                                <i class="fas fa-calendar-times"></i>
                                            </button>
                                            @endif
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
                                Khi có hợp đồng thuê mới, chúng sẽ xuất hiện ở đây
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<script>
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
