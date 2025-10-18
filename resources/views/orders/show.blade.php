@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<section class="py-5">
    <div class="container">
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mb-3">&larr; Quay lại</a>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Đơn hàng {{ $order->order_number }}</h4>
                    <span class="badge {{ $order->status_badge_class }}">{{ $order->status_text }}</span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Thời gian thuê:</strong> {{ $order->rental_period_text }}</p>
                        <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method === 'cash' ? 'Tiền mặt' : 'Chuyển khoản' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tổng tiền:</strong> <span class="text-danger fw-bold">{{ number_format($order->total_amount) }}đ</span></p>
                        <p><strong>Khách hàng:</strong> {{ $order->customer_name }}</p>
                        <p><strong>SĐT/Email:</strong> {{ $order->customer_phone }} / {{ $order->customer_email }}</p>
                    </div>
                </div>
                <hr>
                <h5 class="mb-3">Sản phẩm</h5>
                @foreach($order->items as $item)
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <img src="{{ $item->product->image_url }}" alt="" class="rounded me-3" style="width:60px;height:60px;object-fit:cover;">
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $item->product_name }}</div>
                            <small class="text-muted">{{ $item->rental_duration_months }} tháng × {{ $item->quantity }}</small>
                        </div>
                        <div class="text-end fw-bold">{{ number_format($item->total_price) }}đ</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection


