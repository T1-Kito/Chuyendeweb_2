
@extends('layouts.app')

@section('title', 'Trang Chủ - WebChoThu')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-white" style="position: relative; min-height: 100vh; display: flex; align-items: center;">
    @if(($banners ?? null) && $banners->count() > 0)
    <div id="homeBannerCarousel" class="carousel slide position-absolute w-100 h-100" data-bs-ride="carousel" style="z-index:0;">
        <div class="carousel-inner h-100">
            @foreach($banners as $i => $banner)
            <div class="carousel-item h-100 {{ $i === 0 ? 'active' : '' }}">
                <div class="w-100 h-100" style="
                    background-image: url('{{ $banner->image_path }}');
                    background-size: cover; background-position: center;
                    filter: brightness(0.7);
                "></div>
                @if($banner->link_url)
                    <a href="{{ $banner->link_url }}" class="stretched-link" aria-label="Banner Link"></a>
                @endif
            </div>
            @endforeach
        </div>
        @if($banners->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        @endif
    </div>
    @else
    <div class="position-absolute w-100 h-100" style="
        background-image: url('{{ asset('47beb9201a40a4f652206b2295f12608.gif') }}');
        background-size: cover; background-position: center; filter: brightness(0.7);
    "></div>
    @endif
    
    <div style="position:absolute; inset:0; background: rgba(0,0,0,0.35);"></div>
            <canvas id="hero-network" class="d-none d-lg-block" style="position:absolute; inset:0; width:100%; height:100%; pointer-events:none;"></canvas>
    
    <div class="container position-relative">
        <div class="row">
            <div class="col-lg-9 col-xl-8">
                <h1 class="display-5 fw-bold text-uppercase mb-3" style="letter-spacing:1px; font-size: 2.5rem;">
                    <i class="fas fa-shield-alt me-3 text-warning"></i>
                    Dịch Vụ Cho Thuê Thiết Bị Chấm Công & Kiểm Soát Ra Vào
                </h1>
                <p class="lead mb-4 text-white-50" style="font-size: 1.2rem; font-weight: 500;">
                    <i class="fas fa-star text-warning me-2"></i>
                    Giải pháp quản lý nhân viên hiện đại - Tin cậy, tiết kiệm, hiệu quả
                </p>
                <div class="fs-5 fw-medium mb-4" style="line-height: 1.8;">
                    <div class="mb-3 d-flex align-items-center">
                        <i class="fas fa-fingerprint me-3 text-info" style="font-size: 1.2rem;"></i>
                        <span>Cho thuê máy chấm công: <strong>Vân tay – Thẻ từ – Nhận diện khuôn mặt</strong></span>
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <i class="fas fa-gate me-3 text-success" style="font-size: 1.2rem;"></i>
                        <span>Cho thuê cổng Barrier tự động: <strong>Kiểm soát xe ra vào bãi giữ xe, tòa nhà, khu công nghiệp</strong></span>
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <i class="fas fa-user-shield me-3 text-warning" style="font-size: 1.2rem;"></i>
                        <span>Cho thuê hệ thống nhận diện khuôn mặt: <strong>Quản lý nhân viên, kiểm soát an ninh hiện đại</strong></span>
                    </div>
                </div>
                <!-- Trust Indicators -->
                <div class="trust-section mb-4">
                    <div class="row g-3">
                        <div class="col-md-4 col-6">
                            <div class="trust-item">
                                <i class="fas fa-shield-alt text-warning"></i>
                                <span>Bảo hành 12 tháng</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="trust-item">
                                <i class="fas fa-truck text-info"></i>
                                <span>Giao hàng miễn phí</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="trust-item">
                                <i class="fas fa-headset text-success"></i>
                                <span>Hỗ trợ 24/7</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="trust-item">
                                <i class="fas fa-tools text-primary"></i>
                                <span>Cài đặt miễn phí</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="trust-item">
                                <i class="fas fa-certificate text-warning"></i>
                                <span>Chứng nhận ISO</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="trust-item">
                                <i class="fas fa-star text-warning"></i>
                                <span>1000+ khách hàng</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-3 flex-wrap justify-content-center">
                    <a href="#products" class="btn btn-warning btn-lg">
                        <i class="fas fa-handshake me-2"></i>Thuê Ngay
                    </a>
                    <a href="#contact" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-phone me-2"></i>Liên Hệ Ngay
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="products-section py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold text-dark mb-3">
                <i class="fas fa-boxes text-primary me-3"></i>
                CÁC SẢN PHẨM CHO THUÊ
            </h2>
            <p class="text-muted fs-5">Khám phá các thiết bị chấm công và kiểm soát ra vào chất lượng cao</p>
            
            <!-- Popular Products Section -->
            @if($featuredProducts->count() > 0)
            <div class="hot-sale-section mb-4">
                <div class="hot-sale-banner">
                    <div class="banner-content">
                        <i class="fas fa-fire pulse-animation"></i>
                        <span class="banner-text">CÁC SẢN PHẨM ĐƯỢC THUÊ NHIỀU NHẤT</span>
                        <div class="banner-decoration">
                            <div class="decoration-dot"></div>
                            <div class="decoration-dot"></div>
                            <div class="decoration-dot"></div>
                        </div>
                    </div>
                </div>
                
                <div class="products-carousel" id="featuredCarousel">
                    <button class="carousel-arrow carousel-prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    
                    <div class="carousel-container">
                        <div class="carousel-track" id="carouselTrack">
                            @foreach($featuredProducts as $featuredProduct)
                            <div class="product-card-featured" onclick="window.location.href='{{ route('products.show', $featuredProduct->slug ?? $featuredProduct->id) }}'">
                                <div class="product-image">
                                    <img src="{{ $featuredProduct->image_url }}" alt="{{ $featuredProduct->name }}">

                                    <div class="product-badge">
                                        <span>🔥 HOT</span>
                                    </div>
                                </div>
                                
                                <div class="product-info">
                                    <h5 class="product-name">{{ $featuredProduct->name }}</h5>
                                    <div class="product-specs">{{ Str::limit($featuredProduct->description, 60) }}</div>
                                    
                                    <div class="pricing">
                                        <div class="current-price">
                                            @if($featuredProduct->price_1_month)
                                                {{ number_format($featuredProduct->price_1_month) }}đ/1 tháng
                                            @else
                                                {{ number_format($featuredProduct->price_6_months) }}đ/6 tháng
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="product-meta">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <span>{{ number_format(rand(45, 50) / 10, 1) }}</span>
                                        </div>
                                        <div class="like-btn" onclick="event.stopPropagation(); toggleLike(this)">
                                            <i class="fas fa-heart"></i>
                                            <span>Yêu thích</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <button class="carousel-arrow carousel-next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    
                    <!-- Carousel Indicators -->
                    <div class="carousel-indicators">
                        <!-- Indicators will be generated dynamically by JavaScript -->
                    </div>
                </div>
            </div>
            @endif

            <!-- Model filter as dropdown -->
            @php
                $models = ($products ?? collect())->pluck('model')->filter()->unique()->values();
                if ($models->isEmpty()) {
                    $models = ($products ?? collect())->pluck('name')->map(fn($n)=> \Illuminate\Support\Str::limit($n, 18))->unique()->values();
                }
            @endphp
            <div class="row mt-2 g-2 align-items-center">
                <div class="col-auto">
                    <label class="fw-semibold">Lọc theo model:</label>
                </div>
                <div class="col-sm-4 col-md-3">
                    <select id="modelDropdown" class="form-select form-select-sm" onchange="setModel(this.value)">
                        <option value="all" selected>Tất cả model</option>
                        @foreach($models as $m)
                            @php $mid = \Illuminate\Support\Str::slug((string)$m); @endphp
                            <option value="{{ $mid }}">{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="row row-cols-xxl-4 row-cols-xl-4 row-cols-lg-4 row-cols-md-2 row-cols-sm-1 g-4">
                    @forelse($products as $product)
                    <div class="col">
                        <div class="product-card h-100" data-category="{{ $product->category_id ?? 'all' }}" data-model="{{ \Illuminate\Support\Str::slug((string)($product->model ?? $product->name)) }}" data-url="{{ route('products.show', $product->slug ?? $product->id) }}" tabindex="0" role="link">
                            <div class="product-image">
                                <img src="{{ $product->image_url }}" 
                                     class="img-fluid" alt="{{ $product->name }}">
                            </div>
                            <div class="product-content d-flex flex-column">
                                <h5 class="product-title">{{ $product->name }}</h5>
                                <p class="product-category">{{ $product->category->name ?? 'Chưa phân loại' }}</p>
                                <div class="product-price">
                                    @if($product->price_1_month || $product->price_6_months)
                                        <div class="price-selector">
                                            <div class="price-display mb-2">
                                                <span class="price" id="price-{{ $product->id }}" 
                                                      data-price-1="{{ $product->price_1_month ?? 0 }}"
                                                      data-price-6="{{ $product->price_6_months ?? 0 }}"
                                                      data-price-12="{{ $product->price_12_months ?? 0 }}"
                                                      data-price-24="{{ $product->price_24_months ?? 0 }}">
                                                    @if($product->price_1_month)
                                                        {{ number_format($product->price_1_month) }}đ/1 tháng
                                                    @else
                                                        {{ number_format($product->price_6_months) }}đ/6 tháng
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="duration-selector">
                                                <select class="form-select form-select-sm duration-select" 
                                                        onchange="updateProductPrice({{ $product->id }}, this.value)">
                                                    @if($product->price_1_month)
                                                    <option value="1" selected>1 tháng</option>
                                                    @endif
                                                    @if($product->price_6_months)
                                                    <option value="6" {{ !$product->price_1_month ? 'selected' : '' }}>6 tháng</option>
                                                    @endif
                                                    @if($product->price_12_months)
                                                    <option value="12">12 tháng</option>
                                                    @endif
                                                    @if($product->price_24_months)
                                                    <option value="24">24 tháng</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    @else
                                        <span class="price">Liên hệ</span>
                                    @endif
                                </div>
                                <div class="product-spacer"></div>
                                <div class="product-actions">
                                    <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>Chi tiết
                                    </a>
                                    <form method="POST" action="{{ route('cart.add') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="rental_duration" value="6">
                                        <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-shopping-cart me-1"></i>Thuê ngay
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <div class="empty-state">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Chưa có sản phẩm nào</h5>
                            <p class="text-muted">Hãy thêm sản phẩm trong admin panel</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        @if($products->count() > 0)
        <div class="text-center mt-5">
            <a href="#products" class="btn btn-primary btn-lg">
                <i class="fas fa-th-large me-2"></i>Xem tất cả sản phẩm
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Gói Bảo Hành Section -->
<section class="service-packages-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold text-white mb-3">
                <i class="fas fa-shield-alt text-warning me-3"></i>
                GÓI DỊCH VỤ THUÊ
            </h2>
            <p class="text-white fs-5 opacity-75">Lựa chọn gói dịch vụ thuê phù hợp với nhu cầu của bạn</p>
        </div>
        
        <div class="packages-container">
            <!-- Decorative Elements (2 cái tai) -->
            <div class="package-decoration left-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-line"></div>
                <i class="fas fa-shield-alt decoration-icon"></i>
            </div>
            
            <div class="package-decoration right-decoration">
                <div class="decoration-circle"></div>
                <div class="decoration-line"></div>
                <i class="fas fa-star decoration-icon"></i>
            </div>
            
            <!-- Packages Grid -->
            <div class="row g-4 justify-content-center">
                <!-- Package 1: 6 Months -->
                <div class="col-lg-4 col-md-6">
                    <div class="package-card basic-package">
                        <div class="package-header">
                            <div class="package-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3 class="package-title">Gói 6 Tháng</h3>
                            
                        </div>
                        
                        <div class="package-features">
                            <ul class="feature-list">
                                <li><i class="fas fa-check"></i>Thuê thiết bị trong 6 tháng</li>
                                <li><i class="fas fa-check"></i>Hỗ trợ kỹ thuật cơ bản</li>
                                <li><i class="fas fa-check"></i>Bảo hành tiêu chuẩn</li>
                                <li><i class="fas fa-check"></i>Cài đặt miễn phí</li>
                                <li><i class="fas fa-check"></i>Hướng dẫn sử dụng</li>
                            </ul>
                        </div>
                        
                        <div class="package-action">
                            <a href="#products" class="btn btn-outline-primary btn-lg w-100">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Package 2: 12 Months (Featured) -->
                <div class="col-lg-4 col-md-6">
                    <div class="package-card featured-package">
                        <div class="featured-badge">
                            <span>PHỔ BIẾN</span>
                        </div>
                        <div class="package-header">
                            <div class="package-icon">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h3 class="package-title">Gói 12 Tháng</h3>
                            
                        </div>
                        
                        <div class="package-features">
                            <ul class="feature-list">
                                <li><i class="fas fa-check"></i>Tất cả dịch vụ gói 6 tháng</li>
                                <li><i class="fas fa-check"></i>Hỗ trợ xuất hóa đơn</li>
                                <li><i class="fas fa-check"></i>Hỗ trợ xuất tiền lương</li>
                                <li><i class="fas fa-check"></i>Hỗ trợ bảo hành lỗi</li>
                                <li><i class="fas fa-check"></i>Ưu tiên hỗ trợ kỹ thuật</li>
                                <li><i class="fas fa-check"></i>Cập nhật phần mềm miễn phí</li>
                            </ul>
                        </div>
                        
                        <div class="package-action">
                            <a href="#products" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-star"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Package 3: 24 Months -->
                <div class="col-lg-4 col-md-6">
                    <div class="package-card premium-package">
                        <div class="package-header">
                            <div class="package-icon">
                                <i class="fas fa-gem"></i>
                            </div>
                            <h3 class="package-title">Gói 24 Tháng</h3>
                            
                        </div>
                        
                        <div class="package-features">
                            <ul class="feature-list">
                                <li><i class="fas fa-check"></i>Tất cả dịch vụ gói 12 tháng</li>
                                <li><i class="fas fa-gift text-warning"></i>Tặng máy sau 24 tháng</li>
                                <li><i class="fas fa-check"></i>Hỗ trợ kỹ thuật nhanh tại nơi</li>
                                <li><i class="fas fa-check"></i>Hỗ trợ license phần mềm</li>
                                <li><i class="fas fa-check"></i>Hỗ trợ 24/7</li>
                                <li><i class="fas fa-check"></i>Ưu đãi đặc biệt</li>
                            </ul>
                        </div>
                        
                        <div class="package-action">
                            <a href="#products" class="btn btn-warning btn-lg w-100">
                                <i class="fas fa-gem"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

<style>
/* Products Section */
.products-section {
    background: white;
}

/* Categories filter bar */
.categories-filter-container{position:relative;overflow:hidden;padding:6px 40px;margin-top:10px}
.categories-filter{display:flex;gap:12px;overflow-x:auto;scrollbar-width:none;-ms-overflow-style:none}
.categories-filter::-webkit-scrollbar{display:none}
.filter-item{display:flex;align-items:center;gap:8px;padding:8px 14px;background:#f8f9fa;border:1px solid #e9ecef;border-radius:999px;color:#495057;text-decoration:none;white-space:nowrap;font-weight:600;transition:all .2s}
.filter-item:hover{background:#eef2ff;border-color:#dbe4ff;color:#0d6efd}
.filter-item.active{background:linear-gradient(135deg,#0d6efd,#6610f2);color:#fff;border-color:transparent}
.scroll-arrow{position:absolute;top:50%;transform:translateY(-50%);width:36px;height:36px;border:none;border-radius:50%;background:#fff;box-shadow:0 4px 12px rgba(0,0,0,.1);display:flex;align-items:center;justify-content:center;color:#495057}
.scroll-left{left:0}
.scroll-right{right:0}

@media (max-width: 768px){
  .categories-filter-container{padding:6px 10px}
  .scroll-arrow{display:none}
}

/* Sidebar categories */
.sidebar-categories .sidebar-cat-item{display:block;padding:.55rem .75rem;border-radius:10px;color:#495057;text-decoration:none;transition:all .2s;border:1px solid #e9ecef}
.sidebar-categories .sidebar-cat-item:hover{background:#eef2ff;border-color:#dbe4ff;color:#0d6efd}
.sidebar-categories .sidebar-cat-item.active{background:linear-gradient(135deg,#0d6efd,#6610f2);color:#fff;border-color:transparent}

/* HOT SALE Section */
.hot-sale-section {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 25px;
    padding: 35px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08), 0 5px 15px rgba(255, 71, 87, 0.1);
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(255, 71, 87, 0.1);
}

.hot-sale-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

.hot-sale-banner {
    background: linear-gradient(135deg, #ff4757, #ff3742, #ff6b7a, #ff8a95);
    border-radius: 20px;
    padding: 25px;
    margin-bottom: 30px;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 35px rgba(255, 71, 87, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.hot-sale-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.banner-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    color: white;
    font-size: 1.6rem;
    font-weight: 800;
    position: relative;
    z-index: 2;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    letter-spacing: 1px;
}

.banner-text {
    position: relative;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.banner-decoration {
    display: flex;
    gap: 8px;
    margin-left: 15px;
}

.decoration-dot {
    width: 8px;
    height: 8px;
    background: #ffd700;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.decoration-dot:nth-child(2) {
    animation-delay: 0.3s;
}

.decoration-dot:nth-child(3) {
    animation-delay: 0.6s;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.2); opacity: 0.7; }
}

.pulse-animation {
    animation: firePulse 1.5s infinite;
}

@keyframes firePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.products-carousel {
    position: relative;
    display: flex;
    align-items: center;
    gap: 25px;
    padding: 25px 0;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 20px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 71, 87, 0.1);
    overflow: hidden; /* Ẩn overflow để tránh khoảng trắng */
}



.carousel-arrow {
    background: linear-gradient(135deg, #ff4757, #ff3742, #ff6b7a);
    border: none;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 2;
    color: white;
    box-shadow: 0 6px 20px rgba(255, 71, 87, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.2);
    font-size: 1.2rem;
    font-weight: bold;
}

.carousel-arrow:hover {
    background: linear-gradient(135deg, #ff3742, #ff4757, #ff8a95);
    transform: scale(1.15) rotate(5deg);
    box-shadow: 0 10px 30px rgba(255, 71, 87, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.3);
}

.carousel-arrow:active {
    transform: scale(0.95);
}

.carousel-container {
    flex: 1;
    overflow: hidden;
    border-radius: 15px;
}

.carousel-track {
    display: flex;
    gap: 20px;
    transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    will-change: transform; /* Tối ưu performance */
}

.product-card-featured {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border: 2px solid #ff4757;
    border-radius: 20px;
    padding: 25px;
    min-width: 300px;
    box-shadow: 0 8px 25px rgba(255, 71, 87, 0.15), 0 2px 8px rgba(0, 0, 0, 0.1);
    position: relative;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    overflow: hidden;
    backdrop-filter: blur(5px);
}

.product-card-featured::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 71, 87, 0.1), transparent);
    transition: left 0.5s ease;
}

.product-card-featured:hover::before {
    left: 100%;
}

.product-card-featured:hover {
    transform: translateY(-12px) scale(1.03);
    box-shadow: 0 20px 50px rgba(255, 71, 87, 0.3), 0 5px 15px rgba(0, 0, 0, 0.15);
    border-color: #ff3742;
    background: linear-gradient(135deg, #fff 0%, #fff5f5 100%);
}



.product-card-featured .product-image {
    text-align: center;
    margin: 35px 0 25px;
    position: relative;
    overflow: hidden;
    border-radius: 15px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 20px;
    border: 1px solid rgba(255, 71, 87, 0.1);
}

.product-card-featured .product-image img {
    max-width: 100%;
    height: 160px;
    object-fit: contain;
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), filter 0.3s ease;
    filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.15));
}

.product-card-featured:hover .product-image img {
    transform: scale(1.06);
    filter: drop-shadow(0 10px 18px rgba(255, 71, 87, 0.25));
}



.product-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(135deg, #ff3b30 0%, #ff6a00 100%);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    box-shadow: 0 4px 14px rgba(255, 71, 87, 0.35);
    animation: badgePulse 2s infinite;
}

@keyframes badgePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Additional Animations */
@keyframes ripple {
    0% { transform: scale(0); opacity: 1; }
    100% { transform: scale(4); opacity: 0; }
}

@keyframes heartBeat {
    0% { transform: scale(1); }
    14% { transform: scale(1.3); }
    28% { transform: scale(1); }
    42% { transform: scale(1.3); }
    70% { transform: scale(1); }
}

@keyframes slideInUp {
    from {
        transform: translateY(30px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.product-card-featured {
    animation: slideInUp 0.6s ease-out;
}

.product-card-featured:nth-child(1) { animation-delay: 0.1s; }
.product-card-featured:nth-child(2) { animation-delay: 0.2s; }
.product-card-featured:nth-child(3) { animation-delay: 0.3s; }
.product-card-featured:nth-child(4) { animation-delay: 0.4s; }

/* Floating animation for cards */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

.product-card-featured {
    animation: slideInUp 0.6s ease-out, float 3s ease-in-out infinite;
}

.product-card-featured:nth-child(1) { animation-delay: 0.1s, 0s; }
.product-card-featured:nth-child(2) { animation-delay: 0.2s, 0.5s; }
.product-card-featured:nth-child(3) { animation-delay: 0.3s, 1s; }
.product-card-featured:nth-child(4) { animation-delay: 0.4s, 1.5s; }

/* Glow effect for active card */
.product-card-featured.active {
    box-shadow: 0 0 30px rgba(255, 71, 87, 0.3);
    border-color: #ff3742;
}

/* Sparkle effect */
@keyframes sparkle {
    0%, 100% { opacity: 0; transform: scale(0) rotate(0deg); }
    50% { opacity: 1; transform: scale(1) rotate(180deg); }
}

.product-card-featured::after {
    content: '✨';
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 1.2rem;
    animation: sparkle 2s ease-in-out infinite;
    opacity: 0;
    pointer-events: none;
}

.product-card-featured:hover::after {
    opacity: 1;
}

.product-name {
    font-size: 1.2rem;
    font-weight: 800;
    color: #2c3e50;
    margin-bottom: 10px;
    line-height: 1.3;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.05);
}

.product-specs {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 15px;
    line-height: 1.4;
}

.pricing {
    margin-bottom: 15px;
}

.current-price {
    font-size: 1.5rem;
    font-weight: 800;
    color: #ff4757;
    margin-bottom: 18px;
    text-shadow: 1px 1px 2px rgba(255, 71, 87, 0.2);
    background: linear-gradient(135deg, #ff4757, #ff3742);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.product-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-top: 1px solid rgba(255, 71, 87, 0.1);
    margin-top: 15px;
}

.rating {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #f39c12;
    font-weight: 700;
    font-size: 0.95rem;
    background: rgba(243, 156, 18, 0.1);
    padding: 6px 12px;
    border-radius: 20px;
    border: 1px solid rgba(243, 156, 18, 0.2);
}

.like-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #3498db;
    cursor: pointer;
    transition: all 0.3s ease;
    background: rgba(52, 152, 219, 0.1);
    padding: 6px 12px;
    border-radius: 20px;
    border: 1px solid rgba(52, 152, 219, 0.2);
    font-weight: 600;
}

.like-btn:hover {
    color: #2980b9;
    transform: scale(1.05);
    background: rgba(52, 152, 219, 0.15);
    box-shadow: 0 2px 8px rgba(52, 152, 219, 0.2);
}

/* Carousel Indicators */
.carousel-indicators {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 25px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 25px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 71, 87, 0.1);
}

.indicator {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e9ecef, #dee2e6);
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.indicator.active {
    background: linear-gradient(135deg, #ff4757, #ff3742);
    transform: scale(1.3);
    border-color: rgba(255, 255, 255, 0.3);
    box-shadow: 0 4px 12px rgba(255, 71, 87, 0.4);
}

.indicator:hover {
    background: linear-gradient(135deg, #ff6b7a, #ff4757);
    transform: scale(1.2);
    box-shadow: 0 3px 8px rgba(255, 71, 87, 0.3);
}

/* Responsive for HOT SALE */
@media (max-width: 768px) {
    /* Reduce visual effects and heavy animations for mobile */
    .hot-sale-section { 
        padding: 16px; 
        box-shadow: none; 
        border-radius: 16px; 
        background: #fff !important;
    }
    .hot-sale-banner { 
        padding: 14px; 
        box-shadow: none; 
        border-radius: 14px; 
        background: #ff4757 !important;
        border: none;
    }
    .hot-sale-banner::before { content: none; }
    .hot-sale-banner::after { content: none; }
    .banner-content { 
        font-size: 1rem; 
        gap: 10px; 
        text-shadow: none;
    }
    .banner-content i { font-size: 1.2rem; }
    .decoration-dot { animation: none !important; }
    .pulse-animation { animation: none !important; }

    .products-carousel { gap: 12px; padding: 12px 0; background: #fff; border: 0; backdrop-filter: none; }
    .carousel-track {
        gap: 15px;
    }
    .carousel-arrow { width: 44px; height: 44px; box-shadow: none; }
    .product-card-featured {
        min-width: 240px;
        padding: 14px;
        box-shadow: none;
        border: 1px solid #e9ecef;
    }
    .product-card-featured::before, .product-card-featured::after { content: none !important; }
    .product-card-featured, .product-card-featured:hover { transform: none; animation: none !important; }
    .product-card-featured .product-image { 
        margin: 20px 0 15px; 
        padding: 15px; 
        background: #f8f9fa;
        border: none;
    }
    .product-card-featured .product-image img { 
        height: 120px; 
        filter: none;
    }
    .product-badge { 
        background: #dc3545; 
        box-shadow: none; 
        animation: none !important;
    }
    .current-price { 
        background: #ff4757; 
        -webkit-background-clip: unset; 
        -webkit-text-fill-color: unset; 
        color: #ff4757;
        text-shadow: none;
    }
}

.product-card {
    background: linear-gradient(135deg, #ffffff 0%, #f7f8fa 100%);
    border-radius: 16px;
    box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
    height: 500px;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0,0,0,0.12);
}

.product-image {
    position: relative;
    height: 250px;
    overflow: hidden;
    background: #f8f9fb; /* solid to avoid banding/stripes */
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px;
}

.product-image::before,
.product-image::after {
    display: none !important;
}

.product-image img {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    transition: transform 0.3s ease, filter 0.3s ease;
    filter: drop-shadow(0 6px 14px rgba(0,0,0,0.12));
}

.product-card:hover .product-image img {
    transform: scale(1.06);
    filter: drop-shadow(0 10px 20px rgba(255, 71, 87, 0.25));
}

.featured-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #dc3545;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.7rem;
    font-weight: 600;
}

.product-content {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
}

.product-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-height: 2.6em;
}

.product-category {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 12px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-height: 1.8em;
    line-height: 1.4;
}

.product-price {
    margin-bottom: 15px;
    flex-shrink: 0;
}

.product-spacer {
    flex: 1;
    min-height: 20px;
}

.price {
    font-size: 1.2rem;
    font-weight: 700;
    color: #dc3545;
}

.product-actions {
    display: flex;
    gap: 8px;
}

.product-actions .btn {
    flex: 1;
    font-size: 0.85rem;
    padding: 8px 12px;
    min-width: 120px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

/* Price Selector Styles */
.price-selector {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 12px;
    border: 1px solid #e9ecef;
}

.price-display {
    text-align: center;
}

.duration-selector {
    margin-top: 8px;
}

.duration-select {
    border: 2px solid #dee2e6;
    border-radius: 6px;
    font-size: 0.85rem;
    padding: 6px 10px;
    background: white;
    transition: all 0.3s ease;
}

.duration-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.duration-select:hover {
    border-color: #adb5bd;
}

/* Rental Filter Styles */
.rental-filter-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    color: white;
}

.filter-header {
    text-align: center;
    margin-bottom: 15px;
    font-size: 1.1rem;
}

.filter-content {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    padding: 15px;
    backdrop-filter: blur(10px);
}

.rental-duration-select {
    border: none;
    border-radius: 8px;
    padding: 10px 15px;
    font-weight: 500;
    background: white;
    color: #333;
}

.price-info {
    text-align: center;
}

.info-text {
    font-size: 0.9rem;
    opacity: 0.9;
}



/* Empty State */
.empty-state {
    padding: 60px 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .product-image {
        height: 200px;
    }
    
    .product-content {
        padding: 15px;
    }
}

/* Service Packages Section */
.service-packages-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
    padding: 80px 0;
}

.packages-container {
    position: relative;
    z-index: 2;
}

/* Decorative Elements (2 cái tai) */
.package-decoration {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 200px;
    height: 400px;
    z-index: 1;
}

.left-decoration {
    left: -100px;
}

.right-decoration {
    right: -100px;
}

.decoration-circle {
    position: absolute;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(13, 110, 253, 0.1) 0%, rgba(102, 16, 242, 0.1) 100%);
    animation: float 6s ease-in-out infinite;
}

.left-decoration .decoration-circle {
    top: 20px;
    left: 20px;
}

.right-decoration .decoration-circle {
    bottom: 20px;
    right: 20px;
}

.decoration-line {
    position: absolute;
    width: 2px;
    height: 200px;
    background: linear-gradient(to bottom, transparent, rgba(13, 110, 253, 0.3), transparent);
    animation: pulse 4s ease-in-out infinite;
}

.left-decoration .decoration-line {
    right: 50px;
    top: 50px;
}

.right-decoration .decoration-line {
    left: 50px;
    bottom: 50px;
}

.decoration-icon {
    position: absolute;
    font-size: 2.5rem;
    color: rgba(255, 255, 255, 0.6);
    animation: rotate 8s linear infinite;
    text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
}

.left-decoration .decoration-icon {
    bottom: 80px;
    left: 60px;
}

.right-decoration .decoration-icon {
    top: 80px;
    right: 60px;
}

/* Package Cards */
.package-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 25px;
    padding: 35px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
    border: 2px solid transparent;
    border-top: 4px solid transparent;
}

.package-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #0d6efd, #6610f2);
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.package-card:hover::before {
    transform: scaleX(1);
}

.package-card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 30px 60px rgba(0,0,0,0.2);
    background: rgba(255, 255, 255, 1);
}

/* Featured Package */
.featured-package {
    border-color: #0d6efd;
    border-top-color: #0d6efd;
    transform: scale(1.05);
    background: linear-gradient(135deg, rgba(255,255,255,0.98), rgba(255,255,255,0.95));
    box-shadow: 0 25px 50px rgba(13, 110, 253, 0.2);
}

.featured-package:hover {
    transform: scale(1.05) translateY(-15px) scale(1.02);
    box-shadow: 0 35px 70px rgba(13, 110, 253, 0.3);
}

.featured-badge {
    position: absolute;
    top: -15px;
    right: 20px;
    background: linear-gradient(135deg, #dc3545, #fd7e14);
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 700;
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
    animation: pulse 2s ease-in-out infinite;
}

/* Package Header */
.package-header {
    text-align: center;
    margin-bottom: 25px;
}

.package-icon {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    transition: all 0.4s ease;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.package-card:hover .package-icon {
    transform: scale(1.15) rotate(5deg);
    background: linear-gradient(135deg, #0d6efd, #6610f2);
    color: white;
    box-shadow: 0 15px 30px rgba(13, 110, 253, 0.3);
}

.package-icon i {
    font-size: 2rem;
    color: #0d6efd;
    transition: all 0.3s ease;
}

.package-card:hover .package-icon i {
    color: white;
}

.package-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: #333;
}

.package-price {
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 5px;
}

.currency {
    font-size: 1.2rem;
    color: #6c757d;
    font-weight: 600;
}

.amount {
    font-size: 3rem;
    font-weight: 900;
    background: linear-gradient(135deg, #0d6efd, #6610f2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
}

.period {
    font-size: 1rem;
    color: #6c757d;
    font-weight: 500;
}

/* Package Features */
.package-features {
    margin-bottom: 25px;
}

.feature-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.feature-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 0;
    font-size: 0.95rem;
    color: #555;
    transition: all 0.3s ease;
}

.feature-list li:hover {
    color: #0d6efd;
    transform: translateX(5px);
}

.feature-list i {
    color: #28a745;
    font-size: 1rem;
    min-width: 16px;
}

.feature-list .text-warning {
    color: #ffc107 !important;
}

/* Package Action */
.package-action {
    margin-top: auto;
}

.package-action .btn {
    border-radius: 25px;
    font-weight: 600;
    padding: 12px 24px;
    transition: all 0.3s ease;
}

.package-action .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* Animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes pulse {
    0%, 100% { opacity: 0.3; }
    50% { opacity: 1; }
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
    .package-decoration {
        display: none;
    }
    
    .package-card {
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .featured-package {
        transform: none;
    }
    
    .featured-package:hover {
        transform: translateY(-5px);
    }
    
    .package-icon {
        width: 60px;
        height: 60px;
    }
    
    .package-icon i {
        font-size: 1.5rem;
    }
    
    .amount {
        font-size: 2rem;
    }
    
    .feature-list li {
        font-size: 0.9rem;
    }
}

/* Fix for missing buttons */
.product-card {
    overflow: hidden !important;
    position: relative;
    height: 500px !important;
    display: flex !important;
    flex-direction: column !important;
}

.product-content {
    flex: 1 !important;
    min-height: 0 !important;
    position: relative;
    z-index: 5;
    display: flex !important;
    flex-direction: column !important;
}

.product-price {
    flex-shrink: 0 !important;
    flex-grow: 0 !important;
    margin-bottom: 15px !important;
}

.product-spacer {
    flex: 1 !important;
    min-height: 20px !important;
}

.product-actions {
    flex-shrink: 0 !important;
    position: relative;
    z-index: 10;
    display: flex !important;
    gap: 6px;
    padding: 0 20px 15px 20px;
    margin-left: -20px;
    margin-right: -20px;
    margin-bottom: -15px;
}

.product-actions .btn {
    position: relative;
    z-index: 15;
    white-space: nowrap;
    overflow: hidden;
    display: flex !important;
    align-items: center;
    justify-content: center;
    text-align: center;
    min-width: 90px;
    height: 32px;
    flex: 1;
    font-size: 0.75rem;
    padding: 6px 10px;
    border-radius: 6px;
    font-weight: 500;
}

.product-card:hover {
    z-index: 20;
    position: relative;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}

/* Animation for filter */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Button hover effects */
.product-actions .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transition: all 0.2s ease;
}

.product-actions .btn:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Ensure buttons stay within card boundaries */
.product-actions .btn {
    max-width: calc(50% - 3px);
    word-wrap: break-word;
    white-space: normal;
    line-height: 1.1;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Responsive adjustments for buttons */
@media (max-width: 768px) {
    .product-card {
        height: 450px !important;
    }
    
    .product-actions {
        padding: 0 15px 12px 15px;
        margin-left: -15px;
        margin-right: -15px;
        margin-bottom: -12px;
        gap: 4px;
    }
    
    .product-actions .btn {
        font-size: 0.7rem;
        padding: 5px 8px;
        min-width: 80px;
        height: 28px;
        letter-spacing: 0.3px;
    }
}

/* Extra small screens */
@media (max-width: 576px) {
    .product-card {
        height: 420px !important;
    }
    
    .product-actions .btn {
        font-size: 0.65rem;
        padding: 4px 6px;
        min-width: 70px;
        height: 26px;
    }
}

/* ===== HERO SECTION ENHANCEMENTS ===== */

/* Trust Indicators */
.trust-section {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 25px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.trust-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.trust-item:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.trust-item i {
    font-size: 1.2rem;
    min-width: 20px;
}

.trust-item span {
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
}

/* Interactive Elements */
.hero-section .btn {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.hero-section .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

/* Ripple Effect */
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

/* Mobile optimization for hero section */
@media (max-width: 768px) {
    .hero-section {
        min-height: 80vh !important;
        padding: 20px 0;
    }
    
    .trust-section {
        padding: 20px 15px;
        margin: 0 10px;
    }
    
    .trust-item {
        padding: 10px 12px;
        font-size: 0.85rem;
    }
    
    .trust-item i {
        font-size: 1rem;
    }
    
    .trust-item span {
        font-size: 0.8rem;
    }
    
    .hero-title-mobile {
        font-size: 1.8rem !important;
        line-height: 1.3;
        margin-bottom: 20px !important;
    }
    
    .hero-services-mobile {
        font-size: 1rem !important;
        line-height: 1.6 !important;
        margin-bottom: 25px !important;
    }
    
    .hero-services-mobile .mb-3 {
        margin-bottom: 15px !important;
    }
    
    .hero-services-mobile i {
        font-size: 1rem !important;
        margin-right: 12px !important;
    }
    
    .hero-section .btn {
        font-size: 1rem;
        padding: 12px 20px;
    }
}
</style>

@push('scripts')
<script>
// Filter without reload
let selectedCategory = 'all';
let selectedModel = 'all';

function applyFilters(){
  const cards = document.querySelectorAll('.product-card');
  cards.forEach(card => {
    const cat = String(card.getAttribute('data-category'));
    const mdl = String(card.getAttribute('data-model'));
    const matchCat = (selectedCategory==='all' || cat===String(selectedCategory));
    const matchModel = (selectedModel==='all' || mdl===String(selectedModel));
    const show = matchCat && matchModel;
    const col = card.closest('.col');
    if(col){ 
      col.style.display = show ? '' : 'none'; 
      if(show){
        col.style.animation = 'fadeInUp .3s ease';
      }
    }
  });
}

function updateActive(containerSelector, attr, value){
  const items = document.querySelectorAll(containerSelector+' .filter-item');
  items.forEach(i=>i.classList.remove('active'));
  const active = Array.from(items).find(i=>i.dataset[attr]===String(value));
  if(active){ active.classList.add('active'); }
}

function filterProductsByCategory(categoryId){
  selectedCategory = String(categoryId);
  updateActive('#categoriesFilter','category',selectedCategory);
  applyFilters();
}

function setModel(modelId){
  console.log('Filtering by model:', modelId);
  selectedModel = String(modelId);
  updateActive('#modelsFilter','model',selectedModel);
  applyFilters();
}

// Scroll functions for filter
function scrollCategoriesLeft() {
  const filter = document.getElementById('modelsFilter');
  if (filter) {
    filter.scrollBy({ left: -200, behavior: 'smooth' });
  }
}

function scrollCategoriesRight() {
  const filter = document.getElementById('modelsFilter');
  if (filter) {
    filter.scrollBy({ left: 200, behavior: 'smooth' });
  }
}
// Update product price based on selected duration
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

// Number formatting function
function numberFormat(num) {
    return new Intl.NumberFormat('vi-VN').format(num);
}

// ===== HERO SECTION INTERACTIVE FEATURES =====

// Simple button hover effects
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.hero-section .btn');
    
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Interactive particles + lines effect for the hero section
document.addEventListener('DOMContentLoaded', function () {
    const section = document.querySelector('.hero-section');
    const canvas = document.getElementById('hero-network');
    if (!section || !canvas) return;

    const ctx = canvas.getContext('2d');
    let width = 0, height = 0, particles = [], mouse = { x: null, y: null, active: false };

    function resize() {
        width = canvas.width = section.clientWidth;
        height = canvas.height = section.clientHeight;
        spawnParticles();
    }

    function random(min, max) { return Math.random() * (max - min) + min; }

    class Particle {
        constructor() { this.reset(true); }
        reset(initial = false) {
            this.x = initial ? random(0, width) : (Math.random() < 0.5 ? 0 : width);
            this.y = random(0, height);
            this.vx = random(-0.7, 0.7);
            this.vy = random(-0.7, 0.7);
            this.size = random(1.5, 3.0);
            this.alpha = random(0.6, 1);
        }
        update() {
            this.x += this.vx; this.y += this.vy;
            if (this.x < -50 || this.x > width + 50 || this.y < -50 || this.y > height + 50) {
                this.reset();
            }
        }
        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(255,255,255,${this.alpha})`;
            ctx.fill();
        }
    }

    function spawnParticles() {
        const density = Math.min(220, Math.max(120, Math.floor((width * height) / 15000)));
        particles = new Array(density).fill(0).map(() => new Particle());
    }

    function connect() {
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const a = particles[i], b = particles[j];
                const dx = a.x - b.x, dy = a.y - b.y;
                const dist2 = dx * dx + dy * dy;
                const maxDist2 = 150 * 150;
                if (dist2 < maxDist2) {
                    const opacity = 1 - dist2 / maxDist2;
                    ctx.strokeStyle = `rgba(255,255,255,${0.25 * opacity})`;
                    ctx.lineWidth = 1.2;
                    ctx.shadowColor = 'rgba(180, 200, 255, 0.6)';
                    ctx.shadowBlur = 6;
                    ctx.beginPath();
                    ctx.moveTo(a.x, a.y);
                    ctx.lineTo(b.x, b.y);
                    ctx.stroke();
                    ctx.shadowBlur = 0;
                }
            }
        }
        if (mouse.active) {
            for (const p of particles) {
                const dx = p.x - mouse.x, dy = p.y - mouse.y;
                const dist2 = dx * dx + dy * dy;
                const maxDist2 = 200 * 200;
                if (dist2 < maxDist2) {
                    const opacity = 1 - dist2 / maxDist2;
                    ctx.strokeStyle = `rgba(96, 165, 250, ${0.75 * opacity})`;
                    ctx.lineWidth = 1.8;
                    ctx.shadowColor = 'rgba(96, 165, 250, 0.8)';
                    ctx.shadowBlur = 8;
                    ctx.beginPath();
                    ctx.moveTo(p.x, p.y);
                    ctx.lineTo(mouse.x, mouse.y);
                    ctx.stroke();
                    ctx.shadowBlur = 0;
                }
            }
        }
    }

    function animate() {
        ctx.clearRect(0, 0, width, height);
        for (const p of particles) { p.update(); p.draw(); }
        connect();
        requestAnimationFrame(animate);
    }

    section.addEventListener('mousemove', (e) => {
        const rect = section.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
        mouse.active = true;
    });
    section.addEventListener('mouseleave', () => { mouse.active = false; });

    window.addEventListener('resize', resize);
    resize();
    animate();
});

// Enhanced Popular Products Carousel functionality
document.addEventListener('DOMContentLoaded', function() {
    const carouselTrack = document.getElementById('carouselTrack');
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    const indicators = document.querySelectorAll('.indicator');
    
    if (carouselTrack && prevBtn && nextBtn) {
        let currentPosition = 0;
        // We'll use logical slide index excluding clones
        let currentSlide = 0;
        // Detect actual card width + gap dynamically for accurate movement
        const trackStyles = window.getComputedStyle(carouselTrack);
        const gapPx = parseFloat(trackStyles.gap || trackStyles.columnGap || '0');
        const container = document.querySelector('.carousel-container');
        const originalCards = Array.from(carouselTrack.children);
        const originalCount = originalCards.length;
        const firstRealCardInitial = originalCards[0];
        const detectedCardWidthInitial = firstRealCardInitial ? Math.round(firstRealCardInitial.getBoundingClientRect().width + gapPx) : 300;
        let cardWidth = detectedCardWidthInitial; // effective width per slide
        const cardsPerSlide = 1; // Move one card at a time
        let totalSlides = originalCount; // number of logical slides (original items)
        let autoPlayInterval;

        // 1) Ensure there are enough visual cards to fill the viewport to avoid whitespace
        if (container && originalCount > 0) {
            const containerWidth = Math.round(container.getBoundingClientRect().width);
            const minCardsVisible = Math.max(1, Math.floor(containerWidth / cardWidth));
            const minNeeded = Math.max(minCardsVisible + 1, 3); // at least 3 cards to allow movement
            let currentChildren = Array.from(carouselTrack.children);
            while (currentChildren.length < minNeeded) {
                const clone = currentChildren[currentChildren.length % originalCount].cloneNode(true);
                carouselTrack.appendChild(clone);
                currentChildren = Array.from(carouselTrack.children);
            }
            // Recalculate cardWidth in case layout changed
            const firstAfterFill = carouselTrack.children[0];
            if (firstAfterFill) {
                cardWidth = Math.round(firstAfterFill.getBoundingClientRect().width + gapPx);
            }
            // Clamp fallback if measurement fails
            if (!Number.isFinite(cardWidth) || cardWidth < 80 || cardWidth > 1000) {
                cardWidth = 300;
            }
        }

        // 2) Clone cards để tạo infinite loop mượt mà
        // Clone 3-4 cards đầu và cuối để tránh khoảng trắng
        const cloneCount = Math.min(3, originalCount);
        for (let i = 0; i < cloneCount; i++) {
            const firstCard = carouselTrack.children[i];
            const lastCard = carouselTrack.children[originalCount - 1 - i];
            if (firstCard) {
                const firstClone = firstCard.cloneNode(true);
                carouselTrack.appendChild(firstClone);
            }
            if (lastCard) {
                const lastClone = lastCard.cloneNode(true);
                carouselTrack.insertBefore(lastClone, carouselTrack.children[0]);
            }
        }

        // Bắt đầu từ slide đầu tiên (sau các clone)
        let visualIndex = cloneCount;
        let visualTotal = carouselTrack.children.length;
        currentPosition = visualIndex * cardWidth;
        carouselTrack.style.transform = `translateX(-${currentPosition}px)`;
        
        // Initialize auto-play if there is actually something to scroll
        const canScroll = originalCount > 1 && (carouselTrack.scrollWidth > (container ? container.clientWidth : 0));
        if (canScroll) {
            startAutoPlay();
        } else {
            // Hide arrows if no scrolling is possible
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
        }
        
        // Update indicators count based on actual slides
        updateIndicators();
        
        function updateCarousel() {
            carouselTrack.style.transform = `translateX(-${currentPosition}px)`;
            
            // Update indicators
            const indicators = document.querySelectorAll('.indicator');
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentSlide);
            });
            
            // Update active card
            const cards = carouselTrack.querySelectorAll('.product-card-featured');
            cards.forEach((card, index) => {
                // account for the leading clone at index 0
                const logicalIndex = (index - 1 + totalSlides) % totalSlides;
                card.classList.toggle('active', logicalIndex === currentSlide);
            });
        }
        
        function moveToSlide(slideIndex) {
            currentSlide = (slideIndex + totalSlides) % totalSlides;
            visualIndex = currentSlide + cloneCount;
            currentPosition = visualIndex * cardWidth;
            updateCarousel();
        }
        
        function nextSlide() {
            visualIndex += 1;
            currentSlide = (currentSlide + 1) % totalSlides;
            currentPosition = visualIndex * cardWidth;
            updateCarousel();
        }
        
        function prevSlide() {
            visualIndex -= 1;
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            currentPosition = visualIndex * cardWidth;
            updateCarousel();
        }
        
        function startAutoPlay() {
            stopAutoPlay();
            autoPlayInterval = setInterval(nextSlide, 4000); // Auto-slide every 4 seconds
        }
        
        function stopAutoPlay() {
            clearInterval(autoPlayInterval);
        }

        // Handle seamless jump when we reach clones - tạo infinite loop mượt mà
        carouselTrack.addEventListener('transitionend', () => {
            visualTotal = carouselTrack.children.length;
            
            // Nếu đang ở clone cuối, nhảy về slide đầu thật
            if (visualIndex >= visualTotal - cloneCount) {
                carouselTrack.style.transition = 'none';
                visualIndex = cloneCount;
                currentPosition = visualIndex * cardWidth;
                carouselTrack.style.transform = `translateX(-${currentPosition}px)`;
                void carouselTrack.offsetWidth;
                carouselTrack.style.transition = '';
            }
            
            // Nếu đang ở clone đầu, nhảy về slide cuối thật
            if (visualIndex < cloneCount) {
                carouselTrack.style.transition = 'none';
                visualIndex = visualTotal - cloneCount - 1;
                currentPosition = visualIndex * cardWidth;
                carouselTrack.style.transform = `translateX(-${currentPosition}px)`;
                void carouselTrack.offsetWidth;
                carouselTrack.style.transition = '';
            }
        });
        
        function updateIndicators() {
            // Remove existing indicators
            const existingIndicators = document.querySelectorAll('.indicator');
            existingIndicators.forEach(indicator => indicator.remove());
            
            // Create new indicators based on actual number of products
            const indicatorsContainer = document.querySelector('.carousel-indicators');
            if (indicatorsContainer) {
                for (let i = 0; i < totalSlides; i++) {
                    const indicator = document.createElement('div');
                    indicator.className = `indicator ${i === 0 ? 'active' : ''}`;
                    indicator.onclick = () => {
                        stopAutoPlay();
                        moveToSlide(i);
                        if (canScroll) startAutoPlay();
                    };
                    indicatorsContainer.appendChild(indicator);
                }
            }
        }
        
        // Manual navigation
        prevBtn.addEventListener('click', () => {
            stopAutoPlay();
            prevSlide();
            startAutoPlay();
        });
        
        nextBtn.addEventListener('click', () => {
            stopAutoPlay();
            nextSlide();
            startAutoPlay();
        });
        
        // Indicator clicks (will be handled by updateIndicators function)
        
        // Pause auto-play on hover
        const carousel = document.getElementById('featuredCarousel');
        carousel.addEventListener('mouseenter', stopAutoPlay);
        carousel.addEventListener('mouseleave', () => { if (canScroll) startAutoPlay(); });
        
        // Touch/swipe support
        let startX = 0;
        let endX = 0;
        
        carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });
        
        carousel.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            const diff = startX - endX;
            
            if (Math.abs(diff) > 50) { // Minimum swipe distance
                if (diff > 0) {
                    // Swipe left - next slide
                    stopAutoPlay();
                    nextSlide();
                    startAutoPlay();
                } else {
                    // Swipe right - previous slide
                    stopAutoPlay();
                    prevSlide();
                    startAutoPlay();
                }
            }
        });
    }
    
    // Enhanced featured product cards functionality
    const featuredCards = document.querySelectorAll('.product-card-featured');
    featuredCards.forEach(card => {
        // Add ripple effect on click
        card.addEventListener('click', function(e) {
            if (e.target.closest('.like-btn')) {
                return;
            }
            
            // Create ripple effect
            const ripple = document.createElement('div');
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(255, 255, 255, 0.6)';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'ripple 0.6s linear';
            ripple.style.left = (e.clientX - this.offsetLeft) + 'px';
            ripple.style.top = (e.clientY - this.offsetTop) + 'px';
            ripple.style.width = ripple.style.height = '20px';
            ripple.style.pointerEvents = 'none';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Like button functionality
    window.toggleLike = function(button) {
        const icon = button.querySelector('i');
        const isLiked = icon.classList.contains('fas');
        
        if (isLiked) {
            icon.classList.remove('fas');
            icon.classList.add('far');
            button.style.color = '#6c757d';
        } else {
            icon.classList.remove('far');
            icon.classList.add('fas');
            button.style.color = '#e74c3c';
            
            // Add heart animation
            button.style.animation = 'heartBeat 0.6s ease-in-out';
            setTimeout(() => {
                button.style.animation = '';
            }, 600);
        }
    };
    
    // Make catalog product cards clickable to detail page
    const catalogCards = document.querySelectorAll('.product-card[data-url]');
    catalogCards.forEach(card => {
        // Avoid navigating when clicking on interactive child elements
        card.addEventListener('click', (e) => {
            const interactive = e.target.closest('a, button, select, input, textarea, .duration-select, form');
            if (interactive) return;
            const url = card.getAttribute('data-url');
            if (url) window.location.href = url;
        });
        // Keyboard accessibility
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                const url = card.getAttribute('data-url');
                if (url) window.location.href = url;
            }
        });
    });
});

// Global carousel functions
window.goToSlide = function(slideIndex) {
    const carouselTrack = document.getElementById('carouselTrack');
    if (carouselTrack) {
        const cardWidth = 300;
        const currentPosition = slideIndex * cardWidth;
        carouselTrack.style.transform = `translateX(-${currentPosition}px)`;
        
        // Update indicators
        const indicators = document.querySelectorAll('.indicator');
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === slideIndex);
        });
    }
};

</script>
@endpush

@section('content')
@parent
@endsection