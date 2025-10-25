@extends('layouts.app')

@section('title', 'Chỉnh Sửa Gói Dịch Vụ')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Chỉnh Sửa Gói Dịch Vụ: {{ $servicePackage->name }}
                    </h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.service-packages.update', $servicePackage) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên Gói <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $servicePackage->name) }}" 
                                           placeholder="VD: Gói 6 Tháng" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Thời Gian <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="duration" class="form-control @error('duration') is-invalid @enderror" 
                                            id="duration_number" value="{{ old('duration') ? intval(preg_replace('/[^0-9]/','', old('duration'))) : intval(preg_replace('/[^0-9]/','', $servicePackage->duration)) }}" 
                                            placeholder="VD: 6" required min="1" max="60">
                                        <span class="input-group-text">Tháng</span>
                                    </div>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô Tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Mô tả ngắn về gói dịch vụ">{{ old('description', $servicePackage->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tính Năng <span class="text-danger">*</span></label>
                            <div id="features-container">
                                @php
                                    // Ưu tiên dữ liệu từ database, chỉ dùng old() khi có validation error
                                    $features = $servicePackage->features ?? [];
                                    if (old('features') && session()->has('errors')) {
                                        $features = old('features');
                                    }
                                @endphp
                                @if(count($features) > 0)
                                    @foreach($features as $index => $feature)
                                        <div class="input-group mb-2 feature-item">
                                            <input type="text" class="form-control @error('features.'.$index) is-invalid @enderror" 
                                                   name="features[]" value="{{ $feature }}" 
                                                   placeholder="Nhập tính năng">
                                            <button type="button" class="btn btn-outline-danger remove-feature">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2 feature-item">
                                        <input type="text" class="form-control" name="features[]" 
                                               placeholder="Nhập tính năng">
                                        <button type="button" class="btn btn-outline-danger remove-feature">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="add-feature">
                                <i class="fas fa-plus me-1"></i>
                                Thêm Tính Năng
                            </button>
                            @error('features')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="icon" class="form-label">Icon</label>
                                    <select class="form-select @error('icon') is-invalid @enderror" 
                                            id="icon" name="icon">
                                        <option value="">Chọn icon</option>
                                        <option value="clock" {{ old('icon', $servicePackage->icon) == 'clock' ? 'selected' : '' }}>Clock</option>
                                        <option value="crown" {{ old('icon', $servicePackage->icon) == 'crown' ? 'selected' : '' }}>Crown</option>
                                        <option value="diamond" {{ old('icon', $servicePackage->icon) == 'diamond' ? 'selected' : '' }}>Diamond</option>
                                        <option value="star" {{ old('icon', $servicePackage->icon) == 'star' ? 'selected' : '' }}>Star</option>
                                        <option value="gem" {{ old('icon', $servicePackage->icon) == 'gem' ? 'selected' : '' }}>Gem</option>
                                        <option value="trophy" {{ old('icon', $servicePackage->icon) == 'trophy' ? 'selected' : '' }}>Trophy</option>
                                    </select>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="button_text" class="form-label">Text Nút <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('button_text') is-invalid @enderror" 
                                           id="button_text" name="button_text" value="{{ old('button_text', $servicePackage->button_text) }}" 
                                           placeholder="VD: Xem Chi Tiết" required>
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="button_icon" class="form-label">Icon Nút</label>
                                    <select class="form-select @error('button_icon') is-invalid @enderror" 
                                            id="button_icon" name="button_icon">
                                        <option value="">Chọn icon nút</option>
                                        <option value="arrow-right" {{ old('button_icon', $servicePackage->button_icon) == 'arrow-right' ? 'selected' : '' }}>Arrow Right</option>
                                        <option value="star" {{ old('button_icon', $servicePackage->button_icon) == 'star' ? 'selected' : '' }}>Star</option>
                                        <option value="diamond" {{ old('button_icon', $servicePackage->button_icon) == 'diamond' ? 'selected' : '' }}>Diamond</option>
                                        <option value="check" {{ old('button_icon', $servicePackage->button_icon) == 'check' ? 'selected' : '' }}>Check</option>
                                        <option value="plus" {{ old('button_icon', $servicePackage->button_icon) == 'plus' ? 'selected' : '' }}>Plus</option>
                                    </select>
                                    @error('button_icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="button_color" class="form-label">Màu Nút <span class="text-danger">*</span></label>
                                    <select class="form-select @error('button_color') is-invalid @enderror" 
                                            id="button_color" name="button_color" required>
                                        <option value="primary" {{ old('button_color', $servicePackage->button_color) == 'primary' ? 'selected' : '' }}>Primary (Xanh)</option>
                                        <option value="success" {{ old('button_color', $servicePackage->button_color) == 'success' ? 'selected' : '' }}>Success (Xanh lá)</option>
                                        <option value="warning" {{ old('button_color', $servicePackage->button_color) == 'warning' ? 'selected' : '' }}>Warning (Vàng)</option>
                                        <option value="danger" {{ old('button_color', $servicePackage->button_color) == 'danger' ? 'selected' : '' }}>Danger (Đỏ)</option>
                                        <option value="info" {{ old('button_color', $servicePackage->button_color) == 'info' ? 'selected' : '' }}>Info (Xanh dương)</option>
                                        <option value="secondary" {{ old('button_color', $servicePackage->button_color) == 'secondary' ? 'selected' : '' }}>Secondary (Xám)</option>
                                    </select>
                                    @error('button_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Thứ Tự Sắp Xếp</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', $servicePackage->sort_order) }}" 
                                           min="0" placeholder="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_popular" name="is_popular" 
                                               {{ old('is_popular', $servicePackage->is_popular) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_popular">
                                            Gói Phổ Biến
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               {{ old('is_active', $servicePackage->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Hoạt Động
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.service-packages.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Quay Lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Cập Nhật Gói Dịch Vụ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Thêm tính năng mới
    document.getElementById('add-feature').addEventListener('click', function() {
        console.log('Add feature button clicked');
        const container = document.getElementById('features-container');
        const newFeature = document.createElement('div');
        newFeature.className = 'input-group mb-2 feature-item';
        newFeature.innerHTML = `
            <input type="text" class="form-control" name="features[]" placeholder="Nhập tính năng">
            <button type="button" class="btn btn-outline-danger remove-feature">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(newFeature);
    });

    // Xóa tính năng
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-feature')) {
            console.log('Remove feature clicked');
            e.target.closest('.feature-item').remove();
        }
    });

    // Debug form submit
    document.querySelector('form').addEventListener('submit', function(e) {
        console.log('Form submitted');
        console.log('Form data:', new FormData(this));
    });
});
</script>
@endpush
@endsection
