@extends('layouts.app')

@section('title', 'Tài khoản của tôi')

@section('content')
<div class="container py-5" style="max-width: 960px;">
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-0"><i class="fas fa-id-card me-2 text-primary"></i>Xem Thông Tin Tài Khoản</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="row g-0">
            <div class="col-md-4 bg-light d-flex flex-column align-items-center justify-content-start p-4">
                <div class="avatar-wrapper mb-3" style="width:180px; height:180px; border-radius:16px; overflow:hidden; background:#fff; border:1px solid #dee2e6; display:flex; align-items:center; justify-content:center;">
                    <img src="{{ $avatarUrl }}" alt="Avatar" style="max-width:100%; max-height:100%; object-fit:cover;">
                </div>
                <div class="text-muted small">Ảnh đại diện</div>
            </div>
            <div class="col-md-8">
                <div class="p-4 p-md-5">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Họ Tên</dt>
                        <dd class="col-sm-8">{{ $user->name }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $user->email }}</dd>

                        <dt class="col-sm-4">SDT</dt>
                        <dd class="col-sm-8">{{ $user->phone ?? 'Chưa cập nhật' }}</dd>

                        <dt class="col-sm-4">Địa chỉ</dt>
                        <dd class="col-sm-8">{{ $user->address ? nl2br(e($user->address)) : 'Chưa cập nhật' }}</dd>

                        <dt class="col-sm-4">Ngày Tạo</dt>
                        <dd class="col-sm-8">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '—' }}</dd>

                        <dt class="col-sm-4">Ngày Cập Nhật</dt>
                        <dd class="col-sm-8">{{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : '—' }}</dd>
                        
                        <dt class="col-sm-4">Bảo mật 2FA</dt>
                        <dd class="col-sm-8">
                            @if($user->two_factor_enabled)
                                <span class="badge bg-success"><i class="fas fa-shield-alt me-1"></i>Đã bật</span>
                            @else
                                <span class="badge bg-secondary"><i class="fas fa-exclamation-triangle me-1"></i>Chưa bật</span>
                            @endif
                        </dd>
                    </dl>
                    <hr>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Quay Lại</a>
                        <a href="{{ route('account.edit') }}" class="btn btn-primary">Chỉnh Sửa</a>
                        <a href="{{ route('account.password.edit') }}" class="btn btn-warning">
                            <i class="fas fa-key me-1"></i>Đổi Mật Khẩu
                        </a>
                        @if(!$user->two_factor_enabled)
                            <a href="{{ route('account.two-factor.form') }}" class="btn btn-outline-success">
                                <i class="fas fa-shield-alt me-1"></i>Bật bảo mật 2FA
                            </a>
                        @else
                            <form method="POST" action="{{ route('account.two-factor.disable') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Bạn chắc chắn muốn tắt bảo mật 2FA?');">
                                    <i class="fas fa-shield-alt me-1"></i>Tắt bảo mật 2FA
                                </button>
                            </form>
                        @endif
                    </div>
            
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
