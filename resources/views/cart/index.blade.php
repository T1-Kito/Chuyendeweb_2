@extends('layouts.app')

@section('content')
<section class="py-5" style="margin-top: 80px;">
	<div class="container">
		<h3 class="fw-bold mb-4"><i class="fas fa-shopping-cart me-2"></i>Giỏ Hàng</h3>

		@if(session('success'))
			<div class="alert alert-success">{{ session('success') }}</div>
		@endif

		@if($items->isEmpty())
			<div class="text-center text-muted py-5">Chưa có sản phẩm nào trong giỏ.</div>
		@else
			<!-- Decorative hero strip -->
			<div class="cart-hero mb-4">
				<div class="d-flex align-items-center gap-3">
					<i class="fas fa-bag-shopping"></i>
					<div>
						<div class="fw-semibold">Giỏ hàng của bạn</div>
						<small class="opacity-75">Kiểm tra sản phẩm và cập nhật số lượng trước khi thanh toán</small>
					</div>
				</div>
			</div>

			<div class="row g-4">
				<div class="col-lg-8">
					@foreach($items as $item)
					<div class="card cart-item shadow-sm border-0 mb-3">
						<div class="card-body d-flex align-items-center justify-content-between">
							<div class="d-flex align-items-center">
								<img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="cart-thumb me-3" loading="lazy" decoding="async">
								<div>
									<div class="fw-semibold">{{ $item->product->name }}</div>
									<div class="small text-muted">{{ $item->product->category?->name ?? 'Chưa phân loại' }}</div>
									<span class="badge bg-primary-subtle text-primary border border-primary small mt-2">{{ $item->rental_duration }} tháng</span>
								</div>
							</div>
							<div class="d-flex align-items-center gap-3">
								<form action="{{ route('cart.update', $item) }}" method="post" class="d-flex align-items-center cart-qty">
									@csrf
									@method('patch')
									<button class="btn btn-sm btn-light border" onclick="this.parentNode.querySelector('input[type=number]').stepDown();"><i class="fas fa-minus"></i></button>
									<input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm text-center mx-2" style="width:70px">
									<button class="btn btn-sm btn-light border" onclick="this.parentNode.querySelector('input[type=number]').stepUp();"><i class="fas fa-plus"></i></button>
									<button class="btn btn-sm btn-outline-primary ms-2">Lưu</button>
								</form>
								<div class="text-end">
									<div class="fw-bold text-danger">{{ number_format($item->total_price) }}đ</div>
									<form action="{{ route('cart.remove', $item) }}" method="post" class="mt-1">
										@csrf
										@method('delete')
										<button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
									</form>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
				<div class="col-lg-4">
					<div class="card cart-summary sticky-top border-0" style="top: 90px;">
						<div class="card-body">
							<h5 class="fw-bold mb-3">Tổng kết</h5>
							<div class="d-flex justify-content-between mb-2">
								<span class="text-muted">Số món</span>
								<span class="fw-semibold">{{ $items->sum('quantity') }}</span>
							</div>
							<hr>
							<div class="d-flex justify-content-between align-items-center">
								<span class="fw-semibold">Tổng cộng</span>
								<span class="fs-5 fw-bold text-danger">{{ number_format($total) }}đ</span>
							</div>
							<a href="{{ route('checkout.index') }}" class="btn btn-success w-100 mt-3">
								<i class="fas fa-credit-card me-2"></i>Thanh Toán
							</a>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
</section>

<style>
.cart-thumb{width:70px;height:70px;object-fit:contain;border-radius:8px;background:#fff;border:1px solid #eef2f5;padding:6px}
.cart-item{transition:transform .2s ease}
.cart-item:hover{transform:translateY(-2px)}
.bg-primary-subtle{background:rgba(13,110,253,.08)!important}
.cart-hero{position:relative;background:linear-gradient(135deg,#f0f6ff,#fff);border:1px solid #e3edff;border-radius:14px;padding:16px 18px}
.cart-hero i{color:#0d6efd;font-size:22px}
.cart-summary{box-shadow:0 10px 25px rgba(13,110,253,.08),0 2px 8px rgba(0,0,0,.04)}
</style>
@endsection
