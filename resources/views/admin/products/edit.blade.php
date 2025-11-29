@extends('layouts.admin')

@section('page-title', 'Chỉnh Sửa Sản Phẩm')
@section('page-description', 'Chỉnh sửa thông tin sản phẩm: ' . $product->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-edit me-2"></i>
                        Chỉnh Sửa Sản Phẩm: {{ $product->name }}
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" id="productForm" novalidate>
                        @csrf
                        @method('PUT')
                        
                        <!-- Hidden field để kiểm tra conflict khi update -->
                        <input type="hidden" name="original_updated_at" value="{{ $product->updated_at->format('Y-m-d H:i:s') }}">
                        
                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Thông Tin Cơ Bản
                                </h5>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $product->name) }}" placeholder="Nhập tên sản phẩm (tối đa 255 ký tự)" required maxlength="255">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Vui lòng nhập tên sản phẩm (tối đa 255 ký tự)</div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Vui lòng chọn danh mục</div>
                            </div>
                            
                            <div class="col-12 mt-3">
                                <label class="form-label">Mô tả <span class="text-danger">*</span></label>
                                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
                                          placeholder="Nhập mô tả sản phẩm (tối đa 2500 ký tự)" required maxlength="2500">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Vui lòng nhập mô tả (tối đa 2500 ký tự)</div>
                            </div>
                            
                            <div class="col-12 mt-3">
                                <label class="form-label">Tính năng</label>
                                <textarea name="features" rows="3" class="form-control @error('features') is-invalid @enderror" 
                                          placeholder="Nhập các tính năng nổi bật (tối đa 2500 ký tự)" maxlength="2500">{{ old('features', $product->features) }}</textarea>
                                @error('features')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Tối đa 2500 ký tự</div>
                            </div>
                            
                            <div class="col-md-6 mt-3">
                                <label class="form-label">Số seri</label>
                                <input type="text" name="serial_number" class="form-control @error('serial_number') is-invalid @enderror" 
                                       value="{{ old('serial_number', $product->serial_number) }}" placeholder="VD: SN001, SN002..." maxlength="255">
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Tối đa 255 ký tự</div>
                                <small class="text-muted">Không bắt buộc - sẽ được cập nhật khi khách thuê</small>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="form-label">Model</label>
                                <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" 
                                       value="{{ old('model', $product->model) }}" placeholder="VD: ZKTeco F18, MB560, ..." maxlength="255">
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Tối đa 255 ký tự</div>
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label">Thông số kỹ thuật</label>
                                <textarea id="specs" name="specs" rows="6" class="form-control @error('specs') is-invalid @enderror" 
                                          placeholder='Nhập JSON (ví dụ: {"CPU":"280MHz DSP"}) hoặc từng dòng "Key: Value"' maxlength="2500">{{ old('specs', $product->specs) }}</textarea>
                                @error('specs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Tối đa 2500 ký tự</div>
                                <small class="text-muted">Có thể nhập JSON hoặc từng dòng dạng Key: Value. Xem preview ở khung bên dưới.</small>
                                <div class="card mt-2">
                                    <div class="card-header py-2"><small class="text-muted">Preview</small></div>
                                    <div class="card-body p-0">
                                        <table class="table table-sm mb-0" id="specsPreview"></table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mt-3">
                                <label class="form-label">Ảnh sản phẩm</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Hỗ trợ: JPG, PNG, GIF, WebP. Kích thước tối đa: 2MB</small>
                                
                                @if($product->image)
                                <div class="mt-2">
                                    <label class="form-label">Ảnh hiện tại:</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $product->image_url }}" alt="Ảnh hiện tại" style="max-width: 100px; max-height: 100px; object-fit: cover;" class="border rounded">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                                            <label class="form-check-label" for="remove_image">
                                                Xóa ảnh hiện tại
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Rental Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-clock me-2"></i>Thông Tin Thuê
                                </h5>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Thời gian thuê tối thiểu (tháng) <span class="text-danger">*</span></label>
                                <input type="number" name="min_rental_months" class="form-control @error('min_rental_months') is-invalid @enderror" 
                                       value="{{ old('min_rental_months', $product->min_rental_months) }}" min="1" max="60" placeholder="Nhập số tháng (1-60)" required>
                                @error('min_rental_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Vui lòng nhập số tháng từ 1-60</div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Số lượng tồn kho <span class="text-danger">*</span></label>
                                <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                       value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" max="99999999" placeholder="Nhập số lượng" required>
                                @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Vui lòng nhập số lượng từ 0 đến 99999999</div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-dollar-sign me-2"></i>Bảng Giá Thuê
                                </h5>
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">Giá 1 tháng (₫)</label>
                                <input type="number" name="price_1_month" class="form-control @error('price_1_month') is-invalid @enderror" 
                                       value="{{ old('price_1_month', $product->price_1_month) }}" min="0" max="99999999.99" step="1000" placeholder="Nhập giá">
                                @error('price_1_month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Giá phải từ 0 đến 99999999.99</div>
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">Giá 6 tháng (₫)</label>
                                <input type="number" name="price_6_months" class="form-control @error('price_6_months') is-invalid @enderror" 
                                       value="{{ old('price_6_months', $product->price_6_months) }}" min="0" max="99999999.99" step="1000" placeholder="Nhập giá">
                                @error('price_6_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Giá phải từ 0 đến 99999999.99</div>
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">Giá 12 tháng (₫)</label>
                                <input type="number" name="price_12_months" class="form-control @error('price_12_months') is-invalid @enderror" 
                                       value="{{ old('price_12_months', $product->price_12_months) }}" min="0" max="99999999.99" step="1000" placeholder="Nhập giá">
                                @error('price_12_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Giá phải từ 0 đến 99999999.99</div>
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">Giá 18 tháng (₫)</label>
                                <input type="number" name="price_18_months" class="form-control @error('price_18_months') is-invalid @enderror" 
                                       value="{{ old('price_18_months', $product->price_18_months) }}" min="0" max="99999999.99" step="1000" placeholder="Nhập giá">
                                @error('price_18_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Giá phải từ 0 đến 99999999.99</div>
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">Giá 24 tháng (₫)</label>
                                <input type="number" name="price_24_months" class="form-control @error('price_24_months') is-invalid @enderror" 
                                       value="{{ old('price_24_months', $product->price_24_months) }}" min="0" max="99999999.99" step="1000" placeholder="Nhập giá">
                                @error('price_24_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Giá phải từ 0 đến 99999999.99</div>
                            </div>
                        </div>

                        <!-- Promotion -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-star me-2"></i>Khuyến Mãi
                                </h5>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Badge khuyến mãi</label>
                                <input type="text" name="promotion_badge" class="form-control @error('promotion_badge') is-invalid @enderror" 
                                       value="{{ old('promotion_badge', $product->promotion_badge) }}" placeholder="VD: Ưu đãi -10%, Sản phẩm nổi bật" maxlength="100">
                                @error('promotion_badge')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Tối đa 100 ký tự</div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Thông tin bảo hành</label>
                                <input type="text" name="warranty_info" class="form-control @error('warranty_info') is-invalid @enderror" 
                                       value="{{ old('warranty_info', $product->warranty_info) }}" placeholder="VD: Bảo hành 12 tháng" maxlength="2500">
                                @error('warranty_info')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Tối đa 2500 ký tự</div>
                            </div>
                            
                            <div class="col-md-6 mt-3">
                                <label class="form-label">Ngày bắt đầu khuyến mãi</label>
                                <input type="date" name="promotion_start_date" class="form-control @error('promotion_start_date') is-invalid @enderror" 
                                       value="{{ old('promotion_start_date', $product->promotion_start_date ? $product->promotion_start_date->format('Y-m-d') : '') }}">
                                @error('promotion_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mt-3">
                                <label class="form-label">Ngày kết thúc khuyến mãi</label>
                                <input type="date" name="promotion_end_date" class="form-control @error('promotion_end_date') is-invalid @enderror" 
                                       value="{{ old('promotion_end_date', $product->promotion_end_date ? $product->promotion_end_date->format('Y-m-d') : '') }}">
                                @error('promotion_end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mt-3">
                                <label class="form-label">Mô tả chi tiết khuyến mãi</label>
                                <textarea name="promotion_description" rows="3" class="form-control @error('promotion_description') is-invalid @enderror" 
                                          placeholder="Nhập mô tả chi tiết về khuyến mãi" maxlength="2500">{{ old('promotion_description', $product->promotion_description) }}</textarea>
                                @error('promotion_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Tối đa 2500 ký tự</div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-cog me-2"></i>Thông Tin Bổ Sung
                                </h5>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">Điều khoản thuê</label>
                                <textarea name="rental_terms" rows="3" class="form-control @error('rental_terms') is-invalid @enderror" 
                                          placeholder="Nhập các điều khoản thuê" maxlength="2500">{{ old('rental_terms', $product->rental_terms) }}</textarea>
                                @error('rental_terms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Tối đa 2500 ký tự</div>
                            </div>
                            
                            <div class="col-12 mt-3">
                                <label class="form-label">Thông tin giao hàng</label>
                                <textarea name="delivery_info" rows="3" class="form-control @error('delivery_info') is-invalid @enderror" 
                                          placeholder="Nhập thông tin về giao hàng" maxlength="255">{{ old('delivery_info', $product->delivery_info) }}</textarea>
                                @error('delivery_info')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="invalid-feedback">Tối đa 255 ký tự</div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-toggle-on me-2"></i>Trạng Thái
                                </h5>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" 
                                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Kích hoạt sản phẩm
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" 
                                           {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Sản phẩm nổi bật
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="has_warranty_support" id="has_warranty_support" value="1" 
                                           {{ old('has_warranty_support', $product->has_warranty_support) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_warranty_support">
                                        Hỗ trợ bảo hành
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay Lại
                            </a>
                            
                            <div>
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-save me-2"></i>Lưu Thay Đổi
                                </button>
                                
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Hủy
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Simple preview renderer for specs field
function renderSpecsPreview(value){
    const table = document.getElementById('specsPreview');
    if(!table) return;
    table.innerHTML = '';
    let rows = {};
    try {
        const obj = JSON.parse(value);
        if (typeof obj === 'object' && obj) rows = obj;
    } catch(e){
        // parse Key: Value lines
        value.split(/\r?\n/).forEach(line => {
            const idx = line.indexOf(':');
            if (idx > -1){
                const k = line.slice(0, idx).trim();
                const v = line.slice(idx+1).trim();
                if(k) rows[k] = v;
            }
        });
    }
    for (const k in rows){
        const v = rows[k];
        if (typeof v === 'object'){
            const trHead = document.createElement('tr');
            const th = document.createElement('th'); th.colSpan = 2; th.textContent = k; th.className='bg-light';
            trHead.appendChild(th); table.appendChild(trHead);
            for (const ck in v){
                const tr = document.createElement('tr');
                tr.innerHTML = `<td class="fw-semibold" style="width:35%">${ck}</td><td>${v[ck]}</td>`;
                table.appendChild(tr);
            }
        } else {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td class="fw-semibold" style="width:35%">${k}</td><td>${v}</td>`;
            table.appendChild(tr);
        }
    }
}

// Form validation
function validateForm(form) {
    let isValid = true;
    let firstInvalidField = null;
    
    // Reset all validation states
    form.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    
    // Validate required text inputs
    const requiredFields = [
        { name: 'name', maxLength: 255 },
        { name: 'description', maxLength: 2500 },
        { name: 'min_rental_months', min: 1, max: 60, type: 'number' },
        { name: 'stock_quantity', min: 0, max: 99999999, type: 'number' }
    ];
    
    requiredFields.forEach(field => {
        const input = form.querySelector(`[name="${field.name}"]`);
        if (!input) return;
        
        const value = input.value.trim();
        
        // Check if empty
        if (!value) {
            input.classList.add('is-invalid');
            isValid = false;
            if (!firstInvalidField) firstInvalidField = input;
            return;
        }
        
        // Check maxLength for text fields
        if (field.maxLength && value.length > field.maxLength) {
            input.classList.add('is-invalid');
            isValid = false;
            if (!firstInvalidField) firstInvalidField = input;
            return;
        }
        
        // Check number range
        if (field.type === 'number') {
            const numValue = parseFloat(value);
            if (isNaN(numValue) || (field.min !== undefined && numValue < field.min) || (field.max !== undefined && numValue > field.max)) {
                input.classList.add('is-invalid');
                isValid = false;
                if (!firstInvalidField) firstInvalidField = input;
                return;
            }
        }
    });
    
    // Validate category selection
    const categorySelect = form.querySelector('[name="category_id"]');
    if (categorySelect && !categorySelect.value) {
        categorySelect.classList.add('is-invalid');
        isValid = false;
        if (!firstInvalidField) firstInvalidField = categorySelect;
    }
    
    // Validate optional fields with maxLength
    const optionalFields = [
        { name: 'features', maxLength: 2500 },
        { name: 'serial_number', maxLength: 255 },
        { name: 'model', maxLength: 255 },
        { name: 'specs', maxLength: 2500 },
        { name: 'promotion_badge', maxLength: 100 },
        { name: 'warranty_info', maxLength: 2500 },
        { name: 'promotion_description', maxLength: 2500 },
        { name: 'rental_terms', maxLength: 2500 },
        { name: 'delivery_info', maxLength: 255 }
    ];
    
    optionalFields.forEach(field => {
        const input = form.querySelector(`[name="${field.name}"]`);
        if (!input) return;
        
        const value = input.value.trim();
        if (value && field.maxLength && value.length > field.maxLength) {
            input.classList.add('is-invalid');
            isValid = false;
            if (!firstInvalidField) firstInvalidField = input;
        }
    });
    
    // Validate number fields
    const numberFields = [
        { name: 'price_1_month', min: 0, max: 99999999.99 },
        { name: 'price_6_months', min: 0, max: 99999999.99 },
        { name: 'price_12_months', min: 0, max: 99999999.99 },
        { name: 'price_18_months', min: 0, max: 99999999.99 },
        { name: 'price_24_months', min: 0, max: 99999999.99 }
    ];
    
    numberFields.forEach(field => {
        const input = form.querySelector(`[name="${field.name}"]`);
        if (!input || !input.value) return;
        
        const value = parseFloat(input.value);
        if (isNaN(value) || value < field.min || value > field.max) {
            input.classList.add('is-invalid');
            isValid = false;
            if (!firstInvalidField) firstInvalidField = input;
        }
    });
    
    // Scroll to first invalid field
    if (!isValid && firstInvalidField) {
        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstInvalidField.focus();
    }
    
    return isValid;
}

document.addEventListener('DOMContentLoaded', () => {
    const textarea = document.getElementById('specs');
    if (textarea){
        renderSpecsPreview(textarea.value);
        textarea.addEventListener('input', () => renderSpecsPreview(textarea.value));
    }
    
    // Form validation on submit
    const form = document.getElementById('productForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm(form)) {
                e.preventDefault();
                e.stopPropagation();
                
                // Show alert
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <strong>Lỗi:</strong> Vui lòng kiểm tra lại các trường đã đánh dấu đỏ.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                const existingAlert = form.parentElement.querySelector('.alert-danger');
                if (existingAlert) {
                    existingAlert.remove();
                }
                
                form.parentElement.insertBefore(alertDiv, form);
                
                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
        
        // Remove invalid class on input
        form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    // Re-validate this field
                    const value = this.value.trim();
                    const maxLength = this.getAttribute('maxlength');
                    const min = this.getAttribute('min');
                    const max = this.getAttribute('max');
                    const required = this.hasAttribute('required');
                    
                    let valid = true;
                    
                    if (required && !value) {
                        valid = false;
                    } else if (maxLength && value.length > parseInt(maxLength)) {
                        valid = false;
                    } else if (this.type === 'number' && value) {
                        const numValue = parseFloat(value);
                        if (isNaN(numValue) || 
                            (min !== null && numValue < parseFloat(min)) || 
                            (max !== null && numValue > parseFloat(max))) {
                            valid = false;
                        }
                    }
                    
                    if (valid) {
                        this.classList.remove('is-invalid');
                    }
                }
            });
        });
    }
});
</script>
@endpush
