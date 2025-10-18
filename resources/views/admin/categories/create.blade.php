@extends('layouts.app')

@section('title', 'Thêm Danh Mục Mới')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Thêm Danh Mục Mới</h1>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
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
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" required placeholder="VD: Máy chấm công, Cổng barrier, Camera giám sát">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Mô tả</label>
                                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
                                              placeholder="Mô tả chi tiết về danh mục này">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Icon (Font Awesome)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-icons"></i></span>
                                        <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror" 
                                               value="{{ old('icon') }}" placeholder="VD: fas fa-clock, fas fa-shield-alt">
                                    </div>
                                    <small class="text-muted">Sử dụng class Font Awesome (VD: fas fa-clock)</small>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Màu sắc</label>
                                    <input type="color" name="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                                           value="{{ old('color', '#2563eb') }}" title="Chọn màu cho icon">
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Thứ tự sắp xếp</label>
                                    <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" 
                                           value="{{ old('sort_order', 0) }}" min="0" placeholder="0">
                                    <small class="text-muted">Số càng nhỏ càng hiển thị trước</small>
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Kích hoạt danh mục
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Icon Preview -->
                        <div class="mb-3">
                            <label class="form-label">Xem trước icon:</label>
                            <div class="border rounded p-3 bg-light">
                                <div id="iconPreview" class="text-center">
                                    <i class="fas fa-tag" style="font-size: 2rem; color: #2563eb;"></i>
                                    <p class="mt-2 mb-0 text-muted">Icon mặc định</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Lưu Danh Mục
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const iconInput = document.querySelector('input[name="icon"]');
    const colorInput = document.querySelector('input[name="color"]');
    const iconPreview = document.getElementById('iconPreview');
    
    function updateIconPreview() {
        const iconClass = iconInput.value || 'fas fa-tag';
        const color = colorInput.value || '#2563eb';
        
        iconPreview.innerHTML = `
            <i class="${iconClass}" style="font-size: 2rem; color: ${color};"></i>
            <p class="mt-2 mb-0 text-muted">${iconClass}</p>
        `;
    }
    
    iconInput.addEventListener('input', updateIconPreview);
    colorInput.addEventListener('input', updateIconPreview);
    
    // Initial preview
    updateIconPreview();
});
</script>
@endsection
