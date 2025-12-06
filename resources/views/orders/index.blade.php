@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<section class="py-5">
    <div class="container">
        <h3 class="mb-4">Đơn hàng của tôi</h3>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('orders.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Tìm kiếm theo mã đơn hàng</label>
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="Nhập mã đơn hàng...">
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Tất cả</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2" id="search-btn">
                            <i class="fas fa-search me-1"></i>Tìm kiếm
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary" id="reset-btn">
                            <i class="fas fa-redo me-1"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if($orders->count() === 0)
            <div class="alert alert-info">
                @if(request()->has('search') || request()->has('status'))
                    Không tìm thấy đơn hàng nào phù hợp với bộ lọc của bạn.
                @else
                    Bạn chưa có đơn hàng nào.
                @endif
            </div>
        @else
            <div class="card">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td class="fw-semibold">{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-danger fw-bold">{{ number_format($order->total_amount) }}đ</td>
                                <td><span class="badge {{ $order->status_badge_class }}">{{ $order->status_text }}</span></td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-primary" href="{{ route('orders.show', $order) }}">Xem</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</section>

<style>
/* Smooth button hover effects */
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

/* Smooth form controls */
.form-select, .form-control {
    transition: all 0.2s ease;
    border-radius: 8px;
}

.form-select:focus, .form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* Override card hover effect - reduce movement */
.card {
    transition: all 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('form[method="GET"]');
    const searchBtn = document.getElementById('search-btn');

    // Validate trước khi submit form
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            // Disable button to prevent double submission
            if (searchBtn) {
                searchBtn.disabled = true;
                searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang tìm kiếm...';
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
        });
    });
});
</script>
@endsection


