<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AdminPermission;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display the users management page
     */
    public function index()
    {
        // Kiểm tra quyền quản lý người dùng
        if (!\App\Helpers\PermissionHelper::hasPermission('users_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }
        
        $users = User::with('adminPermissions')->get();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details and permissions
     */
    public function show(User $user)
    {
        // Kiểm tra quyền quản lý người dùng
        if (!\App\Helpers\PermissionHelper::hasPermission('users_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }
        
        $userPermissions = $user->getPermissions();
        $allPermissions = [
            'orders_view' => 'Xem đơn hàng',
            'orders_edit' => 'Chỉnh sửa đơn hàng',
            'orders_delete' => 'Xóa đơn hàng',
            'products_manage' => 'Quản lý sản phẩm',
            'categories_manage' => 'Quản lý danh mục',
            'banners_manage' => 'Quản lý banner',
            'users_manage' => 'Quản lý người dùng',
            'permissions_manage' => 'Quản lý quyền',
        ];

        return view('admin.users.show', compact('user', 'userPermissions', 'allPermissions'));
    }

    /**
     * Toggle admin status
     */
    public function toggleAdmin(User $user)
    {
        // Kiểm tra quyền quản lý người dùng
        if (!\App\Helpers\PermissionHelper::hasPermission('users_manage')) {
            return back()->with('error', 'Bạn không có quyền thực hiện thao tác này!');
        }
        
        $user->update(['is_admin' => !$user->is_admin]);
        
        if ($user->is_admin) {
            // Grant all permissions to new admin
            $permissions = [
                'orders_view', 'orders_edit', 'orders_delete',
                'products_manage', 'categories_manage', 'banners_manage',
                'users_manage', 'permissions_manage'
            ];
            
            foreach ($permissions as $permission) {
                AdminPermission::grantPermission($user->id, $permission);
            }
            
            $message = 'Đã cấp quyền admin cho ' . $user->name;
        } else {
            // Revoke all permissions from user
            $user->adminPermissions()->update(['granted' => false]);
            $message = 'Đã thu hồi quyền admin từ ' . $user->name;
        }

        return back()->with('status', $message);
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        // Kiểm tra quyền quản lý người dùng
        if (!\App\Helpers\PermissionHelper::hasPermission('users_manage')) {
            return back()->with('error', 'Bạn không có quyền thực hiện thao tác này!');
        }
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Không thể xóa chính mình!');
        }

        $userName = $user->name;
        $user->delete();

        return back()->with('status', 'Đã xóa người dùng ' . $userName);
    }
}
