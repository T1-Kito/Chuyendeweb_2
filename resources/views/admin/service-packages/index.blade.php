@extends('layouts.app')

@section('title', 'Quản Lý Gói Dịch Vụ')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-box-open me-2"></i>
                        Quản Lý Gói Dịch Vụ
                    </h3>
                    <a href="{{ route('admin.service-packages.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Thêm Gói Mới
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
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

                    @if($packages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Tên Gói</th>
                                        <th width="10%">Thời Gian</th>
                                        <th width="25%">Tính Năng</th>
                                        <th width="10%">Icon</th>
                                        <th width="10%">Trạng Thái</th>
                                        <th width="10%">Phổ Biến</th>
                                        <th width="15%">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($packages as $index => $package)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $package->name }}</strong>
                                                @if($package->description)
                                                    <br><small class="text-muted">{{ Str::limit($package->description, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $package->duration }}</span>
                                            </td>
                                            <td>
                                                @if($package->features && count($package->features) > 0)
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach(array_slice($package->features, 0, 3) as $feature)
                                                            <li><i class="fas fa-check text-success me-1"></i>{{ Str::limit($feature, 30) }}</li>
                                                        @endforeach
                                                        @if(count($package->features) > 3)
                                                            <li><small class="text-muted">+{{ count($package->features) - 3 }} tính năng khác</small></li>
                                                        @endif
                                                    </ul>
                                                @else
                                                    <span class="text-muted">Chưa có tính năng</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($package->icon)
                                                    <i class="fas fa-{{ $package->icon }} fa-lg text-primary"></i>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($package->is_active)
                                                    <span class="badge bg-success">Hoạt động</span>
                                                @else
                                                    <span class="badge bg-secondary">Tạm dừng</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($package->is_popular)
                                                    <span class="badge bg-warning">Phổ biến</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.service-packages.show', $package) }}" 
                                                       class="btn btn-sm btn-outline-info" 
                                                       title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.service-packages.edit', $package) }}" 
                                                       class="btn btn-sm btn-outline-warning" 
                                                       title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if(auth()->check() && auth()->user()->is_admin)
                                                    <form id="delete-form-{{ $package->id }}" action="{{ route('admin.service-packages.destroy', $package) }}" 
                                                          method="POST" 
                                                          class="d-inline delete-package-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-danger btn-delete-package" 
                                                                data-package-id="{{ $package->id }}"
                                                                data-package-name="{{ $package->name }}"
                                                                title="Xóa">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Chưa có gói dịch vụ nào</h5>
                            <p class="text-muted">Hãy tạo gói dịch vụ đầu tiên để bắt đầu quản lý.</p>
                            <a href="{{ route('admin.service-packages.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Tạo Gói Đầu Tiên
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete confirmation modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="confirmDeleteMessage">Bạn có chắc chắn muốn xóa gói dịch vụ này không?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
        var deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        var formToSubmit = null;

        document.querySelectorAll('.btn-delete-package').forEach(function(btn){
                btn.addEventListener('click', function(e){
                        var id = this.getAttribute('data-package-id');
                        var name = this.getAttribute('data-package-name');
                        formToSubmit = document.getElementById('delete-form-' + id);
                        var msg = 'Bạn có chắc chắn muốn xóa gói dịch vụ "' + name + '" không?';
                        document.getElementById('confirmDeleteMessage').textContent = msg;
                        deleteModal.show();
                });
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function(){
                if (formToSubmit) {
                        // submit the form
                        formToSubmit.submit();
                }
        });
});
</script>
@endpush
@endsection
