@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard')
@section('page-description', 'Tổng quan hệ thống')

@section('content')
    {{-- Hàng 1: tổng quan đối tượng --}}
    <div class="ad-stats-grid">
            <div class="ad-stat-card">
                <div class="ad-stat-icon"><i class="fas fa-box"></i></div>
                <div class="ad-stat-content">
                    <h3>{{ $totalProducts ?? 0 }}</h3>
                    <p>Tổng Sản Phẩm</p>
                </div>
                <div class="ad-stat-progress"><div class="ad-progress-bar" style="width:75%"></div></div>
            </div>

            <div class="ad-stat-card">
                <div class="ad-stat-icon"><i class="fas fa-users"></i></div>
                <div class="ad-stat-content">
                    <h3>{{ $totalUsers ?? 0 }}</h3>
                    <p>Người Dùng</p>
                </div>
                <div class="ad-stat-progress"><div class="ad-progress-bar" style="width:90%"></div></div>
            </div>

        <div class="ad-stat-card">
            <div class="ad-stat-icon"><i class="fas fa-shopping-cart"></i></div>
            <div class="ad-stat-content">
                <h3>{{ $totalOrders ?? 0 }}</h3>
                <p>Tổng Đơn Hàng</p>
            </div>
            <div class="ad-stat-progress"><div class="ad-progress-bar" style="width:80%"></div></div>
        </div>

        <div class="ad-stat-card">
            <div class="ad-stat-icon"><i class="fas fa-file-contract"></i></div>
            <div class="ad-stat-content">
                <h3>{{ $totalRentals ?? 0 }}</h3>
                <p>Tổng Đơn Thuê</p>
            </div>
            <div class="ad-stat-progress"><div class="ad-progress-bar" style="width:70%"></div></div>
        </div>
    </div>

    {{-- Hàng 2: doanh thu & đơn theo thời gian --}}
    <div class="ad-stats-grid" style="margin-top:1rem;">
        <div class="ad-stat-card">
            <div class="ad-stat-icon"><i class="fas fa-coins"></i></div>
            <div class="ad-stat-content">
                <h3>{{ number_format($totalRevenue ?? 0, 0, ',', '.') }} ₫</h3>
                <p>Doanh Thu Tổng (Orders + Rentals)</p>
            </div>
            <div class="ad-stat-progress"><div class="ad-progress-bar" style="width:85%"></div></div>
        </div>

        <div class="ad-stat-card">
            <div class="ad-stat-icon"><i class="fas fa-calendar-day"></i></div>
            <div class="ad-stat-content">
                <h3>{{ $ordersToday ?? 0 }}</h3>
                <p>Đơn Hàng Hôm Nay</p>
            </div>
            <div class="ad-stat-progress"><div class="ad-progress-bar" style="width:60%"></div></div>
        </div>

        <div class="ad-stat-card">
            <div class="ad-stat-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="ad-stat-content">
                <h3>{{ $ordersThisMonth ?? 0 }}</h3>
                <p>Đơn Hàng Tháng Này</p>
            </div>
            <div class="ad-stat-progress"><div class="ad-progress-bar" style="width:65%"></div></div>
        </div>

        <div class="ad-stat-card">
            <div class="ad-stat-icon"><i class="fas fa-eye"></i></div>
            <div class="ad-stat-content">
                <h3>{{ $totalViews ?? 0 }}</h3>
                <p>Lượt Xem (Mock)</p>
            </div>
            <div class="ad-stat-progress"><div class="ad-progress-bar" style="width:50%"></div></div>
        </div>
    </div>

    {{-- Biểu đồ đơn hàng 7 ngày gần nhất + doanh thu --}}
    <div class="ad-charts-grid">
        <div class="ad-chart-card">
            <h4>Đơn Hàng 7 Ngày Gần Nhất</h4>
            @php
                $maxOrders = !empty($ordersByDay ?? []) ? collect($ordersByDay)->max('total_orders') : 0;
                $maxOrders = $maxOrders ?: 1;
            @endphp
            <div class="ad-chart-bars">
                @forelse($ordersByDay ?? [] as $day)
                    <div class="ad-chart-row">
                        <span class="ad-chart-label">{{ $day['date'] }}</span>
                        <div class="ad-chart-bar-wrapper">
                            <div class="ad-chart-bar" style="width: {{ ($day['total_orders'] / $maxOrders) * 100 }}%"></div>
                        </div>
                        <span class="ad-chart-value">{{ $day['total_orders'] }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">Chưa có dữ liệu đơn hàng.</p>
                @endforelse
            </div>
        </div>

        <div class="ad-chart-card">
            <h4>Doanh Thu 7 Ngày Gần Nhất</h4>
            @php
                $maxRevenue = !empty($ordersByDay ?? []) ? collect($ordersByDay)->max('total_revenue') : 0;
                $maxRevenue = $maxRevenue ?: 1;
            @endphp
            <div class="ad-chart-bars">
                @forelse($ordersByDay ?? [] as $day)
                    <div class="ad-chart-row">
                        <span class="ad-chart-label">{{ $day['date'] }}</span>
                        <div class="ad-chart-bar-wrapper">
                            <div class="ad-chart-bar" style="width: {{ ($day['total_revenue'] / $maxRevenue) * 100 }}%"></div>
                        </div>
                        <span class="ad-chart-value">{{ $day['total_revenue'] ? number_format($day['total_revenue'], 0, ',', '.') : 0 }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">Chưa có dữ liệu doanh thu.</p>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .ad-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .ad-stat-card {
            background: #fff;
            border-radius: 15px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.06);
            position: relative;
            overflow: hidden;
        }

        .ad-stat-icon {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .ad-stat-content h3 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0 0 .25rem;
        }

        .ad-stat-content p {
            margin: 0;
            color: #6b7280;
            font-weight: 500;
        }

        .ad-stat-progress {
            margin-top: .9rem;
            height: 4px;
            background: #e5e7eb;
            border-radius: 999px;
            overflow: hidden;
        }

        .ad-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
        }

        .ad-charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .ad-chart-card {
            background: #fff;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.06);
        }

        .ad-chart-card h4 {
            margin: 0 0 1rem;
            font-weight: 600;
        }

        /* Biểu đồ dọc cho Đơn Hàng */
        .ad-chart-vertical {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: .75rem;
            height: 180px;
            padding-bottom: .25rem;
        }

        .ad-chart-v-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .3rem;
            font-size: .8rem;
        }

        .ad-chart-v-bar-wrapper {
            width: 26px;
            height: 100%;
            border-radius: 999px;
            background: #e5e7eb !important;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
        }

        .ad-chart-v-bar {
            width: 100%;
            background: linear-gradient(180deg, #6366f1, #8b5cf6) !important;
            border-radius: 999px;
            transition: height .4s ease;
        }

        .ad-chart-v-label {
            color: #6b7280;
        }

        .ad-chart-v-value {
            font-weight: 600;
        }

        /* Biểu đồ ngang cho Doanh Thu */
        .ad-chart-bars {
            display: flex;
            flex-direction: column;
            gap: .75rem;
        }

        .ad-chart-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            font-size: .9rem;
        }

        .ad-chart-label {
            width: 50px;
            color: #6b7280;
        }

        .ad-chart-bar-wrapper {
            flex: 1;
            height: 6px;
            background: #e5e7eb;
            border-radius: 999px;
            overflow: hidden;
        }

        .ad-chart-bar {
            height: 100%;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
        }

        .ad-chart-value {
            width: 60px;
            text-align: right;
            font-weight: 600;
        }

        .ad-bottom-grid {
            display: grid;
            grid-template-columns: 2fr 1.4fr;
            gap: 1.5rem;
        }

        .ad-timeline-card,
        .ad-todo-card {
            background: #fff;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.06);
        }

        .ad-timeline {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: .5rem;
        }

        .ad-timeline-item {
            display: flex;
            gap: .75rem;
        }

        .ad-timeline-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            margin-top: .2rem;
        }

        .ad-time {
            font-size: .75rem;
            color: #6b7280;
        }

        .ad-timeline-content p {
            margin: .15rem 0 0;
            font-size: .9rem;
        }

        .ad-todo-list {
            display: flex;
            flex-direction: column;
            gap: .75rem;
            margin-top: .5rem;
        }

        .ad-todo-item {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .9rem;
        }

        .ad-todo-input {
            display: flex;
            gap: .5rem;
            margin-top: 1rem;
        }

        .ad-todo-input input {
            flex: 1;
            border-radius: .5rem;
            border: 1px solid #e5e7eb;
            padding: .4rem .6rem;
            font-size: .9rem;
        }

        .ad-todo-input button {
            border-radius: .5rem;
            border: none;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            padding: .4rem .7rem;
        }

        @media (max-width: 992px) {
            .ad-charts-grid,
            .ad-bottom-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .ad-stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress bars
            const progressBars = document.querySelectorAll('.ad-progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 400);
            });
        });
    </script>
@endsection
