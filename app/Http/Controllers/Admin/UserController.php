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
    public function index(Request $request)
    {
        // Kiểm tra quyền quản lý người dùng
        if (!\App\Helpers\PermissionHelper::hasPermission('users_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }
        
        // Validate search input
        $request->validate([
            'search' => 'nullable|string|max:255',
            'role' => 'nullable|in:admin,user',
            'sort' => 'nullable|in:id,name,role,created_at'
        ]);
        
        $query = User::with('adminPermissions');
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Role filter
        if ($request->filled('role')) {
            if ($request->role === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->role === 'user') {
                $query->where('is_admin', false);
            }
        }
        
        // Sorting
        if ($request->filled('sort')) {
            $sort = $request->sort;
            switch ($sort) {
                case 'id':
                    $query->orderBy('id', 'asc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                case 'role':
                    // role maps to is_admin (admin first)
                    $query->orderBy('is_admin', 'desc');
                    break;
                case 'created_at':
                    $query->orderBy('created_at', 'asc');
                    break;
            }
        } else {
            // Default sort
            $query->orderBy('created_at', 'desc');
        }

        // Paginate and preserve query string
        $users = $query->paginate(5)->withQueryString();
        
        // Kiểm tra nếu trang không tồn tại
// Lấy tham số page từ request
$page = $request->input('page');

// Kiểm tra xem page có hợp lệ không (phải là số nguyên dương)
if ($request->has('page') && (!is_numeric($page) || $page < 1)) {
    return redirect()->route('admin.users.index', [
        'search' => $request->search,
        'role' => $request->role,
        'page' => 1
    ])->with('error', 'Giá trị trang không hợp lệ. Đã chuyển về trang đầu tiên.');
}

// Nếu page là số hợp lệ nhưng vượt quá trang cuối
if ($request->has('page') && $users->currentPage() > $users->lastPage()) {
    return redirect()->route('admin.users.index', [
        'search' => $request->search,
        'role' => $request->role,
        'page' => $users->lastPage() ?: 1
    ])->with('error', 'Trang không tồn tại. Đã chuyển về trang cuối cùng.');
}

// Hiển thị danh sách người dùng
return view('admin.users.index', compact('users'));

    }

    /**
     * Show user details and permissions
     */
    public function show($userId)
    {
        // Kiểm tra quyền quản lý người dùng
        if (!\App\Helpers\PermissionHelper::hasPermission('users_manage')) {
            return back()->with('error', 'Bạn không có quyền truy cập trang này!');
        }
        
        $user = User::find($userId);
        if (!$user) {
            return back()->with('error', 'Người dùng này đã bị xóa. Vui lòng tải lại trang để cập nhật dữ liệu.');
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
    public function toggleAdmin($userId)
    {
        // Kiểm tra quyền quản lý người dùng
        if (!\App\Helpers\PermissionHelper::hasPermission('users_manage')) {
            return back()->with('error', 'Bạn không có quyền thực hiện thao tác này!');
        }
        
        $user = User::find($userId);
        if (!$user) {
            return back()->with('error', 'Người dùng này đã bị xóa. Vui lòng tải lại trang để cập nhật dữ liệu.');
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
    public function destroy($userId)
    {
        // Kiểm tra quyền quản lý người dùng
        if (!\App\Helpers\PermissionHelper::hasPermission('users_manage')) {
            return back()->with('error', 'Bạn không có quyền thực hiện thao tác này!');
        }
        
        $user = User::find($userId);
        if (!$user) {
            return back()->with('error', 'Người dùng này đã bị xóa. Vui lòng tải lại trang để cập nhật dữ liệu.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Không thể xóa chính mình!');
        }

        $userName = $user->name;
        $user->delete();

        return back()->with('status', 'Đã xóa người dùng ' . $userName);
    }
}
