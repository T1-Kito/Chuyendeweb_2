@extends('layouts.admin')

@section('title', 'Quản Lý Số Seri')
@section('page-title', 'Quản Lý Số Seri')
@section('page-description', 'Quản lý số seri của các sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-barcode me-2"></i>Quản Lý Số Seri</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-boxes me-1"></i>Quản lý sản phẩm
        </a>
    </div>
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

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $stats['total_with_serial'] }}</h4>
                        <p class="card-text">Sản phẩm có số seri</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-barcode fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $stats['total_products'] }}</h4>
                        <p class="card-text">Tổng sản phẩm</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-boxes fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $stats['without_serial'] }}</h4>
                        <p class="card-text">Chưa có số seri</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.serials.search') }}" class="row g-3">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" name="q" 
                           placeholder="Tìm kiếm theo số seri, tên sản phẩm hoặc model..." 
                           value="{{ $query ?? '' }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Tìm kiếm
                    </button>
                    @if(isset($query))
                        <a href="{{ route('admin.serials.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Xóa bộ lọc
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>
            @if(isset($query))
                Kết quả tìm kiếm cho: "{{ $query }}"
            @else
                Danh sách sản phẩm có số seri
            @endif
        </h5>
    </div>
    <div class="card-body">
        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Số seri</th>
                            <th>Model</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="img-thumbnail" 
                                     style="width: 60px; height: 60px; object-fit: cover;"
                                     onerror="this.src='https://via.placeholder.com/60x60/f3f4f6/6b7280?text=No+Image'">
                            </td>
                            <td>
                                <div>
                                    <h6 class="mb-1">{{ $product->name }}</h6>
                                    <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $product->category->name }}</span>
                            </td>
                            <td>
                                <code class="bg-light p-2 rounded">{{ $product->serial_number }}</code>
                            </td>
                            <td>
                                @if($product->model)
                                    <span class="badge bg-info">{{ $product->model }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @switch($product->status)
                                    @case('available')
                                        <span class="badge bg-success">Có sẵn</span>
                                        @break
                                    @case('rented')
                                        <span class="badge bg-warning">Đang thuê</span>
                                        @break
                                    @case('maintenance')
                                        <span class="badge bg-danger">Bảo trì</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $product->status }}</span>
                                @endswitch
                            </td>
                            <td>
                                <small class="text-muted">{{ $product->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.serials.show', $product) }}" 
                                       class="btn btn-outline-primary" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="btn btn-outline-secondary" title="Chỉnh sửa sản phẩm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">
                    @if(isset($query))
                        Không tìm thấy sản phẩm nào với từ khóa "{{ $query }}"
                    @else
                        Chưa có sản phẩm nào có số seri
                    @endif
                </h5>
                <p class="text-muted">
                    @if(isset($query))
                        Hãy thử tìm kiếm với từ khóa khác
                    @else
                        Hãy thêm số seri cho sản phẩm trong quản lý sản phẩm
                    @endif
                </p>
                @if(!isset($query))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Quản lý sản phẩm
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<style>
.img-thumbnail {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

code {
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
}

.badge {
    font-size: 0.75rem;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}
</style>
@endsection
