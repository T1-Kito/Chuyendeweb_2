@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<section class="py-5">
    <div class="container">
        <h3 class="mb-4">Đơn hàng của tôi</h3>
        @if($orders->count() === 0)
            <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
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
@endsection


