@extends('layouts.app')

@section('title', 'Xác minh đăng nhập 2FA')

@section('content')
<div class="container py-5" style="max-width: 540px;">
    <div class="text-center mb-4">
        <h1 class="h3 fw-bold mb-1"><i class="fas fa-key me-2 text-primary"></i>Xác minh đăng nhập hai lớp</h1>
        <p class="text-muted mb-0">Nhập mã 6 chữ số gửi tới {{ $email ?? 'email của bạn' }} để hoàn tất đăng nhập.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('two-factor.login.store') }}" class="d-flex flex-column gap-3">
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

                <p class="small text-muted mb-0 text-center">
                    <i class="fas fa-info-circle me-1"></i>
                    Nếu bạn chưa nhận được email, hãy kiểm tra thư rác hoặc yêu cầu gửi lại mã.
                </p>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>Xác minh và đăng nhập
                    </button>
                </div>
            </form>
        </div>
        <div class="card-footer bg-white border-0 px-4 px-md-5 pb-4">
            <form method="POST" action="{{ route('two-factor.login.resend') }}" class="d-grid gap-2">
                @csrf
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-paper-plane me-2"></i>Gửi lại mã
                </button>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Hủy và quay lại đăng nhập
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
