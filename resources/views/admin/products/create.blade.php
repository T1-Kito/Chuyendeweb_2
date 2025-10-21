@extends('layouts.app')

@section('title', 'Thêm Sản Phẩm Mới')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Thêm Sản Phẩm Mới</h1>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Lỗi:</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                        @csrf
                        
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
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mt-3">
                                <label class="form-label">Mô tả <span class="text-danger">*</span></label>
                                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mt-3">
                                <label class="form-label">Tính năng</label>
                                <textarea name="features" rows="3" class="form-control @error('features') is-invalid @enderror">{{ old('features') }}</textarea>
                                @error('features')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mt-3">
                                <label class="form-label">Số seri</label>
                                <input type="text" name="serial_number" class="form-control @error('serial_number') is-invalid @enderror" 
                                       value="{{ old('serial_number') }}" placeholder="VD: SN001, SN002...">
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Không bắt buộc - sẽ được cập nhật khi khách thuê</small>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="form-label">Model</label>
                                <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" 
                                       value="{{ old('model') }}" placeholder="VD: ZKTeco F18, MB560, ...">
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label">Thông số kỹ thuật</label>
                                <textarea id="specs" name="specs" rows="6" class="form-control @error('specs') is-invalid @enderror" placeholder='Nhập JSON (ví dụ: {"CPU":"280MHz DSP"}) hoặc từng dòng "Key: Value"'>{{ old('specs') }}</textarea>
                                @error('specs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                       value="{{ old('min_rental_months', 6) }}" min="1" max="60" required>
                                @error('min_rental_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Số lượng tồn kho</label>
                                <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                       value="{{ old('stock_quantity') }}" min="0">
                                @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                       value="{{ old('price_1_month') }}" min="0" step="1000">
                                @error('price_1_month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">Giá 6 tháng (₫)</label>
                                <input type="number" name="price_6_months" class="form-control @error('price_6_months') is-invalid @enderror" 
                                       value="{{ old('price_6_months') }}" min="0" step="1000">
                                @error('price_6_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">Giá 12 tháng (₫)</label>
                                <input type="number" name="price_12_months" class="form-control @error('price_12_months') is-invalid @enderror" 
                                       value="{{ old('price_12_months') }}" min="0" step="1000">
                                @error('price_12_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">Giá 18 tháng (₫)</label>
                                <input type="number" name="price_18_months" class="form-control @error('price_18_months') is-invalid @enderror" 
                                       value="{{ old('price_18_months') }}" min="0" step="1000">
                                @error('price_18_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label">Giá 24 tháng (₫)</label>
                                <input type="number" name="price_24_months" class="form-control @error('price_24_months') is-invalid @enderror" 
                                       value="{{ old('price_24_months') }}" min="0" step="1000">
                                @error('price_24_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                       value="{{ old('promotion_badge') }}" placeholder="VD: Ưu đãi -10%, Sản phẩm nổi bật">
                                @error('promotion_badge')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Thông tin bảo hành</label>
                                <input type="text" name="warranty_info" class="form-control @error('warranty_info') is-invalid @enderror" 
                                       value="{{ old('warranty_info') }}" placeholder="VD: Bảo hành 12 tháng">
                                @error('warranty_info')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mt-3">
                                <label class="form-label">Ngày bắt đầu khuyến mãi</label>
                                <input type="date" name="promotion_start_date" class="form-control @error('promotion_start_date') is-invalid @enderror" 
                                       value="{{ old('promotion_start_date') }}">
                                @error('promotion_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mt-3">
                                <label class="form-label">Ngày kết thúc khuyến mãi</label>
                                <input type="date" name="promotion_end_date" class="form-control @error('promotion_end_date') is-invalid @enderror" 
                                       value="{{ old('promotion_end_date') }}">
                                @error('promotion_end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mt-3">
                                <label class="form-label">Mô tả chi tiết khuyến mãi</label>
                                <textarea name="promotion_description" rows="3" class="form-control @error('promotion_description') is-invalid @enderror">{{ old('promotion_description') }}</textarea>
                                @error('promotion_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                <textarea name="rental_terms" rows="3" class="form-control @error('rental_terms') is-invalid @enderror">{{ old('rental_terms') }}</textarea>
                                @error('rental_terms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mt-3">
                                <label class="form-label">Thông tin giao hàng</label>
                                <textarea name="delivery_info" rows="3" class="form-control @error('delivery_info') is-invalid @enderror">{{ old('delivery_info') }}</textarea>
                                @error('delivery_info')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Kích hoạt sản phẩm
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" 
                                           {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Sản phẩm nổi bật
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="has_warranty_support" id="has_warranty_support" value="1" 
                                           {{ old('has_warranty_support') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_warranty_support">
                                        Hỗ trợ bảo hành
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Lưu Sản Phẩm
                                    </button>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Hủy
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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

document.addEventListener('DOMContentLoaded', () => {
    const textarea = document.getElementById('specs');
    if (textarea){
        renderSpecsPreview(textarea.value);
        textarea.addEventListener('input', () => renderSpecsPreview(textarea.value));
    }
});
</script>
@endpush
@endsection
