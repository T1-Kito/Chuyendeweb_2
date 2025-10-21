@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row">
        <!-- Left Column - Product Images -->
        <div class="col-lg-5 mb-4">
            <div class="product-images">
                <!-- Main Image -->
                <div class="main-image-container mb-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" 
                       onclick="document.getElementById('modalImage').src = document.getElementById('mainImage').src; return false;">
                        <img src="{{ $product->image_url }}" 
                             class="img-fluid rounded main-product-image" alt="{{ $product->name }}" 
                             id="mainImage" loading="lazy" decoding="async">
                    </a>
                </div>
                
                <!-- Thumbnail Images (if available) -->
                @if($product->image)
                <div class="thumbnail-images">
                    <div class="row g-2">
                        <div class="col-3">
                            <img src="{{ $product->image_url }}" 
                                 class="img-thumbnail thumbnail-img active" 
                                 alt="{{ $product->name }}"
                                 onclick="changeMainImage(this.src)" loading="lazy" decoding="async">
                        </div>
                        <!-- Add more thumbnails here if you have multiple images -->
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Middle Column - Product Info -->
        <div class="col-lg-4 mb-4">
            <!-- Product Title -->
            <div class="mb-3">
                <h1 class="h2 fw-bold mb-2">{{ $product->name }}</h1>
                <p class="text-muted mb-0">{{ Str::limit($product->description, 200) }}</p>
            </div>
            
            <!-- Trust Badges -->
            <div class="trust-badges mb-4">
                @if($product->has_warranty_support)
                <span class="badge bg-success me-2">
                    <i class="fas fa-shield-alt me-1"></i>Bảo hành 12 tháng
                </span>
                @endif
                <span class="badge bg-primary me-2">
                    <i class="fas fa-truck me-1"></i>Hỗ trợ tận nơi
                </span>
                <span class="badge bg-warning text-dark">
                    <i class="fas fa-phone me-1"></i>Hotline 24/7
                </span>
            </div>
                        
            <!-- Rental Packages -->
            <div class="rental-packages mb-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                    Chọn Gói Thuê
                </h5>
                
                <div class="package-options">
                    @if($product->price_6_months)
                    <div class="package-option active" data-months="6" data-price="{{ $product->price_6_months }}">
                        <div class="package-header">
                            <input type="radio" name="rental_package" value="6" checked>
                            <label class="package-label">
                                <span class="package-duration">6 tháng</span>
                                <span class="package-total-price">{{ number_format($product->getPriceByMonths(6)) }}đ</span>
                            </label>
                        </div>
                        <div class="package-total">≈ {{ number_format(max(1, (int) $product->getPriceByMonths(6) / 6)) }}đ/tháng</div>
                    </div>
                    @endif
                    
                    @if($product->price_12_months)
                    <div class="package-option" data-months="12" data-price="{{ $product->price_12_months }}">
                        <div class="package-header">
                            <input type="radio" name="rental_package" value="12">
                            <label class="package-label">
                                <span class="package-duration">12 tháng</span>
                                <span class="package-total-price">{{ number_format($product->getPriceByMonths(12)) }}đ</span>
                            </label>
                        </div>
                        <div class="package-total">≈ {{ number_format(max(1, (int) $product->getPriceByMonths(12) / 12)) }}đ/tháng</div>
                    </div>
                    @endif
                    
                    @if($product->price_24_months)
                    <div class="package-option" data-months="24" data-price="{{ $product->price_24_months }}">
                        <div class="package-header">
                            <input type="radio" name="rental_package" value="24">
                            <label class="package-label">
                                <span class="package-duration">24 tháng</span>
                                <span class="package-total-price">{{ number_format($product->getPriceByMonths(24)) }}đ</span>
                            </label>
                        </div>
                        <div class="package-total">≈ {{ number_format(max(1, (int) $product->getPriceByMonths(24) / 24)) }}đ/tháng
                            <div class="bonus-text"><i class="fas fa-gift text-warning me-1"></i>Tặng máy mới</div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- VAT Notice -->
                <div class="vat-notice mt-3">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Giá chưa bao gồm VAT 8%
                    </small>
                </div>
            </div>
                        
            <!-- Rental Duration Selector -->
            <div class="rental-duration-selector mb-4" style="display: none;">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                    Chọn Thời Hạn Thuê
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="rental_duration" class="form-label">Thời hạn thuê:</label>
                        <select id="rental_duration" class="form-select" onchange="updatePrice()">
                            @if($product->price_6_months)
                            <option value="6" data-price="{{ $product->price_6_months }}" data-total="{{ $product->price_6_months * 6 }}">6 tháng</option>
                            @endif
                            @if($product->price_12_months)
                            <option value="12" data-price="{{ $product->price_12_months }}" data-total="{{ $product->price_12_months * 12 }}">12 tháng</option>
                            @endif
                            @if($product->price_24_months)
                            <option value="24" data-price="{{ $product->price_24_months }}" data-total="{{ $product->price_24_months * 24 }}">24 tháng</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Giá thuê:</label>
                        <div class="price-display">
                            <div class="monthly-price">
                                <span id="monthly_price" class="h5 text-success fw-bold">
                                    {{ number_format($product->price_6_months ?? 0) }}đ/tháng
                                </span>
                            </div>
                            <div class="total-price">
                                <small class="text-muted">Tổng: <span id="total_price" class="fw-bold">{{ number_format(($product->price_6_months ?? 0) * 6) }}đ</span></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- CTA Buttons -->
            <div class="cta-section mb-3">
                <div class="d-grid">
                    @auth
                    <form method="POST" action="{{ route('cart.add') }}" onsubmit="return setCartInputs()">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="rental_duration" id="cart_duration" value="6">
                        <input type="hidden" name="quantity" id="cart_qty" value="1">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold" id="add_to_cart_btn">
                            <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg fw-bold">
                        <i class="fas fa-shopping-cart me-2"></i>Đăng nhập để thêm vào giỏ
                    </a>
                    @endauth
                </div>
            </div>
                    
            <!-- Product Features -->
            @if($product->features)
            <div class="product-features mb-4">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-list-check me-2 text-primary"></i>
                    Tính Năng Nổi Bật
                </h6>
                <div class="features-list" id="featuresList">
                    <div class="features-preview">
                        {!! nl2br(e(Str::limit($product->features, 300))) !!}
                        @if(strlen($product->features) > 300)
                            <span class="features-dots">...</span>
                        @endif
                    </div>
                    @if(strlen($product->features) > 300)
                        <div class="features-full" style="display: none;">
                            {!! nl2br(e($product->features)) !!}
                        </div>
                        <button class="btn btn-outline-primary btn-sm mt-2" onclick="toggleFeatures()" id="toggleFeaturesBtn">
                            <i class="fas fa-eye me-1"></i>Xem thêm
                        </button>
                    @endif
                </div>

                
            </div>
            @endif
            
            <!-- Additional Info -->
            <div class="additional-info">
                @if($product->warranty_info)
                <div class="info-item mb-2">
                    <i class="fas fa-shield-alt text-success me-2"></i>
                    <strong>Bảo hành:</strong> {{ $product->warranty_info }}
                </div>
                @endif
                
                @if($product->rental_terms)
                <div class="info-item mb-2">
                    <i class="fas fa-file-contract text-primary me-2"></i>
                    <strong>Điều khoản:</strong> {{ $product->rental_terms }}
                </div>
                @endif
                
                @if($product->delivery_info)
                <div class="info-item mb-2">
                    <i class="fas fa-truck text-warning me-2"></i>
                    <strong>Giao hàng:</strong> {{ $product->delivery_info }}
                </div>
                @endif
            </div>
        </div>
        
        <!-- Right Sidebar - Services & Support -->
        <div class="col-lg-3">
            <div class="services-sidebar">
                <!-- Maintenance During Rental Period -->
                <div class="service-section mb-4">
                    <div class="service-header">
                        <div class="service-icon">
                            <i class="fas fa-tools text-primary"></i>
                        </div>
                        <h6 class="service-title text-primary fw-bold">Bảo Trì Trong Suốt Thời Gian Thuê</h6>
                    </div>
                    <p class="service-content">Cam kết hỗ trợ kỹ thuật và bảo trì trong suốt thời gian thuê thiết bị.</p>
                </div>

                <!-- Accompanying Services Section -->
                <div class="service-section mb-4">
                    <div class="service-header">
                        <div class="service-icon">
                            <i class="fas fa-tools text-success"></i>
                        </div>
                        <h6 class="service-title fw-bold">DỊCH VỤ KÈM THEO</h6>
                    </div>
                    <p class="service-content">Hỗ trợ lắp đặt và bảo hành tận nhà</p>
                </div>

                <!-- Company Commitment Section -->
                <div class="service-section mb-4">
                    <h6 class="service-title fw-bold" style="font-size:1.05rem;">Vi Khang Cam Kết</h6>
                    <div class="commitment-list">
                        <div class="commitment-item" style="font-size:0.9rem;">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Hàng <strong>chính hãng</strong> đến từ các thương hiệu <strong>uy tín</strong> trong và ngoài nước.</span>
                        </div>
                        <div class="commitment-item" style="font-size:0.9rem;">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Giá cả luôn luôn <strong>cạnh tranh</strong> và cập nhập hàng ngày với thị trường.</span>
                        </div>
                        <div class="commitment-item" style="font-size:0.9rem;">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Tư vấn bán hàng <strong>chuyên nghiệp</strong>, giúp khách hàng hiểu hơn về sản phẩm.</span>
                        </div>
                        <div class="commitment-item" style="font-size:0.9rem;">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span><strong>Hậu mãi</strong> chu đáo, hài lòng khách hàng khi đến với Vi Khang.</span>
                        </div>
                    </div>
                </div>

                <!-- Support Hotline Section -->
                <div class="service-section">
                    <h6 class="service-title fw-bold">TỔNG ĐÀI HỖ TRỢ</h6>
                    <div class="support-list">
                        <div class="support-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Mua hàng: <strong>0981 201 889</strong></span>
                        </div>
                        <div class="support-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Bảo hành: <strong>0327 63 4849</strong></span>
                        </div>
                        <div class="support-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Khiếu nại: <strong>0981 201 889</strong></span>
                        </div>
                        <div class="support-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Thời gian làm việc từ <strong>8H - 20H</strong> tất cả các ngày trong tuần.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                    
    <!-- Product Description -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Mô Tả Chi Tiết</h5>
                </div>
                <div class="card-body">{!! nl2br(e($product->description)) !!}</div>
            </div>
        </div>
        @if($product->specs)
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-microchip me-2 text-primary"></i>Thông Số Kỹ Thuật</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <tbody>
                                @php
                                    $rows = [];
                                    if (is_array($product->specs)) { $rows = $product->specs; }
                                    else {
                                        $decoded = json_decode($product->specs, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) $rows = $decoded;
                                        else {
                                            // Parse simple "key: value" lines fallback
                                            foreach (preg_split('/\r?\n/', $product->specs) as $line) {
                                                if (strpos($line, ':') !== false) {
                                                    [$k,$v] = array_map('trim', explode(':', $line, 2));
                                                    if ($k !== '') $rows[$k] = $v;
                                                }
                                            }
                                        }
                                    }
                                @endphp
                                @foreach($rows as $k => $v)
                                    @if(is_array($v))
                                        <tr><th colspan="2" class="bg-light">{{ $k }}</th></tr>
                                        @foreach($v as $ck => $cv)
                                            <tr>
                                                <td style="width: 35%;" class="fw-semibold">{{ $ck }}</td>
                                                <td>{{ $cv }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td style="width: 35%;" class="fw-semibold">{{ $k }}</td>
                                            <td>{{ $v }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Comparison Table -->
        <div class="col-12">
            <div class="card comparison-card">
                <div class="card-header" style="cursor: pointer;" onclick="toggleComparison()">
                    <h5 class="mb-0 d-flex align-items-center justify-content-between">
                        <span>
                            <i class="fas fa-balance-scale me-2 text-primary"></i>
                            So Sánh Thuê vs Mua
                        </span>
                        <i class="fas fa-chevron-down" id="comparison-icon"></i>
                    </h5>
                </div>
                <div class="card-body p-0" id="comparison-content" style="display: none;">
                    <div class="table-responsive">
                        <table class="table comparison-table mb-0">
                            <thead>
                                <tr>
                                    <th class="comparison-header">Tiêu chí</th>
                                    <th class="comparison-header text-center">
                                        <i class="fas fa-handshake text-success me-2"></i>
                                        Thuê Thiết Bị
                                    </th>
                                    <th class="comparison-header text-center">
                                        <i class="fas fa-shopping-cart text-warning me-2"></i>
                                        Mua Thiết Bị
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="comparison-row">
                                    <td class="comparison-criteria">
                                        <i class="fas fa-coins me-2 text-primary"></i>
                                        Chi phí đầu tư ban đầu
                                    </td>
                                    <td class="comparison-rent text-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <strong>Thấp hoặc không có</strong><br>
                                        <small class="text-muted">Thanh toán theo tháng/quý/năm</small>
                                    </td>
                                    <td class="comparison-buy text-center">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        <strong>Cao</strong><br>
                                        <small class="text-muted">Phải trả toàn bộ giá trị thiết bị & cài đặt ban đầu</small>
                                    </td>
                                </tr>
                                
                                <tr class="comparison-row">
                                    <td class="comparison-criteria">
                                        <i class="fas fa-tools me-2 text-primary"></i>
                                        Chi phí bảo trì, sửa chữa
                                    </td>
                                    <td class="comparison-rent text-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <strong>Đã bao gồm</strong><br>
                                        <small class="text-muted">Trong gói thuê</small>
                                    </td>
                                    <td class="comparison-buy text-center">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        <strong>Tự chịu</strong><br>
                                        <small class="text-muted">Chi phí bảo trì, thay thế linh kiện</small>
                                    </td>
                                </tr>
                                
                                <tr class="comparison-row">
                                    <td class="comparison-criteria">
                                        <i class="fas fa-sync-alt me-2 text-primary"></i>
                                        Cập nhật công nghệ
                                    </td>
                                    <td class="comparison-rent text-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <strong>Dễ dàng nâng cấp</strong><br>
                                        <small class="text-muted">Thiết bị mới hơn khi thuê dài hạn</small>
                                    </td>
                                    <td class="comparison-buy text-center">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        <strong>Phải mua mới</strong><br>
                                        <small class="text-muted">Nếu muốn đổi sang thiết bị hiện đại hơn</small>
                                    </td>
                                </tr>
                                
                                <tr class="comparison-row">
                                    <td class="comparison-criteria">
                                        <i class="fas fa-expand-arrows-alt me-2 text-primary"></i>
                                        Linh hoạt quy mô
                                    </td>
                                    <td class="comparison-rent text-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <strong>Tăng/giảm dễ dàng</strong><br>
                                        <small class="text-muted">Theo nhu cầu doanh nghiệp</small>
                                    </td>
                                    <td class="comparison-buy text-center">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        <strong>Khó thay đổi</strong><br>
                                        <small class="text-muted">Mua dư thì lãng phí, mua thiếu thì phải mua thêm</small>
                                    </td>
                                </tr>
                                
                                <tr class="comparison-row">
                                    <td class="comparison-criteria">
                                        <i class="fas fa-rocket me-2 text-primary"></i>
                                        Triển khai nhanh
                                    </td>
                                    <td class="comparison-rent text-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <strong>Có sẵn thiết bị</strong><br>
                                        <small class="text-muted">Cài đặt và hỗ trợ nhanh chóng</small>
                                    </td>
                                    <td class="comparison-buy text-center">
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                        <strong>Có thể mất thời gian</strong><br>
                                        <small class="text-muted">Chọn mua, cài đặt và đào tạo sử dụng</small>
                                    </td>
                                </tr>
                                
                                <tr class="comparison-row">
                                    <td class="comparison-criteria">
                                        <i class="fas fa-headset me-2 text-primary"></i>
                                        Dịch vụ hậu mãi
                                    </td>
                                    <td class="comparison-rent text-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <strong>Hỗ trợ liên tục</strong><br>
                                        <small class="text-muted">Đổi thiết bị khi lỗi</small>
                                    </td>
                                    <td class="comparison-buy text-center">
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                        <strong>Giới hạn thời gian</strong><br>
                                        <small class="text-muted">Thường chỉ trong thời gian bảo hành</small>
                                    </td>
                                </tr>
                                
                                <tr class="comparison-row">
                                    <td class="comparison-criteria">
                                        <i class="fas fa-chart-line me-2 text-primary"></i>
                                        Tính thanh khoản
                                    </td>
                                    <td class="comparison-rent text-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <strong>Không bị "mắc kẹt" vốn</strong><br>
                                        <small class="text-muted">Trong tài sản cố định</small>
                                    </td>
                                    <td class="comparison-buy text-center">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        <strong>Khó thanh lý</strong><br>
                                        <small class="text-muted">Mất giá trị theo thời gian</small>
                                    </td>
                                </tr>
                                
                                <tr class="comparison-row">
                                    <td class="comparison-criteria">
                                        <i class="fas fa-arrow-up me-2 text-primary"></i>
                                        Cập nhật khi hết hạn
                                    </td>
                                    <td class="comparison-rent text-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <strong>Tự động nâng cấp</strong><br>
                                        <small class="text-muted">Thiết bị/phần mềm mới nếu gia hạn</small>
                                    </td>
                                    <td class="comparison-buy text-center">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        <strong>Không được cập nhật</strong><br>
                                        <small class="text-muted">Thiết bị ngày càng lạc hậu</small>
                                    </td>
                                </tr>
                                
                                <tr class="comparison-row">
                                    <td class="comparison-criteria">
                                        <i class="fas fa-building me-2 text-primary"></i>
                                        Phù hợp với doanh nghiệp
                                    </td>
                                    <td class="comparison-rent text-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <strong>Rất phù hợp</strong><br>
                                        <small class="text-muted">Doanh nghiệp nhỏ, start-up, chi nhánh tạm thời</small>
                                    </td>
                                    <td class="comparison-buy text-center">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        <strong>Phù hợp hơn</strong><br>
                                        <small class="text-muted">Doanh nghiệp lớn, ổn định lâu dài</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="related-products-section">
                <div class="section-header text-center mb-4">
                    <h3 class="section-title">
                        <i class="fas fa-random me-3 text-primary"></i>
                        Sản Phẩm Khác
                    </h3>
                    <p class="section-subtitle text-muted">Khám phá thêm các thiết bị chấm công và kiểm soát ra vào khác</p>
                </div>
                
                <div class="row g-4">
                    @forelse($otherProducts as $otherProduct)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('products.show', $otherProduct->id) }}" class="related-product-card">
                            <div class="product-image-container">
                                <img src="{{ $otherProduct->image_url }}" 
                                     alt="{{ $otherProduct->name }}" class="product-image" loading="lazy" decoding="async">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">{{ $otherProduct->name }}</h5>
                                <p class="product-description">{{ Str::limit($otherProduct->description, 80) }}</p>
                                <div class="product-price">
                                    <span class="price-label">Từ</span>
                                    <span class="price-amount">{{ number_format($otherProduct->getPriceByMonths(6) / 6) }}đ</span>
                                    <span class="price-period">/tháng</span>
                                </div>
                                <div class="product-features">
                                    @if($otherProduct->has_warranty_support)
                                    <span class="feature-badge">
                                        <i class="fas fa-shield-alt me-1"></i>Bảo hành
                                    </span>
                                    @endif
                                    @if($otherProduct->category)
                                    <span class="feature-badge">
                                        <i class="fas fa-tag me-1"></i>{{ $otherProduct->category->name }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <div class="no-products-message">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Chưa có sản phẩm khác</h5>
                            <p class="text-muted">Hãy khám phá các sản phẩm khác của chúng tôi</p>
                        </div>
                    </div>
                    @endforelse
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}#products" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-th-large me-2"></i>
                        Xem Tất Cả Sản Phẩm
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sticky bottom CTA for mobile -->
<div class="sticky-cta d-lg-none">
    <div class="sticky-cta-inner">
        <button class="btn btn-primary w-100 fw-bold" onclick="document.getElementById('add_to_cart_btn').click()">
            <i class="fas fa-shopping-cart me-2"></i>Thuê Ngay
        </button>
    </div>
    </div>

<style>
/* Product Images */
.main-image-container {
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    background: #f8f9fa;
}

.main-image-container img {
    width: 100%;
    max-width: 100%;
    height: auto;
    max-height: 720px;
    object-fit: contain;
    background: #fff;
    image-rendering: auto;
}

.main-image-container {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 740px;
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
}

.thumbnail-img {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.thumbnail-img:hover,
.thumbnail-img.active {
    border-color: #0d6efd;
    transform: scale(1.05);
}

/* Package Options */
.package-options {
    display: grid;
    grid-template-columns: 1fr;
    gap: 12px;
}

.package-option {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 16px 18px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.package-option:hover {
    border-color: #0d6efd;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.1);
}

.package-option.active {
    border-color: #0d6efd;
    background: #f8f9ff;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
}

.package-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
}

.package-label {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
}

.package-duration {
    font-weight: 600;
    font-size: 1.1rem;
    color: #333;
}

.package-total-price {
    font-weight: 700;
    color: #0d6efd;
}

.discount-badge {
    background: #dc3545;
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.75rem;
    margin-left: 8px;
}

.package-total {
    font-size: 0.9rem;
    color: #6c757d;
}

.best-value {
    border-color: #0d6efd;
    box-shadow: 0 4px 12px rgba(13,110,253,0.15);
}

.original-price {
    text-decoration: line-through;
    color: #dc3545;
    margin-left: 8px;
}

.bonus-text {
    color: #fd7e14;
    font-weight: 600;
    margin-top: 4px;
}

/* VAT Notice */
.vat-notice {
    padding: 8px 12px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 3px solid #6c757d;
}

.vat-notice small {
    font-size: 0.85rem;
    color: #6c757d;
}

.vat-notice i {
    color: #6c757d;
}

/* Trust Badges */
.trust-badges .badge {
    font-size: 0.875rem;
    padding: 8px 12px;
}

/* Features List */
.features-list {
    line-height: 1.8;
    color: #6c757d;
}

.features-preview {
    line-height: 1.8;
    color: #6c757d;
}

.features-full {
    line-height: 1.8;
    color: #6c757d;
}

.features-dots {
    color: #0d6efd;
    font-weight: 600;
}

.features-list button {
    transition: all 0.3s ease;
}

.features-list button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
}

/* Info Items */
.info-item {
    font-size: 0.9rem;
    color: #6c757d;
}

/* Rental Duration Selector */
.rental-duration-selector {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #e9ecef;
}

.price-display {
    background: white;
    border-radius: 8px;
    padding: 15px;
    border: 1px solid #dee2e6;
}

.monthly-price {
    margin-bottom: 8px;
}

.total-price {
    border-top: 1px solid #dee2e6;
    padding-top: 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .main-image-container { height: 58vw; max-height: 420px; }
    .main-image-container img { max-height: 100%; }
    
    .package-label {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }
    
    .package-price { font-size: 0.9rem; }
    
    .rental-duration-selector { padding: 15px; }
}

/* Services Sidebar Styles */
.services-sidebar {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 16px;
    padding: 24px;
    border: 1px solid #e9ecef;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    position: sticky;
    top: 100px;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.services-sidebar:hover {
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

.service-section {
    border-bottom: 1px solid rgba(222, 226, 230, 0.6);
    padding-bottom: 20px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.service-section:hover {
    transform: translateX(4px);
}

.service-section:last-child {
    border-bottom: none;
    padding-bottom: 0;
    margin-bottom: 0;
}

.service-header {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
}

.service-icon {
    position: relative;
    margin-right: 12px;
    font-size: 1.4rem;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    color: inherit;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
}

.free-badge {
    position: absolute;
    top: -6px;
    right: -6px;
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    color: white;
    font-size: 0.65rem;
    font-weight: bold;
    padding: 3px 6px;
    border-radius: 8px;
    line-height: 1;
    box-shadow: 0 2px 8px rgba(255, 107, 107, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.service-title {
    margin: 0;
    font-size: 1rem;
    line-height: 1.3;
    font-weight: 700;
    color: #2c3e50;
}

.service-title.text-primary { color: #2c3e50; }

.service-content {
    font-size: 0.85rem;
    color: #6c757d;
    margin: 0;
    line-height: 1.5;
    font-weight: 500;
}

.commitment-list, .support-list {
    margin-top: 12px;
}

.commitment-item, .support-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 10px;
    font-size: 0.8rem;
    line-height: 1.5;
    color: #495057;
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 8px;
    border-left: 3px solid #28a745;
    transition: all 0.3s ease;
}

.commitment-item:hover, .support-item:hover {
    background: rgba(255, 255, 255, 0.9);
    transform: translateX(4px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.commitment-item:last-child, .support-item:last-child {
    margin-bottom: 0;
}

.commitment-item i, .support-item i {
    margin-top: 2px;
    flex-shrink: 0;
    color: #28a745;
    font-size: 0.9rem;
}

.commitment-item span, .support-item span {
    flex: 1;
    font-weight: 500;
}

.commitment-item strong, .support-item strong {
    color: #2c3e50;
    font-weight: 700;
}

/* Responsive adjustments */
@media (max-width: 991.98px) {
    .services-sidebar {
        position: static;
        margin-top: 30px;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    .product-info-section {
        display: block;
    }
    
    .col-lg-5, .col-lg-4, .col-lg-3 {
        margin-bottom: 30px;
    }
}

@media (max-width: 767.98px) {
    .services-sidebar {
        margin-top: 20px;
        padding: 20px;
        border-radius: 12px;
    }
    
    .service-icon {
        width: 35px;
        height: 35px;
        font-size: 1.2rem;
    }
    
    .service-title {
        font-size: 0.9rem;
    }
    
    .service-content {
        font-size: 0.8rem;
    }
    
    .commitment-item, .support-item {
        font-size: 0.75rem;
        padding: 6px 10px;
    }
    
    .free-badge {
        font-size: 0.6rem;
        padding: 2px 5px;
    }
}

/* Additional beautiful effects */
.services-sidebar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #11998e 100%);
    border-radius: 16px 16px 0 0;
    z-index: 1;
}

.service-section {
    position: relative;
}

.service-section::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    transition: width 0.3s ease;
}

.service-section:hover::after {
    width: 100%;
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Loading animation for icons */
.service-icon i {
    animation: fadeInUp 0.6s ease-out;
}

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

/* Staggered animation for list items */
.commitment-item:nth-child(1) { animation-delay: 0.1s; }
.commitment-item:nth-child(2) { animation-delay: 0.2s; }
.commitment-item:nth-child(3) { animation-delay: 0.3s; }
.commitment-item:nth-child(4) { animation-delay: 0.4s; }

.support-item:nth-child(1) { animation-delay: 0.1s; }
.support-item:nth-child(2) { animation-delay: 0.2s; }
.support-item:nth-child(3) { animation-delay: 0.3s; }
.support-item:nth-child(4) { animation-delay: 0.4s; }

/* Comparison Table Styles */
.comparison-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-top: 30px;
}

.comparison-card .card-header {
    background: linear-gradient(135deg, #5b86e5 0%, #36d1dc 100%);
    color: white;
    border: none;
    padding: 20px 25px;
    transition: all 0.3s ease;
    border-radius: 14px;
    box-shadow: 0 10px 28px rgba(54, 209, 220, 0.25);
    position: relative;
}

.comparison-card .card-header:hover {
    transform: translateY(-1px);
    box-shadow: 0 14px 34px rgba(54, 209, 220, 0.35);
}

/* Shimmer highlight */
.comparison-card .card-header::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 14px;
}

.comparison-card .card-header:hover::after { opacity: 1; }

.comparison-card .card-header h5 {
    margin: 0;
    font-weight: 700;
    font-size: 1.15rem;
}

.comparison-table {
    margin: 0;
    border: none;
}

.comparison-table th,
.comparison-table td {
    border: none;
    padding: 16px 20px;
    vertical-align: middle;
}

.comparison-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    color: #495057;
    font-weight: 700;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #dee2e6;
}

.comparison-criteria {
    background: rgba(102, 126, 234, 0.05);
    font-weight: 600;
    color: #495057;
    border-right: 1px solid #e9ecef;
    min-width: 200px;
}

.comparison-criteria i {
    color: #667eea;
    width: 20px;
    text-align: center;
}

.comparison-rent {
    background: rgba(40, 167, 69, 0.05);
    border-right: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.comparison-rent:hover {
    background: rgba(40, 167, 69, 0.1);
    transform: scale(1.02);
}

.comparison-buy {
    background: rgba(220, 53, 69, 0.05);
    transition: all 0.3s ease;
}

.comparison-buy:hover {
    background: rgba(220, 53, 69, 0.1);
    transform: scale(1.02);
}

.comparison-row {
    border-bottom: 1px solid #f1f3f4;
    transition: all 0.3s ease;
}

.comparison-row:hover {
    background: rgba(255, 255, 255, 0.8);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.comparison-rent strong {
    color: #28a745;
    font-weight: 700;
}

.comparison-buy strong {
    color: #dc3545;
    font-weight: 700;
}

.comparison-rent small {
    color: #6c757d;
    font-size: 0.8rem;
}

.comparison-buy small {
    color: #6c757d;
    font-size: 0.8rem;
}

.comparison-rent i.fa-check-circle {
    color: #28a745;
    font-size: 1.1rem;
}

.comparison-buy i.fa-times-circle {
    color: #dc3545;
    font-size: 1.1rem;
}

.comparison-buy i.fa-exclamation-triangle {
    color: #ffc107;
    font-size: 1.1rem;
}

/* Responsive for comparison table */
@media (max-width: 768px) {
    .comparison-table th,
    .comparison-table td {
        padding: 12px 15px;
        font-size: 0.85rem;
    }
    
    .comparison-criteria {
        min-width: 150px;
    }
    
    .comparison-card .card-header {
        padding: 15px 20px;
    }
    
    .comparison-card .card-header h5 {
        font-size: 1rem;
    }
}

/* Animation for table rows */
.comparison-row {
    animation: slideInUp 0.6s ease-out;
}

.comparison-row:nth-child(1) { animation-delay: 0.1s; }
.comparison-row:nth-child(2) { animation-delay: 0.2s; }
.comparison-row:nth-child(3) { animation-delay: 0.3s; }
.comparison-row:nth-child(4) { animation-delay: 0.4s; }
.comparison-row:nth-child(5) { animation-delay: 0.5s; }
.comparison-row:nth-child(6) { animation-delay: 0.6s; }
.comparison-row:nth-child(7) { animation-delay: 0.7s; }
.comparison-row:nth-child(8) { animation-delay: 0.8s; }
.comparison-row:nth-child(9) { animation-delay: 0.9s; }

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Slide animations for comparison table */
@keyframes slideDown {
    from {
        opacity: 0;
        max-height: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        max-height: 2000px;
        transform: translateY(0);
    }
}

@keyframes slideUp {
    from {
        opacity: 1;
        max-height: 2000px;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        max-height: 0;
        transform: translateY(-10px);
    }
}

/* Icon rotation animation */
#comparison-icon {
    transition: transform 0.3s ease;
    font-size: 0.95rem;
    background: rgba(255,255,255,0.9);
    color: #5b86e5;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Sticky CTA styles */
.sticky-cta {
    position: fixed;
    left: 0; right: 0; bottom: 0;
    padding: 10px 14px 14px;
    background: linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(245,247,250,0.95) 30%, rgba(245,247,250,1) 100%);
    border-top: 1px solid #e9ecef;
    z-index: 1050;
}
.sticky-cta-inner {
    max-width: 720px; margin: 0 auto;
    box-shadow: 0 10px 26px rgba(13,110,253,0.18);
    border-radius: 12px; overflow: hidden;
}

/* Extra mobile polish */
@media (max-width: 576px){
    .trust-badges .badge{ font-size: .75rem; padding:6px 8px; }
    .package-options{ display: flex; overflow-x: auto; gap: 10px; }
    .package-option{ min-width: 260px; }
    .services-sidebar{ padding: 16px; border-radius: 12px; box-shadow: none; background: #fff; }
    .service-title{ font-size: .95rem; }
    .service-content{ font-size: .84rem; }
    .comparison-card{ margin-top: 20px; }
    .comparison-card .card-header{ border-radius: 12px; }
    table.table{ font-size: .9rem; }
    .thumbnail-images .col-3{ width: 25%; }
}

/* Hover effect for clickable header */
.comparison-card .card-header:hover #comparison-icon {
    transform: scale(1.1);
}

/* Related Products Section Styles */
.related-products-section {
    padding: 40px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 16px;
    margin-top: 40px;
}

.section-header {
    margin-bottom: 30px;
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #6c757d;
}

.related-product-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid #e9ecef;
    text-decoration: none;
    color: inherit;
    display: block;
    cursor: pointer;
    position: relative;
    z-index: 1;
}

.related-product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.product-image-container {
    position: relative;
    overflow: hidden;
    height: 220px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image {
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    transition: transform 0.3s ease;
    background: #fff;
}

.related-product-card:hover .product-image {
    transform: scale(1.03);
}

.product-info {
    padding: 20px;
}

.product-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 8px;
    line-height: 1.3;
}

.product-description {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 15px;
    line-height: 1.4;
}

.product-price {
    margin-bottom: 15px;
}

.price-label {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
}

.price-amount {
    font-size: 1.2rem;
    font-weight: 700;
    color: #28a745;
    margin: 0 4px;
}

.price-period {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
}

.product-features {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.feature-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
}

.feature-badge i {
    font-size: 0.7rem;
}

/* Responsive for related products */
@media (max-width: 768px) {
    .related-products-section {
        padding: 30px 0;
        margin-top: 30px;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .section-subtitle {
        font-size: 1rem;
    }
    
    .related-product-card {
        margin-bottom: 20px;
    }
    
    .product-info { padding: 15px; }
    .product-image-container { height: 180px; }
    
    .product-title {
        font-size: 1rem;
    }
    
    .product-description {
        font-size: 0.85rem;
    }
    
    .price-amount {
        font-size: 1.1rem;
    }
}

/* No products message */
.no-products-message {
    padding: 40px 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    border: 2px dashed #dee2e6;
}

.no-products-message i {
    color: #adb5bd;
}

.no-products-message h5 {
    margin-bottom: 10px;
}

.no-products-message p {
    margin-bottom: 0;
}
</style>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content" style="background: transparent; border: none;">
      <img id="modalImage" src="" alt="preview" style="width: 100%; height: auto; border-radius: 10px;">
    </div>
  </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Package selection
    const packageOptions = document.querySelectorAll('.package-option');
    const radioButtons = document.querySelectorAll('input[name="rental_package"]');
    
    packageOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            packageOptions.forEach(opt => opt.classList.remove('active'));
            
            // Add active class to clicked option
            this.classList.add('active');
            
            // Check the radio button
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;

            // Read price from this card and update summary
            const duration = parseInt(this.getAttribute('data-months'), 10);
            const total = this.getAttribute('data-price');
            updatePriceFromPackage(duration, total);
        });
    });
    
    // Radio button change
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            packageOptions.forEach(opt => opt.classList.remove('active'));
            const selectedOption = document.querySelector(`[data-months="${this.value}"]`);
            if (selectedOption) {
                selectedOption.classList.add('active');
                updatePriceFromPackage(parseInt(this.value, 10), selectedOption.getAttribute('data-price'));
            }
        });
    });
});

// Change main image function
function changeMainImage(src) {
    document.getElementById('mainImage').src = src;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail-img').forEach(img => {
        img.classList.remove('active');
    });
    event.target.classList.add('active');
}

// Update price based on selected duration
function updatePriceFromPackage(duration, totalPrice) {
    const monthly = Math.max(1, parseInt(totalPrice, 10) / duration);
    document.getElementById('monthly_price').textContent = numberFormat(monthly) + 'đ/tháng';
    document.getElementById('total_price').textContent = numberFormat(totalPrice) + 'đ';
    const cartDuration = document.getElementById('cart_duration');
    if (cartDuration) cartDuration.value = duration;
}

// Number formatting function
function numberFormat(num) {
    return new Intl.NumberFormat('vi-VN').format(num);
}

function setCartInputs() {
    // Ensure cart_duration follows the currently selected package
    const selectedRadio = document.querySelector('input[name="rental_package"]:checked');
    if (selectedRadio) {
        const value = selectedRadio.value;
        const cartDuration = document.getElementById('cart_duration');
        if (cartDuration) cartDuration.value = value;
    }
    return true; // submit form
}

// Toggle comparison table
function toggleComparison() {
    const content = document.getElementById('comparison-content');
    const icon = document.getElementById('comparison-icon');
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        content.style.animation = 'slideDown 0.3s ease-out';
        icon.style.transform = 'rotate(180deg)';
        icon.style.transition = 'transform 0.3s ease';
    } else {
        content.style.animation = 'slideUp 0.3s ease-out';
        setTimeout(() => {
            content.style.display = 'none';
        }, 300);
        icon.style.transform = 'rotate(0deg)';
        icon.style.transition = 'transform 0.3s ease';
    }
}

// Toggle features display
function toggleFeatures() {
    const preview = document.querySelector('.features-preview');
    const full = document.querySelector('.features-full');
    const btn = document.getElementById('toggleFeaturesBtn');
    
    if (full.style.display === 'none') {
        // Show full features
        preview.style.display = 'none';
        full.style.display = 'block';
        btn.innerHTML = '<i class="fas fa-eye-slash me-1"></i>Thu gọn';
    } else {
        // Show preview
        preview.style.display = 'block';
        full.style.display = 'none';
        btn.innerHTML = '<i class="fas fa-eye me-1"></i>Xem thêm';
    }
}
</script>
@endsection




