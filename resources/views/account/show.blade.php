@extends('layouts.app')

@section('title', 'Tài khoản của tôi')

@section('content')
<div class="container py-5" style="max-width: 960px;">
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-0"><i class="fas fa-id-card me-2 text-primary"></i>Xem Thông Tin Tài Khoản</h1>
    </div>

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
                    </dl>
                    <hr>
                    <div class="d-flex gap-3">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Quay Lại</a>
                        <a href="{{ route('account.edit') }}" class="btn btn-primary">Chỉnh Sửa</a>
                    </div>
            
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
