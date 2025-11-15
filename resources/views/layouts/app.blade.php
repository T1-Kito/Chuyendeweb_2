<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WebChoThu - Cho Thuê Thiết Bị Chất Lượng')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --accent-color: #f59e0b;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --vikhang-blue: #2563eb;
            --vikhang-orange: #f97316;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            min-height: 100vh;
            /* Ensure main content is pushed below the fixed navbar. Use the CSS variable
               --nav-h set on the <nav> (defaults to 90px). This prevents the header from
               overlapping top-of-page action buttons (e.g. "Tạo Gói Dịch Vụ"). */
            padding-top: var(--nav-h, 90px);
        }
        
        .navbar {
            background: rgba(0, 0, 0, 0.4) !important;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            padding: 0.8rem 0;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            color: white !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 1.2rem;
            padding: 0.7rem 1.3rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }
        
        .navbar-brand .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }
        
        .navbar-brand .brand-name {
            font-size: 1.8rem;
            font-weight: 800;
        }
        
        .navbar-brand .brand-tagline {
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 400;
        }
        
        .nav-link {
            font-weight: 500;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease;
            padding: 0.8rem 1.2rem !important;
            border-radius: 10px;
            margin: 0 0.2rem;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            min-width: 80px;
        }
        
        .nav-link:hover {
            color: var(--vikhang-orange) !important;
            background: rgba(249, 115, 22, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
        }
        
        .nav-link.active {
            color: var(--vikhang-orange) !important;
            background: rgba(249, 115, 22, 0.25);
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
        }
        
        .nav-link i {
            font-size: 1.3rem;
            margin-bottom: 0.3rem;
            opacity: 0.9;
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.25rem 0.5rem;
            color: white;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
        }
        
        .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: rgba(37, 99, 235, 0.1);
            color: var(--vikhang-blue);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--vikhang-blue), var(--vikhang-orange));
            border: none;
            border-radius: 20px;
            padding: 0.5rem 1.4rem;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
        }
        
        /* Cart Icon Styles */
        .cart-icon {
            position: relative;
            padding: 0.5rem 0.8rem !important;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .cart-icon:hover {
            background: rgba(249, 115, 22, 0.15);
            color: var(--vikhang-orange) !important;
        }
        
        .cart-icon i {
            font-size: 1.4rem;
        }
        
        .cart-count {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        
        .cart-count:empty {
            display: none;
        }
        
        /* Home hero style controlled inline in the view */
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--dark-color);
            margin-bottom: 40px;
            opacity: 0.8;
        }
        
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        /* Compact form variant (used by admin create/edit forms) */
        .compact-form .card-header {
            padding: 0.6rem 1rem;
        }
        .compact-form .card-body {
            padding: 1rem 1rem;
        }
        .compact-form .card-title { font-size: 1.15rem; }
        
        /* Removed particles background */
        
        /* Mobile-first improvements */
        @media (max-width: 576px) {
            .navbar-brand { display: none !important; }
            .nav-link { min-width: auto; padding: 0.6rem 0.7rem !important; font-size: 0.85rem; }
            .navbar { padding: 0.4rem 0; }
            body { font-size: 15px; }
            .btn { padding: 0.55rem 0.9rem; font-weight: 600; border-radius: 10px; }
            .container { padding-left: 14px; padding-right: 14px; }

            /* Mobile menu panel */
            .navbar-collapse.show {
                position: fixed;
                left: 0; right: 0; top: 0;
                background: #12171f;
                padding: calc(var(--nav-h, 60px) + 8px) 16px 24px;
                z-index: 1100;
                border-bottom: 1px solid rgba(255,255,255,0.08);
                min-height: 100vh;
                overflow-y: auto;
            }
            .navbar-collapse.show .navbar-nav { width: 100%; }
            .navbar-collapse.show .nav-link {
                color: #ffffff !important;
                background: transparent !important;
                box-shadow: none !important;
                border-radius: 8px;
                display: flex; align-items: center; gap: 10px;
                padding: 0.85rem 0.6rem !important;
                font-size: 1rem;
                text-transform: none;
            }
            .navbar-collapse.show .nav-link i { margin: 0; font-size: 1.1rem; }
            .navbar-collapse.show .nav-link.active { color: #ffd166 !important; background: rgba(255,255,255,0.06) !important; }
            .navbar-collapse.show .dropdown-menu { position: static; float: none; box-shadow: none; background: transparent; padding: 0; }
            .navbar-collapse.show .dropdown-item { color: #e5e7eb; padding: 0.6rem 1rem; }
            .navbar-collapse.show .dropdown-item:hover { background: rgba(255,255,255,0.08); color: #ffffff; }
        }

        /* Lock scroll when menu open */
        body.menu-open { overflow: hidden; }

        /* Backdrop behind mobile menu */
        .menu-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 1095; display: none; }
        body.menu-open .menu-backdrop { display: block; }

        /* Bottom mobile tabbar (hidden by default) */
        .mobile-tabbar { position: fixed; left: 0; right: 0; bottom: 0; background: #ffffff; border-top: 1px solid #e9ecef; box-shadow: 0 -6px 20px rgba(0,0,0,0.06); z-index: 1200; display: none; }
        .mobile-tabbar .tabbar-inner { display: grid; grid-template-columns: repeat(5, 1fr); gap: 0; }
        .mobile-tabbar a { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 8px 4px; color: #6b7280; text-decoration: none; font-size: 11px; font-weight: 600; }
        .mobile-tabbar a i { font-size: 18px; margin-bottom: 4px; }
        .mobile-tabbar a.active { color: #0d6efd; }
        
        /* Mobile + tablet: thay navbar bằng tabbar */
        @media (max-width: 991.98px){
            /* Hide logo on mobile and tablet */
            .navbar-brand { display: none !important; }
            /* Hide old hamburger menu on mobile */
            .navbar-toggler{ display:none !important; }
            #navbarNav{ display:none !important; }
            .navbar-collapse{ display:none !important; }
            .menu-backdrop{ display:none !important; }
            body{ padding-bottom: 62px; }
            .mobile-tabbar{ display:block; }
        }
        }
    </style>
    @stack('styles')
    
    <script>
    // Smooth scroll for anchor links
    document.addEventListener('DOMContentLoaded', function() {
        // Auto close mobile menu when clicking a nav link, and lock body scroll
        const nav = document.getElementById('navbarNav');
        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(nav, {toggle:false});
        document.querySelectorAll('#navbarNav .nav-link, #navbarNav .dropdown-item').forEach(el => {
            el.addEventListener('click', () => {
                bsCollapse.hide();
                document.body.classList.remove('menu-open');
            });
        });

        // Toggle body class when menu opens/closes and control backdrop
        const backdrop = document.querySelector('.menu-backdrop');
        const openMenu = () => { document.body.classList.add('menu-open'); backdrop.style.display = 'block'; };
        const closeMenu = () => { document.body.classList.remove('menu-open'); backdrop.style.display = 'none'; };
        nav.addEventListener('shown.bs.collapse', openMenu);
        nav.addEventListener('hidden.bs.collapse', closeMenu);
        if (backdrop) backdrop.addEventListener('click', () => bsCollapse.hide());

        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    const offsetTop = targetElement.offsetTop - 80; // Account for fixed navbar
                    
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
    </script>
</head>
<body>
    
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="--nav-h: 90px;">
        <div class="container">
            <!-- Logo/Brand -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('LogoViKhang1.jpg') }}" alt="VIKHANG Logo" style="height: 70px; width: auto;">
            </a>

            <!-- Mobile Toggle (hidden on mobile in favor of tabbar) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu (hidden on <= lg by CSS above) -->
            <div class="collapse navbar-collapse d-flex align-items-center justify-content-between w-100" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home"></i>Trang Chủ
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ request()->routeIs('home') ? '#products' : route('home') . '#products' }}">
                            <i class="fas fa-boxes"></i>Sản Phẩm
                        </a>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <div class="d-flex align-items-center gap-1">
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->routeIs('products.by-category') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-list me-1"></i>Danh mục
                                </a>
                                <div class="dropdown-menu p-2" style="min-width:260px;max-height:300px;overflow:auto;">
                                    <style>
                                    .dropdown-item.active {
                                        background-color: #0d6efd;
                                        color: white;
                                    }
                                    .dropdown-item.active:hover {
                                        background-color: #0b5ed7;
                                        color: white;
                                    }
                                    </style>
                                    <a href="{{ route('home') }}" class="dropdown-item {{ request()->routeIs('home') ? 'active' : '' }}">
                                        <i class="fas fa-th-large me-2"></i>Tất cả sản phẩm
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    @php $navCats = \App\Models\Category::where('is_active',true)->orderBy('sort_order')->get(); @endphp
                                    @foreach($navCats as $cat)
                                        <a href="{{ route('products.by-category', $cat->slug) }}" class="dropdown-item {{ request()->routeIs('products.by-category') && request()->route('products.by-category', $cat->slug) == request()->url() ? 'active' : '' }}">
                                            @if($cat->icon)
                                                <i class="{{ $cat->icon }} me-2"></i>
                                            @else
                                                <i class="fas fa-tag me-2"></i>
                                            @endif
                                            {{ $cat->name }}
                                            <small class="text-muted ms-2">({{ $cat->products()->where('is_active', true)->count() }})</small>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                            <i class="fas fa-users"></i>Giới Thiệu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                            <i class="fas fa-phone-alt"></i>Liên Hệ
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <!-- Cart Icon -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            @php
                                $cartCount = 0;
                                try {
                                    if (auth()->check() && \Illuminate\Support\Facades\Schema::hasTable('carts')) {
                                        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                                    }
                                } catch (\Throwable $e) { $cartCount = 0; }
                            @endphp
                            <a class="nav-link cart-icon" href="{{ auth()->check() ? route('cart.index') : route('login') }}" 
                               title="{{ auth()->check() ? 'Giỏ hàng' : 'Đăng nhập để xem giỏ hàng' }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Giỏ hàng</span>
                                @if($cartCount > 0)
                                    <span class="cart-count" id="cart-count">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>

                    <!-- User Menu -->
                    <ul class="navbar-nav">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('rentals.*') ? 'active' : '' }}" href="{{ route('rentals.index') }}">
                                    <i class="fas fa-list me-1"></i>Đơn Thuê
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('checkin.*') ? 'active' : '' }}" href="{{ route('checkin.index') }}">
                                    <i class="fas fa-calendar-check me-1"></i>Điểm Danh
                                </a>
                            </li>
                            <!-- Notification bell -->
                            <li class="nav-item dropdown">
                                <a class="nav-link position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-bell me-1"></i>Thông báo
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.69em; margin-left: -5px;">{{ auth()->user()->unreadNotifications->count() }}</span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown" style="min-width:320px;max-width:420px;max-height:420px;overflow:auto;">
                                    <li class="dropdown-header">Thông báo mới nhất</li>
                                    @forelse(auth()->user()->notifications->take(10) as $notification)
                                        <li class="dropdown-item @if(!$notification->read_at) fw-bold bg-light @endif" style="padding: 10px 15px;">
                                            @php
                                                $type = $notification->data['type'] ?? '';
                                                $data = $notification->data;
                                            @endphp
                                            
                                            @if($type === 'new_comment')
                                                <a href="{{ $data['product_url'] ?? '#' }}" style="text-decoration:none;" class="text-dark d-block">
                                                    <i class="fas fa-comment-dots text-success me-2"></i>
                                                    <strong>{{ $data['user_name'] ?? 'Người dùng' }}</strong> đã bình luận sản phẩm <strong>{{ $data['product_name'] ?? '' }}</strong>
                                                    <div class="small text-muted mt-1">{{ Str::limit($data['comment_content'] ?? '', 50) }}</div>
                                                    <div class="small text-muted mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                                </a>
                                            @elseif($type === 'new_rating')
                                                <a href="{{ $data['product_url'] ?? '#' }}" style="text-decoration:none;" class="text-dark d-block">
                                                    <i class="fas fa-star text-warning me-2"></i>
                                                    <strong>{{ $data['user_name'] ?? 'Người dùng' }}</strong> đã đánh giá {{ $data['stars'] ?? '' }} sao cho sản phẩm <strong>{{ $data['product_name'] ?? '' }}</strong>
                                                    <div class="small text-muted mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                                </a>
                                            @elseif($type === 'new_cart')
                                                <a href="{{ $data['product_url'] ?? '#' }}" style="text-decoration:none;" class="text-dark d-block">
                                                    <i class="fas fa-shopping-cart text-info me-2"></i>
                                                    <strong>{{ $data['user_name'] ?? 'Người dùng' }}</strong> đã thêm sản phẩm <strong>{{ $data['product_name'] ?? '' }}</strong> vào giỏ hàng
                                                    <div class="small text-muted mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                                </a>
                                            @elseif($type === 'order_approved')
                                                <a href="{{ $data['order_url'] ?? '#' }}" style="text-decoration:none;" class="text-dark d-block">
                                                    <i class="fas fa-check-circle text-primary me-2"></i>
                                                    <strong>{{ $data['message'] ?? 'Đơn hàng của bạn đã được duyệt!' }}</strong>
                                                    <div class="small text-muted mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                                </a>
                                            @elseif($type === 'rating_approved')
                                                <a href="{{ $data['product_url'] ?? '#' }}" style="text-decoration:none;" class="text-dark d-block">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <strong>{{ $data['message'] ?? 'Đánh giá của bạn đã được duyệt!' }}</strong>
                                                    <div class="small text-muted mt-1">Sản phẩm: {{ $data['product_name'] ?? '' }}</div>
                                                    <div class="small text-muted mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                                </a>
                                            @elseif($type === 'new_message')
                                                <a href="{{ $data['chat_url'] ?? '#' }}" style="text-decoration:none;" class="text-dark d-block">
                                                    <i class="fas fa-comments text-info me-2"></i>
                                                    <strong>{{ $data['user_name'] ?? 'Người dùng' }}</strong> đã gửi tin nhắn
                                                    <div class="small text-muted mt-1">{{ $data['content'] ?? '' }}</div>
                                                    <div class="small text-muted mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                                </a>
                                            @else
                                                <div class="text-dark">
                                                    <i class="fas fa-bell text-secondary me-2"></i>
                                                    {{ $data['message'] ?? 'Thông báo mới' }}
                                                    <div class="small text-muted mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                                </div>
                                            @endif
                                        </li>
                                    @empty
                                        <li class="dropdown-item text-muted text-center py-3">Không có thông báo nào mới.</li>
                                    @endforelse
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('notifications.mark_all_read') }}" class="d-inline w-100">
                                            @csrf
                                            <button type="submit" class="dropdown-item small text-center text-primary w-100">Đánh dấu tất cả đã đọc</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @if(auth()->user()->is_admin)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog me-1"></i>Quản Lý
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.products.index') }}">
                                        <i class="fas fa-box me-2"></i>Sản Phẩm
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">
                                        <i class="fas fa-tags me-2"></i>Danh Mục
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.banners.index') }}">
                                        <i class="fas fa-images me-2"></i>Banner
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.service-packages.index') }}">
                                        <i class="fas fa-gift me-2"></i>Gói Dịch Vụ
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}">
                                        <i class="fas fa-shopping-cart me-2"></i>Đơn Hàng
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.ratings.index') }}">
                                        <i class="fas fa-star me-2"></i>Quản lý đánh giá
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.comments.index') }}">
                                        <i class="fas fa-comments me-2"></i>Quản lý bình luận
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.messages.index') }}">
                                        <i class="fas fa-envelope me-2"></i>Tin nhắn hỗ trợ
                                    </a></li>
                                </ul>
                            </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('cart.index') }}">
                                        <i class="fas fa-shopping-cart me-2"></i>Giỏ Hàng
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('account.show') }}">
                                        <i class="fas fa-id-card me-2"></i>Tài khoản của tôi
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('messages.index') }}">
                                        <i class="fas fa-comments me-2"></i>Tin nhắn hỗ trợ
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i>Đăng Xuất
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-1"></i>Đăng Nhập
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus me-1"></i>Đăng Ký
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="menu-backdrop"></div>

    <!-- Mobile bottom tabbar -->
    <div class="mobile-tabbar d-lg-none">
        <div class="tabbar-inner">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Trang chủ</span>
            </a>
            <a href="#products" onclick="event.preventDefault(); document.querySelector('#products').scrollIntoView({behavior:'smooth',block:'start'});">
                <i class="fas fa-boxes"></i>
                <span>Sản phẩm</span>
            </a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Giới thiệu</span>
            </a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                <i class="fas fa-phone"></i>
                <span>Liên hệ</span>
            </a>
            @auth
                <a href="{{ route('rentals.index') }}" class="{{ request()->routeIs('rentals.*') ? 'active' : '' }}">
                    <i class="fas fa-list"></i>
                    <span>Đơn thuê</span>
                </a>
            @else
                <a href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Đăng nhập</span>
                </a>
            @endauth
        </div>
    </div>
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Ensure body top padding matches the actual fixed navbar height so content
        // (buttons/cards) never sit behind the header. This measures the navbar
        // and applies the value to body padding-top, updating on load/resize and
        // when the bootstrap collapse opens/closes.
        (function() {
            function updateBodyPadding() {
                try {
                    var nav = document.querySelector('.navbar.fixed-top');
                    if (!nav) return;
                    var rect = nav.getBoundingClientRect();
                    var h = Math.ceil(rect.height);
                    // Add a small extra gap so shadow doesn't visually overlap
                    document.body.style.paddingTop = (h + 8) + 'px';
                } catch (e) { /* silent */ }
            }

            // Update on load and resize (debounced)
            window.addEventListener('load', updateBodyPadding);
            var _resizeTimer = null;
            window.addEventListener('resize', function() {
                clearTimeout(_resizeTimer);
                _resizeTimer = setTimeout(updateBodyPadding, 100);
            });

            // Update when bootstrap collapse (mobile menu) toggles
            var navCollapse = document.getElementById('navbarNav');
            if (navCollapse) {
                navCollapse.addEventListener('shown.bs.collapse', updateBodyPadding);
                navCollapse.addEventListener('hidden.bs.collapse', updateBodyPadding);
            }

            // Initial call in case DOMContentLoaded already fired
            updateBodyPadding();
        })();

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                // Skip if href is just "#" (empty anchor)
                if (href === '#') {
                    return;
                }

                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Auto-scroll to products section when coming from other pages
        if (window.location.hash === '#products') {
            // Wait for page to load completely
            window.addEventListener('load', function() {
                setTimeout(function() {
                    const productsSection = document.querySelector('#products');
                    if (productsSection) {
                        productsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 100);
            });
        }
    </script>
    
    @stack('scripts')
    
    @auth
    <!-- Chat Widget -->
    <div id="chatWidget" class="chat-widget">
        <!-- Chat Button -->
        <button id="chatToggle" class="chat-toggle-btn">
            <i class="fas fa-comments"></i>
            <span class="chat-badge" id="chatBadge" style="display: none;">0</span>
        </button>

        <!-- Chat Box -->
        <div id="chatBox" class="chat-box">
            <div class="chat-header">
                <h6 class="mb-0">
                    <i class="fas fa-headset me-2"></i>
                    {{ auth()->user()->is_admin ? 'Hỗ trợ khách hàng' : 'Hỗ trợ' }}
                </h6>
                <button id="chatClose" class="btn btn-sm btn-link text-white p-0">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Conversations List -->
            <div id="conversationsList" class="chat-conversations">
                <div class="chat-body p-3">
                    <div class="text-center py-3">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div id="chatMessages" class="chat-messages" style="display: none;">
                <div class="chat-header">
                    <button class="btn btn-sm btn-link text-white p-0" onclick="backToConversations()">
                        <i class="fas fa-arrow-left me-2"></i>
                    </button>
                    <h6 class="mb-0 flex-grow-1" id="conversationTitle">Cuộc trò chuyện</h6>
                    <div style="width: 24px;"></div>
                </div>
                <div class="chat-body" id="messagesContainer">
                    <!-- Messages will be loaded here -->
                </div>
                <div class="chat-input-area">
                    <form id="messageForm" class="d-flex gap-2 p-2">
                        <input type="hidden" id="currentConversationId" value="">
                        <textarea id="messageInput" class="form-control form-control-sm" rows="2" 
                                  placeholder="Nhập tin nhắn..." maxlength="2000" required></textarea>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- New Message Form -->
            <div id="newMessageForm" class="chat-new-message" style="display: none;">
                <div class="chat-header">
                    <button class="btn btn-sm btn-link text-white p-0" onclick="backToConversations()">
                        <i class="fas fa-arrow-left me-2"></i>
                    </button>
                    <h6 class="mb-0 flex-grow-1">Tin nhắn mới</h6>
                    <div style="width: 24px;"></div>
                </div>
                <div class="chat-body p-3">
                    <form id="startConversationForm">
                        <div class="mb-3">
                            <label class="form-label small">Chủ đề (tùy chọn)</label>
                            <input type="text" id="subjectInput" class="form-control form-control-sm" 
                                   placeholder="Ví dụ: Hỏi về sản phẩm...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Nội dung <span class="text-danger">*</span></label>
                            <textarea id="contentInput" class="form-control form-control-sm" rows="4" 
                                      placeholder="Nhập nội dung tin nhắn..." required maxlength="2000"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-paper-plane me-2"></i>Gửi tin nhắn
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .chat-widget {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
        }

        .chat-toggle-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-toggle-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.6);
        }

        .chat-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .chat-box {
            position: absolute;
            bottom: 80px;
            right: 0;
            width: 380px;
            height: 600px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-box.active {
            display: flex;
        }

        .chat-header {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
        }

        .chat-conversations .conversation-item {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
            cursor: pointer;
            transition: background 0.2s;
        }

        .chat-conversations .conversation-item:hover {
            background: #f8f9fa;
        }

        .chat-conversations .conversation-item.active {
            background: #e7f3ff;
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .chat-messages .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            background: #f8f9fa;
        }

        .message-item {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .message-item.own {
            align-items: flex-end;
        }

        .message-item.other {
            align-items: flex-start;
        }

        .message-bubble {
            max-width: 75%;
            padding: 10px 15px;
            border-radius: 18px;
            word-wrap: break-word;
        }

        .message-item.own .message-bubble {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
        }

        .message-item.other .message-bubble {
            background: white;
            color: #333;
            border: 1px solid #e9ecef;
        }

        .message-time {
            font-size: 11px;
            color: #6c757d;
            margin-top: 5px;
        }

        .chat-input-area {
            border-top: 1px solid #e9ecef;
            background: white;
        }

        .chat-input-area textarea {
            resize: none;
        }

        @media (max-width: 576px) {
            .chat-box {
                width: calc(100vw - 40px);
                height: calc(100vh - 120px);
                bottom: 80px;
                right: 20px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatToggle = document.getElementById('chatToggle');
            const chatBox = document.getElementById('chatBox');
            const chatClose = document.getElementById('chatClose');
            const conversationsList = document.getElementById('conversationsList');
            const chatMessages = document.getElementById('chatMessages');
            const newMessageForm = document.getElementById('newMessageForm');
            const messageForm = document.getElementById('messageForm');
            const startConversationForm = document.getElementById('startConversationForm');
            const messagesContainer = document.getElementById('messagesContainer');
            const messageInput = document.getElementById('messageInput');
            const currentConversationId = document.getElementById('currentConversationId');
            let refreshInterval = null;

            // Toggle chat box
            chatToggle.addEventListener('click', function() {
                chatBox.classList.toggle('active');
                if (chatBox.classList.contains('active')) {
                    loadConversations();
                } else {
                    stopRefreshing();
                }
            });

            chatClose.addEventListener('click', function() {
                chatBox.classList.remove('active');
                stopRefreshing();
            });

            // Load conversations
            function loadConversations() {
                fetch('{{ route("api.conversations") }}', {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const container = conversationsList.querySelector('.chat-body');
                    if (data.length === 0) {
                        container.innerHTML = `
                            <div class="text-center py-4">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Chưa có cuộc trò chuyện nào.</p>
                                <button class="btn btn-primary btn-sm" onclick="showNewMessageForm()">
                                    <i class="fas fa-plus me-2"></i>Tạo tin nhắn mới
                                </button>
                            </div>
                        `;
                    } else {
                        container.innerHTML = `
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <strong>Cuộc trò chuyện</strong>
                                <button class="btn btn-sm btn-primary" onclick="showNewMessageForm()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            ${data.map(conv => `
                                <div class="conversation-item" onclick="openConversation(${conv.id})">
                                    <div class="d-flex justify-content-between">
                                        <strong class="small">${conv.subject || 'Hỗ trợ khách hàng'}</strong>
                                        <small class="text-muted">${conv.last_message_at ? new Date(conv.last_message_at).toLocaleDateString('vi-VN') : ''}</small>
                                    </div>
                                    ${conv.latest_message && conv.latest_message.content ? `<p class="mb-0 small text-muted">${conv.latest_message.content.substring(0, 50)}${conv.latest_message.content.length > 50 ? '...' : ''}</p>` : ''}
                                    ${conv.unread_messages_count > 0 ? `<span class="badge bg-danger">${conv.unread_messages_count}</span>` : ''}
                                </div>
                            `).join('')}
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error loading conversations:', error);
                });
            }

            // Show new message form
            window.showNewMessageForm = function() {
                conversationsList.style.display = 'none';
                chatMessages.style.display = 'none';
                newMessageForm.style.display = 'block';
                stopRefreshing();
            }

            // Back to conversations list
            window.backToConversations = function() {
                conversationsList.style.display = 'block';
                chatMessages.style.display = 'none';
                newMessageForm.style.display = 'none';
                stopRefreshing();
                loadConversations();
            }

            // Open conversation
            window.openConversation = function(conversationId) {
                currentConversationId.value = conversationId;
                conversationsList.style.display = 'none';
                newMessageForm.style.display = 'none';
                chatMessages.style.display = 'flex';
                
                // Update conversation title
                fetch('{{ route("api.conversations") }}', {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const conv = data.find(c => c.id == conversationId);
                    if (conv) {
                        document.getElementById('conversationTitle').textContent = conv.subject || 'Hỗ trợ khách hàng';
                    }
                });
                
                loadMessages(conversationId);
                startRefreshing(conversationId);
            }

            // Load messages
            function loadMessages(conversationId) {
                fetch(`/api/messages/${conversationId}`, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const currentUserId = {{ auth()->id() }};
                    messagesContainer.innerHTML = data.messages.map(msg => `
                        <div class="message-item ${msg.user_id == currentUserId ? 'own' : 'other'}">
                            <div class="message-bubble">
                                ${msg.content.replace(/\n/g, '<br>')}
                            </div>
                            <div class="message-time">
                                ${msg.user ? msg.user.name : 'Người dùng'} - ${new Date(msg.created_at).toLocaleString('vi-VN')}
                            </div>
                        </div>
                    `).join('');
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                })
                .catch(error => {
                    console.error('Error loading messages:', error);
                });
            }

            // Send message
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const conversationId = currentConversationId.value;
                const content = messageInput.value.trim();
                
                if (!content || !conversationId) {
                    alert('Vui lòng nhập nội dung tin nhắn!');
                    return;
                }

                // Disable form while sending
                const submitBtn = messageForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch(`/messages/${conversationId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ content: content })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        messageInput.value = '';
                        // Reload messages immediately
                        loadMessages(conversationId);
                    } else {
                        alert('Có lỗi xảy ra khi gửi tin nhắn!');
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    let errorMsg = 'Có lỗi xảy ra khi gửi tin nhắn!';
                    if (error.errors) {
                        // Validation errors
                        const firstError = Object.values(error.errors)[0];
                        if (Array.isArray(firstError) && firstError.length > 0) {
                            errorMsg = firstError[0];
                        }
                    } else if (error.message) {
                        errorMsg = error.message;
                    } else if (error.content && Array.isArray(error.content)) {
                        errorMsg = error.content[0];
                    }
                    alert(errorMsg);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });

            // Start new conversation
            startConversationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const subject = document.getElementById('subjectInput').value;
                const content = document.getElementById('contentInput').value.trim();
                
                if (!content) {
                    alert('Vui lòng nhập nội dung tin nhắn!');
                    return;
                }

                // Disable form while sending
                const submitBtn = startConversationForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';

                fetch('{{ route("messages.start") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ subject: subject, content: content })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        document.getElementById('subjectInput').value = '';
                        document.getElementById('contentInput').value = '';
                        openConversation(data.conversation_id);
                    } else {
                        alert('Có lỗi xảy ra khi tạo tin nhắn!');
                    }
                })
                .catch(error => {
                    console.error('Error starting conversation:', error);
                    let errorMsg = 'Có lỗi xảy ra khi tạo tin nhắn!';
                    if (error.errors) {
                        // Validation errors
                        const firstError = Object.values(error.errors)[0];
                        if (Array.isArray(firstError) && firstError.length > 0) {
                            errorMsg = firstError[0];
                        }
                    } else if (error.message) {
                        errorMsg = error.message;
                    } else if (error.content && Array.isArray(error.content)) {
                        errorMsg = error.content[0];
                    }
                    alert(errorMsg);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });

            // Auto refresh
            function startRefreshing(conversationId) {
                stopRefreshing();
                refreshInterval = setInterval(() => {
                    loadMessages(conversationId);
                }, 3000);
            }

            function stopRefreshing() {
                if (refreshInterval) {
                    clearInterval(refreshInterval);
                    refreshInterval = null;
                }
            }

            // Update badge
            function updateBadge() {
                fetch('{{ route("api.conversations") }}', {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const unreadCount = data.reduce((sum, conv) => sum + (conv.unread_messages_count || 0), 0);
                    const badge = document.getElementById('chatBadge');
                    if (unreadCount > 0) {
                        badge.textContent = unreadCount;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                });
            }

            // Update badge every 10 seconds
            setInterval(updateBadge, 10000);
            updateBadge();
        });
    </script>
    @endauth
</body>
</html>

