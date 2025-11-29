@extends('layouts.admin')

@section('title', 'Quản Lý Danh Mục')

@section('page-title', 'Quản Lý Danh Mục')
@section('page-description', 'Thêm, sửa và xóa danh mục sản phẩm')

@section('content')
<!-- Compact Header with Stats -->
<div class="compact-header mb-3">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="header-content">
                <h2 class="fw-bold mb-1">
                    <i class="fas fa-tags me-2"></i>Quản Lý Danh Mục
                </h2>
                <div class="stats-summary">
                    <span class="stat-item">
                        <i class="fas fa-tag text-primary"></i>
                        Tổng: {{ $totalCategories }} danh mục
                    </span>
                    <span class="stat-item">
                        <i class="fas fa-check-circle text-success"></i>
                        Kích hoạt: {{ $activeCategories }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>Thêm danh mục
            </a>
        </div>
    </div>
</div>

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Icon</th>
                                <th>Tên Danh Mục</th>
                                <th>Mô Tả</th>
                                <th>Số Sản Phẩm</th>
                                <th>Thứ Tự</th>
                                <th>Trạng Thái</th>
                                <th>Ngày Tạo</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    @if($category->icon)
                                        <i class="{{ $category->icon }}" style="color: {{ $category->color ?? '#333' }}; font-size: 1.2rem;"></i>
                                    @else
                                        <i class="fas fa-tag text-muted"></i>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    <br><small class="text-muted">{{ $category->slug }}</small>
                                </td>
                                <td>
                                    @if($category->description)
                                        {{ Str::limit($category->description, 50) }}
                                    @else
                                        <span class="text-muted">Chưa có mô tả</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $category->products()->count() }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $category->sort_order ?? 0 }}</span>
                                </td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success">Kích hoạt</span>
                                    @else
                                        <span class="badge bg-secondary">Tắt</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $category->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger" 
                                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Info -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Hiển thị {{ $categories->firstItem() }} đến {{ $categories->lastItem() }} trong {{ $categories->total() }} kết quả
                    </div>
                </div>

                <!-- Pagination -->
                @if($categories->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($categories->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $categories->previousPageUrl() }}" rel="prev">&laquo;</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                                @if ($page == $categories->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($categories->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $categories->nextPageUrl() }}" rel="next">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Chưa có danh mục nào</h5>
                    <p class="text-muted">Hãy thêm danh mục đầu tiên để phân loại sản phẩm</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm Danh Mục Đầu Tiên
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
