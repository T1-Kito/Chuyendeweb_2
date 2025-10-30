@extends('layouts.app')

@section('title', $category->name . ' - VIKHANG')

@section('content')
<!-- Category Header with Enhanced Design -->
<div class="category-header">
    <div class="header-bg"></div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-25">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="breadcrumb-link">
                                <i class="fas fa-home me-1"></i>Trang chủ
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fas fa-tag me-1"></i>{{ $category->name }}
                        </li>
                    </ol>
                </nav>
                <h1 class="category-title mb-3">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="category-description">{{ $category->description }}</p>
                @endif
                <div class="category-stats">
                    <span class="stat-item">
                        <i class="fas fa-box me-2"></i>
                        {{ $products->total() }} sản phẩm
                    </span>
                    @if($category->icon)
                        <span class="stat-item">
                            <i class="{{ $category->icon }} me-2"></i>
                            Danh mục chính
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="category-icon-wrapper">
                    @if($category->icon)
                        <i class="{{ $category->icon }} category-main-icon"></i>
                    @else
                        <i class="fas fa-tags category-main-icon"></i>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Products Section -->
<div class="products-section py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Enhanced Products Header -->
                <div class="products-header mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="section-title">
                                <i class="fas fa-th-large me-2"></i>
                                Sản phẩm trong danh mục
                            </h2>
                        </div>
                        <div class="col-md-6">
                            <div class="controls-wrapper">
                                <div class="sort-control">
                                    <label class="sort-label">
                                        <i class="fas fa-sort me-2"></i>Sắp xếp:
                                    </label>
                                    <select class="form-select sort-select" onchange="sortProducts(this.value)">
                                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>
                                            <i class="fas fa-clock"></i> Mới nhất
                                        </option>
                                        <option value="price_low" {{ $sort === 'price_low' ? 'selected' : '' }}>
                                            <i class="fas fa-sort-numeric-down"></i> Giá thấp → cao
                                        </option>
                                        <option value="price_high" {{ $sort === 'price_high' ? 'selected' : '' }}>
                                            <i class="fas fa-sort-numeric-up"></i> Giá cao → thấp
                                        </option>
                                        <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>
                                            <i class="fas fa-sort-alpha-down"></i> Tên A-Z
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($products->count() > 0)
                    <!-- Enhanced Products Grid -->
                    <div class="products-grid">
                        <div class="row g-4">
                            @foreach($products as $product)
                            <div class="col-md-6 col-lg-4">
                                <div class="product-card">
                                    <div class="product-image-section">
                                        <div class="product-image-wrapper">
                                            <img src="{{ $product->image_url }}" 
                                                 class="product-image" 
                                                 alt="{{ $product->name }}"
                                                 loading="lazy">
                                            <div class="product-overlay">
                                                <div class="overlay-buttons">
                                                    <a href="{{ route('products.show', $product->slug) }}" 
                                                       class="btn btn-light btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-primary btn-sm" 
                                                            onclick="addToCart({{ $product->id }})">
                                                        <i class="fas fa-shopping-cart"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @if($product->is_featured)
                                            <div class="featured-badge">
                                                <i class="fas fa-star"></i>
                                                <span>Nổi bật</span>
                                            </div>
                                        @endif
                                        <div class="product-category-badge">
                                            <i class="fas fa-tag me-1"></i>
                                            {{ $product->category->name ?? 'Không phân loại' }}
                                        </div>
                                    </div>
                                    
                                    <div class="product-content">
                                        <h3 class="product-name">
                                            <a href="{{ route('products.show', $product->slug) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        
                                        <p class="product-description">
                                            {{ Str::limit($product->description, 100) }}
                                        </p>
                                        
                                                                                 <!-- Price Selector (like homepage) -->
                                         <form method="POST" action="{{ route('cart.add') }}" class="product-add-form" onsubmit="return ensureDurationSelected(this)">
                                             @csrf
                                             <input type="hidden" name="product_id" value="{{ $product->id }}">
                                             <div class="price-selector">
                                                 <div class="price-display mb-2">
                                                     <span class="price" id="price-{{ $product->id }}" 
                                                           data-price-1="{{ $product->price_1_month ?? 0 }}"
                                                           data-price-6="{{ $product->price_6_months ?? 0 }}"
                                                           data-price-12="{{ $product->price_12_months ?? 0 }}"
                                                           data-price-18="{{ $product->price_18_months ?? 0 }}"
                                                           data-price-24="{{ $product->price_24_months ?? 0 }}">
                                                         @if($product->price_1_month)
                                                             {{ number_format($product->price_1_month) }}đ/1 tháng
                                                         @else
                                                             {{ number_format($product->price_6_months) }}đ/6 tháng
                                                         @endif
                                                     </span>
                                                 </div>
                                                 <div class="duration-selector">
                                                     <select name="rental_duration" class="form-select form-select-sm duration-select" 
                                                             onchange="updateProductPrice({{ $product->id }}, this.value)">
                                                         <option value="">-- Chọn thời gian thuê --</option>
                                                         @if($product->price_1_month)
                                                         <option value="1">1 tháng</option>
                                                         @endif
                                                         @if($product->price_6_months)
                                                         <option value="6" selected>6 tháng</option>
                                                         @endif
                                                         @if($product->price_12_months)
                                                         <option value="12">12 tháng</option>
                                                         @endif
                                                         @if($product->price_18_months)
                                                         <option value="18">18 tháng</option>
                                                         @endif
                                                         @if($product->price_24_months)
                                                         <option value="24">24 tháng</option>
                                                         @endif
                                                     </select>
                                                 </div>
                                             </div>

                                             <!-- VAT Notice -->
                                             <div class="vat-notice">
                                                 <i class="fas fa-info-circle me-2"></i>
                                                 <span>Giá chưa bao gồm VAT 8%</span>
                                             </div>

                                             <!-- Action Buttons (like homepage) -->
                                             <div class="product-actions">
                                                 <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="btn btn-outline-primary">
                                                     <i class="fas fa-eye me-1"></i>Chi tiết
                                                 </a>
                                                 <button type="submit" class="btn btn-warning">
                                                     <i class="fas fa-shopping-cart me-1"></i>Thuê ngay
                                                 </button>
                                             </div>
                                         </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Enhanced Pagination -->
                    @if($products->hasPages())
                    <div class="pagination-wrapper mt-5">
                        {{ $products->links() }}
                    </div>
                    @endif

                @else
                    <!-- Enhanced Empty State -->
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h3>Không có sản phẩm nào</h3>
                        <p>Danh mục "{{ $category->name }}" hiện chưa có sản phẩm nào.</p>
                        <div class="empty-actions">
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-home me-2"></i>Về trang chủ
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                                <i class="fas fa-th-large me-2"></i>Xem tất cả sản phẩm
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Enhanced Sidebar -->
            <div class="col-lg-3">
                <!-- Other Categories -->
                <div class="sidebar-card categories-card">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-tags me-2"></i>Danh mục khác
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="categories-list">
                            @foreach($otherCategories as $otherCategory)
                            <a href="{{ route('products.by-category', $otherCategory->slug) }}" 
                               class="category-item">
                                <div class="category-info">
                                    @if($otherCategory->icon)
                                        <i class="{{ $otherCategory->icon }} category-icon"></i>
                                    @else
                                        <i class="fas fa-tag category-icon"></i>
                                    @endif
                                    <span class="category-name">{{ $otherCategory->name }}</span>
                                </div>
                                <span class="category-count">
                                    {{ $otherCategory->products_count ?? 0 }}
                                </span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Category Info -->
                <div class="sidebar-card info-card">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-info-circle me-2"></i>Thông tin danh mục
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="category-summary">
                            @if($category->icon)
                                <div class="summary-icon">
                                    <i class="{{ $category->icon }}"></i>
                                </div>
                            @endif
                            <h6>{{ $category->name }}</h6>
                            @if($category->description)
                                <p>{{ $category->description }}</p>
                            @endif
                        </div>
                        
                        <div class="summary-stats">
                            <div class="stat-row">
                                <span class="stat-label">Tổng sản phẩm:</span>
                                <span class="stat-value">{{ $products->total() }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="stat-label">Trang hiện tại:</span>
                                <span class="stat-value">{{ $products->currentPage() }}/{{ $products->lastPage() }}</span>
                            </div>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="{{ route('home') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-home me-2"></i>Về trang chủ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Category Header */
.category-header {
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    overflow: hidden;
    min-height: 300px;
}

.header-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.min-vh-25 {
    min-height: 25vh;
}

.breadcrumb {
    background: rgba(255,255,255,0.1);
    border-radius: 25px;
    padding: 0.75rem 1.5rem;
    backdrop-filter: blur(10px);
}

.breadcrumb-link {
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-link:hover {
    color: white;
}

.category-title {
    font-size: 3.5rem;
    font-weight: 800;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    margin: 0;
}

.category-description {
    font-size: 1.25rem;
    opacity: 0.9;
    margin-bottom: 2rem;
}

.category-stats {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.stat-item {
    background: rgba(255,255,255,0.15);
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.category-icon-wrapper {
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    width: 150px;
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.2);
}

.category-main-icon {
    font-size: 4rem;
    color: white;
}

/* Products Section */
.products-section {
    background: #f8f9fa;
}

.products-header {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.section-title {
    color: #2c3e50;
    margin: 0;
    font-weight: 700;
}

.controls-wrapper {
    display: flex;
    justify-content: flex-end;
}

.sort-control {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.sort-label {
    color: #6c757d;
    font-weight: 600;
    margin: 0;
}

.sort-select {
    border-radius: 25px;
    border: 2px solid #e9ecef;
    padding: 0.5rem 1rem;
    min-width: 200px;
    transition: all 0.3s ease;
}

.sort-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Products Grid */
.products-grid {
    margin-top: 2rem;
}

.product-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    display: flex;
    flex-direction: column;
}

/* Ensure all cards have equal height */
.row > [class*="col-"] {
    display: flex;
    flex-direction: column;
}

.row > [class*="col-"] > .product-card {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.product-image-section {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.product-image-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.overlay-buttons {
    display: flex;
    gap: 1rem;
}

.overlay-buttons .btn {
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.overlay-buttons .btn:hover {
    transform: scale(1.1);
}

.featured-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: linear-gradient(45deg, #ff6b6b, #ffa500);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
}

.product-category-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    backdrop-filter: blur(10px);
}

.product-content {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.product-name {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.product-name a {
    color: #2c3e50;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-name a:hover {
    color: #667eea;
}

.product-description {
    color: #6c757d;
    margin-bottom: 1.5rem;
    line-height: 1.6;
    min-height: 3.2rem; /* Fixed height for 2 lines of text */
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Price Selector (like homepage) */
.price-selector {
    margin-bottom: 1.5rem;
}

.price-display {
    text-align: center;
}

.price {
    font-size: 1.25rem;
    font-weight: 700;
    color: #0d6efd;
}

.duration-selector {
    text-align: center;
}

.duration-select {
    border-radius: 20px;
    border: 2px solid #e9ecef;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    min-width: 120px;
}

.duration-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

/* VAT Notice */
.vat-notice {
    background: #fff3cd;
    color: #856404;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
    border-left: 4px solid #ffc107;
}

/* Action Buttons (like homepage) */
.product-actions {
    display: flex;
    gap: 0.75rem;
    margin-top: auto;
}

.product-actions .btn {
    flex: 1;
    border-radius: 20px;
    padding: 0.75rem 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.product-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Sidebar Cards */
.sidebar-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
    overflow: hidden;
}

.sidebar-card .card-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 1.5rem;
    border: none;
}

.sidebar-card .card-header h5 {
    margin: 0;
    font-weight: 600;
}

.sidebar-card .card-body {
    padding: 1.5rem;
}

/* Categories List */
.categories-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.category-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;
    text-decoration: none;
    color: #495057;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.category-item:hover {
    background: #e9ecef;
    border-color: #667eea;
    transform: translateX(5px);
}

.category-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.category-icon {
    color: #667eea;
    font-size: 1.1rem;
}

.category-name {
    font-weight: 600;
}

.category-count {
    background: #667eea;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.875rem;
    font-weight: 600;
}

/* Category Info Card */
.category-summary {
    text-align: center;
    margin-bottom: 1.5rem;
}

.summary-icon {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 1rem;
}

.category-summary h6 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.category-summary p {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

.summary-stats {
    margin-bottom: 1.5rem;
}

.stat-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e9ecef;
}

.stat-row:last-child {
    border-bottom: none;
}

.stat-label {
    color: #6c757d;
    font-size: 0.9rem;
}

.stat-value {
    color: #2c3e50;
    font-weight: 600;
}

.action-buttons {
    margin-top: 1rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.empty-icon {
    font-size: 5rem;
    color: #dee2e6;
    margin-bottom: 2rem;
}

.empty-state h3 {
    color: #6c757d;
    margin-bottom: 1rem;
}

.empty-state p {
    color: #adb5bd;
    margin-bottom: 2rem;
}

.empty-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
}

.pagination .page-link {
    border-radius: 10px;
    margin: 0 0.25rem;
    border: none;
    color: #667eea;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
}

.pagination .page-item.active .page-link {
    background: #667eea;
    border-color: #667eea;
}

/* Responsive Design */
@media (max-width: 768px) {
    .category-title {
        font-size: 2.5rem;
    }
    
    .category-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .products-header {
        padding: 1.5rem;
    }
    
    .controls-wrapper {
        justify-content: flex-start;
        margin-top: 1rem;
    }
    
    .sort-control {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .sort-select {
        min-width: 100%;
    }
    
    .product-actions {
        flex-direction: column;
    }
    
    .empty-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .empty-actions .btn {
        width: 100%;
        max-width: 300px;
    }
    
    /* Ensure equal height on mobile */
    .row > [class*="col-"] {
        margin-bottom: 1rem;
    }
}

@media (max-width: 576px) {
    .category-header {
        min-height: 250px;
    }
    
    .category-title {
        font-size: 2rem;
    }
    
    .category-description {
        font-size: 1rem;
    }
    
    .category-icon-wrapper {
        width: 100px;
        height: 100px;
    }
    
    .category-main-icon {
        font-size: 2.5rem;
    }
}
</style>

<script>
function sortProducts(sortBy) {
    const url = new URL(window.location);
    url.searchParams.set('sort', sortBy);
    window.location.href = url.toString();
}

function addToCart(productId) {
    // Add to cart functionality
    console.log('Adding product to cart:', productId);
    // You can implement AJAX call here
}

// Update product price based on selected duration (like homepage)
function updateProductPrice(productId, duration) {
    const priceElement = document.getElementById(`price-${productId}`);
    if (!priceElement) return;
    
    const price1 = parseInt(priceElement.getAttribute('data-price-1')) || 0;
    const price6 = parseInt(priceElement.getAttribute('data-price-6')) || 0;
    const price12 = parseInt(priceElement.getAttribute('data-price-12')) || 0;
    const price24 = parseInt(priceElement.getAttribute('data-price-24')) || 0;
    
    let selectedPrice = 0;
    let durationText = '';
    
    switch(duration) {
        case '1':
            selectedPrice = price1;
            durationText = '1 tháng';
            break;
        case '6':
            selectedPrice = price6;
            durationText = '6 tháng';
            break;
        case '12':
            selectedPrice = price12;
            durationText = '12 tháng';
            break;
        case '24':
            selectedPrice = price24;
            durationText = '24 tháng';
            break;
        default:
            // Ưu tiên giá 1 tháng, nếu không có thì dùng 6 tháng
            if (price1 > 0) {
                selectedPrice = price1;
                durationText = '1 tháng';
            } else {
                selectedPrice = price6;
                durationText = '6 tháng';
            }
    }
    
    if (selectedPrice > 0) {
        priceElement.textContent = `${numberFormat(selectedPrice)}đ/${durationText}`;
    } else {
        priceElement.textContent = 'Liên hệ';
    }
}

// Number formatting function (like homepage)
function numberFormat(num) {
    return new Intl.NumberFormat('vi-VN').format(num);
}

// Ensure the rental duration is selected before submitting add-to-cart forms
function ensureDurationSelected(form) {
    try {
        const select = form.querySelector('select[name="rental_duration"]');
        if (!select) return true; // nothing to validate
        if (!select.value || select.value === '') {
            // Show a friendly message and focus the select
            alert('Vui lòng chọn thời gian thuê');
            select.focus();
            return false;
        }
        return true;
    } catch (e) {
        console.error('Validation error', e);
        return true;
    }
}
</script>
@endsection
