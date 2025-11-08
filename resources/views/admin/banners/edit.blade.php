@extends('layouts.app')

@section('title','Sửa Banner')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Sửa Banner</h1>

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
            <form method="POST" action="{{ route('admin.banners.update', $banner) }}" enctype="multipart/form-data" class="row g-3" id="bannerForm">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label class="form-label">Ảnh Banner</label>
                    <input type="file" name="image" id="bannerImage" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/gif,image/webp">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="invalid-feedback" id="imageError"></div>
                    <small class="text-muted d-block mt-1">Hỗ trợ: JPG, PNG, GIF, WebP. Kích thước tối đa: 10MB</small>
                    <div class="mt-2">
                        <p class="text-muted mb-1">Ảnh hiện tại:</p>
                        <img src="{{ $banner->image_path }}" alt="Banner hiện tại" style="max-height:150px" class="rounded border img-thumbnail">
                    </div>
                    <div id="imagePreview" class="mt-2"></div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Thứ tự hiển thị <span class="text-danger">*</span></label>
                    <input type="number" name="sort_order" id="sortOrder" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $banner->sort_order) }}" min="1" required>
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="invalid-feedback" id="sortOrderError"></div>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Kích hoạt</label>
                    </div>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save me-2"></i>Lưu Banner
                    </button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bannerForm');
    const imageInput = document.getElementById('bannerImage');
    const sortOrderInput = document.getElementById('sortOrder');
    const imageError = document.getElementById('imageError');
    const sortOrderError = document.getElementById('sortOrderError');
    const imagePreview = document.getElementById('imagePreview');

    // Validate image on change
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        imageError.textContent = '';
        imageInput.classList.remove('is-invalid');
        imagePreview.innerHTML = '';

        if (!file) {
            return;
        }

        // Check file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            imageError.textContent = 'Định dạng không hợp lệ. Chỉ hỗ trợ JPG, PNG, GIF, WebP';
            imageInput.classList.add('is-invalid');
            imageInput.value = '';
            return;
        }

        // Check file size (10MB = 10 * 1024 * 1024 bytes)
        const maxSize = 10 * 1024 * 1024;
        if (file.size > maxSize) {
            imageError.textContent = 'Kích thước vượt quá 10MB';
            imageInput.classList.add('is-invalid');
            imageInput.value = '';
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.innerHTML = `
                <p class="text-success mb-1">Ảnh mới:</p>
                <img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
            `;
        };
        reader.readAsDataURL(file);
    });

    // Validate sort order on change
    sortOrderInput.addEventListener('input', function(e) {
        sortOrderError.textContent = '';
        sortOrderInput.classList.remove('is-invalid');

        const value = e.target.value;

        if (value === '') {
            sortOrderError.textContent = 'Vui lòng nhập thứ tự';
            sortOrderInput.classList.add('is-invalid');
            return;
        }

        const numValue = parseInt(value);
        if (isNaN(numValue) || numValue < 1 || !Number.isInteger(parseFloat(value))) {
            sortOrderError.textContent = 'Thứ tự phải là số nguyên dương';
            sortOrderInput.classList.add('is-invalid');
            return;
        }
    });

    // Validate form on submit
    form.addEventListener('submit', function(e) {
        let isValid = true;

        // Validate image - only if a new image is selected
        if (imageInput.files && imageInput.files.length > 0) {
            const file = imageInput.files[0];
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

            if (!validTypes.includes(file.type)) {
                imageError.textContent = 'Định dạng không hợp lệ. Chỉ hỗ trợ JPG, PNG, GIF, WebP';
                imageInput.classList.add('is-invalid');
                isValid = false;
            }

            const maxSize = 10 * 1024 * 1024;
            if (file.size > maxSize) {
                imageError.textContent = 'Kích thước vượt quá 10MB';
                imageInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        // Validate sort order
        const sortOrderValue = sortOrderInput.value;
        if (sortOrderValue === '') {
            sortOrderError.textContent = 'Vui lòng nhập thứ tự';
            sortOrderInput.classList.add('is-invalid');
            isValid = false;
        } else {
            const numValue = parseInt(sortOrderValue);
            if (isNaN(numValue) || numValue < 1 || !Number.isInteger(parseFloat(sortOrderValue))) {
                sortOrderError.textContent = 'Thứ tự phải là số nguyên dương';
                sortOrderInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>
@endsection


