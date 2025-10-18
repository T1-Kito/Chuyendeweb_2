@extends('layouts.admin')

@section('title','Quản Lý Banner')

@section('page-title', 'Quản Lý Banner')
@section('page-description', 'Thêm, sửa và xóa banner quảng cáo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-images me-2"></i>Danh Sách Banner</h2>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Thêm Banner
    </a>
</div>

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($banners->count() > 0)
                <div class="row">
                    @foreach($banners as $banner)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ $banner->image_path }}" class="card-img-top" alt="Banner" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">{{ $banner->title }}</h6>
                                <p class="card-text">
                                    <small class="text-muted">
                                        Thứ tự: {{ $banner->sort_order }}<br>
                                        Trạng thái: 
                                        @if($banner->is_active)
                                            <span class="badge bg-success">Kích hoạt</span>
                                        @else
                                            <span class="badge bg-secondary">Tắt</span>
                                        @endif
                                    </small>
                                </p>
                                <div class="btn-group w-100">
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa banner này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có banner nào</h5>
                    <p class="text-muted">Hãy thêm banner đầu tiên để hiển thị trên trang chủ</p>
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm Banner Đầu Tiên
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection


