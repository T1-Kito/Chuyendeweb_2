@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard')
@section('page-description', 'Tổng quan hệ thống')

@section('content')
    @php
        // Tính toán giá trị tối đa để normalize progress bars
        $stats = [
            'products' => $totalProducts ?? 0,
            'users' => $totalUsers ?? 0,
            'orders' => $totalOrders ?? 0,
            'rentals' => $totalRentals ?? 0,
        ];
        $maxStat = max($stats) ?: 1;

        // Helper function để format số
        $formatNumber = function($value) {
            return number_format($value, 0, ',', '.');
        };

        // Helper function để tính progress percentage
        $getProgress = function($value, $max) {
            return min(100, ($value / $max) * 100);
        };
    @endphp

    {{-- Hàng 1: tổng quan đối tượng --}}
    <div class="ad-stats-grid">
        <div class="ad-stat-card" data-value="{{ $stats['products'] }}">
            <div class="ad-stat-icon"><i class="fas fa-box"></i></div>
            <div class="ad-stat-content">
                <h3>{{ $formatNumber($stats['products']) }}</h3>
                <p>Tổng Sản Phẩm</p>
            </div>
            <div class="ad-stat-progress">
                <div class="ad-progress-bar" data-width="{{ $getProgress($stats['products'], $maxStat) }}"></div>
            </div>
        </div>

        <div class="ad-stat-card" data-value="{{ $stats['users'] }}">
            <div class="ad-stat-icon"><i class="fas fa-users"></i></div>
            <div class="ad-stat-content">
                <h3>{{ $formatNumber($stats['users']) }}</h3>
                <p>Người Dùng</p>
            </div>
            <div class="ad-stat-progress">
                <div class="ad-progress-bar" data-width="{{ $getProgress($stats['users'], $maxStat) }}"></div>
            </div>
        </div>

        <div class="ad-stat-card" data-value="{{ $stats['orders'] }}">
            <div class="ad-stat-icon"><i class="fas fa-shopping-cart"></i></div>
            <div class="ad-stat-content">
                <h3>{{ $formatNumber($stats['orders']) }}</h3>
                <p>Tổng Đơn Hàng</p>
            </div>
            <div class="ad-stat-progress">
                <div class="ad-progress-bar" data-width="{{ $getProgress($stats['orders'], $maxStat) }}"></div>
            </div>
        </div>

        <div class="ad-stat-card" data-value="{{ $stats['rentals'] }}">
            <div class="ad-stat-icon"><i class="fas fa-file-contract"></i></div>
            <div class="ad-stat-content">
                <h3>{{ $formatNumber($stats['rentals']) }}</h3>
                <p>Tổng Đơn Thuê</p>
            </div>
            <div class="ad-stat-progress">
                <div class="ad-progress-bar" data-width="{{ $getProgress($stats['rentals'], $maxStat) }}"></div>
            </div>
        </div>
    </div>

    {{-- Hàng 2: doanh thu & đơn theo thời gian --}}
    @php
        $revenueStats = [
            'revenue' => $totalRevenue ?? 0,
            'today' => $ordersToday ?? 0,
            'month' => $ordersThisMonth ?? 0,
            'views' => $totalViews ?? 0,
        ];
        $maxRevenueStat = max($revenueStats) ?: 1;
    @endphp

    <div class="ad-stats-grid ad-stats-grid--secondary">
        <div class="ad-stat-card" data-value="{{ $revenueStats['revenue'] }}">
            <div class="ad-stat-icon"><i class="fas fa-coins"></i></div>
            <div class="ad-stat-content">
                <h3>{{ $formatNumber($revenueStats['revenue']) }} ₫</h3>
                <p>Doanh Thu Tổng (Orders + Rentals)</p>
            </div>
            <div class="ad-stat-progress">
                <div class="ad-progress-bar" data-width="{{ $getProgress($revenueStats['revenue'], $maxRevenueStat) }}"></div>
            </div>
        </div>

        <div class="ad-stat-card" data-value="{{ $revenueStats['today'] }}">
            <div class="ad-stat-icon"><i class="fas fa-calendar-day"></i></div>
            <div class="ad-stat-content">
                <h3>{{ $formatNumber($revenueStats['today']) }}</h3>
                <p>Đơn Hàng Hôm Nay</p>
            </div>
            <div class="ad-stat-progress">
                <div class="ad-progress-bar" data-width="{{ $getProgress($revenueStats['today'], $maxRevenueStat) }}"></div>
            </div>
        </div>

        <div class="ad-stat-card" data-value="{{ $revenueStats['month'] }}">
            <div class="ad-stat-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="ad-stat-content">
                <h3>{{ $formatNumber($revenueStats['month']) }}</h3>
                <p>Đơn Hàng Tháng Này</p>
            </div>
            <div class="ad-stat-progress">
                <div class="ad-progress-bar" data-width="{{ $getProgress($revenueStats['month'], $maxRevenueStat) }}"></div>
            </div>
        </div>

        <div class="ad-stat-card" data-value="{{ $revenueStats['views'] }}">
            <div class="ad-stat-icon"><i class="fas fa-eye"></i></div>
            <div class="ad-stat-content">
                <h3>{{ $formatNumber($revenueStats['views']) }}</h3>
                <p>Lượt Xem (Mock)</p>
            </div>
            <div class="ad-stat-progress">
                <div class="ad-progress-bar" data-width="{{ $getProgress($revenueStats['views'], $maxRevenueStat) }}"></div>
            </div>
        </div>
    </div>

    {{-- Biểu đồ đơn hàng 7 ngày gần nhất + doanh thu --}}
    @php
        $ordersByDay = $ordersByDay ?? [];
        $maxOrders = !empty($ordersByDay) ? collect($ordersByDay)->max('total_orders') : 0;
        $maxOrders = $maxOrders ?: 1;
        $maxRevenue = !empty($ordersByDay) ? collect($ordersByDay)->max('total_revenue') : 0;
        $maxRevenue = $maxRevenue ?: 1;
    @endphp

    <div class="ad-charts-grid">
        <div class="ad-chart-card">
            <h4>Đơn Hàng 7 Ngày Gần Nhất</h4>
            <div class="ad-chart-bars">
                @forelse($ordersByDay as $day)
                    @php
                        $orderCount = (int) ($day['total_orders'] ?? 0);
                        $orderPercentage = ($orderCount / $maxOrders) * 100;
                    @endphp
                    <div class="ad-chart-row">
                        <span class="ad-chart-label">{{ $day['date'] ?? '' }}</span>
                        <div class="ad-chart-bar-wrapper">
                            <div class="ad-chart-bar"
                                 data-width="{{ $orderPercentage }}"
                                 style="width: {{ $orderPercentage }}%"></div>
                        </div>
                        <span class="ad-chart-value">{{ $formatNumber($orderCount) }}</span>
                    </div>
                @empty
                    <div class="ad-chart-empty">
                        <i class="fas fa-chart-line text-muted mb-2"></i>
                        <p class="text-muted mb-0">Chưa có dữ liệu đơn hàng.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="ad-chart-card">
            <h4>Doanh Thu 7 Ngày Gần Nhất</h4>
            <div class="ad-chart-bars">
                @forelse($ordersByDay as $day)
                    @php
                        $revenue = (float) ($day['total_revenue'] ?? 0);
                        $revenuePercentage = ($revenue / $maxRevenue) * 100;
                    @endphp
                    <div class="ad-chart-row">
                        <span class="ad-chart-label">{{ $day['date'] ?? '' }}</span>
                        <div class="ad-chart-bar-wrapper">
                            <div class="ad-chart-bar"
                                 data-width="{{ $revenuePercentage }}"
                                 style="width: {{ $revenuePercentage }}%"></div>
                        </div>
                        <span class="ad-chart-value">{{ $revenue > 0 ? $formatNumber($revenue) . ' ₫' : '0 ₫' }}</span>
                    </div>
                @empty
                    <div class="ad-chart-empty">
                        <i class="fas fa-chart-line text-muted mb-2"></i>
                        <p class="text-muted mb-0">Chưa có dữ liệu doanh thu.</p>
                    </div>
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

        .ad-stats-grid--secondary {
            margin-top: 1rem;
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
            width: 80px;
            text-align: right;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .ad-chart-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }

        .ad-chart-empty i {
            font-size: 2rem;
            opacity: 0.5;
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
            // Animate progress bars với data attributes
            const progressBars = document.querySelectorAll('.ad-progress-bar[data-width]');
            progressBars.forEach((bar, index) => {
                const targetWidth = bar.getAttribute('data-width') + '%';
                bar.style.width = '0%';
                bar.style.transition = 'width 0.6s ease';

                // Stagger animation
                setTimeout(() => {
                    bar.style.width = targetWidth;
                }, 100 + (index * 50));
            });

            // Animate chart bars
            const chartBars = document.querySelectorAll('.ad-chart-bar[data-width]');
            chartBars.forEach((bar, index) => {
                const targetWidth = bar.getAttribute('data-width') + '%';
                bar.style.width = '0%';
                bar.style.transition = 'width 0.8s cubic-bezier(0.4, 0, 0.2, 1)';

                setTimeout(() => {
                    bar.style.width = targetWidth;
                }, 200 + (index * 80));
            });
        });
    </script>
@endsection
