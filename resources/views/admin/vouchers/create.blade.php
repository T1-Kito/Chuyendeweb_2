@extends('layouts.admin')

@section('title', 'Tạo Voucher Mới')

@section('page-title', 'Tạo Voucher Mới')
@section('page-description', 'Thêm voucher giảm giá mới vào hệ thống')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus-circle me-2"></i>
                    Thông Tin Voucher
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.vouchers.store') }}">
                    @csrf
                    
                    <div class="row">
                        <!-- Tên Voucher -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Tên Voucher <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mã Voucher -->
                        <div class="col-md-6 mb-3">
                            <label for="code" class="form-label">Mã Voucher</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                   id="code" name="code" value="{{ old('code') }}" 
                                   placeholder="Để trống để tự động tạo">
                            <div class="form-text">Để trống để hệ thống tự động tạo mã</div>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Mô tả -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" 
                                  placeholder="Mô tả chi tiết về voucher...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Loại Voucher -->
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Loại Voucher <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" name="type" required>
                                <option value="">Chọn loại voucher</option>
                                <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>
                                    Phần trăm (%)
                                </option>
                                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>
                                    Số tiền cố định (đ)
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Giá trị -->
                        <div class="col-md-6 mb-3">
                            <label for="value" class="form-label">Giá trị <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('value') is-invalid @enderror" 
                                       id="value" name="value" value="{{ old('value') }}" 
                                       step="0.01" min="0" required>
                                <span class="input-group-text" id="valueUnit">%</span>
                            </div>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Đơn hàng tối thiểu -->
                        <div class="col-md-6 mb-3">
                            <label for="min_order_amount" class="form-label">Đơn hàng tối thiểu (đ)</label>
                            <input type="number" class="form-control @error('min_order_amount') is-invalid @enderror" 
                                   id="min_order_amount" name="min_order_amount" 
                                   value="{{ old('min_order_amount') }}" step="1000" min="0">
                            <div class="form-text">Để trống nếu không có yêu cầu</div>
                            @error('min_order_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Giảm tối đa -->
                        <div class="col-md-6 mb-3">
                            <label for="max_discount" class="form-label">Giảm tối đa (đ)</label>
                            <input type="number" class="form-control @error('max_discount') is-invalid @enderror" 
                                   id="max_discount" name="max_discount" 
                                   value="{{ old('max_discount') }}" step="1000" min="0">
                            <div class="form-text">Chỉ áp dụng với voucher phần trăm</div>
                            @error('max_discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Giới hạn sử dụng -->
                        <div class="col-md-6 mb-3">
                            <label for="usage_limit" class="form-label">Giới hạn sử dụng</label>
                            <input type="number" class="form-control @error('usage_limit') is-invalid @enderror" 
                                   id="usage_limit" name="usage_limit" 
                                   value="{{ old('usage_limit') }}" min="1">
                            <div class="form-text">Để trống nếu không giới hạn</div>
                            @error('usage_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Trạng thái -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" 
                                       name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Kích hoạt voucher
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Thời gian bắt đầu -->
                        <div class="col-md-6 mb-3">
                            <label for="starts_at" class="form-label">Bắt đầu từ</label>
                            <input type="datetime-local" class="form-control @error('starts_at') is-invalid @enderror" 
                                   id="starts_at" name="starts_at" value="{{ old('starts_at') }}">
                            <div class="form-text">Để trống nếu có hiệu lực ngay</div>
                            @error('starts_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Thời gian hết hạn -->
                        <div class="col-md-6 mb-3">
                            <label for="expires_at" class="form-label">Hết hạn</label>
                            <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror" 
                                   id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                            <div class="form-text">Để trống nếu không hết hạn</div>
                            @error('expires_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Quay lại
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>Tạo Voucher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px 15px 0 0;
    border: none;
    padding: 1.5rem;
}

.card-title {
    margin: 0;
    font-weight: 600;
}

.form-label {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn {
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
}

.btn-secondary {
    background: #6b7280;
    border: none;
}

.btn-secondary:hover {
    background: #4b5563;
    transform: translateY(-2px);
}

.form-text {
    font-size: 0.8rem;
    color: #6b7280;
}

.text-danger {
    color: #ef4444 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const valueUnit = document.getElementById('valueUnit');
    const valueInput = document.getElementById('value');
    const maxDiscountInput = document.getElementById('max_discount');
    const maxDiscountLabel = maxDiscountInput.previousElementSibling;

    // Update value unit based on type
    typeSelect.addEventListener('change', function() {
        if (this.value === 'percentage') {
            valueUnit.textContent = '%';
            valueInput.placeholder = 'Nhập phần trăm (ví dụ: 10)';
            maxDiscountInput.parentElement.style.display = 'block';
            maxDiscountLabel.textContent = 'Giảm tối đa (đ)';
        } else if (this.value === 'fixed') {
            valueUnit.textContent = 'đ';
            valueInput.placeholder = 'Nhập số tiền (ví dụ: 50000)';
            maxDiscountInput.parentElement.style.display = 'none';
        }
    });

    // Set default datetime for starts_at
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const datetime = `${year}-${month}-${day}T${hours}:${minutes}`;
    
    if (!document.getElementById('starts_at').value) {
        document.getElementById('starts_at').value = datetime;
    }
});
</script>
@endsection
