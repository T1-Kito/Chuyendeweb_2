@extends('layouts.admin')

@section('title', 'Quản Lý Người Dùng')

@section('page-title', 'Quản Lý Người Dùng')
@section('page-description', 'Xem và quản lý tất cả người dùng trong hệ thống')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users me-2"></i>Danh Sách Người Dùng</h2>
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
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Người dùng</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Quyền</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <span class="text-white fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    <br><small class="text-muted">ID: {{ $user->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge bg-success">Admin</span>
                            @else
                                <span class="badge bg-secondary">Người dùng</span>
                            @endif
                        </td>
                        <td>
                            <div class="permission-tags">
                                @if($user->is_admin)
                                    @php
                                        $userPermissions = $user->getPermissions();
                                    @endphp
                                    @foreach($userPermissions as $permission)
                                        <span class="badge bg-info me-1 mb-1 small">{{ $permission }}</span>
                                    @endforeach
                                    @if(empty($userPermissions))
                                        <span class="text-muted small">Chưa có quyền</span>
                                    @endif
                                @else
                                    <span class="text-muted small">Không có quyền admin</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div>{{ $user->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $user->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="btn btn-outline-primary" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}" 
                                          class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning" 
                                                title="{{ $user->is_admin ? 'Thu hồi quyền admin' : 'Cấp quyền admin' }}">
                                            @if($user->is_admin)
                                                <i class="fas fa-user-minus"></i>
                                            @else
                                                <i class="fas fa-user-plus"></i>
                                            @endif
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                          class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">Bạn</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 16px;
}

.permission-tags .badge {
    font-size: 0.7rem;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}
</style>
@endsection
