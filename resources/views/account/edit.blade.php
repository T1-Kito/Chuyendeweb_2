@extends('layouts.app')

@section('title', 'Cập nhật tài khoản')

@section('content')
<div class="container py-5" style="max-width: 960px;">
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-0"><i class="fas fa-user-edit me-2 text-primary"></i>Cập Nhật Thông Tin Tài Khoản</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">Có lỗi, vui lòng kiểm tra:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('account.update') }}" enctype="multipart/form-data" class="card shadow-sm border-0 overflow-hidden">
        @csrf
        @method('PUT')
        <div class="row g-0">
            <div class="col-md-4 bg-light d-flex flex-column align-items-center p-4">
                <div class="avatar-wrapper mb-3" style="width:180px; height:180px; border-radius:16px; overflow:hidden; background:#fff; border:1px solid #dee2e6; display:flex; align-items:center; justify-content:center;">
                    <img id="avatarPreview" src="{{ $avatarUrl }}" alt="Avatar" style="max-width:100%; max-height:100%; object-fit:cover;">
                </div>
                <div class="d-grid w-100">
                    <label class="btn btn-success">
                        Đổi ảnh
                        <input type="file" name="avatar" accept="image/png,image/jpeg" class="d-none" onchange="previewAvatar(event)">
                    </label>
                    <div class="form-text">Hỗ trợ JPG/PNG, tối đa 2MB</div>
                    @error('avatar')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-8">
                <div class="p-4 p-md-5">
                    <div class="mb-3">
                        <label class="form-label">Họ Tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" minlength="3" maxlength="100" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" maxlength="255" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SDT <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}" maxlength="11" required>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" maxlength="255">{{ old('address', $user->address) }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="{{ route('account.show') }}" class="btn btn-outline-secondary">Huỷ</a>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewAvatar(e){
    const file = e.target.files && e.target.files[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    const img = document.getElementById('avatarPreview');
    img.src = url;
}
</script>
@endsection
