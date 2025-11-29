<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Rental;
use App\Models\Order;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $this->ensureAdmin();
        
        // Kiểm tra quyền để hiển thị thống kê
        $user = auth()->user();
        $userPermissions = $user->getPermissions();
        
        $totalProducts = in_array('products_manage', $userPermissions) ? Product::count() : 0;
        $totalCategories = in_array('categories_manage', $userPermissions) ? Category::count() : 0;
        $totalUsers = in_array('users_manage', $userPermissions) ? User::count() : 0;
        $totalViews = 1250; // Mock data for now

        // Đơn hàng và thuê
        $totalOrders = in_array('orders_view', $userPermissions) ? Order::count() : 0;
        $totalRentals = in_array('orders_view', $userPermissions) ? Rental::count() : 0;

        // Doanh thu tổng từ orders và rentals
        $totalOrderRevenue = in_array('orders_view', $userPermissions) ? (float) Order::sum('total_amount') : 0.0;
        $totalRentalRevenue = in_array('orders_view', $userPermissions) ? (float) Rental::sum('total_amount') : 0.0;
        $totalRevenue = $totalOrderRevenue + $totalRentalRevenue;

        // Đơn trong ngày và trong tháng (tính theo bảng orders)
        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();

        $ordersToday = in_array('orders_view', $userPermissions)
            ? Order::whereDate('created_at', $today)->count()
            : 0;

        $ordersThisMonth = in_array('orders_view', $userPermissions)
            ? Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count()
            : 0;

        // Dữ liệu biểu đồ: đơn hàng theo ngày 7 ngày gần nhất
        $ordersByDay = [];
        if (in_array('orders_view', $userPermissions)) {
            $fromDate = Carbon::today()->subDays(6)->startOfDay();
            $rawData = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total_orders, SUM(total_amount) as total_revenue')
                ->where('created_at', '>=', $fromDate)
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Chuẩn hoá về mảng liên tục 7 ngày
            $cursor = $fromDate->copy();
            $indexed = $rawData->keyBy(function ($row) {
                return Carbon::parse($row->date)->toDateString();
            });

            for ($i = 0; $i < 7; $i++) {
                $dateKey = $cursor->toDateString();
                $row = $indexed->get($dateKey);

                $ordersByDay[] = [
                    'date' => $cursor->format('d/m'),
                    'total_orders' => $row ? (int) $row->total_orders : 0,
                    'total_revenue' => $row ? (float) $row->total_revenue : 0.0,
                ];

                $cursor->addDay();
            }
        }
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalUsers',
            'totalViews',
            'userPermissions',
            'totalOrders',
            'totalRentals',
            'totalRevenue',
            'ordersToday',
            'ordersThisMonth',
            'ordersByDay'
        ));
    }
}
