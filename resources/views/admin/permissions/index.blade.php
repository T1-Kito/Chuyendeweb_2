@extends('layouts.admin')

@section('title', 'Quản Lý Quyền')

@section('page-title', 'Quản Lý Quyền')
@section('page-description', 'Phân quyền cho các admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user-shield me-2"></i>Quản Lý Quyền Admin</h2>
</div>

@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Admin</th>
                        <th>Email</th>
                        <th>Quyền</th>
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
                            <div class="permission-tags" id="permissions-{{ $user->id }}">
                                @php
                                    try {
                                        $userPermissions = $user->getPermissions();
                                    } catch (\Exception $e) {
                                        $userPermissions = [];
                                    }
                                @endphp
                                @if(!empty($userPermissions))
                                    @foreach($userPermissions as $permission)
                                        <span class="badge bg-success me-1 mb-1">{{ $permissions[$permission] ?? $permission }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">Chưa có quyền</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm" 
                                    onclick="editPermissions({{ $user->id }}, '{{ $user->name }}')">
                                <i class="fas fa-edit me-1"></i>Chỉnh sửa quyền
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Permissions Modal -->
<div class="modal fade" id="editPermissionsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa quyền cho: <span id="adminName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="permissionsForm" method="POST" action="{{ route('admin.permissions.update') }}">
                @csrf
                <input type="hidden" name="user_id" id="userId">
                <div class="modal-body">
                    <div class="row">
                        @foreach($permissions as $key => $label)
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       name="permissions[]" value="{{ $key }}" 
                                       id="permission_{{ $key }}">
                                <label class="form-check-label" for="permission_{{ $key }}">
                                    {{ $label }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cập nhật quyền</button>
                </div>
            </form>
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
    font-size: 0.75rem;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-check-label {
    cursor: pointer;
    user-select: none;
}
</style>

<script>
function editPermissions(userId, userName) {
    // Set modal title and user ID
    document.getElementById('adminName').textContent = userName;
    document.getElementById('userId').value = userId;
    
    // Get current permissions for this user
    console.log('Fetching permissions for user:', userId);
    fetch(`/admin/permissions/${userId}/permissions`)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(permissions => {
            console.log('Received permissions:', permissions);
            // Reset all checkboxes
            document.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Check permissions that user has
            permissions.forEach(permission => {
                const checkbox = document.getElementById(`permission_${permission}`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        })
        .catch(error => {
            console.error('Error fetching permissions:', error);
            alert('Có lỗi khi tải quyền: ' + error.message);
        });
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editPermissionsModal'));
    modal.show();
}

// Handle form submission - simplified to use normal form submission
document.getElementById('permissionsForm').addEventListener('submit', function(e) {
    // Don't prevent default - let form submit normally
    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Disable submit button and show loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang cập nhật...';
    
    // Form will submit normally
});
</script>
@endsection
