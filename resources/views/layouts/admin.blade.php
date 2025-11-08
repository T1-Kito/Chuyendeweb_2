<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - WebChoThu')</title>
    
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
            
            /* Sidebar Color Themes */
            --sidebar-bg: #1e1b4b;
            --sidebar-hover: #312e81;
            --sidebar-active: #4338ca;
            --sidebar-gradient: linear-gradient(135deg, #1e1b4b, #312e81);
            
            /* Theme Colors */
            --theme-primary: #6366f1;
            --theme-secondary: #8b5cf6;
            --theme-accent: #f59e0b;
            
            /* Dark Mode Variables */
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
        }
        
        /* Dark Mode */
        [data-theme="dark"] {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border-color: #334155;
        }
        
        /* Color Themes */
        [data-theme-color="blue"] {
            --sidebar-bg: #1e3a8a;
            --sidebar-hover: #1e40af;
            --sidebar-active: #2563eb;
            --sidebar-gradient: linear-gradient(135deg, #1e3a8a, #1e40af);
        }
        
        [data-theme-color="purple"] {
            --sidebar-bg: #581c87;
            --sidebar-hover: #6b21a8;
            --sidebar-active: #7c3aed;
            --sidebar-gradient: linear-gradient(135deg, #581c87, #6b21a8);
        }
        
        [data-theme-color="green"] {
            --sidebar-bg: #14532d;
            --sidebar-hover: #166534;
            --sidebar-active: #16a34a;
            --sidebar-gradient: linear-gradient(135deg, #14532d, #166534);
        }
        
        [data-theme-color="red"] {
            --sidebar-bg: #991b1b;
            --sidebar-hover: #b91c1c;
            --sidebar-active: #dc2626;
            --sidebar-gradient: linear-gradient(135deg, #991b1b, #b91c1c);
        }
        
        [data-theme-color="orange"] {
            --sidebar-bg: #c2410c;
            --sidebar-hover: #ea580c;
            --sidebar-active: #f97316;
            --sidebar-gradient: linear-gradient(135deg, #c2410c, #ea580c);
        }
        
        [data-theme-color="pink"] {
            --sidebar-bg: #be185d;
            --sidebar-hover: #db2777;
            --sidebar-active: #ec4899;
            --sidebar-gradient: linear-gradient(135deg, #be185d, #db2777);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .admin-sidebar {
            width: 280px;
            background: var(--sidebar-gradient);
            color: white;
            padding: 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        
        .admin-sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .admin-sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        
        .admin-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
        
        .sidebar-header {
            padding: 2rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            position: relative;
        }
        
        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #f59e0b, #f97316, #ec4899);
        }
        
        .sidebar-header h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .sidebar-header p {
            margin: 0.5rem 0 0;
            font-size: 0.875rem;
            opacity: 0.8;
        }
        
        /* Theme Controls */
        .theme-controls {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .theme-controls h6 {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
        }
        
        .color-picker {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .color-option {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .color-option:hover {
            transform: scale(1.1);
            border-color: rgba(255, 255, 255, 0.8);
        }
        
        .color-option.active {
            border-color: #fff;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
        }
        
        .color-option[data-color="blue"] { background: #1e3a8a; }
        .color-option[data-color="purple"] { background: #581c87; }
        .color-option[data-color="green"] { background: #14532d; }
        .color-option[data-color="red"] { background: #991b1b; }
        .color-option[data-color="orange"] { background: #c2410c; }
        .color-option[data-color="pink"] { background: #be185d; }
        
        .dark-mode-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .dark-mode-toggle:hover {
            background: rgba(255, 255, 255, 0.15);
        }
        
        .dark-mode-toggle span {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .toggle-switch {
            width: 40px;
            height: 20px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .toggle-switch.active {
            background: #f59e0b;
        }
        
        .toggle-switch::before {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            background: white;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            transition: all 0.3s ease;
        }
        
        .toggle-switch.active::before {
            transform: translateX(20px);
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-section {
            margin-bottom: 2rem;
        }
        
        .nav-title {
            padding: 0 1.5rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.6);
            margin: 0;
        }
        
        .nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .nav-item {
            margin: 0;
        }
        
        .nav-item a {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            position: relative;
            margin: 0.25rem 0;
        }
        
        .nav-item a:hover {
            background: var(--sidebar-hover);
            color: white;
            border-left-color: #f59e0b;
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .nav-item.active a {
            background: var(--sidebar-active);
            color: white;
            border-left-color: #f59e0b;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .nav-item a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: linear-gradient(90deg, #f59e0b, #f97316);
            transition: width 0.3s ease;
        }
        
        .nav-item a:hover::before,
        .nav-item.active a::before {
            width: 3px;
        }
        
        .nav-item i:first-child {
            width: 20px;
            margin-right: 12px;
            font-size: 1rem;
        }
        
        .nav-item span {
            flex: 1;
            font-weight: 500;
        }
        
        .nav-item .arrow {
            font-size: 0.75rem;
            opacity: 0.6;
            transition: transform 0.3s ease;
        }
        
        .nav-item:hover .arrow {
            transform: translateX(3px);
            opacity: 1;
        }
        
        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 280px;
            background: var(--bg-primary);
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        .main-header {
            background: var(--bg-secondary);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .header-left h1 {
            margin: 0;
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--text-primary);
            transition: all 0.3s ease;
        }
        
        .header-left p {
            margin: 0.25rem 0 0;
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-info span {
            font-weight: 500;
            color: var(--dark-color);
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
        }
        
        .main-content {
            padding: 2rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .main-header {
                padding: 1rem;
            }
            
            .main-content {
                padding: 1rem;
            }
        }
        
        /* Card Styles */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            background: var(--bg-secondary);
            color: var(--text-primary);
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }
        
        .card-header {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            border-radius: 12px 12px 0 0 !important;
            padding: 1.25rem 1.5rem;
            color: var(--text-primary);
        }
        
        .card-body {
            padding: 1.5rem;
            background: var(--bg-secondary);
            color: var(--text-primary);
        }
        
        /* Button Styles */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--vikhang-blue), var(--vikhang-orange));
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        /* Table Styles */
        .table {
            border-radius: 8px;
            overflow: hidden;
            background: var(--bg-secondary);
            color: var(--text-primary);
        }
        
        .table th {
            background: var(--bg-primary);
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .table td {
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
        }
        
        /* Badge Styles */
        .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
        }
        
        /* Form Styles */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 0.625rem 0.875rem;
            background: var(--bg-secondary);
            color: var(--text-primary);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--vikhang-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            background: var(--bg-secondary);
            color: var(--text-primary);
        }
        
        .form-control::placeholder {
            color: var(--text-secondary);
        }
        
        .form-label {
            color: var(--text-primary);
        }
        
        .text-muted {
            color: var(--text-secondary) !important;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-shield-alt me-2"></i>VIKHANG</h3>
                <p class="text-muted">Admin Panel</p>
            </div>
            
            <!-- Theme Controls -->
            <div class="theme-controls">
                <h6><i class="fas fa-palette me-1"></i>Màu sắc</h6>
                <div class="color-picker">
                    <div class="color-option active" data-color="blue" title="Xanh dương"></div>
                    <div class="color-option" data-color="purple" title="Tím"></div>
                    <div class="color-option" data-color="green" title="Xanh lá"></div>
                    <div class="color-option" data-color="red" title="Đỏ"></div>
                    <div class="color-option" data-color="orange" title="Cam"></div>
                    <div class="color-option" data-color="pink" title="Hồng"></div>
                </div>
                
                <div class="dark-mode-toggle" onclick="toggleDarkMode()">
                    <span><i class="fas fa-moon me-1"></i>Dark Mode</span>
                    <div class="toggle-switch" id="darkModeToggle"></div>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <h6 class="nav-title">DASHBOARD</h6>
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" target="_blank">
                                <i class="fas fa-home"></i>
                                <span>Về Trang Chủ</span>
                                <i class="fas fa-external-link-alt arrow"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="nav-section">
                    <h6 class="nav-title">QUẢN LÝ</h6>
                    <ul class="nav-list">
                        @if(\App\Helpers\PermissionHelper::hasPermission('products_manage'))
                        <li class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.products.index') }}">
                                <i class="fas fa-box"></i>
                                <span>Sản Phẩm</span>
                                <i class="fas fa-chevron-right arrow"></i>
                            </a>
                        </li>
                        @endif
                        
                        @if(\App\Helpers\PermissionHelper::hasPermission('categories_manage'))
                        <li class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-tags"></i>
                                <span>Danh Mục</span>
                                <i class="fas fa-chevron-right arrow"></i>
                            </a>
                        </li>
                        @endif
                        
                        @if(\App\Helpers\PermissionHelper::hasPermission('banners_manage'))
                        <li class="nav-item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.banners.index') }}">
                                <i class="fas fa-images"></i>
                                <span>Banner</span>
                                <i class="fas fa-chevron-right arrow"></i>
                            </a>
                        </li>
                        @endif
                        
                        @if(\App\Helpers\PermissionHelper::hasPermission('orders_view'))
                        <li class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.orders.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Đơn Hàng</span>
                                <i class="fas fa-chevron-right arrow"></i>
                            </a>
                        </li>
                        @endif
                        
                        @if(\App\Helpers\PermissionHelper::hasPermission('orders_view'))
                        <li class="nav-item {{ request()->routeIs('admin.rentals.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.rentals.index') }}">
                                <i class="fas fa-users"></i>
                                <span>Khách Thuê</span>
                                <i class="fas fa-chevron-right arrow"></i>
                            </a>
                        </li>
                        @endif
                        
                        @if(\App\Helpers\PermissionHelper::hasPermission('users_manage'))
                        <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}">
                                <i class="fas fa-user-cog"></i>
                                <span>Quản Lý Người Dùng</span>
                                <i class="fas fa-chevron-right arrow"></i>
                            </a>
                        </li>
                        @endif
                        
                        @if(\App\Helpers\PermissionHelper::hasPermission('products_manage'))
                        <li class="nav-item {{ request()->routeIs('admin.serials.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.serials.index') }}">
                                <i class="fas fa-barcode"></i>
                                <span>Quản Lý Số Seri</span>
                                <i class="fas fa-chevron-right arrow"></i>
                            </a>
                        </li>
                        @endif
                        
                        @if(\App\Helpers\PermissionHelper::hasPermission('permissions_manage'))
                        <li class="nav-item {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.permissions.index') }}">
                                <i class="fas fa-user-shield"></i>
                                <span>Quản Lý Quyền</span>
                                <i class="fas fa-chevron-right arrow"></i>
                            </a>
                        </li>
                        @endif
                        
                        <li class="nav-item {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.vouchers.index') }}">
                                <i class="fas fa-ticket-alt"></i>
                                <span>Quản Lý Voucher</span>
                                <i class="fas fa-chevron-right arrow"></i>
                            </a>
                        </li>
                    </ul>
                </div>


            </nav>
        </div>

        <!-- Main Content -->
        <div class="admin-main">
            <div class="main-header">
                <div class="header-left">
                    <h1>@yield('page-title', 'Admin Panel')</h1>
                    <p class="text-muted">@yield('page-description', 'Quản lý hệ thống')</p>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <span>{{ auth()->user()->name }}</span>
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=6366f1&color=fff" alt="Avatar" class="avatar">
                    </div>
                </div>
            </div>

            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Theme Management
        document.addEventListener('DOMContentLoaded', function() {
            // Load saved theme
            loadTheme();
            
            // Color picker functionality
            const colorOptions = document.querySelectorAll('.color-option');
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active class from all options
                    colorOptions.forEach(opt => opt.classList.remove('active'));
                    // Add active class to clicked option
                    this.classList.add('active');
                    
                    // Apply color theme
                    const color = this.getAttribute('data-color');
                    document.body.setAttribute('data-theme-color', color);
                    
                    // Save to localStorage
                    localStorage.setItem('admin-theme-color', color);
                });
            });
        });
        
        // Dark mode toggle
        function toggleDarkMode() {
            const body = document.body;
            const toggle = document.getElementById('darkModeToggle');
            const isDark = body.getAttribute('data-theme') === 'dark';
            
            if (isDark) {
                body.removeAttribute('data-theme');
                toggle.classList.remove('active');
                localStorage.setItem('admin-dark-mode', 'false');
            } else {
                body.setAttribute('data-theme', 'dark');
                toggle.classList.add('active');
                localStorage.setItem('admin-dark-mode', 'true');
            }
        }
        
        // Load saved theme
        function loadTheme() {
            // Load color theme
            const savedColor = localStorage.getItem('admin-theme-color') || 'blue';
            document.body.setAttribute('data-theme-color', savedColor);
            
            // Update active color option
            const colorOptions = document.querySelectorAll('.color-option');
            colorOptions.forEach(option => {
                option.classList.remove('active');
                if (option.getAttribute('data-color') === savedColor) {
                    option.classList.add('active');
                }
            });
            
            // Load dark mode
            const isDark = localStorage.getItem('admin-dark-mode') === 'true';
            const toggle = document.getElementById('darkModeToggle');
            
            if (isDark) {
                document.body.setAttribute('data-theme', 'dark');
                toggle.classList.add('active');
            } else {
                document.body.removeAttribute('data-theme');
                toggle.classList.remove('active');
            }
        }
        
        // Add smooth transitions for theme changes
        document.body.style.transition = 'all 0.3s ease';
        
        // Add some nice animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate sidebar items on load
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, index * 50);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
