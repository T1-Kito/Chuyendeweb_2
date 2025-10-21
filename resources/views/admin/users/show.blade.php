@extends('layouts.admin')

@section('title', 'Chi Tiết Người Dùng')

@section('page-title', 'Chi Tiết Người Dùng')
@section('page-description', 'Xem và quản lý quyền của người dùng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user me-2"></i>{{ $user->name }}</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>Quay lại
    </a>
</div>

@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- User Information -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-circle me-2"></i>Thông Tin Người Dùng
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                    <span class="text-white fw-bold" style="font-size: 3rem;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
                
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                
                <div class="mb-3">
                    @if($user->is_admin)
                        <span class="badge bg-success fs-6">Admin</span>
                    @else
                        <span class="badge bg-secondary fs-6">Người dùng</span>
                    @endif
                </div>
                
                <div class="text-muted small">
                    <div>ID: {{ $user->id }}</div>
                    <div>Ngày tạo: {{ $user->created_at->format('d/m/Y H:i') }}</div>
                    @if($user->updated_at != $user->created_at)
                        <div>Cập nhật: {{ $user->updated_at->format('d/m/Y H:i') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Permissions Management -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-shield me-2"></i>Quản Lý Quyền
                </h5>
            </div>
            <div class="card-body">
                                 @if($user->is_admin)
                     <form method="POST" action="{{ route('admin.users.permissions.update', $user) }}" id="permissionsForm">
                         @csrf
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         
                         <div class="row">
                             @foreach($allPermissions as $key => $label)
                             <div class="col-md-6 mb-3">
                                 <div class="form-check">
                                     <input class="form-check-input" type="checkbox" 
                                            name="permissions[]" value="{{ $key }}" 
                                            id="permission_{{ $key }}"
                                            {{ in_array($key, $userPermissions) ? 'checked' : '' }}>
                                     <label class="form-check-label" for="permission_{{ $key }}">
                                         {{ $label }}
                                     </label>
                                 </div>
                             </div>
                             @endforeach
                         </div>
                         
                         <div class="d-flex gap-2">
                             <button type="submit" class="btn btn-primary">
                                 <i class="fas fa-save me-1"></i>Cập nhật quyền
                             </button>
                         </div>
                     </form>
                     
                     @if($user->id !== auth()->id())
                         <div class="mt-3">
                             <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}" 
                                   class="d-inline">
                                 @csrf
                                 @method('PATCH')
                                 <button type="submit" class="btn btn-warning" 
                                         onclick="return confirm('Bạn có chắc muốn thu hồi quyền admin?')">
                                     <i class="fas fa-user-minus me-1"></i>Thu hồi quyền admin
                                 </button>
                             </form>
                         </div>
                     @endif
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-user-lock fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Người dùng này không phải admin</h5>
                        <p class="text-muted">Để cấp quyền, hãy cấp quyền admin trước</p>
                        
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}" 
                                  class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-user-plus me-1"></i>Cấp quyền admin
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Current Permissions Display -->
        @if($user->is_admin && !empty($userPermissions))
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-check-circle me-2"></i>Quyền Hiện Tại
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($userPermissions as $permission)
                        <span class="badge bg-success fs-6">{{ $allPermissions[$permission] ?? $permission }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.avatar-lg {
    width: 120px;
    height: 120px;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-check-label {
    cursor: pointer;
    user-select: none;
}

.badge {
    font-size: 0.875rem;
}
</style>

<script>
// Handle permissions form submission
document.getElementById('permissionsForm').addEventListener('submit', function(e) {
    // Let the form submit normally for now to test
    // e.preventDefault();
    
    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Disable submit button and show loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang cập nhật...';
    
    // Form will submit normally
});
</script>
@endsection
