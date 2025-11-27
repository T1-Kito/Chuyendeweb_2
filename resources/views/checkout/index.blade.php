@extends('layouts.app')

@section('title', 'Thanh Toán - WebChoThu')

@section('content')
<section class="py-5" style="margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-credit-card me-2"></i>Thông Tin Thanh Toán</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('checkout.store') }}">
                            @csrf

                            <!-- Customer Information -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="customer_name" class="form-label">Họ và tên *</label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                           id="customer_name" name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}" required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="customer_phone" class="form-label">Số điện thoại *</label>
                                    <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror"
                                           id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="customer_email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('customer_email') is-invalid @enderror"
                                           id="customer_email" name="customer_email" value="{{ old('customer_email', auth()->user()->email ?? '') }}" required>
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="rental_start_date" class="form-label">Ngày bắt đầu thuê *</label>
                                    <input type="date" class="form-control @error('rental_start_date') is-invalid @enderror"
                                           id="rental_start_date" name="rental_start_date" value="{{ old('rental_start_date', date('Y-m-d')) }}" required>
                                    @error('rental_start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="customer_address" class="form-label">Địa chỉ giao hàng *</label>
                                <textarea class="form-control @error('customer_address') is-invalid @enderror"
                                          id="customer_address" name="customer_address" rows="3" required>{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="form-label">Ghi chú</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2"
                                          placeholder="Ghi chú thêm về đơn hàng...">{{ old('notes') }}</textarea>
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-4">
                                <label class="form-label">Phương thức thanh toán *</label>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check payment-method-card" style="border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; cursor: pointer; transition: all 0.3s;" onclick="selectPaymentMethod('cod')">
                                            <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                            <label class="form-check-label w-100" for="cod" style="cursor: pointer;">
                                                <div class="d-flex align-items-center">
                                                    <!-- <i class="fas fa-truck text-primary me-2" style="font-size: 1.5rem;"></i> -->
                                                    <div>
                                                        <strong>COD - Thanh toán khi nhận hàng</strong>
                                                        <br>
                                                        <small class="text-muted">Thanh toán bằng tiền mặt khi nhận được hàng</small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('payment_method')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-check me-2"></i>Xác Nhận Đặt Hàng
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Đơn Hàng Của Bạn</h5>
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                 class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $item->product->name }}</h6>
                                <small class="text-muted">{{ $item->rental_duration }} tháng × {{ $item->quantity }}</small>
                            </div>
                            <div class="text-end">
                                <strong>{{ number_format($item->total_price) }}đ</strong>
                            </div>
                        </div>
                        @endforeach

                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tổng cộng:</span>
                                <strong class="text-primary fs-5">{{ number_format($total) }}đ</strong>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Phí vận chuyển và lắp đặt sẽ được tính thêm
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.card {
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

.payment-method-card:hover {
    border-color: #0d6efd !important;
    background-color: #f8f9fa;
}

.payment-method-card input[type="radio"]:checked ~ label,
.payment-method-card:has(input[type="radio"]:checked) {
    border-color: #0d6efd !important;
    background-color: #e7f1ff;
}

.payment-method-card input[type="radio"] {
    margin-top: 0.5rem;
}
</style>

<script>
function selectPaymentMethod(method) {
    document.getElementById(method).checked = true;
    // Update card styles
    document.querySelectorAll('.payment-method-card').forEach(card => {
        const input = card.querySelector('input[type="radio"]');
        if (input.checked) {
            card.style.borderColor = '#0d6efd';
            card.style.backgroundColor = '#e7f1ff';
        } else {
            card.style.borderColor = '#e0e0e0';
            card.style.backgroundColor = 'transparent';
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.payment-method-card input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            selectPaymentMethod(this.value);
        });
    });
    // Set initial state
    const checked = document.querySelector('.payment-method-card input[type="radio"]:checked');
    if (checked) {
        selectPaymentMethod(checked.value);
    }
});
</script>
@endsection
