@extends('layouts.app')

@section('title', 'Tạo Gói Dịch Vụ Mới')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card compact-form">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Tạo Gói Dịch Vụ Mới
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

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.service-packages.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên Gói <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" 
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
                                        <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                                            id="duration_number" value="{{ old('duration') ? intval(old('duration')) : '' }}" 
                                            placeholder="VD: 6" required min="1" max="60">
                                        <span class="input-group-text">Tháng</span>
                                    </div>
                                    <input type="hidden" name="duration" id="duration">
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
                                      placeholder="Mô tả ngắn về gói dịch vụ">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tính Năng <span class="text-danger">*</span></label>
                            <div id="features-container">
                                @if(old('features'))
                                    @foreach(old('features') as $index => $feature)
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
                                        <option value="clock" {{ old('icon') == 'clock' ? 'selected' : '' }}>Clock</option>
                                        <option value="crown" {{ old('icon') == 'crown' ? 'selected' : '' }}>Crown</option>
                                        <option value="diamond" {{ old('icon') == 'diamond' ? 'selected' : '' }}>Diamond</option>
                                        <option value="star" {{ old('icon') == 'star' ? 'selected' : '' }}>Star</option>
                                        <option value="gem" {{ old('icon') == 'gem' ? 'selected' : '' }}>Gem</option>
                                        <option value="trophy" {{ old('icon') == 'trophy' ? 'selected' : '' }}>Trophy</option>
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
                                           id="button_text" name="button_text" value="{{ old('button_text', 'Xem Chi Tiết') }}" 
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
                                        <option value="arrow-right" {{ old('button_icon') == 'arrow-right' ? 'selected' : '' }}>Arrow Right</option>
                                        <option value="star" {{ old('button_icon') == 'star' ? 'selected' : '' }}>Star</option>
                                        <option value="diamond" {{ old('button_icon') == 'diamond' ? 'selected' : '' }}>Diamond</option>
                                        <option value="check" {{ old('button_icon') == 'check' ? 'selected' : '' }}>Check</option>
                                        <option value="plus" {{ old('button_icon') == 'plus' ? 'selected' : '' }}>Plus</option>
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
                                        <option value="primary" {{ old('button_color', 'primary') == 'primary' ? 'selected' : '' }}>Primary (Xanh)</option>
                                        <option value="success" {{ old('button_color') == 'success' ? 'selected' : '' }}>Success (Xanh lá)</option>
                                        <option value="warning" {{ old('button_color') == 'warning' ? 'selected' : '' }}>Warning (Vàng)</option>
                                        <option value="danger" {{ old('button_color') == 'danger' ? 'selected' : '' }}>Danger (Đỏ)</option>
                                        <option value="info" {{ old('button_color') == 'info' ? 'selected' : '' }}>Info (Xanh dương)</option>
                                        <option value="secondary" {{ old('button_color') == 'secondary' ? 'selected' : '' }}>Secondary (Xám)</option>
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
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" 
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
                                               {{ old('is_popular') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_popular">
                                            Gói Phổ Biến
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Hoạt Động
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.service-packages.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Quay Lại
                            </a>
                            <button type="submit" id="submit-btn" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Tạo Gói Dịch Vụ
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
    // Handle duration input
    const durationNumber = document.getElementById('duration_number');
    const durationHidden = document.getElementById('duration');
    
    function updateDuration() {
        const val = durationNumber.value.trim();
        if (val && !isNaN(val) && parseInt(val) >= 1 && parseInt(val) <= 60) {
            durationHidden.value = val + ' Tháng';
        } else {
            durationHidden.value = '';
        }
    }
    
    durationNumber.addEventListener('input', updateDuration);
    durationNumber.addEventListener('change', updateDuration);
    
    // Set initial value
    updateDuration();
    // Thêm tính năng mới
    document.getElementById('add-feature').addEventListener('click', function() {
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
            e.target.closest('.feature-item').remove();
        }
    });
});
</script>
<script>
// Client-side validation + ajax name uniqueness check
(function(){
    const form = document.querySelector('form');
    const nameInput = document.getElementById('name');
    const durationInput = document.getElementById('duration');
    const descInput = document.getElementById('description');
    const featuresContainer = document.getElementById('features-container');
    const buttonText = document.getElementById('button_text');
    const buttonColor = document.getElementById('button_color');
    const submitBtn = document.getElementById('submit-btn');
    const checkNameUrl = '{{ route("admin.service-packages.check-name") }}';

    let lastCheckedName = '';
    let lastNameExists = false;

    function setInvalid(el, msg) {
        if (!el) return;
        el.classList.add('is-invalid');
        let feedback = el.parentNode.querySelector('.invalid-feedback.client');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback client';
            el.parentNode.appendChild(feedback);
        }
        feedback.textContent = msg;
    }
    function clearInvalid(el) {
        if (!el) return;
        el.classList.remove('is-invalid');
        let feedback = el.parentNode.querySelector('.invalid-feedback.client');
        if (feedback) feedback.remove();
    }

    // AJAX uniqueness check on blur
    nameInput.addEventListener('blur', function() {
        const val = nameInput.value.trim();
        clearInvalid(nameInput);
        if (val.length < 3 || val.length > 100) return;
        if (val === lastCheckedName) return; // avoid repeat
        lastCheckedName = val;
        fetch(checkNameUrl + '?name=' + encodeURIComponent(val), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(data => {
                lastNameExists = !!data.exists;
                if (lastNameExists) {
                    setInvalid(nameInput, 'Tên gói đã tồn tại');
                }
            }).catch(() => {});
    });

    function gatherFeatures() {
        const inputs = featuresContainer.querySelectorAll('input[name="features[]"]');
        return Array.from(inputs).map(i => i.value.trim()).filter(v => v !== '');
    }

    function validateForm() {
        let ok = true;
        
        // Prepare duration value before validation
        const durNum = document.getElementById('duration_number');
        const durHidden = document.getElementById('duration');
        if (durNum && durHidden) {
            const val = parseInt(durNum.value, 10);
            if (!isNaN(val) && val >= 1 && val <= 60) {
                durHidden.value = val + ' Tháng';
            }
        }

        // name
        clearInvalid(nameInput);
        const nameVal = nameInput.value.trim();
        if (!nameVal) { setInvalid(nameInput, 'Vui lòng nhập tên gói dịch vụ'); ok = false; }
        else if (nameVal.length < 3 || nameVal.length > 100) { setInvalid(nameInput, 'Tên quá ngắn/dài'); ok = false; }
        else if (lastNameExists && lastCheckedName === nameVal) { setInvalid(nameInput, 'Tên gói đã tồn tại'); ok = false; }

        // duration
        clearInvalid(durationInput);
        const dur = parseInt(durationInput.value, 10);
        if (isNaN(dur)) { setInvalid(durationInput, 'Vui lòng nhập thời gian'); ok = false; }
        else if (dur < 1 || dur > 60) { setInvalid(durationInput, 'Thời gian không hợp lệ'); ok = false; }

        // description
        clearInvalid(descInput);
        if (descInput.value && descInput.value.length > 500) { setInvalid(descInput, 'Mô tả quá dài'); ok = false; }

        // features
        const feats = gatherFeatures();
        const featError = document.getElementById('features-client-error');
        if (featError) featError.remove();
        if (feats.length < 1) {
            const err = document.createElement('div');
            err.id = 'features-client-error';
            err.className = 'text-danger small mt-1';
            err.textContent = 'Vui lòng nhập tính năng';
            featuresContainer.parentNode.appendChild(err);
            ok = false;
        } else if (feats.length !== new Set(feats).size) {
            const err = document.createElement('div');
            err.id = 'features-client-error';
            err.className = 'text-danger small mt-1';
            err.textContent = 'Tính năng bị trùng';
            featuresContainer.parentNode.appendChild(err);
            ok = false;
        }

        // button text
        clearInvalid(buttonText);
        if (!buttonText.value.trim()) { setInvalid(buttonText, 'Vui lòng nhập văn bản nút'); ok = false; }
        else if (buttonText.value.trim().length > 50) { setInvalid(buttonText, 'Văn bản nút quá dài'); ok = false; }

        // button color
        clearInvalid(buttonColor);
        if (!buttonColor.value) { setInvalid(buttonColor, 'Vui lòng chọn màu nút'); ok = false; }

        return ok;
    }

    // Intercept submit
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            e.stopPropagation();
            window.scrollTo({ top: document.querySelector('.card').offsetTop - 20, behavior: 'smooth' });
            return false;
        }
        // Before letting the form submit, remove any empty feature inputs so server
        // doesn't receive empty array entries (avoids array.* validation issues).
        const featureInputs = document.querySelectorAll('input[name="features[]"]');
        featureInputs.forEach(fi => {
            if (fi.value.trim() === '') {
                fi.closest('.feature-item')?.remove();
            }
        });
        // allow normal submit and server-side validation
    });
})();
</script>
@endpush
@endsection
