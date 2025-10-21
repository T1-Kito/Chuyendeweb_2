@extends('layouts.admin')

@section('title', 'Quản Lý Danh Mục')

@section('page-title', 'Quản Lý Danh Mục')
@section('page-description', 'Thêm, sửa và xóa danh mục sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tags me-2"></i>Danh Sách Danh Mục</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Thêm Danh Mục
    </a>
</div>

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
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
                                            @method('DELETE')
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
