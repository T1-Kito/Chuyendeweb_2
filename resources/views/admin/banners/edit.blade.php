@extends('layouts.app')

@section('title','Sửa Banner')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Sửa Banner</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data" class="row g-3">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label class="form-label">Tên Banner</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $banner->name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Liên kết (URL)</label>
                    <input type="url" name="link_url" class="form-control" value="{{ old('link_url',$banner->link_url) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ảnh (tải mới nếu muốn thay)</label>
                    <input type="file" name="image" class="form-control">
                    <div class="mt-2">
                        <img src="{{ $banner->image_path }}" alt="" style="max-height:120px" class="rounded">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Thứ tự</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$banner->sort_order) }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $banner->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Kích hoạt</label>
                    </div>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary" type="submit">Cập nhật</button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


