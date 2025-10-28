@extends('layouts.app')

@section('title','Thêm Banner')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Thêm Banner</h1>
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Lỗi:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label class="form-label">Ảnh Banner <span class="text-danger">*</span></label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" required accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Hỗ trợ: JPG, PNG, GIF, WebP. Kích thước tối đa: 10MB</small>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Thứ tự hiển thị</label>
                    <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="1" min="0">
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Kích hoạt</label>
                    </div>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save me-2"></i>Lưu Banner
                    </button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


