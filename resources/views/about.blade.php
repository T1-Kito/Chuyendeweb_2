@extends('layouts.app')

@section('title', 'Giới Thiệu - VIGILANCE')

@section('content')
<!-- Hero Section with Parallax -->
<section class="hero-about position-relative overflow-hidden">
    <div class="hero-bg position-absolute w-100 h-100" style="
        background: linear-gradient(135deg, rgba(55, 65, 81, 0.95), rgba(75, 85, 99, 0.9)),
                    url('{{ asset('storage/LogoViKhang1.jpg') }}') center/cover;
        background-attachment: fixed;
    "></div>
    
    <!-- Floating Elements -->
    <div class="floating-elements">
        <div class="floating-icon" style="top: 20%; left: 10%; animation-delay: 0s;">
            <i class="fas fa-shield-alt fa-2x text-white opacity-50"></i>
        </div>
        <div class="floating-icon" style="top: 60%; right: 15%; animation-delay: 2s;">
            <i class="fas fa-fingerprint fa-2x text-white opacity-50"></i>
        </div>
        <div class="floating-icon" style="top: 30%; right: 30%; animation-delay: 4s;">
            <i class="fas fa-clock fa-2x text-white opacity-50"></i>
        </div>
    </div>
    
    <div class="container position-relative py-5">
        <div class="row text-center">
            <div class="col-12">
                <div class="hero-content">
                    <h1 class="display-3 fw-bold text-white mb-4 animate-fade-in">
                        <i class="fas fa-star me-3 text-warning"></i>
                        Về VIGILANCE
                    </h1>
                    <p class="lead text-white mb-4 animate-slide-up">Chuyên gia cho thuê thiết bị chấm công & kiểm soát ra vào hàng đầu Việt Nam</p>
                    <div class="hero-stats d-flex justify-content-center gap-4 flex-wrap">
                        <div class="stat-item">
                            <h3 class="text-warning fw-bold">20+</h3>
                            <p class="text-white-50 mb-0">Năm Kinh Nghiệm</p>
                        </div>
                        <div class="stat-item">
                            <h3 class="text-warning fw-bold">24000+</h3>
                            <p class="text-white-50 mb-0">Khách Hàng</p>
                        </div>
                        <div class="stat-item">
                            <h3 class="text-warning fw-bold">90000+</h3>
                            <p class="text-white-50 mb-0">Thiết Bị</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company Story with Images -->
<section class="py-5" style="background: #F9FAFB;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="story-content">
                    <div class="section-badge mb-3">
                        <span class="badge bg-primary px-3 py-2">
                            <i class="fas fa-history me-2"></i>Câu Chuyện Của Chúng Tôi
                        </span>
                    </div>
                    <h2 class="display-6 fw-bold mb-4">Hành Trình Phát Triển</h2>
                    <div class="story-text">
                        <p class="lead mb-4">VIGILANCE được thành lập với mục tiêu mang đến giải pháp cho thuê thiết bị chấm công và kiểm soát ra vào chất lượng cao, giá cả hợp lý cho mọi nhu cầu của khách hàng.</p>
                        <p class="mb-4">Với hơn 20 năm kinh nghiệm trong lĩnh vực công nghệ an ninh và quản lý nhân sự, chúng tôi đã phục vụ hàng nghìn khách hàng từ các doanh nghiệp vừa và nhỏ đến các công ty lớn, tòa nhà văn phòng, khu công nghiệp và tổ chức sự kiện.</p>
                        <p class="mb-4">Chúng tôi tin rằng mỗi khách hàng đều xứng đáng được trải nghiệm dịch vụ tốt nhất với sự tận tâm và chuyên nghiệp trong lĩnh vực quản lý thời gian và an ninh.</p>
                    </div>
                    <div class="achievement-stats d-flex gap-4">
                        <div class="stat-box text-center">
                            <h4 class="text-primary fw-bold mb-1">2004</h4>
                            <p class="small text-muted mb-0">Thành Lập</p>
                        </div>
                        <div class="stat-box text-center">
                            <h4 class="text-primary fw-bold mb-1">24000+</h4>
                            <p class="small text-muted mb-0">Khách Hàng</p>
                        </div>
                        <div class="stat-box text-center">
                            <h4 class="text-primary fw-bold mb-1">90000+</h4>
                            <p class="small text-muted mb-0">Thiết Bị</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="story-images">
                        <div class="row g-3">
                        <div class="col-6">
                            <div class="image-card">
                                <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&h=300&fit=crop&crop=center" 
                                     class="img-fluid rounded-3 shadow" alt="Office Team">
                                <div class="image-overlay">
                                    <i class="fas fa-users text-white fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="image-card">
                                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop&crop=center" 
                                     class="img-fluid rounded-3 shadow" alt="Technology">
                                <div class="image-overlay">
                                    <i class="fas fa-cogs text-white fa-2x"></i>
                                </div>
                            </div>
                                </div>
                        <div class="col-12">
                            <div class="image-card">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=200&fit=crop&crop=center" 
                                     class="img-fluid rounded-3 shadow" alt="Company Building">
                                <div class="image-overlay">
                                    <i class="fas fa-building text-white fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold mb-3">Tầm Nhìn & Sứ Mệnh</h2>
                <p class="lead text-muted">Định hướng phát triển và giá trị cốt lõi</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="vision-card text-center p-4 h-100">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-eye fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Tầm Nhìn</h5>
                    <p class="text-muted">Trở thành công ty cho thuê thiết bị chấm công & kiểm soát ra vào hàng đầu tại Việt Nam</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="vision-card text-center p-4 h-100">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-bullseye fa-3x text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Sứ Mệnh</h5>
                    <p class="text-muted">Cung cấp giải pháp tối ưu cho mọi nhu cầu quản lý thời gian và an ninh doanh nghiệp</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="vision-card text-center p-4 h-100">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-heart fa-3x text-danger"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Giá Trị Cốt Lõi</h5>
                    <p class="text-muted">Chất lượng, uy tín và sự hài lòng của khách hàng</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="vision-card text-center p-4 h-100">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-handshake fa-3x text-warning"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Cam Kết</h5>
                    <p class="text-muted">Đối tác tin cậy, dịch vụ xuất sắc</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us with Enhanced Design -->
<section class="py-5 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #374151, #4B5563);">
    <!-- Background Pattern -->
    <div class="bg-pattern position-absolute w-100 h-100 opacity-10"></div>
    <!-- Dark Overlay for better text contrast -->
    <div class="position-absolute w-100 h-100" style="background: rgba(0,0,0,0.3);"></div>
    
    <div class="container position-relative">
        <div class="row text-center mb-5">
            <div class="col-12">
                <div class="section-badge mb-3">
                    <span class="badge bg-warning text-dark px-3 py-2">
                        <i class="fas fa-star me-2"></i>Tại Sao Chọn VIGILANCE?
                    </span>
                </div>
                <h2 class="display-4 fw-bold mb-3">Những Lý Do Hàng Đầu</h2>
                <p class="lead opacity-75">Những lý do khiến chúng tôi trở thành lựa chọn hàng đầu</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card h-100 text-center p-4 position-relative">
                    <div class="feature-icon mb-4">
                        <div class="icon-wrapper">
                            <i class="fas fa-shield-alt fa-3x text-warning"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Chất Lượng Đảm Bảo</h5>
                    <p class="opacity-75">Tất cả thiết bị chấm công và kiểm soát ra vào đều được kiểm tra kỹ lưỡng, bảo trì định kỳ và đảm bảo hoạt động ổn định trước khi cho thuê.</p>
                    <div class="feature-image mt-3">
                        <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=300&h=200&fit=crop&crop=center" 
                             class="img-fluid rounded-3" alt="Quality Assurance">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card h-100 text-center p-4 position-relative">
                    <div class="feature-icon mb-4">
                        <div class="icon-wrapper">
                            <i class="fas fa-clock fa-3x text-warning"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Dịch Vụ Nhanh Chóng</h5>
                    <p class="opacity-75">Giao hàng trong vòng 2-4 giờ tại TP.HCM, hỗ trợ 24/7 và xử lý yêu cầu khẩn cấp một cách hiệu quả.</p>
                    <div class="feature-image mt-3">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=300&h=200&fit=crop&crop=center" 
                             class="img-fluid rounded-3" alt="Fast Service">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card h-100 text-center p-4 position-relative">
                    <div class="feature-icon mb-4">
                        <div class="icon-wrapper">
                            <i class="fas fa-dollar-sign fa-3x text-warning"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Giá Cả Cạnh Tranh</h5>
                    <p class="opacity-75">Giá thuê hợp lý, không phát sinh chi phí ẩn, nhiều ưu đãi cho khách hàng thân thiết và thuê dài hạn.</p>
                    <div class="feature-image mt-3">
                        <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=300&h=200&fit=crop&crop=center" 
                             class="img-fluid rounded-3" alt="Competitive Price">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Services with Enhanced Design -->
<section class="py-5" style="background: #F3F4F6;">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <div class="section-badge mb-3">
                    <span class="badge bg-success px-3 py-2">
                        <i class="fas fa-cogs me-2"></i>Dịch Vụ Chính
                    </span>
                </div>
                <h2 class="display-5 fw-bold mb-3">Dịch Vụ Chính Của Chúng Tôi</h2>
                <p class="lead text-muted">Chuyên cung cấp các giải pháp quản lý thời gian và an ninh</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6">
                <div class="service-card h-100 text-center p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-image mb-4">
                        <img src="{{ asset('maychamcong.png') }}" 
                             class="img-fluid rounded-3" alt="Máy Chấm Công">
                    </div>
                    <div class="service-icon mb-3">
                        <div class="icon-wrapper bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-fingerprint fa-2x"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Máy Chấm Công</h5>
                    <p class="text-muted">Cho thuê máy chấm công vân tay, thẻ từ, nhận diện khuôn mặt với công nghệ tiên tiến, đảm bảo độ chính xác cao.</p>
                    <div class="service-features mt-3">
                        <span class="badge bg-primary me-2 mb-2">Vân Tay</span>
                        <span class="badge bg-primary me-2 mb-2">Thẻ Từ</span>
                        <span class="badge bg-primary me-2 mb-2">Nhận Diện Khuôn Mặt</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="service-card h-100 text-center p-4 bg-white rounded-4 shadow-sm">
                    <div class="service-image mb-4">
                        <img src="{{ asset('Hethongkiemsoatcua.jpg') }}" 
                             class="img-fluid rounded-3" alt="Hệ Thống Kiểm Soát Ra Vào">
                    </div>
                    <div class="service-icon mb-3">
                        <div class="icon-wrapper bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-door-open fa-2x"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Hệ Thống Kiểm Soát Ra Vào</h5>
                    <p class="text-muted">Cổng Barrier tự động, hệ thống nhận diện khuôn mặt để kiểm soát xe ra vào bãi giữ xe, tòa nhà, khu công nghiệp.</p>
                    <div class="service-features mt-3">
                        <span class="badge bg-success me-2 mb-2">Cổng Barrier</span>
                        <span class="badge bg-success me-2 mb-2">Nhận Diện Khuôn Mặt</span>
                        <span class="badge bg-success me-2 mb-2">Kiểm Soát Xe</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section with Enhanced Design -->
<section class="py-5 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #374151, #4B5563);">
    <!-- Background Pattern -->
    <div class="bg-pattern position-absolute w-100 h-100 opacity-10"></div>
    
    <div class="container position-relative">
        <div class="row text-center mb-5">
            <div class="col-12">
                <div class="section-badge mb-3">
                    <span class="badge bg-warning text-dark px-3 py-2">
                        <i class="fas fa-users me-2"></i>Đội Ngũ Của Chúng Tôi
                    </span>
                </div>
                <h2 class="display-4 fw-bold mb-3">Những Con Người Tài Năng</h2>
                <p class="lead opacity-75">Những con người tài năng và tận tâm</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="team-card text-center p-4 h-100 position-relative">
                    <div class="team-image mb-4">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop&crop=face" 
                             class="rounded-circle shadow-lg" alt="CEO" style="width: 150px; height: 150px; object-fit: cover;">
                        <div class="team-overlay">
                            <div class="social-links">
                                <a href="#" class="text-white me-2"><i class="fab fa-linkedin fa-lg"></i></a>
                                <a href="#" class="text-white me-2"><i class="fab fa-twitter fa-lg"></i></a>
                                <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-2">Nguyễn Văn A</h5>
                    <p class="text-warning fw-bold mb-3">CEO & Founder</p>
                    <p class="opacity-75">Với hơn 10 năm kinh nghiệm trong lĩnh vực công nghệ an ninh và kinh doanh, anh là người dẫn dắt VIGILANCE phát triển.</p>
                    <div class="team-achievements mt-3">
                        <span class="badge bg-warning text-dark me-1 mb-1">10+ Năm Kinh Nghiệm</span>
                        <span class="badge bg-warning text-dark me-1 mb-1">Lãnh Đạo</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-card text-center p-4 h-100 position-relative">
                    <div class="team-image mb-4">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=200&h=200&fit=crop&crop=face" 
                             class="rounded-circle shadow-lg" alt="CTO" style="width: 150px; height: 150px; object-fit: cover;">
                        <div class="team-overlay">
                            <div class="social-links">
                                <a href="#" class="text-white me-2"><i class="fab fa-linkedin fa-lg"></i></a>
                                <a href="#" class="text-white me-2"><i class="fab fa-github fa-lg"></i></a>
                                <a href="#" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-2">Trần Thị B</h5>
                    <p class="text-warning fw-bold mb-3">CTO</p>
                    <p class="opacity-75">Chuyên gia công nghệ với kiến thức sâu rộng về hệ thống quản lý an ninh và phát triển phần mềm kiểm soát.</p>
                    <div class="team-achievements mt-3">
                        <span class="badge bg-warning text-dark me-1 mb-1">Chuyên Gia CNTT</span>
                        <span class="badge bg-warning text-dark me-1 mb-1">Phát Triển Phần Mềm</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-card text-center p-4 h-100 position-relative">
                    <div class="team-image mb-4">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&h=200&fit=crop&crop=face" 
                             class="rounded-circle shadow-lg" alt="Manager" style="width: 150px; height: 150px; object-fit: cover;">
                        <div class="team-overlay">
                            <div class="social-links">
                                <a href="#" class="text-white me-2"><i class="fab fa-linkedin fa-lg"></i></a>
                                <a href="#" class="text-white me-2"><i class="fab fa-twitter fa-lg"></i></a>
                                <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-2">Lê Văn C</h5>
                    <p class="text-warning fw-bold mb-3">Quản Lý Kinh Doanh</p>
                    <p class="opacity-75">Chuyên viên kinh doanh xuất sắc với khả năng thấu hiểu nhu cầu khách hàng và đưa ra giải pháp tối ưu.</p>
                    <div class="team-achievements mt-3">
                        <span class="badge bg-warning text-dark me-1 mb-1">Kinh Doanh</span>
                        <span class="badge bg-warning text-dark me-1 mb-1">Tư Vấn</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics with Enhanced Design -->
<section class="py-5" style="background: #E5E7EB;">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <div class="section-badge mb-3">
                    <span class="badge bg-info px-3 py-2">
                        <i class="fas fa-chart-line me-2"></i>Thành Tựu Của Chúng Tôi
                    </span>
                </div>
                <h2 class="display-5 fw-bold mb-3">Con Số Ấn Tượng</h2>
                <p class="lead text-muted">Những thành tựu đáng tự hào trong suốt chặng đường phát triển</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="stat-icon mb-3">
                        <div class="icon-wrapper bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                    <h3 class="display-4 fw-bold text-primary mb-2 counter" data-target="24000">0</h3>
                    <p class="lead text-muted mb-0">Khách Hàng Hài Lòng</p>
                    <div class="stat-progress mt-3">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="stat-icon mb-3">
                        <div class="icon-wrapper bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                    </div>
                    <h3 class="display-4 fw-bold text-success mb-2 counter" data-target="9000">0</h3>
                    <p class="lead text-muted mb-0">Thiết Bị Cho Thuê</p>
                    <div class="stat-progress mt-3">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="stat-icon mb-3">
                        <div class="icon-wrapper bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>
                    <h3 class="display-4 fw-bold text-warning mb-2 counter" data-target="26000">0</h3>
                    <p class="lead text-muted mb-0">Đơn Thuê Thành Công</p>
                    <div class="stat-progress mt-3">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-warning" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="stat-icon mb-3">
                        <div class="icon-wrapper bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-award fa-2x"></i>
                        </div>
                    </div>
                    <h3 class="display-4 fw-bold text-info mb-2 counter" data-target="20">0</h3>
                    <p class="lead text-muted mb-0">Năm Kinh Nghiệm</p>
                    <div class="stat-progress mt-3">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-info" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Packages Section -->

<!-- CTA Section with Enhanced Design -->
<section class="py-5 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #374151, #4B5563);">
    <!-- Background Elements -->
    <div class="bg-pattern position-absolute w-100 h-100 opacity-10"></div>
    <div class="floating-elements">
        <div class="floating-icon" style="top: 20%; left: 10%; animation-delay: 0s;">
            <i class="fas fa-rocket fa-2x text-white opacity-50"></i>
        </div>
        <div class="floating-icon" style="top: 60%; right: 15%; animation-delay: 2s;">
            <i class="fas fa-star fa-2x text-white opacity-50"></i>
        </div>
    </div>
    
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="cta-content">
                    <div class="section-badge mb-4">
                        <span class="badge bg-warning text-dark px-4 py-2">
                            <i class="fas fa-handshake me-2"></i>Sẵn Sàng Hợp Tác
                        </span>
                    </div>
                    <h2 class="display-4 fw-bold mb-4">Sẵn Sàng Làm Việc Cùng Nhau?</h2>
                    <p class="lead mb-5 opacity-75">Liên hệ ngay với chúng tôi để được tư vấn và hỗ trợ tốt nhất. Chúng tôi cam kết mang đến giải pháp tối ưu cho mọi nhu cầu của bạn.</p>
                    
                    <div class="cta-buttons d-flex gap-3 justify-content-center flex-wrap mb-5">
                        <a href="{{ route('home') }}" class="btn btn-light btn-lg px-4 py-3">
                            <i class="fas fa-box me-2"></i>Xem Sản Phẩm
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-4 py-3">
                            <i class="fas fa-phone me-2"></i>Liên Hệ Ngay
                        </a>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="contact-info d-flex justify-content-center gap-4 flex-wrap">
                        <div class="contact-item d-flex align-items-center">
                            <i class="fas fa-phone text-warning me-2"></i>
                            <span>Hotline: 0123 456 789</span>
                        </div>
                        <div class="contact-item d-flex align-items-center">
                            <i class="fas fa-envelope text-warning me-2"></i>
                            <span>Email: info@vigilance.com</span>
                        </div>
                        <div class="contact-item d-flex align-items-center">
                            <i class="fas fa-clock text-warning me-2"></i>
                            <span>24/7 Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Hero Section Styles */
    .hero-about {
        min-height: 70vh;
        display: flex;
        align-items: center;
    }
    
    .floating-elements {
        position: absolute;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }
    
    .floating-icon {
        position: absolute;
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }
    
    .animate-fade-in {
        animation: fadeIn 1s ease-out;
    }
    
    .animate-slide-up {
        animation: slideUp 1s ease-out 0.3s both;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(50px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Section Badges */
    .section-badge {
        display: inline-block;
    }
    
    /* Image Cards */
    .image-card {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
    }
    
    .image-overlay {
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
    
    .image-card:hover .image-overlay {
        opacity: 1;
    }
    
    /* Feature Cards */
    .feature-card {
        background: rgba(255,255,255,0.1);
        border-radius: 1rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        color: white !important;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        background: rgba(255,255,255,0.15);
    }
    
    .feature-card h5,
    .feature-card p {
        color: white !important;
        text-shadow: 0 2px 4px rgba(0,0,0,0.8);
        font-weight: 600;
    }
    
    .feature-card h5 {
        font-weight: bold;
        text-shadow: 0 3px 6px rgba(0,0,0,0.9);
        font-size: 1.25rem;
    }
    
    .feature-card p {
        font-size: 1rem;
        line-height: 1.6;
        background: rgba(255,255,255,0.1);
        padding: 1rem;
        border-radius: 0.5rem;
        margin-top: 1rem;
    }
    
    .feature-card h5 {
        background: rgba(255,255,255,0.2);
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        display: inline-block;
    }
    
    /* Vision Cards */
    .vision-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 1rem;
        background: white;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }
    
    .vision-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    
    /* Service Cards */
    .service-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: white;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }
    
    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .service-image img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    /* Team Cards */
    .team-card {
        background: rgba(255,255,255,0.1);
        border-radius: 1rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        transition: transform 0.3s ease;
        color: white !important;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    }
    
    .team-card:hover {
        transform: translateY(-10px);
        background: rgba(255,255,255,0.15);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }
    
    .team-card h5,
    .team-card p {
        color: white !important;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }
    
    .team-card h5 {
        font-weight: bold;
        text-shadow: 0 2px 4px rgba(0,0,0,0.7);
    }
    
    .team-image {
        position: relative;
        display: inline-block;
    }
    
    .team-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .team-image:hover .team-overlay {
        opacity: 1;
    }
    
    /* Stat Cards */
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: white;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }
    
    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    /* Background Patterns */
    .bg-pattern {
        background-image: 
            radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 0%, transparent 50%);
    }
    
    
    /* CTA Section */
    .cta-content {
        position: relative;
        z-index: 2;
    }
    
    .cta-content h2,
    .cta-content p {
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    
    .cta-content h2 {
        text-shadow: 0 3px 6px rgba(0,0,0,0.7);
    }
    
    .contact-item {
        background: rgba(255,255,255,0.1);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        color: white !important;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }
    
    /* Hero Section Text */
    .hero-content h1,
    .hero-content p {
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    
    .hero-content h1 {
        text-shadow: 0 3px 6px rgba(0,0,0,0.7);
    }
    
    /* Section Headers */
    .bg-gradient-primary h2,
    .bg-gradient-primary p {
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    
    .bg-gradient-primary h2 {
        text-shadow: 0 3px 6px rgba(0,0,0,0.7);
    }
    
    /* Ensure all white text is visible */
    .text-white,
    .text-white-50,
    .opacity-75 {
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }
    
    /* Make sure headings are bold and visible */
    .display-3,
    .display-4,
    .display-5,
    .display-6 {
        font-weight: 800 !important;
        text-shadow: 0 3px 6px rgba(0,0,0,0.7);
    }
    
    /* Improve contrast for better readability */
    .lead {
        font-weight: 500;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hero-about {
            min-height: 50vh;
        }
        
        .floating-icon {
            display: none;
        }
        
        .hero-stats {
            flex-direction: column;
            gap: 1rem !important;
        }
        
        .achievement-stats {
            flex-direction: column;
            gap: 1rem !important;
        }
        
        .contact-info {
            flex-direction: column;
            gap: 1rem !important;
        }
        
        /* Mobile: Make feature cards more readable */
        .feature-card {
            background: rgba(0,0,0,0.5) !important;
            margin-bottom: 1rem;
        }
        
        .feature-card h5,
        .feature-card p {
            text-shadow: 0 3px 6px rgba(0,0,0,0.9) !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate elements on scroll
        const animateElements = document.querySelectorAll('.feature-card, .vision-card, .service-card, .team-card, .stat-card, .image-card');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        animateElements.forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(50px)';
            element.style.transition = 'all 0.8s ease';
            observer.observe(element);
        });
        
        // Counter animation for statistics
        const counters = document.querySelectorAll('.counter');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-target'));
                    const duration = 2000; // 2 seconds
                    const increment = target / (duration / 16); // 60fps
                    let current = 0;
                    
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        counter.textContent = Math.floor(current) + '+';
                    }, 16);
                    
                    counterObserver.unobserve(counter);
                }
            });
        });
        
        counters.forEach(counter => {
            counterObserver.observe(counter);
        });
        
        // Parallax effect for hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroBg = document.querySelector('.hero-bg');
            if (heroBg) {
                heroBg.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });
        
        // Add hover effects to buttons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.2)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
        
        // Add click animation to cards
        const cards = document.querySelectorAll('.feature-card, .vision-card, .service-card, .team-card, .stat-card');
        cards.forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
    });
</script>
@endpush




