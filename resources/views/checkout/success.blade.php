@extends('layouts.app')

@section('title', 'Đặt Hàng Thành Công - WebChoThu')

@section('content')
<section class="py-5" style="margin-top: 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body py-5">
                        <!-- Success Icon -->
                        <div class="mb-4">
                            <div class="success-icon mx-auto mb-3">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h2 class="text-success mb-3">Đặt Hàng Thành Công!</h2>
                            <p class="text-muted fs-5">Cảm ơn bạn đã tin tưởng dịch vụ của chúng tôi</p>
                        </div>

                        <!-- Order Details -->
                        <div class="order-details bg-light rounded p-4 mb-4">
                            <h5 class="mb-3"><i class="fas fa-receipt me-2"></i>Thông Tin Đơn Hàng</h5>
                            <div class="row text-start">
                                <div class="col-md-6">
                                    <p><strong>Mã đơn hàng:</strong><br>
                                        <span class="text-primary fs-5">{{ $order->order_number }}</span>
                                    </p>
                                    <p><strong>Ngày đặt:</strong><br>
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </p>
                                    <p><strong>Trạng thái:</strong><br>
                                        <span class="badge {{ $order->status_badge_class }}">{{ $order->status_text }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Tổng tiền:</strong><br>
                                        <span class="text-danger fs-5 fw-bold">{{ number_format($order->total_amount) }}đ</span>
                                    </p>
                                    <p><strong>Thời gian thuê:</strong><br>
                                        {{ $order->rental_period_text }}
                                    </p>
                                    <p><strong>Phương thức thanh toán:</strong><br>
                                        @if($order->payment_method === 'cash')
                                            <i class="fas fa-money-bill-wave text-success me-1"></i>Tiền mặt
                                        @else
                                            <i class="fas fa-university text-primary me-1"></i>Chuyển khoản
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="customer-info bg-light rounded p-4 mb-4">
                            <h5 class="mb-3"><i class="fas fa-user me-2"></i>Thông Tin Khách Hàng</h5>
                            <div class="row text-start">
                                <div class="col-md-6">
                                    <p><strong>Họ và tên:</strong><br>{{ $order->customer_name }}</p>
                                    <p><strong>Email:</strong><br>{{ $order->customer_email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Số điện thoại:</strong><br>{{ $order->customer_phone }}</p>
                                    <p><strong>Địa chỉ:</strong><br>{{ $order->customer_address }}</p>
                                </div>
                            </div>
                            @if($order->notes)
                            <div class="mt-3">
                                <p><strong>Ghi chú:</strong><br>{{ $order->notes }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Order Items -->
                        <div class="order-items bg-light rounded p-4 mb-4">
                            <h5 class="mb-3"><i class="fas fa-boxes me-2"></i>Sản Phẩm Đã Đặt</h5>
                            @foreach($order->items as $item)
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" 
                                     class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item->product_name }}</h6>
                                    <small class="text-muted">{{ $item->rental_duration_months }} tháng × {{ $item->quantity }}</small>
                                </div>
                                <div class="text-end">
                                    <strong>{{ number_format($item->total_price) }}đ</strong>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Next Steps -->
                        <div class="next-steps bg-primary text-white rounded p-4 mb-4">
                            <h5 class="mb-3"><i class="fas fa-clock me-2"></i>Bước Tiếp Theo</h5>
                            <div class="row text-start">
                                <div class="col-md-6">
                                    <p><i class="fas fa-phone me-2"></i><strong>Liên hệ xác nhận:</strong><br>
                                        Nhân viên sẽ gọi điện xác nhận đơn hàng trong vòng 24h
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><i class="fas fa-truck me-2"></i><strong>Giao hàng & lắp đặt:</strong><br>
                                        Chúng tôi sẽ liên hệ để sắp xếp thời gian giao hàng
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 justify-content-center">
                            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                                <i class="fas fa-home me-2"></i>Về Trang Chủ
                            </a>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.success-icon {
    width: 80px;
    height: 80px;
    background: #d4edda;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.success-icon i {
    font-size: 3rem;
    color: #28a745;
}

.card {
    border-radius: 15px;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.badge {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
}
</style>
@endsection
