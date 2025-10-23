<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AdminPermission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        // Chỉ admin có quyền permissions_manage mới có thể truy cập
        $this->middleware('permission:permissions_manage');
    }

    /**
     * Display the permissions management page
     */
    public function index()
    {
        // Kiểm tra quyền quản lý quyền
        if (!\App\Helpers\PermissionHelper::hasPermission('permissions_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }
        
        $users = User::where('is_admin', true)->with('adminPermissions')->get();
        $permissions = [
            'orders_view' => 'Xem đơn hàng',
            'orders_edit' => 'Chỉnh sửa đơn hàng',
            'orders_delete' => 'Xóa đơn hàng',
            'products_manage' => 'Quản lý sản phẩm',
            'categories_manage' => 'Quản lý danh mục',
            'banners_manage' => 'Quản lý banner',
            'users_manage' => 'Quản lý người dùng',
            'permissions_manage' => 'Quản lý quyền',
        ];

        return view('admin.permissions.index', compact('users', 'permissions'));
    }

    /**
     * Update user permissions
     */
    public function update(Request $request)
    {
        // Kiểm tra quyền quản lý quyền
        if (!\App\Helpers\PermissionHelper::hasPermission('permissions_manage')) {
            return back()->with('error', 'Bạn không có quyền thực hiện thao tác này!');
        }
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permissions' => 'array',
            'permissions.*' => 'string'
        ]);

        $userId = $request->user_id;
        $permissions = $request->permissions ?? [];

        // Get all available permissions
        $allPermissions = [
            'orders_view', 'orders_edit', 'orders_delete',
            'products_manage', 'categories_manage', 'banners_manage',
            'users_manage', 'permissions_manage'
        ];

        // Update permissions for the user
        try {
            foreach ($allPermissions as $permission) {
                if (in_array($permission, $permissions)) {
                    AdminPermission::grantPermission($userId, $permission);
                } else {
                    AdminPermission::revokePermission($userId, $permission);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Permission update error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }

        return back()->with('status', 'Cập nhật quyền thành công');
    }

    /**
     * Update specific user permissions (from user detail page)
     */
    public function updateUserPermissions(Request $request, $userId)
    {
        // Kiểm tra quyền quản lý quyền
        if (!\App\Helpers\PermissionHelper::hasPermission('permissions_manage')) {
            return back()->with('error', 'Bạn không có quyền thực hiện thao tác này!');
        }
        
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'string'
        ]);
        // Kiểm tra người dùng còn tồn tại
        $user = User::find($userId);
        if (!$user) {
            return back()->with('error', 'Người dùng này đã bị xóa. Vui lòng tải lại trang để cập nhật dữ liệu.');
        }

        $permissions = $request->permissions ?? [];

        // Get all available permissions
        $allPermissions = [
            'orders_view', 'orders_edit', 'orders_delete',
            'products_manage', 'categories_manage', 'banners_manage',
            'users_manage', 'permissions_manage'
        ];

        // Update permissions for the user
        try {
            foreach ($allPermissions as $permission) {
                if (in_array($permission, $permissions)) {
                    AdminPermission::grantPermission($userId, $permission);
                } else {
                    AdminPermission::revokePermission($userId, $permission);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Permission update error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }

        return back()->with('status', 'Cập nhật quyền thành công');
    }

    /**
     * Get user permissions (for AJAX)
     */
    public function getUserPermissions($userId)
    {
        // Kiểm tra quyền quản lý quyền
        if (!\App\Helpers\PermissionHelper::hasPermission('permissions_manage')) {
            return response()->json(['error' => 'Bạn không có quyền thực hiện thao tác này!'], 403);
        }
        
        try {
            $user = User::find($userId);
            if (!$user) {
                return response()->json(['error' => 'Người dùng này đã bị xóa. Vui lòng tải lại trang.'], 404);
            }
            $permissions = $user->getPermissions();
            return response()->json($permissions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
