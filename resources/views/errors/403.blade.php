@extends('layouts.app')

@section('title', '403 - Truy Cập Bị Từ Chối')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center">
                <!-- Error Icon -->
                <div class="mb-4">
                    <i class="fas fa-ban fa-5x text-danger"></i>
                </div>
                
                <!-- Error Title -->
                <h1 class="display-4 fw-bold text-danger mb-3">403</h1>
                <h2 class="h4 mb-4">Truy Cập Bị Từ Chối</h2>
                
                <!-- Error Message -->
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Bạn không có quyền truy cập trang này!</strong>
                    <br>
                    <small class="text-muted mt-2 d-block">
                        Có thể bạn đang cố gắng truy cập một trang không tồn tại hoặc không có quyền xem nội dung này.
                    </small>
                </div>
                
                <!-- Action Buttons -->
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Quay Lại Trang Trước
                    </a>
                    
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Về Trang Chủ
                    </a>
                    
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-success">
                                <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                            </a>
                        @endif
                    @endauth
                </div>
                
                <!-- Additional Help -->
                <div class="mt-5">
                    <h5 class="text-muted mb-3">Có thể bạn đang tìm kiếm:</h5>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm w-100">
                                <i class="fas fa-home me-1"></i>Trang Chủ
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('products.show', 'may-cham-cong') }}" class="btn btn-outline-secondary btn-sm w-100">
                                <i class="fas fa-box me-1"></i>Sản Phẩm
                            </a>
                        </div>
                        @auth
                        <div class="col-md-6">
                            <a href="{{ route('rentals.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                                <i class="fas fa-calendar me-1"></i>Đơn Thuê
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                                <i class="fas fa-shopping-cart me-1"></i>Đơn Hàng
                            </a>
                        </div>
                        @endauth
                    </div>
                </div>
                
                <!-- Contact Support -->
                <div class="mt-4">
                    <p class="text-muted small">
                        Nếu bạn cho rằng đây là lỗi, vui lòng 
                        <a href="{{ route('contact') }}" class="text-decoration-none">liên hệ với chúng tôi</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.alert {
    border-left: 4px solid #ffc107;
}

.fa-ban {
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}
</style>
@endsection
