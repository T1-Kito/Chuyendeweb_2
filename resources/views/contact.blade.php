@extends('layouts.app')

@section('title', 'Liên Hệ - WebChoThu')

@section('content')
<!-- Hero Section with banner image (not full width, no text) -->
<section class="py-3 pt-2">
    <div class="container">
        <div class="contact-banner"></div>
    </div>
    
</section>

<!-- Zalo quick contact -->
<section class="py-5 pt-0">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="display-6 fw-bold text-white mb-2">Kết nối nhanh qua Zalo</h2>
            <p class="text-white-50 mb-0">Chọn đúng chuyên viên để được hỗ trợ nhanh và đúng việc</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <a class="zalo-card d-block h-100" href="https://zalo.me/0000000000" target="_blank" rel="noopener">
                    <div class="zalo-card-inner zalo-card-blue">
                        <div class="zalo-content">
                            <h5 class="mb-1">Chuyên viên tư vấn kỹ thuật VIGILANCE</h5>
                            <span class="zalo-sub">Giải pháp – cài đặt – khắc phục sự cố</span>
                        </div>
                        <span class="zalo-cta zalo-cta-blue">Chat Zalo</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a class="zalo-card d-block h-100" href="zalo://chat?phone=0982751039" target="_blank" rel="noopener">
                    <div class="zalo-card-inner zalo-card-green">
                        <div class="zalo-content">
                            <h5 class="mb-1">Chuyên viên tư vấn sản phẩm-báo giá VIGILANCE</h5>
                            <span class="zalo-sub">Báo giá – cấu hình </span>
                        </div>
                        <span class="zalo-cta zalo-cta-green">Chat Zalo</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a class="zalo-card d-block h-100" href="zalo://chat?phone=0968220919" target="_blank" rel="noopener">
                    <div class="zalo-card-inner zalo-card-orange">
                        <div class="zalo-content">
                            <h5 class="mb-1">Chuyên viên hỗ trợ bảo hành VIGILANCE</h5>
                            <span class="zalo-sub">Tiếp nhận bảo hành – đổi trả – hậu mãi</span>
                        </div>
                        <span class="zalo-cta zalo-cta-orange">Chat Zalo</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
</section>

<!-- Contact Information removed per request -->

<!-- Contact Form & Map -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-7 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-envelope me-2"></i>Gửi Tin Nhắn</h4>
                    </div>
                    <div class="card-body">
                        <form id="contactForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control" id="phone" name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="subject" class="form-label">Chủ đề <span class="text-danger">*</span></label>
                                        <select class="form-select" id="subject" name="subject" required>
                                            <option value="">Chọn chủ đề</option>
                                            <option value="general">Thông tin chung</option>
                                            <option value="rental">Tư vấn thuê thiết bị</option>
                                            <option value="support">Hỗ trợ kỹ thuật</option>
                                            <option value="partnership">Hợp tác kinh doanh</option>
                                            <option value="other">Khác</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Nội dung tin nhắn <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="5" required 
                                          placeholder="Vui lòng mô tả chi tiết yêu cầu của bạn..."></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                    <label class="form-check-label" for="newsletter">
                                        Đăng ký nhận thông tin khuyến mãi và cập nhật từ WebChoThu
                                    </label>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Gửi Tin Nhắn
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Map & Additional Info -->
            <div class="col-lg-5">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-map me-2"></i>Vị Trí Của Chúng Tôi</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="map-container">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.424098981303!2d106.6983153148008!3d10.776838992319!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f46f64b933f%3A0xf8a6e5b2a5a4f1f4!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2jhu4cgVGjDtG5nIHRpbiB2aWV0!5e0!3m2!1svi!2s!4v1629789456789!5m2!1svi!2s" 
                                width="100%" 
                                height="300" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Giờ Làm Việc</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between mb-2">
                                <span>Thứ 2 - Thứ 6:</span>
                                <strong>8:00 - 18:00</strong>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                <span>Thứ 7:</span>
                                <strong>8:00 - 12:00</strong>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                <span>Chủ nhật:</span>
                                <strong>Nghỉ</strong>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Hỗ trợ khẩn cấp:</span>
                                <strong>24/7</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Social media and FAQ removed per request -->
@endsection

@push('scripts')
<script>
    // Contact form handling
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang gửi...';
        submitBtn.disabled = true;
        
        // Simulate form submission (replace with actual AJAX call)
        setTimeout(() => {
            // Show success message
            alert('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
            
            // Reset form
            this.reset();
            
            // Restore button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    });
    
    // Add some interactive effects
    document.addEventListener('DOMContentLoaded', function() {
        // Animate cards on scroll
        const cards = document.querySelectorAll('.card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });
        
        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(50px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
    });
</script>

<style>
.contact-banner{
    width: 100%;
    height: 360px;
    border-radius: 16px;
    background: url('{{ asset('storage/banerlienhe.jpg') }}') center/cover no-repeat;
    box-shadow: 0 10px 30px rgba(0,0,0,.12);
}
@media (max-width: 992px){
  .contact-banner{ height: 260px; }
}
@media (max-width: 576px){
  .contact-banner{ height: 180px; }
}
.map-container {
    position: relative;
    overflow: hidden;
    border-radius: 0.375rem;
}

.hero-gradient{background:linear-gradient(180deg,rgba(13,110,253,.08),transparent)}
.card{border:1px solid #eef1f5;box-shadow:0 8px 24px rgba(0,0,0,.04)}

.zalo-card{ text-decoration:none }
.zalo-card-inner{
    display:flex;align-items:center;justify-content:space-between;background:linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);border-radius:20px;padding:28px 32px;border:2px solid transparent;box-shadow:0 15px 35px rgba(13,110,253,.12), 0 5px 15px rgba(0,0,0,.08);transition:all .3s cubic-bezier(0.4, 0, 0.2, 1);position:relative;overflow:hidden
}
.zalo-card-inner:hover{ 
    transform:translateY(-12px) scale(1.02); 
}
.zalo-card-inner:before{
    content:'';position:absolute;top:0;left:0;right:0;height:4px;opacity:0;transition:opacity .3s ease
}
.zalo-card-inner:hover:before{opacity:1}

/* Blue Card - Technical Consultant */
.zalo-card-blue:before{background:linear-gradient(90deg, #3b82f6, #1d4ed8, #1e40af)}
.zalo-card-blue:hover{box-shadow:0 25px 50px rgba(59,130,246,.25), 0 10px 25px rgba(0,0,0,.15);border-color:rgba(59,130,246,.4);background:linear-gradient(135deg, #ffffff 0%, #eff6ff 100%)}
.zalo-cta-blue{background:linear-gradient(135deg, #3b82f6, #1d4ed8);box-shadow:0 8px 20px rgba(59,130,246,.4), 0 4px 12px rgba(0,0,0,.15)}
.zalo-cta-blue:hover{background:linear-gradient(135deg, #2563eb, #1e40af);box-shadow:0 12px 25px rgba(59,130,246,.5), 0 6px 15px rgba(0,0,0,.2)}
.zalo-cta-blue:after{box-shadow:0 0 0 0 rgba(59,130,246,.6)}

/* Green Card - Product Consultant */
.zalo-card-green:before{background:linear-gradient(90deg, #10b981, #059669, #047857)}
.zalo-card-green:hover{box-shadow:0 25px 50px rgba(16,185,129,.25), 0 10px 25px rgba(0,0,0,.15);border-color:rgba(16,185,129,.4);background:linear-gradient(135deg, #ffffff 0%, #ecfdf5 100%)}
.zalo-cta-green{background:linear-gradient(135deg, #10b981, #059669);box-shadow:0 8px 20px rgba(16,185,129,.4), 0 4px 12px rgba(0,0,0,.15)}
.zalo-cta-green:hover{background:linear-gradient(135deg, #059669, #047857);box-shadow:0 12px 25px rgba(16,185,129,.5), 0 6px 15px rgba(0,0,0,.2)}
.zalo-cta-green:after{box-shadow:0 0 0 0 rgba(16,185,129,.6)}

/* Orange Card - Warranty Support */
.zalo-card-orange:before{background:linear-gradient(90deg, #f97316, #ea580c, #c2410c)}
.zalo-card-orange:hover{box-shadow:0 25px 50px rgba(249,115,22,.25), 0 10px 25px rgba(0,0,0,.15);border-color:rgba(249,115,22,.4);background:linear-gradient(135deg, #ffffff 0%, #fff7ed 100%)}
.zalo-cta-orange{background:linear-gradient(135deg, #f97316, #ea580c);box-shadow:0 8px 20px rgba(249,115,22,.4), 0 4px 12px rgba(0,0,0,.15)}
.zalo-cta-orange:hover{background:linear-gradient(135deg, #ea580c, #c2410c);box-shadow:0 12px 25px rgba(249,115,22,.5), 0 6px 15px rgba(0,0,0,.2)}
.zalo-cta-orange:after{box-shadow:0 0 0 0 rgba(249,115,22,.6)}
.zalo-icon-wrap{width:56px;height:56px;border-radius:14px;display:flex;align-items:center;justify-content:center}
.bg-gradient-blue{background:linear-gradient(135deg,#60a5fa,#2563eb)}
.bg-gradient-green{background:linear-gradient(135deg,#34d399,#059669)}
.bg-gradient-orange{background:linear-gradient(135deg,#fb923c,#f97316)}
.zalo-content h5{font-weight:900;color:#1e293b;margin:0;font-size:1.15rem;line-height:1.4;text-shadow:0 1px 2px rgba(0,0,0,.05)}
.zalo-sub{color:#64748b;font-size:.92rem;font-weight:500;margin-top:4px;display:block}
.zalo-cta{color:#fff;padding:14px 24px;border-radius:999px;font-weight:800;font-size:1rem;position:relative;flex-shrink:0;transition:all .3s ease;border:1px solid rgba(255,255,255,.2)}
.zalo-cta:hover{transform:translateY(-2px)}
.zalo-cta:after{content:'';position:absolute;inset:-6px;border-radius:999px;animation:pulseCta 2s infinite}
@keyframes pulseCta{0%{box-shadow:0 0 0 0 rgba(59,130,246,.6)}70%{box-shadow:0 0 0 12px rgba(59,130,246,0)}100%{box-shadow:0 0 0 0 rgba(59,130,246,0)}}

.accordion-button:not(.collapsed) {
    background-color: rgba(99, 102, 241, 0.1);
    color: var(--primary-color);
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25);
}
</style>
@endpush





