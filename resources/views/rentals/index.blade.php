@extends('layouts.app')

@section('title', 'Đơn Thuê Của Tôi - WebChoThu')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-white">Đơn Thuê Của Tôi</h1>
                <a href="{{ route('cart.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-cart me-2"></i>Giỏ Hàng
                </a>
            </div>

            @if($orders->count() > 0)
                <div class="row g-4">
                    @foreach($orders as $order)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h6 class="card-title mb-0">{{ $order->order_number }}</h6>
                                    <span class="badge {{ $order->status_badge_class }}">
                                        {{ $order->status_text }}
                                    </span>
                                </div>
                                
                                <p class="card-text small">
                                    <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Thời gian thuê:</strong> {{ $order->rental_period_text }}<br>
                                    <strong>Tổng tiền:</strong> {{ number_format($order->total_amount) }}đ
                                </p>

                                <div class="d-grid">
                                    <a href="{{ route('rentals.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Xem Chi Tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="card">
                        <div class="card-body p-5">
                            <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                            <h3 class="text-muted">Chưa có đơn thuê nào</h3>
                            <p class="text-muted">Bắt đầu thuê thiết bị đầu tiên của bạn!</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>Xem Sản Phẩm
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
