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
                <span class="brand-text">
                    <span class="brand-name">{{ config('vikhang.company.name') }}</span>
                    <span class="brand-tagline">{{ config('vikhang.company.slogan') }}</span>
                </span>
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
                                    <i class="fas fa-bell"></i>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="position-absolute top-0 start-75 translate-middle badge rounded-pill bg-danger" style="font-size:0.69em;">{{ auth()->user()->unreadNotifications->count() }}</span>
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
</body>
</html>

