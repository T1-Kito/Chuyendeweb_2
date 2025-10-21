@extends('layouts.app')

@section('title', 'Đăng Ký - WebChoThu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>Đăng Ký Tài Khoản</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <div class="position-relative">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                <button type="button" class="btn btn-link text-decoration-none position-absolute top-50 translate-middle-y end-0 me-2 p-0"
                                        aria-label="Hiện/ẩn mật khẩu" data-toggle="password" data-target="#password">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                            <div class="position-relative">
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                                <button type="button" class="btn btn-link text-decoration-none position-absolute top-50 translate-middle-y end-0 me-2 p-0"
                                        aria-label="Hiện/ẩn mật khẩu" data-toggle="password" data-target="#password_confirmation">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i>Đăng Ký
                            </button>
                        </div>
                    </form>
                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        document.querySelectorAll('[data-toggle="password"]').forEach(function (btn) {
                            btn.addEventListener('click', function () {
                                var input = document.querySelector(this.getAttribute('data-target'));
                                if (!input) return;
                                if (input.type === 'password') {
                                    input.type = 'text';
                                    this.querySelector('i').classList.remove('fa-eye');
                                    this.querySelector('i').classList.add('fa-eye-slash');
                                } else {
                                    input.type = 'password';
                                    this.querySelector('i').classList.remove('fa-eye-slash');
                                    this.querySelector('i').classList.add('fa-eye');
                                }
                            });
                        });
                    });
                    </script>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">Đã có tài khoản? 
                        <a href="{{ route('login') }}" class="text-decoration-none">Đăng nhập ngay</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
