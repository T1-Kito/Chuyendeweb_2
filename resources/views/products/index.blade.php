@extends('layouts.app')

@section('title', 'Sản phẩm - ' . config('app.name'))

@section('content')
<style>
    /* Chỉ áp dụng cho trang danh sách sản phẩm */
    .products-section {
        background: #ffffff;
    }

    .products-section .container {
        max-width: 1320px; /* rộng hơn container mặc định */
    }

    /* Thanh filter */
    .products-section .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        justify-content: flex-end;
    }

    .products-section .filter-form .form-group {
        flex: 1 1 0;
        min-width: 140px;
    }

    .products-section .filter-row-bottom {
        flex: 1 1 100%;
        display: flex;
        justify-content: flex-start;
        gap: 0.75rem;
        margin-top: 0.25rem;
    }

    .products-section .filter-row-bottom .form-group {
        flex: 0 0 160px;
    }

    .products-section .filter-form .form-control,
    .products-section .filter-form .form-select {
        border-radius: 999px;
        font-size: 0.95rem;
        padding: 0.55rem 1rem;
    }

    .products-section .filter-form .form-select {
        padding-right: 2.5rem; /* chừa chỗ cho mũi tên select, tránh đè chữ */
    }

    /* Ẩn spinner của input number trong bộ lọc giá */
    .products-section .filter-form input[type="number"]::-webkit-outer-spin-button,
    .products-section .filter-form input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .products-section .filter-form input[type="number"] {
        -moz-appearance: textfield;
    }

    .products-section .filter-form button[type="submit"] {
        border-radius: 999px;
        background: linear-gradient(135deg, #ff7a18, #ffb347);
        border: none;
        font-weight: 700;
        padding: 0.6rem 1.8rem;
        font-size: 0.95rem;
        box-shadow: 0 8px 20px rgba(255, 122, 24, 0.25);
        white-space: nowrap;
    }

    .products-section .filter-form button[type="submit"]:hover {
        filter: brightness(1.05);
        box-shadow: 0 10px 24px rgba(255, 122, 24, 0.3);
    }

    @media (max-width: 767.98px) {
        .products-section .filter-row-bottom {
            flex-direction: column;
            align-items: stretch;
        }

        .products-section .filter-row-bottom .form-group {
            flex: 1 1 auto;
        }
    }

    /* Card sản phẩm */
    .products-section .product-card {
        height: 500px !important;
        overflow: hidden;
        position: relative;
    }

    .products-section .product-image {
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
    }

    .products-section .product-image img {
        max-height: 100%;
        width: auto;
        max-width: 100%;
        object-fit: contain;
    }

    /* Empty state */
    .products-section .empty-state-wrapper {
        padding: 60px 0;
        text-align: center;
    }

    .products-section .empty-state-wrapper h3 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    .products-section .empty-state-wrapper p {
        color: #6c757d;
        margin-bottom: 20px;
    }

    .products-section .empty-state-wrapper .btn-primary {
        border-radius: 999px;
        padding: 0.6rem 1.6rem;
        background: linear-gradient(135deg, #4e54c8, #8f94fb);
        border: none;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(78, 84, 200, 0.3);
    }

    .products-section .empty-state-wrapper .btn-primary:hover {
        filter: brightness(1.05);
        box-shadow: 0 10px 24px rgba(78, 84, 200, 0.35);
    }

    @media (max-width: 768px) {
        .products-section .product-card {
            height: 450px !important;
        }
        .products-section .product-image {
            height: 200px;
        }
    }

    @media (max-width: 576px) {
        .products-section .product-card {
            height: 420px !important;
        }
        .products-section .product-image {
            height: 180px;
        }
    }
</style>
<div class="products-section py-5">
    <div class="container">
        <div class="row mb-4 align-items-end">
            <div class="col-lg-4 mb-3 mb-lg-0">
                <h1 class="h3 mb-2"><i class="fas fa-th-large me-2"></i>Tất cả sản phẩm</h1>
                <p class="text-muted mb-0">Chọn thiết bị phù hợp nhu cầu thuê của bạn.</p>
            </div>
            <div class="col-lg-8">
                <form method="GET" action="{{ route('products.index') }}" class="filter-form">
                    <!-- Hàng trên: tìm kiếm, danh mục, nút lọc -->
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                    </div>
                    <div class="form-group">
                        <select name="category" class="form-select" style="min-width: 180px;">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="flex:0 0 auto;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Lọc sản phẩm
                        </button>
                    </div>

                    <!-- Hàng dưới: giá từ, đến, sắp xếp -->
                    <div class="filter-row-bottom">
                        <div class="form-group">
                            <input type="number" name="min_price" class="form-control" placeholder="Giá từ" value="{{ request('min_price') }}" min="0">
                        </div>
                        <div class="form-group">
                            <input type="number" name="max_price" class="form-control" placeholder="Đến" value="{{ request('max_price') }}" min="0">
                        </div>
                        <div class="form-group">
                            <select name="sort" class="form-select">
                                <option value="newest" {{ (request('sort','newest') === 'newest') ? 'selected' : '' }}>Mới nhất</option>
                                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Giá thấp đến cao</option>
                                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Giá cao đến thấp</option>
                                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Tên A-Z</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if($products->count() > 0)
            <div class="row mt-3">
                <div class="col-12">
                    <div class="row row-cols-xxl-4 row-cols-xl-4 row-cols-lg-4 row-cols-md-2 row-cols-sm-1 g-4">
                        @foreach($products as $product)
                        <div class="col">
                            <div class="product-card h-100" 
                                 data-category="{{ $product->category_id ?? 'all' }}" 
                                 data-model="{{ \Illuminate\Support\Str::slug((string)($product->model ?? $product->name)) }}" 
                                 data-url="{{ route('products.show', $product->slug ?? $product->id) }}" 
                                 tabindex="0" role="link">
                                <div class="product-image position-relative">
                                    <img src="{{ $product->image_url }}" 
                                         class="img-fluid" alt="{{ $product->name }}">
                                    @auth
                                        <button class="btn btn-sm position-absolute top-0 end-0 m-2 favorite-btn {{ isset($product->isFavorited) && $product->isFavorited ? 'favorited' : '' }}" 
                                                data-product-id="{{ $product->id }}"
                                                title="{{ isset($product->isFavorited) && $product->isFavorited ? 'Bỏ yêu thích' : 'Yêu thích' }}"
                                                onclick="event.stopPropagation(); toggleFavorite(this)"
                                                style="background: rgba(255,255,255,0.9); border: none; z-index: 10;">
                                            <i class="{{ isset($product->isFavorited) && $product->isFavorited ? 'fas' : 'far' }} fa-heart" 
                                               style="color: {{ isset($product->isFavorited) && $product->isFavorited ? '#e74c3c' : '#6c757d' }};"></i>
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}" 
                                           class="btn btn-sm position-absolute top-0 end-0 m-2" 
                                           title="Đăng nhập để yêu thích"
                                           onclick="event.stopPropagation();"
                                           style="background: rgba(255,255,255,0.9); border: none; z-index: 10;">
                                            <i class="far fa-heart" style="color: #6c757d;"></i>
                                        </a>
                                    @endauth
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
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Pagination Info -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Hiển thị {{ $products->firstItem() }} đến {{ $products->lastItem() }} trong {{ $products->total() }} sản phẩm
                </div>
            </div>

            <!-- Custom Pagination -->
            @if($products->hasPages())
            <div class="d-flex justify-content-center mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($products->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                            @if ($page == $products->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($products->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">&raquo;</a>
                                </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">&raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            @endif
        @else
            <div class="text-center py-5">
                <h3 class="mb-3">Chưa có sản phẩm nào phù hợp</h3>
                <p class="text-muted mb-3">Hãy thử thay đổi bộ lọc hoặc quay lại trang chủ để xem thêm sản phẩm.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-home me-1"></i>Về trang chủ
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
