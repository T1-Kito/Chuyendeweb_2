@extends('layouts.admin')

@section('title', 'Quản Lý Khách Thuê')

@section('page-title', 'Quản Lý Khách Thuê')
@section('page-description', 'Theo dõi khách hàng đang thuê, sắp hết hạn và quá hạn')

@section('content')
@php
    $dateFromValue = request('date_from');
    $dateToValue = request('date_to');

    $formatDisplayDate = function ($value) {
        if (empty($value)) {
            return '';
        }

        try {
            return \Carbon\Carbon::parse($value)->format('d/m/Y');
        } catch (\Exception $e) {
            return $value;
        }
    };

    $dateFromValue = $formatDisplayDate($dateFromValue);
    $dateToValue = $formatDisplayDate($dateToValue);
@endphp

<style>
    #rentalFilterForm .form-error-floating {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        display: block;
        background: #fff;
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.2);
        border-radius: 0.375rem;
        padding: 0.4rem 0.65rem;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.1);
        max-width: 320px;
        z-index: 5;
    }

    #rentalFilterForm .form-error-floating::before {
        content: "";
        position: absolute;
        top: -6px;
        left: 16px;
        width: 10px;
        height: 10px;
        background: #fff;
        border-left: 1px solid rgba(220, 53, 69, 0.2);
        border-top: 1px solid rgba(220, 53, 69, 0.2);
        transform: rotate(45deg);
    }

    @media (max-width: 767.98px) {
        #rentalFilterForm .form-error-floating {
            max-width: 100%;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users me-2"></i>Quản Lý Khách Thuê</h2>
</div>

@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div id="rental-filter-error" class="alert alert-danger d-none" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>Vui lòng kiểm tra lại thông tin bộ lọc. Định dạng ngày phải là dd/mm/yyyy.
</div>

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
        <form method="GET" action="{{ route('admin.rentals.index') }}" class="row g-3" id="rentalFilterForm">
            <div class="col-md-3">
                <label for="search" class="form-label">Tìm kiếm</label>
                <div class="position-relative">
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ request('search') }}" placeholder="Mã đơn hàng, tên KH, SĐT..."
                           maxlength="255" title="Tối đa 255 ký tự" oninput="updateCharCounter(this)">
                    <div id="char-limit-warning" class="invalid-feedback d-none form-error-floating">
                        <i class="fas fa-exclamation-circle me-1"></i>Bạn đã nhập tối đa 255 ký tự. Vui lòng rút ngắn nội dung.
                    </div>
                </div>
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
                <label for="date_from" class="form-label">Từ ngày</label>
                <div class="position-relative">
                    <div class="input-group">
                        <input type="text" class="form-control js-date-input" id="date_from" name="date_from"
                               placeholder="dd/mm/yyyy" autocomplete="off"
                               value="{{ $dateFromValue }}" data-display-value="{{ $dateFromValue }}">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <div id="date_from_error" class="invalid-feedback d-none form-error-floating">
                        <i class="fas fa-info-circle me-1"></i>Ngày không hợp lệ. Vui lòng nhập theo định dạng dd/mm/yyyy.
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <label for="date_to" class="form-label">Đến ngày</label>
                <div class="position-relative">
                    <div class="input-group">
                        <input type="text" class="form-control js-date-input" id="date_to" name="date_to"
                               placeholder="dd/mm/yyyy" autocomplete="off"
                               value="{{ $dateToValue }}" data-display-value="{{ $dateToValue }}">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <div id="date_to_error" class="invalid-feedback d-none form-error-floating">
                        <i class="fas fa-info-circle me-1"></i>Ngày không hợp lệ. Vui lòng nhập theo định dạng dd/mm/yyyy.
                    </div>
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
                            <th>Đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Sản phẩm thuê</th>
                            <th>Thời gian thuê</th>
                            <th>Trạng thái thuê</th>
                            <th>Trạng thái đơn</th>
                            <th>Tổng tiền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="{{ $order->is_expired ? 'table-danger' : ($order->rental_end_date->diffInDays(now(), false) <= 7 ? 'table-warning' : '') }}">
                            <td>
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <div>
                                        <strong class="text-primary">{{ $order->order_number }}</strong>
                                    </div>
                                    <span class="badge {{ $order->status_badge_class }}">{{ $order->status_text }}</span>
                                </div>
                                <div class="text-muted small mb-1">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</div>
                                <small class="text-muted">{{ $order->items->count() }} sản phẩm</small>
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
                                    <small class="text-success">
                                        <i class="fas fa-clock me-1"></i>Còn {{ $order->days_remaining }} ngày
                                    </small>
                                @elseif($order->is_expired)
                                    <small class="text-danger">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Đã hết hạn {{ abs($order->days_remaining) }} ngày
                                    </small>
                                @elseif($order->rental_end_date->diffInDays(now(), false) <= 7 && $order->rental_end_date->diffInDays(now(), false) > 0)
                                    <small class="text-warning">
                                        <i class="fas fa-exclamation-circle me-1"></i>Sắp hết hạn {{ $order->days_remaining }} ngày
                                    </small>
                                @else
                                    <small class="text-info">
                                        <i class="fas fa-calendar-plus me-1"></i>Chưa bắt đầu
                                    </small>
                                @endif
                            </td>
                            <td>
                                @if($order->is_active_rental)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Đang thuê
                                    </span>
                                @elseif($order->is_expired)
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>Hết hạn
                                    </span>
                                @elseif($order->rental_end_date->diffInDays(now(), false) <= 7 && $order->rental_end_date->diffInDays(now(), false) > 0)
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Sắp hết hạn
                                    </span>
                                @else
                                    <span class="badge bg-info">
                                        <i class="fas fa-calendar-plus me-1"></i>Chưa bắt đầu
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $order->status_badge_class }}">
                                    <i class="fas fa-shopping-cart me-1"></i>{{ $order->status_text }}
                                </span>
                                <br>
                                <small class="text-muted">(Trạng thái đơn hàng)</small>
                            </td>
                            <td>
                                <strong>{{ number_format($order->total_amount) }}đ</strong>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                       class="btn btn-outline-primary" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-warning"
                                            title="Cập nhật trạng thái đơn hàng"
                                            onclick="openOrderStatusModal({{ $order->id }}, '{{ $order->status }}')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-info"
                                            title="Cập nhật thời gian thuê"
                                            onclick="openRentalModal({{ $order->id }}, '{{ $order->rental_start_date->format('Y-m-d') }}', '{{ $order->rental_end_date->format('Y-m-d') }}')">
                                        <i class="fas fa-calendar-alt"></i>
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

<!-- Order Status Update Modal -->
<div class="modal fade" id="orderStatusModal" tabindex="-1" aria-labelledby="orderStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderStatusModalLabel">Cập Nhật Trạng Thái Đơn Hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="orderStatusUpdateForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Lưu ý:</strong> Đây là trạng thái đơn hàng (pending, confirmed, processing, completed, cancelled),
                        khác với trạng thái thuê (đang thuê, hết hạn, chưa bắt đầu).
                    </div>
                    <div class="mb-3">
                        <label for="order_status" class="form-label">Trạng thái đơn hàng:</label>
                        <select class="form-select" id="order_status" name="status" required>
                            <option value="pending">Chờ xác nhận</option>
                            <option value="confirmed">Đã xác nhận</option>
                            <option value="processing">Đang xử lý</option>
                            <option value="completed">Hoàn thành</option>
                            <option value="cancelled">Đã hủy</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="order_notes" class="form-label">Ghi chú (tùy chọn):</label>
                        <textarea class="form-control" id="order_notes" name="notes" rows="3"
                                  placeholder="Nhập ghi chú về việc thay đổi trạng thái đơn hàng..."></textarea>
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

<!-- Rental Status Update Modal -->
<div class="modal fade" id="rentalModal" tabindex="-1" aria-labelledby="rentalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rentalModalLabel">Cập Nhật Thời Gian Thuê</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rentalUpdateForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Lưu ý:</strong> Cập nhật thời gian thuê sẽ ảnh hưởng đến trạng thái thuê (đang thuê, hết hạn, chưa bắt đầu).
                    </div>
                    <div class="mb-3">
                        <label for="rental_start_date" class="form-label">Ngày bắt đầu thuê:</label>
                        <input type="date" class="form-control" id="rental_start_date" name="rental_start_date" required>
                        <small class="text-muted">Ngày bắt đầu hợp đồng thuê</small>
                    </div>
                    <div class="mb-3">
                        <label for="rental_end_date" class="form-label">Ngày kết thúc thuê:</label>
                        <input type="date" class="form-control" id="rental_end_date" name="rental_end_date" required>
                        <small class="text-muted">Ngày hết hạn hợp đồng thuê</small>
                    </div>
                    <div class="mb-3">
                        <label for="rental_notes" class="form-label">Ghi chú (tùy chọn):</label>
                        <textarea class="form-control" id="rental_notes" name="notes" rows="3"
                                  placeholder="Nhập ghi chú về việc thay đổi thời gian thuê (ví dụ: gia hạn thêm 3 tháng)..."></textarea>
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

@push('scripts')
<script>
function updateCharCounter(input) {
    const maxLength = input.maxLength;
    const currentLength = input.value.length;
    const warning = document.getElementById('char-limit-warning');

    if (!warning) {
        return;
    }

    if (currentLength >= maxLength && maxLength > 0) {
        input.classList.add('is-invalid');
        warning.classList.remove('d-none');
    } else {
        input.classList.remove('is-invalid');
        warning.classList.add('d-none');
    }
}

function convertFormattedDateToISO(value) {
    const match = value.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);
    if (!match) {
        return '';
    }

    const [_, day, month, year] = match;
    return `${year}-${month}-${day}`;
}

function toggleDateError(input, shouldShow) {
    const errorElement = document.getElementById(`${input.id}_error`);
    const globalError = document.getElementById('rental-filter-error');
    if (!errorElement) {
        return;
    }

    if (shouldShow) {
        input.classList.add('is-invalid');
        errorElement.classList.remove('d-none');
        if (globalError) {
            globalError.classList.remove('d-none');
        }
    } else {
        input.classList.remove('is-invalid');
        errorElement.classList.add('d-none');
        if (globalError && document.querySelectorAll('#rentalFilterForm .js-date-input.is-invalid').length === 0) {
            globalError.classList.add('d-none');
        }
    }
}

function isValidFormattedDate(value) {
    const match = value.match(/^(\d{2})\/(\d{2})\/(\d{4})$/);
    if (!match) {
        return false;
    }

    const [_, day, month, year] = match;
    const date = new Date(year, month - 1, day);
    return date.getFullYear() === parseInt(year) && date.getMonth() === parseInt(month) - 1 && date.getDate() === parseInt(day);
}

function formatDateInputValue(rawValue) {
    const digitsOnly = rawValue.replace(/\D/g, '').slice(0, 8);
    let formatted = '';

    if (digitsOnly.length > 0) {
        formatted = digitsOnly.slice(0, Math.min(2, digitsOnly.length));
    }

    if (digitsOnly.length > 2) {
        formatted += '/' + digitsOnly.slice(2, Math.min(4, digitsOnly.length));
    }

    if (digitsOnly.length > 4) {
        formatted += '/' + digitsOnly.slice(4);
    }

    return formatted;
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    if (searchInput) {
        updateCharCounter(searchInput);
    }

    const dateInputs = document.querySelectorAll('#rentalFilterForm .js-date-input');
    dateInputs.forEach((input) => {
        if (input.dataset.displayValue) {
            input.value = input.dataset.displayValue;
        }

        input.addEventListener('input', (event) => {
            const target = event.target;
            const formatted = formatDateInputValue(target.value);
            target.value = formatted;

            const digitsCount = formatted.replace(/\D/g, '').length;
            if (digitsCount < 8) {
                toggleDateError(target, false);
            } else if (!isValidFormattedDate(formatted)) {
                toggleDateError(target, true);
            } else {
                toggleDateError(target, false);
            }
        });
    });
});

const rentalFilterForm = document.getElementById('rentalFilterForm');
if (rentalFilterForm) {
    rentalFilterForm.addEventListener('submit', function(e) {
        const dateInputs = document.querySelectorAll('#rentalFilterForm .js-date-input');
        const originalValues = Array.from(dateInputs).map((input) => input.value);
        let hasInvalid = false;

        dateInputs.forEach((input) => {
            const value = input.value;
            if (value === '') {
                toggleDateError(input, false);
                return;
            }

            if (!isValidFormattedDate(value)) {
                toggleDateError(input, true);
                hasInvalid = true;
                return;
            }

            toggleDateError(input, false);
            input.dataset.displayValue = value;
            input.value = convertFormattedDateToISO(value);
        });

        if (hasInvalid) {
            e.preventDefault();
            dateInputs.forEach((input, index) => {
                input.value = originalValues[index];
            });
            const globalError = document.getElementById('rental-filter-error');
            if (globalError) {
                globalError.classList.remove('d-none');
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh every 5 minutes to show real-time status
    setInterval(function() {
        location.reload();
    }, 5 * 60 * 1000);

    // Handle order status update form submission
    const orderStatusForm = document.getElementById('orderStatusUpdateForm');
    if (orderStatusForm) {
        orderStatusForm.addEventListener('submit', function(e) {
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
                    showAlert('Cập nhật trạng thái đơn hàng thành công!', 'success');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('orderStatusModal'));
                    modal.hide();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showAlert('Có lỗi xảy ra: ' + (data.message || 'Không thể cập nhật trạng thái'), 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Có lỗi xảy ra khi cập nhật trạng thái đơn hàng', 'danger');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }

    // Handle rental status update form submission
    const rentalForm = document.getElementById('rentalUpdateForm');
    if (rentalForm) {
        rentalForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Validate dates
            const startDate = new Date(document.getElementById('rental_start_date').value);
            const endDate = new Date(document.getElementById('rental_end_date').value);

            if (startDate > endDate) {
                showAlert('Ngày bắt đầu không được lớn hơn ngày kết thúc!', 'danger');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                return;
            }

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
                    showAlert('Cập nhật thời gian thuê thành công!', 'success');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('rentalModal'));
                    modal.hide();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showAlert('Có lỗi xảy ra: ' + (data.message || 'Không thể cập nhật thời gian thuê'), 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Có lỗi xảy ra khi cập nhật thời gian thuê', 'danger');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }
});

// Function to open order status update modal
function openOrderStatusModal(orderId, currentStatus) {
    const form = document.getElementById('orderStatusUpdateForm');
    if (form) {
        form.action = `/admin/orders/${orderId}/status`;
        document.getElementById('order_status').value = currentStatus;
        document.getElementById('order_notes').value = '';
        const modal = new bootstrap.Modal(document.getElementById('orderStatusModal'));
        modal.show();
    }
}

// Function to open rental status update modal
function openRentalModal(orderId, startDate, endDate) {
    const form = document.getElementById('rentalUpdateForm');
    if (form) {
        form.action = `/admin/orders/${orderId}/rental`;
        document.getElementById('rental_start_date').value = startDate;
        document.getElementById('rental_end_date').value = endDate;
        document.getElementById('rental_notes').value = '';
        const modal = new bootstrap.Modal(document.getElementById('rentalModal'));
        modal.show();
    }
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
