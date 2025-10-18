@extends('layouts.admin')

@section('title', 'Quản Lý Sản Phẩm')

@section('page-title', 'Quản Lý Sản Phẩm')
@section('page-description', 'Thêm, sửa và xóa sản phẩm')

@section('content')

<!-- Compact Header with Stats -->
<div class="compact-header mb-3">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="header-content">
                <h2 class="fw-bold mb-1">
                    <i class="fas fa-boxes me-2"></i>Quản Lý Sản Phẩm
                </h2>
                <div class="stats-summary">
                    <span class="stat-item">
                        <i class="fas fa-box text-primary"></i>
                        Tổng: {{ $products->count() }} sản phẩm
                    </span>
                    <span class="stat-item">
                        <i class="fas fa-check-circle text-success"></i>
                        Kích hoạt: {{ $products->where('is_active', true)->count() }}
                    </span>
                    <span class="stat-item">
                        <i class="fas fa-star text-warning"></i>
                        Nổi bật: {{ $products->where('is_featured', true)->count() }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>Thêm sản phẩm
            </a>
        </div>
    </div>
</div>

@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Compact Filters Section -->
<div class="compact-filters mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm...">
            </div>
        </div>
        <div class="col-md-2">
            <select class="form-select">
                <option value="">Tất cả danh mục</option>
                @foreach($categories ?? [] as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select">
                <option value="">Tất cả trạng thái</option>
                <option value="active">Kích hoạt</option>
                <option value="inactive">Tắt</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select">
                <option value="newest">Mới nhất</option>
                <option value="oldest">Cũ nhất</option>
                <option value="name">Tên A-Z</option>
                <option value="price">Giá thấp-cao</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                <i class="fas fa-filter me-1"></i>Lọc
            </button>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="products-table-container">
    @if($products->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover products-table">
                <thead class="table-dark">
                    <tr>
                        <th width="50">#</th>
                        <th width="80">Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th width="120">Số seri (SN)</th>
                        <th width="100">Giá bán</th>
                        <th width="100">Khuyến mãi</th>
                        <th width="100">Nổi bật</th>
                        <th width="100">Trạng thái</th>
                        <th width="120">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $index => $product)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="product-image-cell">
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="product-thumbnail">
                            </div>
                        </td>
                        <td>
                            <div class="product-info-cell">
                                <div class="product-name">{{ $product->name }}</div>
                                <div class="product-desc">{{ Str::limit($product->description, 60) }}</div>
                            </div>
                        </td>
                        <td class="text-center">
                            {{ $product->serial_number ?: '-' }}
                        </td>
                        <td class="text-center">
                            @if($product->price_6_months)
                                <span class="price-display">{{ number_format($product->price_6_months) }}đ</span>
                            @else
                                <span class="text-muted">0đ</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($product->promotion_badge)
                                <span class="badge bg-warning">{{ $product->promotion_badge }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            @if($product->is_featured)
                                <span class="badge bg-warning">Nổi bật</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            @if($product->is_active)
                                <span class="status-badge active">Hiện</span>
                            @else
                                <span class="status-badge inactive">Ẩn</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="btn btn-sm btn-primary" title="Sửa">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <button class="btn btn-sm btn-danger" 
                                        onclick="deleteProduct({{ $product->id }})" 
                                        title="Xóa">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-boxes"></i>
            </div>
            <h3 class="empty-state-title">Chưa có sản phẩm nào</h3>
            <p class="empty-state-description">
                Bắt đầu bằng cách thêm sản phẩm đầu tiên vào hệ thống
            </p>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Thêm Sản Phẩm Đầu Tiên
            </a>
        </div>
    @endif
</div>

<!-- Delete Product Form (Hidden) -->
<form id="deleteProductForm" method="POST" style="display: none;">
    @csrf
</form>

<style>
/* Compact Product Management Styles */

/* Compact Header */
.compact-header {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
}

.stats-summary {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: #6c757d;
}

.stat-item i {
    font-size: 1rem;
}

/* Compact Filters */
.compact-filters {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
}

.compact-filters .form-control,
.compact-filters .form-select {
    border-radius: 6px;
    border: 1px solid #ced4da;
}

.compact-filters .input-group-text {
    background: #f8f9fa;
    border: 1px solid #ced4da;
}

/* Products Table Styles */
.products-table-container {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
}

.products-table {
    margin-bottom: 0;
}

.products-table thead th {
    background: #2c3e50;
    color: white;
    border: none;
    padding: 12px 8px;
    font-weight: 600;
    font-size: 0.9rem;
    text-align: center;
    vertical-align: middle;
}

.products-table tbody td {
    padding: 12px 8px;
    vertical-align: middle;
    border-bottom: 1px solid #e9ecef;
}

.products-table tbody tr:hover {
    background-color: #f8f9fa;
}

.product-image-cell {
    display: flex;
    justify-content: center;
    align-items: center;
}

.product-thumbnail {
    width: 50px;
    height: 50px;
    object-fit: contain;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    background: #f8f9fa;
    padding: 4px;
}

.product-info-cell {
    text-align: left;
}

.product-info-cell .product-name {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 4px;
    font-size: 0.9rem;
}

.product-info-cell .product-desc {
    font-size: 0.8rem;
    color: #6c757d;
    line-height: 1.3;
}

.price-display {
    font-weight: 600;
    color: #28a745;
    font-size: 0.9rem;
}

.action-buttons {
    display: flex;
    gap: 4px;
    justify-content: center;
}

.action-buttons .btn {
    font-size: 0.8rem;
    padding: 4px 8px;
}

.status-badge {
    font-size: 0.75rem;
    padding: 4px 8px;
    border-radius: 12px;
    font-weight: 500;
}

.status-badge.active {
    background: #d4edda;
    color: #155724;
}

.status-badge.inactive {
    background: #f8d7da;
    color: #721c24;
}

/* Table responsive */
@media (max-width: 768px) {
    .products-table {
        font-size: 0.8rem;
    }
    
    .products-table thead th,
    .products-table tbody td {
        padding: 8px 4px;
    }
    
    .product-thumbnail {
        width: 40px;
        height: 40px;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 2px;
    }
    
    .action-buttons .btn {
        font-size: 0.7rem;
        padding: 2px 4px;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .stats-summary {
        gap: 1rem;
    }
    
    .stat-item {
        font-size: 0.8rem;
    }
    
    .compact-filters .row {
        gap: 0.5rem;
    }
    
    .compact-filters .col-md-2,
    .compact-filters .col-md-4 {
        margin-bottom: 0.5rem;
    }
}
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.stat-content h3 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: #2d3748;
}

.stat-content p {
    margin: 0;
    color: #718096;
    font-weight: 500;
}

/* Filters Section */
.filters-section .card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.filters-section .form-control,
.filters-section .form-select {
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
}

.filters-section .form-control:focus,
.filters-section .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Modern Product Cards */
.product-card-modern {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
}

.product-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.product-image-section {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card-modern:hover .product-image {
    transform: scale(1.05);
}

.product-badges {
    position: absolute;
    top: 1rem;
    left: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.badge {
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    border: none;
}

.badge-primary {
    background: rgba(102, 126, 234, 0.9);
    color: white;
}

.badge-warning {
    background: rgba(245, 158, 11, 0.9);
    color: white;
}

.badge-success {
    background: rgba(34, 197, 94, 0.9);
    color: white;
}

.product-actions {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.3s ease;
}

.product-card-modern:hover .product-actions {
    opacity: 1;
    transform: translateX(0);
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.edit-btn {
    background: rgba(59, 130, 246, 0.9);
}

.edit-btn:hover {
    background: rgba(59, 130, 246, 1);
    transform: scale(1.1);
}

.delete-btn {
    background: rgba(239, 68, 68, 0.9);
}

.delete-btn:hover {
    background: rgba(239, 68, 68, 1);
    transform: scale(1.1);
}

/* Product Info Section */
.product-info {
    padding: 1.5rem;
}

.product-header {
    margin-bottom: 1rem;
}

.product-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 0.5rem 0;
    line-height: 1.3;
}

.product-category {
    color: #718096;
    font-size: 0.875rem;
    font-weight: 500;
}

.product-serial {
    color: #6c757d;
    font-size: 0.8rem;
    margin-top: 0.25rem;
}

/* Price Section */
.price-section {
    margin-bottom: 1rem;
}

.price-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f1f5f9;
}

.price-item:last-child {
    border-bottom: none;
}

.price-label {
    color: #64748b;
    font-size: 0.875rem;
    font-weight: 500;
}

.price-value {
    font-weight: 700;
    font-size: 1rem;
}

.price-value.primary {
    color: #3b82f6;
}

.price-value.success {
    color: #10b981;
}

.discount {
    color: #ef4444;
    font-size: 0.75rem;
    margin-left: 0.5rem;
}

/* Status Section */
.status-section {
    margin-top: 1rem;
}

.status-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    border: none;
}

.status-badge.active {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.status-badge.inactive {
    background: rgba(107, 114, 128, 0.1);
    color: #6b7280;
}

.status-badge.featured {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.empty-state-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    color: white;
    font-size: 3rem;
}

.empty-state-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 1rem;
}

.empty-state-description {
    color: #718096;
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

/* Responsive */
@media (max-width: 768px) {
    .products-header {
        padding: 1.5rem;
    }
    
    .stat-card {
        padding: 1rem;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
    
    .product-image-section {
        height: 200px;
    }
}
</style>

<script>
function deleteProduct(productId) {
    if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
        const form = document.getElementById('deleteProductForm');
        form.action = `/admin/products/${productId}/delete`;
        form.submit();
    }
}

// Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate stats cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Animate product cards
    const productCards = document.querySelectorAll('.product-card-modern');
    productCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 50);
    });
});
</script>
@endsection
