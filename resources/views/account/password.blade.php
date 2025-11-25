@extends('layouts.app')

@section('title', 'Đổi mật khẩu')

@section('content')
<div class="container py-5" style="max-width: 640px;">
    <div class="mb-4 text-center">
        <h1 class="h3 fw-bold mb-1">
            <i class="fas fa-key text-warning me-2"></i>Đổi Mật Khẩu
        </h1>
        <p class="text-muted mb-0">Vui lòng nhập mật khẩu hiện tại và mật khẩu mới của bạn.</p>
    </div>

    @php
        $messages = $errors->getMessages();
        unset($messages['password_confirmation']);
        $displayErrors = [];
        foreach ($messages as $fieldMessages) {
            foreach ((array) $fieldMessages as $message) {
                $displayErrors[] = $message;
            }
        }
    @endphp

    @if (!empty($displayErrors))
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">Có lỗi xảy ra, vui lòng kiểm tra:</div>
            <ul class="mb-0">
                @foreach ($displayErrors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('account.password.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-semibold">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required autocomplete="current-password" maxlength="255">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password" aria-label="Hiển thị mật khẩu hiện tại">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Mật khẩu mới <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password" maxlength="255">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password" aria-label="Hiển thị mật khẩu mới">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @if (!$errors->has('password'))
                        <div class="form-text">Mật khẩu phải có tối thiểu 8 ký tự.</div>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-check"></i></span>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password" maxlength="255">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation" aria-label="Hiển thị xác nhận mật khẩu">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between flex-wrap gap-3">
                    <a href="{{ route('account.show') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>Lưu mật khẩu mới
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.toggle-password').forEach(function(btn){
        btn.addEventListener('click', function(){
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            if (!input) return;
            const icon = this.querySelector('i');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            if (icon){
                icon.classList.toggle('fa-eye', !isHidden);
                icon.classList.toggle('fa-eye-slash', isHidden);
            }
            this.setAttribute('aria-label', isHidden ? 'Ẩn mật khẩu' : 'Hiển thị mật khẩu');
        });
    });
});
</script>
@endpush
@endsection
