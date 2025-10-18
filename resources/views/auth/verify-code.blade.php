@extends('layouts.app')

@section('title', 'Xác Thực Mã - WebChoThu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Xác Thực Mã</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <p class="text-muted text-center">
                            Vui lòng nhập mã xác thực đã được gửi đến email của bạn.
                        </p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.verify.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="verification_code" class="form-label">Mã xác thực</label>
                            <input type="text" class="form-control @error('verification_code') is-invalid @enderror" 
                                   id="verification_code" name="verification_code" required autofocus
                                   placeholder="Nhập mã xác thực 64 ký tự"
                                   maxlength="64">
                            @error('verification_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Mã xác thực có 64 ký tự. Vui lòng nhập đầy đủ.
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check me-2"></i>Xác Thực Mã
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-2">Chưa nhận được mã?</p>
                        <a href="{{ route('password.request') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-redo me-1"></i>Gửi lại mã xác thực
                        </a>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">Nhớ mật khẩu? 
                        <a href="{{ route('login') }}" class="text-decoration-none">Đăng nhập ngay</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-focus vào input
document.getElementById('verification_code').focus();

// Hiển thị mã xác thực để test (chỉ trong development)
@if(app()->environment('local'))
    console.log('Mã xác thực để test: {{ session("password_reset_token") }}');
@endif
</script>
@endsection
