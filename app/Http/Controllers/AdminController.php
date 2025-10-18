<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Rental;

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
        
        return view('admin.dashboard', compact('totalProducts', 'totalCategories', 'totalUsers', 'totalViews', 'userPermissions'));
    }
}
