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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($banners->count() > 0)
                <div class="row">
                    @foreach($banners as $banner)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $banner->image_path }}" class="card-img-top" alt="Banner" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ $banner->title ?? 'Banner #' . $banner->id }}</h6>
                                <p class="card-text flex-grow-1">
                                    <small class="text-muted">
                                        <div class="mb-2">
                                            <strong>Thứ tự:</strong> {{ $banner->sort_order }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Trạng thái:</strong>
                                            @if($banner->is_active)
                                                <span class="badge bg-success">Kích hoạt</span>
                                            @else
                                                <span class="badge bg-secondary">Không kích hoạt</span>
                                            @endif
                                        </div>
                                        <div class="mb-2">
                                            <strong>Ngày tạo:</strong>
                                            <div>{{ $banner->created_at->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $banner->created_at->format('H:i') }}</small>
                                        </div>
                                        @if($banner->updated_at != $banner->created_at)
                                        <div>
                                            <strong>Cập nhật:</strong>
                                            <div>{{ $banner->updated_at->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $banner->updated_at->format('H:i') }}</small>
                                        </div>
                                        @endif
                                    </small>
                                </p>
                                <div class="mt-auto">
                                    <div class="btn-group w-100" role="group">
                                        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-outline-primary btn-sm" title="Sửa banner">
                                            <i class="fas fa-edit me-1"></i>Sửa
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                onclick="confirmDelete({{ $banner->id }})"
                                                title="Xóa banner">
                                            <i class="fas fa-trash me-1"></i>Xóa
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $banner->id }}" method="POST" action="{{ route('admin.banners.destroy', $banner) }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
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
                    <h5 class="text-muted">Không có banner nào</h5>
                    <p class="text-muted">Hãy thêm banner đầu tiên để hiển thị trên trang chủ</p>
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm Banner Đầu Tiên
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function confirmDelete(bannerId) {
    if (confirm('Bạn có chắc chắn muốn xóa banner này không?')) {
        document.getElementById('delete-form-' + bannerId).submit();
    }
}
</script>
@endsection


