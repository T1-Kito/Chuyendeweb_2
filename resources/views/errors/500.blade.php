@extends('layouts.app')

@section('title', '500 - Lỗi Server')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center">
                <!-- Error Icon -->
                <div class="mb-4">
                    <i class="fas fa-exclamation-triangle fa-5x text-danger"></i>
                </div>
                
                <!-- Error Title -->
                <h1 class="display-4 fw-bold text-danger mb-3">500</h1>
                <h2 class="h4 mb-4">Lỗi Server Nội Bộ</h2>
                
                <!-- Error Message -->
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-server me-2"></i>
                    <strong>Đã xảy ra lỗi server!</strong>
                    <br>
                    <small class="text-muted mt-2 d-block">
                        Chúng tôi đang khắc phục sự cố này. Vui lòng thử lại sau ít phút.
                    </small>
                </div>
                
                <!-- Action Buttons -->
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <button onclick="window.location.reload()" class="btn btn-outline-primary">
                        <i class="fas fa-redo me-2"></i>Thử Lại
                    </button>
                    
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay Lại Trang Trước
                    </a>
                    
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Về Trang Chủ
                    </a>
                </div>
                
                <!-- Contact Support -->
                <div class="mt-4">
                    <p class="text-muted small">
                        Nếu lỗi vẫn tiếp tục, vui lòng 
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
    border-left: 4px solid #dc3545;
}

.fa-exclamation-triangle {
    animation: bounce 1s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}
</style>
@endsection
