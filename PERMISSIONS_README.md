# Hệ Thống Phân Quyền Admin

## Tổng quan
Hệ thống phân quyền cho phép admin chính kiểm soát quyền truy cập của từng admin trong hệ thống.

## Các quyền có sẵn

### 1. Quản lý đơn hàng
- **`orders_view`** - Xem đơn hàng
- **`orders_edit`** - Chỉnh sửa trạng thái đơn hàng  
- **`orders_delete`** - Xóa đơn hàng

### 2. Quản lý sản phẩm
- **`products_manage`** - Quản lý sản phẩm (thêm, sửa, xóa)

### 3. Quản lý danh mục
- **`categories_manage`** - Quản lý danh mục sản phẩm

### 4. Quản lý banner
- **`banners_manage`** - Quản lý banner trang chủ

### 5. Quản lý người dùng
- **`users_manage`** - Quản lý tài khoản người dùng

### 6. Quản lý quyền
- **`permissions_manage`** - Quản lý quyền của các admin khác

## Cách sử dụng

### 1. Truy cập trang quản lý quyền
- Vào Admin Panel → **Quản Lý Quyền**
- Hoặc truy cập trực tiếp: `/admin/permissions`

### 2. Chỉnh sửa quyền cho admin
- Click nút **"Chỉnh sửa quyền"** trên admin cần thay đổi
- Chọn/bỏ chọn các quyền mong muốn
- Click **"Cập nhật quyền"**

### 3. Kiểm tra quyền trong code
```php
// Kiểm tra quyền cụ thể
if (AdminPermission::hasPermission(auth()->id(), 'orders_edit')) {
    // Admin có quyền chỉnh sửa đơn hàng
}

// Lấy tất cả quyền của user
$permissions = AdminPermission::getUserPermissions(auth()->id());
```

## Cài đặt

### 1. Chạy migration
```bash
php artisan migrate
```

### 2. Chạy seeder
```bash
php artisan db:seed --class=AdminPermissionSeeder
```

### 3. Kiểm tra quyền trong controller
```php
// Thêm middleware vào controller
public function __construct()
{
    $this->middleware('auth');
    $this->middleware('admin');
    // Kiểm tra quyền cụ thể
    $this->middleware('permission:orders_edit');
}
```

## Ví dụ thực tế

### Admin chỉ có quyền xem đơn hàng
- Có thể xem danh sách đơn hàng
- Không thể chỉnh sửa trạng thái
- Không thể xóa đơn hàng

### Admin có quyền đầy đủ
- Xem, chỉnh sửa, xóa đơn hàng
- Quản lý sản phẩm, danh mục, banner
- Quản lý quyền của admin khác

## Bảo mật
- Chỉ admin có quyền `permissions_manage` mới có thể thay đổi quyền
- Quyền được kiểm tra ở cả frontend và backend
- Sử dụng middleware để bảo vệ các route

## Lưu ý
- Khi tạo admin mới, cần chạy seeder để cấp quyền mặc định
- Có thể tùy chỉnh thêm quyền mới trong `PermissionController`
- Backup database trước khi thay đổi quyền quan trọng



