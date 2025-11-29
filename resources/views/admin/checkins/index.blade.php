@extends('layouts.admin')

@section('title', 'Quản lý điểm danh')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Quản lý điểm danh</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCheckInModal">
            <i class="fas fa-plus me-2"></i>Thêm điểm danh
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
            <strong><i class="fas fa-exclamation-triangle me-2"></i>Lỗi:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Bộ lọc</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.checkins.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Tìm kiếm (Tên/Email)</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Nhập tên hoặc email...">
                </div>
                <div class="col-md-2">
                    <label for="user_id" class="form-label">Người dùng</label>
                    <select class="form-select" id="user_id" name="user_id">
                        <option value="">Tất cả</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="form-label">Từ ngày</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" 
                           value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_to" class="form-label">Đến ngày</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" 
                           value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <label for="reward_type" class="form-label">Loại phần thưởng</label>
                    <select class="form-select" id="reward_type" name="reward_type">
                        <option value="">Tất cả</option>
                        <option value="day" {{ request('reward_type') == 'day' ? 'selected' : '' }}>Ngày</option>
                        <option value="voucher" {{ request('reward_type') == 'voucher' ? 'selected' : '' }}>Voucher</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                @if(request()->hasAny(['search', 'user_id', 'date_from', 'date_to', 'reward_type']))
                <div class="col-12">
                    <a href="{{ route('admin.checkins.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times me-1"></i>Xóa bộ lọc
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Check-ins Table -->
    <div class="card">
        <div class="card-body">
            @if($checkIns->count())
            <div class="table-responsive">
                <table class="table align-middle table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Người dùng</th>
                            <th>Ngày điểm danh</th>
                            <th>Số ngày</th>
                            <th>Phần thưởng</th>
                            <th>Đã nhận</th>
                            <th>Thời gian tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checkIns as $index => $checkIn)
                        <tr>
                            <td>{{ $checkIns->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $checkIn->user->name ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $checkIn->user->email ?? '' }}</small>
                            </td>
                            <td>
                                <strong>{{ $checkIn->check_in_date->format('d/m/Y') }}</strong><br>
                                <small class="text-muted">{{ $checkIn->check_in_date->diffForHumans() }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info">Ngày {{ $checkIn->day_number }}</span>
                            </td>
                            <td>
                                @if($checkIn->reward_type == 'voucher')
                                    <span class="badge bg-success">
                                        <i class="fas fa-gift me-1"></i>{{ $checkIn->reward_description }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">{{ $checkIn->reward_description }}</span>
                                @endif
                            </td>
                            <td>
                                @if($checkIn->is_claimed)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Đã nhận
                                    </span>
                                    @if($checkIn->claimed_at)
                                        <br><small class="text-muted">{{ $checkIn->claimed_at->format('d/m/Y H:i') }}</small>
                                    @endif
                                @else
                                    <span class="badge bg-warning text-dark">Chưa nhận</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $checkIn->created_at->format('d/m/Y H:i') }}<br>
                                {{ $checkIn->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.checkins.destroy', $checkIn->id) }}" 
                                      onsubmit="return confirm('Bạn chắc chắn muốn xoá điểm danh này?')"
                                      class="delete-checkin-form d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" data-checkin-id="{{ $checkIn->id }}">
                                        <i class="fas fa-trash me-1"></i>Xoá
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $checkIns->links() }}
            </div>
            @else
                <div class="text-muted py-5 text-center">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>Chưa có điểm danh nào.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Check-in Modal -->
<div class="modal fade" id="addCheckInModal" tabindex="-1" aria-labelledby="addCheckInModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCheckInModalLabel">
                    <i class="fas fa-plus me-2"></i>Thêm điểm danh
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.checkins.store') }}" id="addCheckInForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Người dùng <span class="text-danger">*</span></label>
                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                            <option value="">-- Chọn người dùng --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="check_in_date" class="form-label">Ngày điểm danh <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('check_in_date') is-invalid @enderror" 
                               id="check_in_date" name="check_in_date" 
                               value="{{ old('check_in_date', date('Y-m-d')) }}" required>
                        @error('check_in_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="day_number" class="form-label">Số ngày (Tùy chọn)</label>
                        <input type="number" class="form-control @error('day_number') is-invalid @enderror" 
                               id="day_number" name="day_number" 
                               value="{{ old('day_number') }}" min="1" 
                               placeholder="Để trống để tự động tính">
                        <div class="form-text">Nếu để trống, hệ thống sẽ tự động tính dựa trên chuỗi điểm danh hiện tại.</div>
                        @error('day_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Thêm điểm danh
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Kiểm tra nếu có thông báo lỗi "đã được xóa" thì tự động reload sau 2 giây
    const errorAlert = document.getElementById('errorAlert');
    if (errorAlert) {
        const errorText = errorAlert.textContent || errorAlert.innerText;
        if (errorText.includes('đã được xóa') || errorText.includes('tải lại trang')) {
            setTimeout(function() {
                window.location.reload();
            }, 2000);
        }
    }
    
    // Prevent double submit cho form xóa
    const deleteForms = document.querySelectorAll('.delete-checkin-form');
    deleteForms.forEach(form => {
        let isSubmitting = false;
        form.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }
            isSubmitting = true;
            
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang xóa...';
            }
            
            setTimeout(() => { 
                isSubmitting = false;
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            }, 3000);
        });
    });

    // Prevent double submit cho form thêm
    const addForm = document.getElementById('addCheckInForm');
    if (addForm) {
        let isSubmitting = false;
        addForm.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }
            isSubmitting = true;
            
            const submitBtn = addForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang thêm...';
            }
        });
    }

    // Reset form khi đóng modal
    const modal = document.getElementById('addCheckInModal');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('addCheckInForm');
            if (form) {
                form.reset();
                // Reset lại ngày về hôm nay
                const dateInput = form.querySelector('#check_in_date');
                if (dateInput) {
                    dateInput.value = '{{ date('Y-m-d') }}';
                }
            }
        });
    }
});
</script>
@endsection

