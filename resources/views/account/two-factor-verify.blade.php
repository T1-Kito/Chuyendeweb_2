@extends('layouts.app')

@section('title', 'Xác minh mã 2FA')

@section('content')
<div class="container py-5" style="max-width: 540px;">
    <div class="mb-4 text-center">
        <h1 class="h3 fw-bold mb-1"><i class="fas fa-shield-alt me-2 text-primary"></i>Xác minh mã bảo mật</h1>
        <p class="text-muted mb-0">Nhập mã xác thực gồm 6 chữ số được gửi tới email của bạn để bật 2FA.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('account.two-factor.verify') }}" class="d-flex flex-column gap-3">
                @csrf

                <div>
                    <label for="code" class="form-label">Mã xác thực</label>
                    <input type="text"
                           id="code"
                           name="code"
                           inputmode="numeric"
                           maxlength="6"
                           class="form-control form-control-lg text-center fw-semibold tracking-widest {{ $errors->has('code') ? 'is-invalid' : '' }}"
                           placeholder="••••••"
                           autofocus
                           required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <p class="small text-muted mb-0">
                    <i class="fas fa-info-circle me-1"></i>
                    Nếu bạn chưa nhận được email, hãy kiểm tra hộp thư rác hoặc thử yêu cầu lại mã.
                </p>

                <div class="d-flex flex-column flex-md-row gap-2 mt-2">
                    <a href="{{ route('account.show') }}" class="btn btn-outline-secondary flex-fill">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại tài khoản
                    </a>
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fas fa-check me-2"></i>Xác minh và bật 2FA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
