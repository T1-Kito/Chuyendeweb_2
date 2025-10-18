# WebChoThu - Website Cho Thuê Thiết Bị

Website cho thuê thiết bị hiện đại được xây dựng bằng Laravel với giao diện đẹp và đầy đủ tính năng.

## 🚀 Tính Năng Chính

### Frontend (Khách Hàng)
- **Trang Chủ**: Banner 3D, logo, slogan, nút CTA, tai mèo neon LED
- **Danh Sách Sản Phẩm**: Hiển thị thiết bị với bộ lọc theo giá, loại, thời hạn
- **Chi Tiết Sản Phẩm**: Mô tả đầy đủ, hình ảnh, form thuê thiết bị
- **Tài Khoản Khách Hàng**: Đăng ký/đăng nhập, lịch sử thuê, thông báo
- **Trang Liên Hệ**: Form liên hệ, Google Maps, tích hợp mạng xã hội
- **Trang Giới Thiệu**: Thông tin công ty, đội ngũ, đối tác

### Backend (Admin)
- **Quản Lý Sản Phẩm**: CRUD đầy đủ
- **Quản Lý Người Dùng**: Khách hàng & admin
- **Quản Lý Hợp Đồng Thuê**: Theo dõi trạng thái, gia hạn
- **Quản Lý Thanh Toán**: Trạng thái thanh toán, xuất hóa đơn
- **Quản Lý Bảo Hành**: Theo dõi lịch sử sửa chữa
- **Dashboard**: Thống kê doanh thu, sản phẩm hot

## 🛠️ Công Nghệ Sử Dụng

- **Backend**: Laravel 12 (PHP)
- **Database**: MySQL/MariaDB
- **Frontend**: Blade Templates + Bootstrap 5 + JavaScript
- **Styling**: CSS3 với hiệu ứng 3D và animation
- **Icons**: Font Awesome 6
- **Fonts**: Google Fonts (Inter)

## 📋 Yêu Cầu Hệ Thống

- PHP >= 8.2
- Composer
- MySQL >= 8.0 hoặc MariaDB >= 10.5
- Web Server (Apache/Nginx)
- Node.js & NPM (để build assets)

## 🚀 Cài Đặt

### 1. Clone Repository
```bash
git clone <repository-url>
cd webchothu
```

### 2. Cài Đặt Dependencies
```bash
composer install
npm install
```

### 3. Cấu Hình Môi Trường
```bash
cp .env.example .env
php artisan key:generate
```

Cập nhật file `.env` với thông tin database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webchothu
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Tạo Database
```bash
php artisan migrate:fresh --seed
```

### 5. Tạo Storage Link
```bash
php artisan storage:link
```

### 6. Build Assets (Tùy chọn)
```bash
npm run build
```

### 7. Khởi Chạy Server
```bash
php artisan serve
```

Website sẽ chạy tại: `http://localhost:8000`

## 🗄️ Cấu Trúc Database

### Bảng Chính
- **users**: Thông tin người dùng
- **categories**: Danh mục thiết bị
- **products**: Sản phẩm thiết bị
- **rentals**: Hợp đồng thuê
- **rental_items**: Chi tiết từng món trong hợp đồng

### Quan Hệ
- User có nhiều Rental
- Category có nhiều Product
- Product có nhiều RentalItem
- Rental có nhiều RentalItem

## 🎨 Giao Diện

### Thiết Kế
- **Responsive**: Tương thích mọi thiết bị
- **Modern UI**: Thiết kế hiện đại với gradient và shadow
- **Animation**: Hiệu ứng mượt mà, particles background
- **Tai Mèo**: Trang trí độc đáo theo yêu cầu

### Màu Sắc
- **Primary**: #6366f1 (Indigo)
- **Secondary**: #8b5cf6 (Purple)
- **Accent**: #f59e0b (Amber)
- **Dark**: #1f2937 (Gray)
- **Light**: #f8fafc (Gray)

## 📱 Trang Chính

### 1. Trang Chủ (`/`)
- Hero section với banner 3D
- Tính năng nổi bật
- Danh mục thiết bị
- Sản phẩm nổi bật
- Thống kê công ty

### 2. Danh Sách Sản Phẩm (`/products`)
- Grid hiển thị sản phẩm
- Bộ lọc theo danh mục, giá, thời hạn
- Phân trang
- Tìm kiếm nhanh

### 3. Chi Tiết Sản Phẩm (`/products/{slug}`)
- Thông tin chi tiết
- Hình ảnh sản phẩm
- Bảng giá theo ngày/tuần/tháng
- Form đăng ký thuê
- Sản phẩm liên quan

### 4. Trang Giới Thiệu (`/about`)
- Câu chuyện công ty
- Tầm nhìn & sứ mệnh
- Đội ngũ
- Đối tác & khách hàng

### 5. Trang Liên Hệ (`/contact`)
- Thông tin liên hệ
- Form gửi tin nhắn
- Google Maps
- Mạng xã hội
- FAQ

## 🔐 Xác Thực & Phân Quyền

### Khách Hàng
- Đăng ký tài khoản
- Đăng nhập/đăng xuất
- Xem lịch sử thuê
- Quản lý thông tin cá nhân

### Admin
- Quản lý toàn bộ hệ thống
- CRUD sản phẩm, danh mục
- Quản lý đơn thuê
- Thống kê báo cáo

## 📊 Seeder Data

Website đã có sẵn dữ liệu mẫu:
- 4 danh mục thiết bị
- 4 sản phẩm mẫu
- 1 tài khoản test

## 🚀 Triển Khai Production

### 1. Cấu Hình Production
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 2. Tối Ưu Hóa
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

### 3. Bảo Mật
- Cập nhật file `.env` với thông tin production
- Cấu hình HTTPS
- Thiết lập firewall
- Backup database định kỳ

## 🐛 Troubleshooting

### Lỗi Thường Gặp
1. **Permission denied**: Chạy `chmod -R 775 storage bootstrap/cache`
2. **Class not found**: Chạy `composer dump-autoload`
3. **Database connection**: Kiểm tra thông tin database trong `.env`

### Log Files
- Laravel logs: `storage/logs/laravel.log`
- Web server logs: `/var/log/apache2/` hoặc `/var/log/nginx/`

## 🤝 Đóng Góp

1. Fork project
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Mở Pull Request

## 📄 License

Dự án này được phân phối dưới giấy phép MIT. Xem file `LICENSE` để biết thêm chi tiết.

## 📞 Hỗ Trợ

Nếu có vấn đề hoặc câu hỏi, vui lòng:
- Tạo issue trên GitHub
- Liên hệ qua email: support@webchothu.com
- Gọi hotline: 0123 456 789

## 🙏 Cảm Ơn

Cảm ơn bạn đã sử dụng WebChoThu! Chúng tôi hy vọng website này sẽ giúp ích cho việc kinh doanh của bạn.

---

**WebChoThu** - Cho Thuê Thiết Bị Chất Lượng 🚀
