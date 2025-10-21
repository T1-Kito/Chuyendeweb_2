@extends('layouts.app')

@section('title', 'Đăng Nhập - WebChoThu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0"><i class="fas fa-sign-in-alt me-2"></i>Đăng Nhập</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
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
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Ghi nhớ đăng nhập
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Đăng Nhập
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('password.request') }}" class="text-decoration-none">
                                Quên mật khẩu?
                            </a>
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
                    <p class="mb-0">Chưa có tài khoản? 
                        <a href="{{ route('register') }}" class="text-decoration-none">Đăng ký ngay</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
