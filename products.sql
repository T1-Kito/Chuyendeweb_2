-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th10 21, 2025 lúc 02:32 PM
-- Phiên bản máy phục vụ: 8.0.43-cll-lve
-- Phiên bản PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `agajcvso_webthue`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `features` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `daily_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `weekly_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `monthly_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stock_quantity` int NOT NULL DEFAULT '0',
  `status` enum('available','rented','maintenance') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `min_rental_months` int NOT NULL DEFAULT '6' COMMENT 'Số tháng thuê tối thiểu',
  `price_6_months` decimal(12,2) DEFAULT NULL COMMENT 'Giá thuê 6 tháng',
  `price_1_month` decimal(10,2) DEFAULT NULL,
  `price_12_months` decimal(12,2) DEFAULT NULL COMMENT 'Giá thuê 12 tháng',
  `price_18_months` decimal(12,2) DEFAULT NULL COMMENT 'Giá thuê 18 tháng',
  `price_24_months` decimal(12,2) DEFAULT NULL COMMENT 'Giá thuê 24 tháng',
  `promotion_badge` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Badge khuyến mãi (Ưu đãi -10%, Sản phẩm nổi bật, etc.)',
  `promotion_description` text COLLATE utf8mb4_unicode_ci COMMENT 'Mô tả chi tiết khuyến mãi',
  `promotion_start_date` date DEFAULT NULL COMMENT 'Ngày bắt đầu khuyến mãi',
  `promotion_end_date` date DEFAULT NULL COMMENT 'Ngày kết thúc khuyến mãi',
  `warranty_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Thông tin bảo hành',
  `has_warranty_support` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Có hỗ trợ bảo hành',
  `rental_terms` text COLLATE utf8mb4_unicode_ci COMMENT 'Điều khoản thuê',
  `delivery_info` text COLLATE utf8mb4_unicode_ci COMMENT 'Thông tin giao hàng',
  `specs` longtext COLLATE utf8mb4_unicode_ci,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `features`, `image`, `slug`, `category_id`, `daily_price`, `weekly_price`, `monthly_price`, `stock_quantity`, `status`, `is_featured`, `is_active`, `created_at`, `updated_at`, `min_rental_months`, `price_6_months`, `price_1_month`, `price_12_months`, `price_18_months`, `price_24_months`, `promotion_badge`, `promotion_description`, `promotion_start_date`, `promotion_end_date`, `warranty_info`, `has_warranty_support`, `rental_terms`, `delivery_info`, `specs`, `serial_number`, `model`) VALUES
(11, 'K14 Pro', 'K14 Pro is a fingerprint Time & Attendance Terminal. The 2.8-inch TFT screen can display more information \r\nvividly, including fingerprint images and verification results, etc. TCP/IP communication is a standard function \r\nthat ensures smooth data transmission between the terminal and PC within several seconds. And the USB \r\nHost makes data management extremely easy. With an elegant appearance and reliable quality, you can get \r\nthe best from it', 'Features\r\n • TCP/IP, USB Host \r\n• Multi-Languages \r\n• Short Keys to select the IN or OUT status\r\n • Built-in SSR Excel Software (optional) \r\n• Schedule bell', '/storage/products/7QdmX5u7DWFa75k6jWXPO4yVqNGJZpNkfZuPLbZ7.jpg', 'k14-pro', 1, 0.00, 0.00, 0.00, 100, 'available', 1, 1, '2025-08-25 20:43:34', '2025-10-02 07:36:10', 6, 900000.00, 150000.00, 1800000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'Hiển thị\r\n\r\nMàn hình: 2.8-inch TFT\r\n\r\nDung lượng lưu trữ\r\n\r\nVân tay: 3,000\r\n\r\nThẻ: 3,000 (hoặc SSR: 1,000)\r\n\r\nGiao dịch: 200,000\r\n\r\nGiao tiếp\r\n\r\nKết nối: TCP/IP, USB-host\r\n\r\nChức năng chuẩn\r\n\r\nWorkcode\r\n\r\nSMS\r\n\r\nDST (Daylight Saving Time)\r\n\r\nTruy vấn bản ghi (Record Query)\r\n\r\nTự động chuyển trạng thái (Automatic status switch)\r\n\r\nChuông báo lịch trình (Schedule bell)\r\n\r\nNhập liệu T9\r\n\r\nHỗ trợ User ID 9 ký tự\r\n\r\nChức năng tùy chọn\r\n\r\nCông tắc (Switch)\r\n\r\nIC Card / ID Card\r\n\r\nPhoto ID\r\n\r\nSSR Excel (Built-in phần mềm, tùy chọn)\r\n\r\nADMS\r\n\r\nDNS\r\n\r\nWebserver\r\n\r\nNguồn điện\r\n\r\nNguồn cấp: DC 5V / 800mA\r\n\r\nMôi trường hoạt động\r\n\r\nNhiệt độ: 0°C ~ 45°C\r\n\r\nĐộ ẩm: 20% ~ 80%\r\n\r\nKích thước\r\n\r\nKích thước (D × R × C): 183.8 × 136 × 47.76 mm\r\n\r\nPhần mềm (tùy chọn)\r\n\r\nBuilt-in SSR Excel Software\r\n\r\nChuông báo (Schedule bell)', NULL, 'ZKTeco'),
(12, 'MB20-VL', 'Linux-Based Hybrid Biometric \r\nTime & Attendance and Access Control Terminal  \r\nwith Visible Light Facial Recognition', 'MB20-VL is a touchless multi-biometric identification terminal featuring ZKTeco’s innovative Visible Light Facial \r\nRecognition technology. \r\nWith the latest algorithm and Visible Light facial recognition technologies, the device can recognize a target in the \r\ndistance from 30cm to 50cm. It will automatically operate when it detects a human face in the detection distance  \r\nto deliver better recognition quality in terms of speed and accuracy than the previous near-infrared facial  \r\nrecognition terminals.\r\n With the applied Deep Learning algorithm, the pose angle tolerance and anti-spoofing ability against the dynamic \r\nenvironment and various spoofing attacks have been greatly enhanced. \r\nTogether with the world’s cutting-edge 3D Neuron Fingerprint Algorithm and comprehensive support in mainstream \r\ncard modules, MB20-VL must be the best fit in various working environments satisfying different customer’s needs. \r\nFeatures\r\n · Visible Light facial recognition  \r\n· Anti-spoofing algorithm against print attack (laser, color and B/W photos), videos attack and 3D mask attack\r\n · Multiple verification methods: Face / Fingerprint / Card (Optional) / Password\r\n · Card modules (Optional): 125kHz ID Card (EM) / 13.56MHz IC Card\r\n · TCP/IP network, USB Host and WiFi (Optional)\r\n · Standard with Built-in SSR Excel Software\r\n · Simple access control', '/storage/products/xkiQPEEYdx4GHttI1apbcjeR32veotV5RdBtXnL6.png', 'mb20-vl', 1, 0.00, 0.00, 0.00, 100, 'available', 1, 1, '2025-08-25 20:50:27', '2025-08-25 20:50:34', 6, 1500000.00, 250000.00, 3000000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'Hiển thị\r\n\r\nMàn hình: 2.8-inch TFT\r\n\r\nDung lượng\r\n\r\nKhuôn mặt: 100\r\n\r\nVân tay: 500\r\n\r\nThẻ: 500 (tùy chọn)\r\n\r\nGiao dịch: 50,000\r\n\r\nGiao tiếp\r\n\r\nCổng kết nối: TCP/IP, USB Host\r\n\r\nKhông dây: WiFi (tùy chọn)\r\n\r\nChức năng chuẩn\r\n\r\nADMS\r\n\r\nDST (Daylight Saving Time)\r\n\r\nTruy vấn tự phục vụ (Self-service Query)\r\n\r\nTự động chuyển trạng thái (Automatic Status Switch)\r\n\r\nNhập liệu T9\r\n\r\nCamera tích hợp\r\n\r\nHỗ trợ User ID 9 ký tự\r\n\r\nĐa phương thức xác thực (Multiple Verification Methods)\r\n\r\nChuông báo theo lịch (Bell Scheduling)\r\n\r\nSSR\r\n\r\nPhần cứng\r\n\r\nCPU: 1GHz Dual-Core\r\n\r\nBộ nhớ: 256MB RAM / 256MB Flash\r\n\r\nCamera: 1MP Binocular Camera\r\n\r\nHệ điều hành\r\n\r\nOS: Linux\r\n\r\nGiao diện kiểm soát cửa\r\n\r\nHỗ trợ: Khóa điện 3rd Party, Door Sensor, Nút Exit\r\n\r\nChức năng tùy chọn\r\n\r\nThẻ 125kHz ID (EM)\r\n\r\nThẻ 13.56MHz IC\r\n\r\nWiFi\r\n\r\nThuật toán sinh trắc học\r\n\r\nNhận diện khuôn mặt: ZKLiveFace V3.5\r\n\r\nVân tay: ZKFinger V10.0\r\n\r\nTốc độ nhận diện khuôn mặt: ≤ 1 giây\r\n\r\nNguồn điện\r\n\r\nNguồn cấp: 5V / 2A\r\n\r\nMôi trường hoạt động\r\n\r\nNhiệt độ: 0°C ~ 45°C\r\n\r\nĐộ ẩm: 20% ~ 80%\r\n\r\nKích thước\r\n\r\nKích thước (W × H × D): 161.93 × 152.93 × 31.50 mm\r\n\r\nPhần mềm hỗ trợ\r\n\r\nZKBio Access IVS (T&A)', NULL, 'ZKTeco'),
(13, 'K50 Pro', 'SSR Fingerprint  \r\nTime & Attendance Terminal', 'K50 Pro, with self-service reports (SSR) stored in the terminal, is a 2.8-inch TFT screen Time & Attendance \r\nterminal with a simple Access Control function. It has an interface for connection with a third party electric \r\nlock and exit button. TCP/IP communication is a standard function that ensures smooth data transmission \r\nbetween the terminal and PC within several seconds. And the USB Host makes data management extremely \r\neasy. Most importantly, the built-in battery can eliminate the problem of power failure. With an elegant \r\nappearance and reliable quality, you can get the best from it.\r\n Features\r\n • TCP/IP, USB Host \r\n• Built-in Battery \r\n• Simple access control or external bell', '/storage/products/6O8DAJagXxU45YE6XNIt6CnsMmKHQf7v6spy7sxP.webp', 'k50-pro', 1, 0.00, 0.00, 0.00, 100, 'available', 1, 1, '2025-08-25 23:16:06', '2025-08-25 23:38:16', 6, 900000.00, 150000.00, 1800000.00, 2700000.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'Display: 2.8-inch TFT Screen\r\n\r\nFingerprint Capacity: 3,000\r\n\r\nCard Capacity: 3,000 (Optional SSR: 1,000)\r\n\r\nTransaction Capacity: 100,000\r\n\r\nCommunication: TCP/IP, USB-host\r\n\r\nStandard Functions: ID Card, Workcode, SMS, DST, Record Query, Automatic Status Switch, Timed Ring, T9 Input, 9-digit User ID, Simple Access Control, Backup Battery\r\n\r\nOptional Functions: IC Card, ADMS, SSR, External Bell\r\n\r\nPower Supply: DC 5V/0.8A\r\n\r\nOperating Temperature: 0°C ~ 45°C\r\n\r\nOperating Humidity: 20% ~ 80%\r\n\r\nDimensions (mm): 138 × 183 × 45.5 (L×W×T)\r\n\r\nSpecial Features: Built-in SSR Excel Software (optional), Multi-Languages\r\n\r\nConfiguration: Lock, Ethernet, HUB, USB', NULL, 'ZKTeco'),
(14, 'MB160', 'Multi-Biometric Time Attendance \r\nTerminal with Access Control \r\nFunctionsa', 'MB160 is an innovative product featured with ZK advanced ngerprint and face \r\nrecognition technologies. It supports multiple veri cation methods including face, \r\nngerprint, card, password, combinations between them and basic access control \r\nfunctions.\r\n User veri cation is performed in less than 0.5 seconds, which streamlines the \r\nprocess of access.\r\n The communication between the MB160 and PC is by TCP / IP or USB interface for \r\nmanual data transfer. Its sleek design ts perfectly in any environment.\r\n Features\r\n 1.200 Faces, 1.500 Fingerprints, 100.000 Records and 2.000 Cards (optional).\r\n Multi-languages.\r\n Communication: TCP/IP, USB-Host.\r\n High veri cation speed.\r\n Professional rmware and platform make it more exible.\r\n Intuitive and stunning UI design', '/storage/products/OtMZaq4xCeIkKEsFzdjgeRPaYA4jkhiKg94URAV1.jpg', 'mb160', 1, 0.00, 0.00, 0.00, 10000, 'available', 1, 1, '2025-08-25 23:22:10', '2025-09-05 23:35:44', 6, 2340000.00, 390000.00, 4680000.00, 7020000.00, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'Face Capacity: 1,200\r\n\r\nFingerprint Capacity: 1,500\r\n\r\nID Card Capacity: 2,000 (Optional)\r\n\r\nRecord Capacity: 100,000\r\n\r\nDisplay: 2.8-inch TFT Screen\r\n\r\nCommunication: TCP/IP, USB-Host\r\n\r\nStandard Functions: SMS, DTS, Scheduled-bell, Self-Service Query, Automatic Status Switch, T9 Input, Photo ID, Camera, Multi-verification, 12V Output\r\n\r\nOptional Functions: ID / MIFARE Cards, Work Code, ADMS, RS232 Printer\r\n\r\nInterface for Access Control: 3rd Party Electric Lock, Exit Button, Alarm\r\n\r\nPower Supply: DC 12V 1.5A\r\n\r\nRecognition Speed: ≤0.5 Sec\r\n\r\nOperating Temperature: 0°C ~ 45°C\r\n\r\nOperating Humidity: 20% ~ 80%\r\n\r\nDimension (mm): 167.5 × 148.8 × 32.2 (L × W × T)', 'TM-T12', 'ZKTeco');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
