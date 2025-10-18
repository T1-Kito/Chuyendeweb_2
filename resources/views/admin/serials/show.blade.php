@extends('layouts.admin')

@section('title', 'Chi Tiết Số Seri')
@section('page-title', 'Chi Tiết Số Seri')
@section('page-description', 'Thông tin chi tiết sản phẩm và số seri')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-barcode me-2"></i>{{ $product->name }}</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.serials.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Quay lại
        </a>
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary">
            <i class="fas fa-edit me-1"></i>Chỉnh sửa sản phẩm
        </a>
    </div>
</div>

@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- Product Information -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-box me-2"></i>Thông Tin Sản Phẩm
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="{{ $product->image_url }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid rounded" 
                         style="max-height: 300px; object-fit: cover;"
                         onerror="this.src='https://via.placeholder.com/400x300/f3f4f6/6b7280?text=No+Image'">
                </div>
                
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Tên sản phẩm:</strong></td>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Danh mục:</strong></td>
                        <td><span class="badge bg-secondary">{{ $product->category->name }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Trạng thái:</strong></td>
                        <td>
                            @switch($product->status)
                                @case('available')
                                    <span class="badge bg-success">Có sẵn</span>
                                    @break
                                @case('rented')
                                    <span class="badge bg-warning">Đang thuê</span>
                                    @break
                                @case('maintenance')
                                    <span class="badge bg-danger">Bảo trì</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $product->status }}</span>
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Số lượng:</strong></td>
                        <td>{{ $product->stock_quantity }} sản phẩm</td>
                    </tr>
                    <tr>
                        <td><strong>Ngày tạo:</strong></td>
                        <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($product->updated_at != $product->created_at)
                    <tr>
                        <td><strong>Cập nhật:</strong></td>
                        <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    
    <!-- Serial Number Information -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-barcode me-2"></i>Thông Tin Số Seri
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.serials.update', $product) }}" id="serialForm">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label for="serial_number" class="form-label">
                            <i class="fas fa-barcode me-1"></i>Số Seri
                        </label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number" 
                               value="{{ $product->serial_number }}" placeholder="Nhập số seri...">
                        <div class="form-text">Số seri duy nhất của sản phẩm</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="model" class="form-label">
                            <i class="fas fa-tag me-1"></i>Model
                        </label>
                        <input type="text" class="form-control" id="model" name="model" 
                               value="{{ $product->model }}" placeholder="Nhập model sản phẩm...">
                        <div class="form-text">Model hoặc phiên bản của sản phẩm</div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Cập nhật thông tin
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                            <i class="fas fa-undo me-1"></i>Khôi phục
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Serial Number Display -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-qrcode me-2"></i>Hiển Thị Số Seri
                </h6>
            </div>
            <div class="card-body text-center">
                <div class="bg-light p-4 rounded mb-3">
                    <h4 class="text-primary mb-2">Số Seri</h4>
                    <code class="fs-4 text-dark" id="displaySerial">{{ $product->serial_number }}</code>
                </div>
                
                @if($product->model)
                <div class="bg-light p-3 rounded">
                    <h6 class="text-secondary mb-1">Model</h6>
                    <span class="badge bg-info fs-6" id="displayModel">{{ $product->model }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Product Description -->
@if($product->description)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Mô Tả Sản Phẩm
                </h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $product->description }}</p>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Product Features -->
@if($product->features)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-star me-2"></i>Tính Năng
                </h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $product->features }}</p>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Product Specs -->
@if($product->specs)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>Thông Số Kỹ Thuật
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $specs = json_decode($product->specs, true);
                    @endphp
                    @if(is_array($specs))
                        @foreach($specs as $key => $value)
                        <div class="col-md-6 mb-2">
                            <strong>{{ $key }}:</strong> {{ $value }}
                        </div>
                        @endforeach
                    @else
                        <p class="mb-0">{{ $product->specs }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<style>
.img-fluid {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

code {
    font-family: 'Courier New', monospace;
    background-color: #f8f9fa;
    padding: 0.5rem;
    border-radius: 0.375rem;
    border: 1px solid #dee2e6;
}

.badge {
    font-size: 0.875rem;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.table-borderless td {
    border: none;
    padding: 0.5rem 0;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}
</style>

<script>
// Store original values for reset
const originalSerial = '{{ $product->serial_number }}';
const originalModel = '{{ $product->model }}';

// Handle form submission
document.getElementById('serialForm').addEventListener('submit', function(e) {
    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Disable submit button and show loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang cập nhật...';
    
    // Form will submit normally
});

// Update display when form values change
document.getElementById('serial_number').addEventListener('input', function() {
    document.getElementById('displaySerial').textContent = this.value;
});

document.getElementById('model').addEventListener('input', function() {
    const displayModel = document.getElementById('displayModel');
    if (displayModel) {
        displayModel.textContent = this.value;
    }
});

// Reset form function
function resetForm() {
    document.getElementById('serial_number').value = originalSerial;
    document.getElementById('model').value = originalModel;
    document.getElementById('displaySerial').textContent = originalSerial;
    const displayModel = document.getElementById('displayModel');
    if (displayModel) {
        displayModel.textContent = originalModel;
    }
}
</script>
@endsection
