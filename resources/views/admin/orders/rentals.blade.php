@extends('layouts.admin')

@section('title', 'Quản Lý Khách Thuê')

@section('page-title', 'Quản Lý Khách Thuê')
@section('page-description', 'Theo dõi khách hàng đang thuê, sắp hết hạn và quá hạn')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users me-2"></i>Quản Lý Khách Thuê</h2>
</div>

@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $orders->where('rental_start_date', '<=', now())->where('rental_end_date', '>=', now())->count() }}</h4>
                        <small>Đang thuê</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $orders->where('rental_end_date', '>=', now())->where('rental_end_date', '<=', now()->addDays(7))->count() }}</h4>
                        <small>Sắp hết hạn (7 ngày)</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $orders->where('rental_end_date', '<', now())->count() }}</h4>
                        <small>Đã hết hạn</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $orders->where('rental_start_date', '>', now())->count() }}</h4>
                        <small>Chưa bắt đầu</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-plus fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.rentals.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Tìm kiếm</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Mã đơn hàng, tên KH, SĐT..." 
                       maxlength="265" oninput="updateCharCount(this)">
                <small class="text-muted">
                    <span id="char-count">0</span>/265 ký tự
                </small>
            </div>
            <div class="col-md-2">
                <label for="rental_status" class="form-label">Trạng thái thuê</label>
                <select class="form-select" id="rental_status" name="rental_status">
                    <option value="">Tất cả</option>
                    @foreach($rentalStatuses as $key => $label)
                        <option value="{{ $key }}" {{ request('rental_status') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="date_from" class="form-label">
                    <i class="fas fa-calendar-alt me-1"></i>Từ ngày
                </label>
                <input type="date" class="form-control" id="date_from" name="date_from" 
                       value="{{ request('date_from') }}" onchange="validateDateRange()"
                       title="Chọn ngày bắt đầu" min="1900-01-01" max="2100-12-31"
                       pattern="\d{4}-\d{2}-\d{2}" required>
                <small class="text-muted">Định dạng: dd/mm/yyyy</small>
            </div>
            <div class="col-md-2">
                <label for="date_to" class="form-label">
                    <i class="fas fa-calendar-alt me-1"></i>Đến ngày
                </label>
                <input type="date" class="form-control" id="date_to" name="date_to" 
                       value="{{ request('date_to') }}" onchange="validateDateRange()"
                       title="Chọn ngày kết thúc" min="1900-01-01" max="2100-12-31"
                       pattern="\d{4}-\d{2}-\d{2}" required>
                <small class="text-muted">Định dạng: dd/mm/yyyy</small>
                <div id="date-error" class="text-danger small mt-1" style="display: none;">
                    <i class="fas fa-exclamation-triangle me-1"></i>Ngày đến phải sau ngày từ
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-1"></i>Tìm kiếm
                </button>
                <a href="{{ route('admin.rentals.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-refresh me-1"></i>Làm mới
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Rentals List -->
<div class="card">
    <div class="card-body">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Sản phẩm thuê</th>
                            <th>Thời gian thuê</th>
                            <th>Trạng thái thuê</th>
                            <th>Ngày bắt đầu</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="{{ $order->is_expired ? 'table-danger' : ($order->rental_end_date->diffInDays(now(), false) <= 7 ? 'table-warning' : '') }}">
                            <td>
                                <strong class="text-primary">{{ $order->order_number }}</strong>
                                <br><small class="text-muted">{{ $order->items->count() }} sản phẩm</small>
                            </td>
                            <td>
                                <div><strong>{{ $order->customer_name }}</strong></div>
                                <div class="text-muted small">{{ $order->customer_phone }}</div>
                                <div class="text-muted small">{{ $order->customer_email }}</div>
                            </td>
                            <td>
                                @foreach($order->items as $item)
                                    <div class="mb-1">
                                        <strong>{{ $item->product->name }}</strong>
                                        <br><small class="text-muted">{{ $item->rental_months }} tháng</small>
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                <div class="mb-1">
                                    <strong>{{ $order->rental_period_text }}</strong>
                                </div>
                                <div class="mb-1">
                                    <span class="badge bg-secondary">{{ $order->total_months }} tháng</span>
                                </div>
                                @if($order->is_active_rental)
                                    <span class="badge bg-success">Đang thuê</span>
                                @elseif($order->is_expired)
                                    <span class="badge bg-danger">Hết hạn {{ $order->days_remaining }} ngày</span>
                                @elseif($order->rental_end_date->diffInDays(now(), false) <= 7)
                                    <span class="badge bg-warning">Sắp hết hạn {{ $order->days_remaining }} ngày</span>
                                @else
                                    <span class="badge bg-info">Chưa bắt đầu</span>
                                @endif
                            </td>
                            <td>
                                @if($order->is_active_rental)
                                    <span class="badge bg-success">Đang thuê</span>
                                @elseif($order->is_expired)
                                    <span class="badge bg-danger">Hết hạn</span>
                                @elseif($order->rental_end_date->diffInDays(now(), false) <= 7)
                                    <span class="badge bg-warning">Sắp hết hạn</span>
                                @else
                                    <span class="badge bg-info">Chưa bắt đầu</span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $order->rental_start_date->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $order->rental_start_date->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="btn btn-outline-primary" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-warning" 
                                            title="Cập nhật trạng thái" 
                                            onclick="openStatusModal({{ $order->id }}, '{{ $order->status }}')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Chưa có khách hàng nào thuê</h5>
                <p class="text-muted">Khi có đơn hàng được xác nhận, chúng sẽ xuất hiện ở đây</p>
            </div>
        @endif
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Cập Nhật Trạng Thái Đơn Hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="statusUpdateForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái mới:</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending">Chờ xác nhận</option>
                            <option value="confirmed">Đã xác nhận</option>
                            <option value="processing">Đang xử lý</option>
                            <option value="completed">Hoàn thành</option>
                            <option value="cancelled">Đã hủy</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Ghi chú (tùy chọn):</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                  placeholder="Nhập ghi chú về việc thay đổi trạng thái..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* Simple date input styling - không can thiệp vào date picker */
.form-control.is-valid {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

/* Character count styling */
#char-count {
    font-weight: 500;
    transition: color 0.3s ease;
}

/* Date error styling */
#date-error {
    font-size: 0.875rem;
    margin-top: 0.25rem;
    animation: fadeIn 0.3s ease-in;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    background-color: rgba(220, 53, 69, 0.1);
    border-left: 3px solid #dc3545;
}

#date-error[style*="color: #0dcaf0"] {
    background-color: rgba(13, 202, 240, 0.1);
    border-left-color: #0dcaf0;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Form label enhancements */
.form-label i {
    color: #6c757d;
}

/* Date input focus enhancement */
.form-control[type="date"]:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

/* Required field indicator */
.form-control[required] {
    position: relative;
}

.form-control[required]::after {
    content: '*';
    color: #dc3545;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize character count
    const searchInput = document.getElementById('search');
    if (searchInput) {
        updateCharCount(searchInput);
    }
    
    // Enhance date inputs
    enhanceDateInputs();
    
    // Initial date validation
    validateDateRange();
    
    // Auto-refresh every 5 minutes to show real-time status
    setInterval(function() {
        location.reload();
    }, 5 * 60 * 1000);
    
    // Handle status update form submission
    document.getElementById('statusUpdateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang cập nhật...';
        
        // Submit form using PATCH method
        const formData = new FormData(form);
        formData.append('_method', 'PATCH');
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showAlert('Cập nhật trạng thái thành công!', 'success');
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('statusModal'));
                modal.hide();
                
                // Reload page to show updated status
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showAlert('Có lỗi xảy ra: ' + (data.message || 'Không thể cập nhật trạng thái'), 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Có lỗi xảy ra khi cập nhật trạng thái', 'danger');
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
});

// Function to open status update modal
function openStatusModal(orderId, currentStatus) {
    // Set form action
    document.getElementById('statusUpdateForm').action = `/admin/orders/${orderId}/status`;
    
    // Set current status
    document.getElementById('status').value = currentStatus;
    
    // Clear notes
    document.getElementById('notes').value = '';
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('statusModal'));
    modal.show();
}

// Function to update character count
function updateCharCount(input) {
    const charCount = document.getElementById('char-count');
    if (charCount) {
        charCount.textContent = input.value.length;
        
        // Change color when approaching limit
        if (input.value.length > 250) {
            charCount.style.color = '#dc3545'; // Red
        } else if (input.value.length > 200) {
            charCount.style.color = '#ffc107'; // Yellow
        } else {
            charCount.style.color = '#6c757d'; // Gray
        }
    }
}

// Function to validate date range with comprehensive checks
function validateDateRange() {
    const dateFrom = document.getElementById('date_from');
    const dateTo = document.getElementById('date_to');
    const dateError = document.getElementById('date-error');
    const submitBtn = document.querySelector('button[type="submit"]');
    
    if (dateFrom && dateTo && dateError) {
        const fromValue = dateFrom.value;
        const toValue = dateTo.value;
        
        // Clear previous validation states
        dateFrom.classList.remove('is-invalid', 'is-valid');
        dateTo.classList.remove('is-invalid', 'is-valid');
        
        // Validate individual dates first
        let fromDateValid = true;
        let toDateValid = true;
        let errorMessage = '';
        
        if (fromValue) {
            const fromValidation = validateSingleDate(fromValue, 'Từ ngày');
            if (!fromValidation.isValid) {
                fromDateValid = false;
                dateFrom.classList.add('is-invalid');
                errorMessage = fromValidation.message;
            } else {
                dateFrom.classList.add('is-valid');
            }
        }
        
        if (toValue) {
            const toValidation = validateSingleDate(toValue, 'Đến ngày');
            if (!toValidation.isValid) {
                toDateValid = false;
                dateTo.classList.add('is-invalid');
                errorMessage = toValidation.message;
            } else {
                dateTo.classList.add('is-valid');
            }
        }
        
        // If individual dates are invalid, show error
        if (!fromDateValid || !toDateValid) {
            dateError.style.display = 'block';
            dateError.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i>${errorMessage}`;
            dateError.style.color = '#dc3545';
            if (submitBtn) {
                submitBtn.disabled = true;
            }
            return false;
        }
        
        // If both dates are valid, check range
        if (fromValue && toValue) {
            const fromDate = new Date(fromValue);
            const toDate = new Date(toValue);
            
            // Check if to date is after from date
            if (toDate <= fromDate) {
                dateError.style.display = 'block';
                dateError.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Ngày đến phải sau ngày từ';
                dateError.style.color = '#dc3545';
                dateTo.classList.add('is-invalid');
                if (submitBtn) {
                    submitBtn.disabled = true;
                }
                return false;
            } else {
                dateError.style.display = 'none';
                if (submitBtn) {
                    submitBtn.disabled = false;
                }
                return true;
            }
        } else if (fromValue || toValue) {
            // If only one date is filled, show info
            dateError.style.display = 'block';
            dateError.innerHTML = '<i class="fas fa-info-circle me-1"></i>Vui lòng chọn cả hai ngày để tìm kiếm chính xác';
            dateError.style.color = '#0dcaf0';
            if (submitBtn) {
                submitBtn.disabled = false;
            }
            return true;
        } else {
            dateError.style.display = 'none';
            if (submitBtn) {
                submitBtn.disabled = false;
            }
            return true;
        }
    }
    return true;
}

// Function to validate a single date
function validateSingleDate(dateString, fieldName) {
    if (!dateString) {
        return { isValid: true, message: '' };
    }
    
    // Check format (YYYY-MM-DD)
    const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
    if (!dateRegex.test(dateString)) {
        return { 
            isValid: false, 
            message: `${fieldName} không đúng định dạng (dd/mm/yyyy)` 
        };
    }
    
    // Parse date components
    const parts = dateString.split('-');
    const year = parseInt(parts[0]);
    const month = parseInt(parts[1]);
    const day = parseInt(parts[2]);
    
    // Check year range
    if (year < 1900 || year > 2100) {
        return { 
            isValid: false, 
            message: `${fieldName}: Năm phải từ 1900 đến 2100` 
        };
    }
    
    // Check month range
    if (month < 1 || month > 12) {
        return { 
            isValid: false, 
            message: `${fieldName}: Tháng phải từ 1 đến 12` 
        };
    }
    
    // Check day range based on month
    const daysInMonth = new Date(year, month, 0).getDate();
    if (day < 1 || day > daysInMonth) {
        return { 
            isValid: false, 
            message: `${fieldName}: Ngày ${day} không tồn tại trong tháng ${month}/${year}` 
        };
    }
    
    // Check for leap year February 29
    if (month === 2 && day === 29) {
        const isLeapYear = (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
        if (!isLeapYear) {
            return { 
                isValid: false, 
                message: `${fieldName}: Năm ${year} không phải năm nhuận, không có ngày 29/02` 
            };
        }
    }
    
    // Create date object and verify it's valid
    const date = new Date(year, month - 1, day);
    if (date.getFullYear() !== year || date.getMonth() !== month - 1 || date.getDate() !== day) {
        return { 
            isValid: false, 
            message: `${fieldName}: Ngày không hợp lệ` 
        };
    }
    
    return { isValid: true, message: '' };
}

// Function to format date display
function formatDateDisplay(dateInput) {
    if (dateInput && dateInput.value) {
        const date = new Date(dateInput.value);
        if (!isNaN(date.getTime())) {
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }
    }
    return '';
}

// Function to enhance date inputs without interfering with date picker
function enhanceDateInputs() {
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        // Only add title tooltip, don't interfere with date picker
        input.title = 'Định dạng: dd/mm/yyyy (ví dụ: 25/12/2024)';
    });
}

// Function to show alerts
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert alert at the top of the content
    const content = document.querySelector('.content');
    if (content) {
        content.insertBefore(alertDiv, content.firstChild);
    } else {
        document.body.insertBefore(alertDiv, document.body.firstChild);
    }
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>
@endpush
