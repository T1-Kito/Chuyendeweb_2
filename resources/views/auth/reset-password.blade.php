@extends('layouts.app')

@section('title', 'Đặt Lại Mật Khẩu - WebChoThu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0"><i class="fas fa-lock me-2"></i>Đặt Lại Mật Khẩu</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <p class="text-muted text-center">
                            Nhập mật khẩu mới cho tài khoản <strong>{{ $request->email }}</strong>
                        </p>
                    </div>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <input type="hidden" name="email" value="{{ $request->email }}">

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required autofocus
                                   placeholder="Nhập mật khẩu mới">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required
                                   placeholder="Nhập lại mật khẩu mới">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Đặt Lại Mật Khẩu
                            </button>
                        </div>
                    </form>
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
@endsection
