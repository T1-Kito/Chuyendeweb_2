@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard')
@section('page-description', 'Tổng quan hệ thống')

@section('content')
<div class="admin-dashboard">
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-shield-alt me-2"></i>VIKHANG</h3>
            <p class="text-muted">Admin Panel</p>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section">
                <h6 class="nav-title">DASHBOARD</h6>
                <ul class="nav-list">
                    <li class="nav-item active">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <h6 class="nav-title">QUẢN LÝ</h6>
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}">
                            <i class="fas fa-box"></i>
                            <span>Sản Phẩm</span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-tags"></i>
                            <span>Danh Mục</span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.banners.index') }}">
                            <i class="fas fa-images"></i>
                            <span>Banner</span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Đơn Hàng</span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <h6 class="nav-title">THỐNG KÊ</h6>
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-chart-bar"></i>
                            <span>Báo Cáo</span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-users"></i>
                            <span>Người Dùng</span>
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
                <h1>Dashboard</h1>
                <p class="text-muted">Chào mừng bạn đến với trang quản trị</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <span>{{ auth()->user()->name }}</span>
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=6366f1&color=fff" alt="Avatar" class="avatar">
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalProducts ?? 0 }}</h3>
                    <p>Tổng Sản Phẩm</p>
                </div>
                <div class="stat-progress">
                    <div class="progress-bar" style="width: 75%"></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalCategories ?? 0 }}</h3>
                    <p>Danh Mục</p>
                </div>
                <div class="stat-progress">
                    <div class="progress-bar" style="width: 60%"></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalUsers ?? 0 }}</h3>
                    <p>Người Dùng</p>
                </div>
                <div class="stat-progress">
                    <div class="progress-bar" style="width: 90%"></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalViews ?? 0 }}</h3>
                    <p>Lượt Xem</p>
                </div>
                <div class="stat-progress">
                    <div class="progress-bar" style="width: 85%"></div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="chart-card">
                <h4>Thống Kê Truy Cập</h4>
                <div class="chart-bars">
                    <div class="chart-bar">
                        <span>Android</span>
                        <div class="bar-container">
                            <div class="bar" style="width: 60%"></div>
                        </div>
                        <span>60%</span>
                    </div>
                    <div class="chart-bar">
                        <span>iOS</span>
                        <div class="bar-container">
                            <div class="bar" style="width: 70%"></div>
                        </div>
                        <span>70%</span>
                    </div>
                    <div class="chart-bar">
                        <span>Mobile</span>
                        <div class="bar-container">
                            <div class="bar" style="width: 90%"></div>
                        </div>
                        <span>90%</span>
                    </div>
                </div>
            </div>

            <div class="chart-card">
                <h4>Bản Đồ Việt Nam</h4>
                <div class="map-container">
                    <div class="vietnam-map">
                        <div class="map-region north"></div>
                        <div class="map-region central"></div>
                        <div class="map-region south"></div>
                        <div class="map-dots">
                            <div class="dot" style="top: 20%; left: 30%"></div>
                            <div class="dot" style="top: 50%; left: 60%"></div>
                            <div class="dot" style="top: 80%; left: 40%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline & Todo Section -->
        <div class="bottom-section">
            <div class="timeline-card">
                <h4>Timeline</h4>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <span class="time">10 phút trước</span>
                            <p>Người dùng mới đăng ký tài khoản</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <span class="time">30 phút trước</span>
                            <p>Sản phẩm mới được thêm vào hệ thống</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <span class="time">1 giờ trước</span>
                            <p>Cập nhật thông tin banner quảng cáo</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <span class="time">2 giờ trước</span>
                            <p>Hệ thống backup dữ liệu thành công</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="todo-card">
                <h4>Todo</h4>
                <div class="todo-list">
                    <div class="todo-item">
                        <input type="checkbox" id="todo1">
                        <label for="todo1">Kiểm tra đơn hàng mới</label>
                    </div>
                    <div class="todo-item">
                        <input type="checkbox" id="todo2">
                        <label for="todo2">Cập nhật thông tin sản phẩm</label>
                    </div>
                    <div class="todo-item">
                        <input type="checkbox" id="todo3" checked>
                        <label for="todo3">Backup dữ liệu hệ thống</label>
                    </div>
                    <div class="todo-item">
                        <input type="checkbox" id="todo4">
                        <label for="todo4">Kiểm tra bảo mật website</label>
                    </div>
                </div>
                <div class="todo-input">
                    <input type="text" placeholder="Viết công việc mới và nhấn Enter...">
                    <button type="button"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.admin-dashboard {
    display: flex;
    min-height: 100vh;
    background: #f8f9fa;
}

/* Sidebar */
.admin-sidebar {
    width: 280px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    position: fixed;
    height: 100vh;
    overflow-y: auto;
}

.sidebar-header {
    padding: 0 2rem 2rem;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    margin-bottom: 2rem;
}

.sidebar-header h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
}

.nav-section {
    margin-bottom: 2rem;
}

.nav-title {
    padding: 0 2rem 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    opacity: 0.7;
    letter-spacing: 1px;
}

.nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-item {
    margin: 0.25rem 0;
}

.nav-item a {
    display: flex;
    align-items: center;
    padding: 0.75rem 2rem;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
}

.nav-item a:hover,
.nav-item.active a {
    background: rgba(255,255,255,0.1);
    transform: translateX(5px);
}

.nav-item a i:first-child {
    width: 20px;
    margin-right: 1rem;
}

.nav-item a span {
    flex: 1;
}

.nav-item a .arrow {
    font-size: 0.75rem;
    opacity: 0.7;
}

/* Main Content */
.admin-main {
    flex: 1;
    margin-left: 280px;
    padding: 2rem;
}

.main-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.main-header h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

/* Statistics Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.stat-icon {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.stat-content h3 {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 0.5rem 0;
}

.stat-content p {
    color: #718096;
    margin: 0;
    font-weight: 500;
}

.stat-progress {
    margin-top: 1rem;
    height: 4px;
    background: #e2e8f0;
    border-radius: 2px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
    transition: width 0.3s ease;
}

/* Charts Section */
.charts-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.chart-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.chart-card h4 {
    margin: 0 0 1.5rem 0;
    color: #2d3748;
    font-weight: 600;
}

.chart-bars {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.chart-bar {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.chart-bar span:first-child {
    width: 80px;
    font-size: 0.875rem;
    color: #718096;
}

.bar-container {
    flex: 1;
    height: 8px;
    background: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
}

.bar {
    height: 100%;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    border-radius: 4px;
    transition: width 0.3s ease;
}

.chart-bar span:last-child {
    width: 40px;
    text-align: right;
    font-size: 0.875rem;
    color: #718096;
    font-weight: 600;
}

/* Map */
.map-container {
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.vietnam-map {
    width: 150px;
    height: 150px;
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.map-region {
    position: absolute;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 50%;
}

.map-region.north {
    width: 60px;
    height: 60px;
    top: 20px;
    left: 45px;
}

.map-region.central {
    width: 80px;
    height: 80px;
    top: 35px;
    left: 35px;
}

.map-region.south {
    width: 100px;
    height: 100px;
    top: 25px;
    left: 25px;
}

.map-dots {
    position: absolute;
    width: 100%;
    height: 100%;
}

.dot {
    position: absolute;
    width: 8px;
    height: 8px;
    background: #ff6b6b;
    border-radius: 50%;
    border: 2px solid white;
}

/* Bottom Section */
.bottom-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.timeline-card,
.todo-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.timeline-card h4,
.todo-card h4 {
    margin: 0 0 1.5rem 0;
    color: #2d3748;
    font-weight: 600;
}

/* Timeline */
.timeline {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.timeline-marker {
    width: 12px;
    height: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    margin-top: 0.25rem;
    flex-shrink: 0;
}

.timeline-content {
    flex: 1;
}

.timeline-content .time {
    font-size: 0.75rem;
    color: #718096;
    font-weight: 500;
}

.timeline-content p {
    margin: 0.25rem 0 0 0;
    color: #2d3748;
    font-size: 0.875rem;
}

/* Todo */
.todo-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.todo-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.todo-item input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #667eea;
}

.todo-item label {
    flex: 1;
    font-size: 0.875rem;
    color: #2d3748;
    cursor: pointer;
}

.todo-item input[type="checkbox"]:checked + label {
    text-decoration: line-through;
    color: #718096;
}

.todo-input {
    display: flex;
    gap: 0.5rem;
}

.todo-input input {
    flex: 1;
    padding: 0.5rem 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.875rem;
}

.todo-input button {
    padding: 0.5rem 0.75rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.todo-input button:hover {
    transform: scale(1.05);
}

/* Responsive */
@media (max-width: 1024px) {
    .admin-sidebar {
        width: 250px;
    }
    .admin-main {
        margin-left: 250px;
    }
    .charts-section,
    .bottom-section {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .admin-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    .admin-main {
        margin-left: 0;
    }
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Add some interactive effects
document.addEventListener('DOMContentLoaded', function() {
    // Animate progress bars
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 500);
    });

    // Animate chart bars
    const chartBars = document.querySelectorAll('.bar');
    chartBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 800);
    });

    // Todo functionality
    const todoInput = document.querySelector('.todo-input input');
    const todoButton = document.querySelector('.todo-input button');
    const todoList = document.querySelector('.todo-list');

    function addTodo() {
        const text = todoInput.value.trim();
        if (text) {
            const todoItem = document.createElement('div');
            todoItem.className = 'todo-item';
            todoItem.innerHTML = `
                <input type="checkbox" id="todo${Date.now()}">
                <label for="todo${Date.now()}">${text}</label>
            `;
            todoList.appendChild(todoItem);
            todoInput.value = '';
        }
    }

    todoButton.addEventListener('click', addTodo);
    todoInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            addTodo();
        }
    });
});
</script>
@endsection
