-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th10 21, 2025 lúc 02:23 PM
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
-- Cấu trúc bảng cho bảng `admin_permissions`
--

CREATE TABLE `admin_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `granted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admin_permissions`
--

INSERT INTO `admin_permissions` (`id`, `user_id`, `permission`, `granted`, `created_at`, `updated_at`) VALUES
(9, 5, 'orders_view', 1, '2025-09-04 20:13:41', '2025-09-04 20:13:41'),
(10, 5, 'orders_edit', 1, '2025-09-04 20:13:41', '2025-09-04 20:13:41'),
(11, 5, 'orders_delete', 1, '2025-09-04 20:13:41', '2025-09-04 20:13:41'),
(12, 5, 'products_manage', 1, '2025-09-04 20:13:41', '2025-09-04 20:13:41'),
(13, 5, 'categories_manage', 1, '2025-09-04 20:13:41', '2025-09-04 20:13:41'),
(14, 5, 'banners_manage', 1, '2025-09-04 20:13:41', '2025-09-04 20:13:41'),
(15, 5, 'users_manage', 1, '2025-09-04 20:13:41', '2025-09-04 20:13:41'),
(16, 5, 'permissions_manage', 1, '2025-09-04 20:13:41', '2025-09-04 20:13:41'),
(18, 5, 'service_packages_manage', 1, '2025-09-04 20:29:40', '2025-09-04 20:29:40'),
(19, 2, 'orders_view', 1, '2025-10-02 07:33:06', '2025-10-08 23:13:13'),
(20, 2, 'orders_edit', 1, '2025-10-02 07:33:06', '2025-10-08 23:13:13'),
(21, 2, 'orders_delete', 1, '2025-10-02 07:33:06', '2025-10-08 23:13:13'),
(22, 2, 'products_manage', 1, '2025-10-02 07:33:06', '2025-10-08 23:13:13'),
(23, 2, 'categories_manage', 1, '2025-10-02 07:33:06', '2025-10-08 23:13:13'),
(24, 2, 'banners_manage', 1, '2025-10-02 07:33:06', '2025-10-08 23:13:13'),
(25, 2, 'users_manage', 1, '2025-10-02 07:33:06', '2025-10-08 23:13:13'),
(26, 2, 'permissions_manage', 1, '2025-10-02 07:33:06', '2025-10-08 23:13:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `banners`
--

INSERT INTO `banners` (`id`, `title`, `image_path`, `link_url`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Banner 2025-08-26 06:44', '/storage/banners/M4tvQMlWJOufuZPkRqoK317VUOlG196bQYG2NT63.gif', NULL, 1, 1, '2025-08-25 23:44:01', '2025-08-25 23:44:01'),
(2, 'Banner 2025-08-26 06:44', '/storage/banners/D8Onhg9FADApy5rZ3wuTdyzCn6CzzOCFWKW4L8vy.gif', NULL, 2, 1, '2025-08-25 23:44:18', '2025-08-25 23:44:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@gmail.com|115.72.52.169', 'i:1;', 1759414070),
('laravel-cache-admin@gmail.com|115.72.52.169:timer', 'i:1759414070;', 1759414070),
('laravel-cache-admin@webcn.vn|27.74.254.155', 'i:1;', 1757314989),
('laravel-cache-admin@webcn.vn|27.74.254.155:timer', 'i:1757314989;', 1757314989),
('laravel-cache-admin1@com|27.74.254.155', 'i:1;', 1757140549),
('laravel-cache-admin1@com|27.74.254.155:timer', 'i:1757140549;', 1757140549),
('laravel-cache-admin1@gmail.com|113.161.38.221', 'i:2;', 1758611046),
('laravel-cache-admin1@gmail.com|113.161.38.221:timer', 'i:1758611046;', 1758611046),
('laravel-cache-admin1@mail.com|27.74.254.155', 'i:1;', 1757140567),
('laravel-cache-admin1@mail.com|27.74.254.155:timer', 'i:1757140567;', 1757140567),
('laravel-cache-admin1@webcn.vn|27.74.254.155', 'i:2;', 1757151264),
('laravel-cache-admin1@webcn.vn|27.74.254.155:timer', 'i:1757151264;', 1757151264),
('laravel-cache-than@gmail.com|171.255.60.19', 'i:3;', 1758181461),
('laravel-cache-than@gmail.com|171.255.60.19:timer', 'i:1758181461;', 1758181461),
('laravel-cache-than@gmail.com|27.74.254.155', 'i:1;', 1757150823),
('laravel-cache-than@gmail.com|27.74.254.155:timer', 'i:1757150823;', 1757150823);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `rental_duration` tinyint UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `price_per_month` bigint UNSIGNED NOT NULL DEFAULT '0',
  `total_price` bigint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `rental_duration`, `quantity`, `price_per_month`, `total_price`, `created_at`, `updated_at`) VALUES
(10, 4, 14, 6, 1, 2340000, 2340000, '2025-09-04 19:02:04', '2025-09-04 19:02:04'),
(12, 3, 12, 12, 1, 3000000, 3000000, '2025-09-04 19:28:07', '2025-09-04 19:28:07'),
(25, 2, 13, 12, 1, 1800000, 1800000, '2025-09-05 19:20:54', '2025-09-05 19:20:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `icon`, `color`, `sort_order`, `image`, `slug`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'MÁY CHẤM CÔNG', NULL, NULL, '#2563eb', 0, NULL, 'may-cham-cong', 1, '2025-08-25 01:35:26', '2025-08-25 01:35:26'),
(2, 'FA7000', NULL, NULL, '#2563eb', 0, NULL, 'fa7000', 1, '2025-08-28 19:54:22', '2025-08-28 19:54:22'),
(3, 'May In', NULL, NULL, '#2563eb', 0, NULL, 'may-in', 1, '2025-10-03 18:40:42', '2025-10-03 18:40:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_20_045055_create_categories_table', 1),
(5, '2025_08_20_045102_create_products_table', 1),
(6, '2025_08_20_045119_create_rentals_table', 1),
(7, '2025_08_20_045126_create_rental_items_table', 1),
(8, '2025_08_20_045527_add_fields_to_users_table', 1),
(9, '2025_08_20_200000_add_is_admin_to_users_table', 1),
(10, '2025_08_20_200100_create_banners_table', 1),
(11, '2025_08_21_000000_add_rental_features_to_products_table', 1),
(12, '2025_08_21_030000_fix_products_price_defaults', 1),
(13, '2025_08_21_120000_create_carts_table', 1),
(14, '2025_08_21_130000_add_specs_to_products_table', 1),
(15, '2025_08_22_011804_create_orders_table', 1),
(16, '2025_08_22_011805_create_order_items_table', 1),
(17, '2025_08_22_024131_add_icon_color_sort_order_to_categories_table', 1),
(18, '2025_08_22_032850_add_serial_number_to_products_table', 1),
(19, '2025_08_22_090500_add_model_to_products_table', 1),
(20, '2025_08_26_020313_add_price_1_month_to_products_table', 2),
(22, '2025_08_26_000000_create_admin_permissions_table', 3),
(23, '2025_09_05_012524_create_password_reset_tokens_table', 4),
(24, '2025_09_05_032311_create_service_packages_table', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `subtotal` decimal(12,2) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `rental_start_date` date NOT NULL,
  `rental_end_date` date NOT NULL,
  `total_months` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`, `notes`, `subtotal`, `total_amount`, `payment_method`, `status`, `rental_start_date`, `rental_end_date`, `total_months`, `created_at`, `updated_at`) VALUES
(3, 'ORD2025090587622D', 3, 'Thắngaaaa', '12345678', 'hoanthang0307@gmail.com', 'qdqw', 'dqd', 1500000.00, 1500000.00, 'cash', 'pending', '2025-09-05', '2026-03-05', 6, '2025-09-04 19:27:16', '2025-09-04 19:27:16'),
(4, 'ORD202509052D5038', 6, 'thang', '0879774476', 'ttt21@gmail.com', 'adawd', NULL, 3000000.00, 3000000.00, 'cash', 'pending', '2025-09-05', '2026-09-05', 12, '2025-09-05 02:44:15', '2025-09-05 02:44:15'),
(5, 'ORD20250905C2236B', 6, 'thang', '0879774476', 'ttt21@gmail.com', 'dawa', NULL, 1800000.00, 1800000.00, 'cash', 'pending', '2025-09-05', '2026-09-05', 12, '2025-09-05 02:44:56', '2025-09-05 02:44:56'),
(6, 'ORD202509051950A0', 6, 'thang', '08797744763', 'ttt21@gmail.com', 'da', NULL, 900000.00, 900000.00, 'cash', 'pending', '2025-09-05', '2026-03-05', 6, '2025-09-05 02:46:35', '2025-09-05 02:46:35'),
(7, 'ORD20250905204017', 6, 'thange', '123123123', 'ttt211@gmail.com', 'qw', 'dqw', 1500000.00, 1500000.00, 'cash', 'pending', '2025-09-05', '2026-03-05', 6, '2025-09-05 02:50:46', '2025-09-05 02:50:46'),
(8, 'ORD20250906F5E555', 2, 'Thắnga', '0879774476', 'ttt1@gmail.com', 'ad', 'ad', 900000.00, 900000.00, 'cash', 'pending', '2025-09-06', '2026-03-06', 6, '2025-09-05 18:09:37', '2025-09-05 18:09:37'),
(9, 'ORD20250906DE9656', 2, 'Thắnga', '0879774476', 'ttt1@gmail.com', 'a', 'a', 900000.00, 900000.00, 'cash', 'pending', '2025-09-06', '2026-03-06', 6, '2025-09-05 18:28:44', '2025-09-05 18:28:44'),
(10, 'ORD2025090643890C', 5, 'Admin1', '08797744761', 'admin1@gmail.com', 'das', 'ad', 3900000.00, 3900000.00, 'cash', 'pending', '2025-09-06', '2026-09-06', 12, '2025-09-05 18:32:39', '2025-09-05 18:32:39'),
(11, 'ORD202509063A46B7', 5, 'Admin1', '08797744761', 'admin1@gmail.com', 'k', NULL, 2340000.00, 2340000.00, 'cash', 'pending', '2025-09-06', '2026-03-06', 6, '2025-09-05 18:35:48', '2025-09-05 18:35:48'),
(12, 'ORD202509063D3BC8', 5, 'Admin1', '0879774476', 'admin1@gmail.com', 'k', NULL, 900000.00, 900000.00, 'cash', 'pending', '2025-09-06', '2026-03-06', 6, '2025-09-05 18:43:28', '2025-09-05 18:43:28'),
(13, 'ORD20250906A5883D', 5, 'Admin1', '0879774476', 'admin1@gmail.com', 'a', NULL, 1500000.00, 1500000.00, 'cash', 'pending', '2025-09-06', '2026-03-06', 6, '2025-09-05 18:55:46', '2025-09-05 18:55:46'),
(14, 'ORD202509061FC67C', 5, 'Admin1', '0879774476', 'admin1@gmail.com', 'ad', 'a', 900000.00, 900000.00, 'cash', 'pending', '2025-09-06', '2026-03-06', 6, '2025-09-05 19:11:17', '2025-09-05 19:11:17'),
(15, 'ORD20250906CA772F', 2, 'Thắnga', '0879774476', 'ttt1@gmail.com', 'da', 'da', 900000.00, 900000.00, 'cash', 'pending', '2025-09-06', '2026-03-06', 6, '2025-09-05 19:16:36', '2025-09-05 19:16:36'),
(16, 'ORD202509069BD811', 5, 'Admin1', '0879774476', 'admin1@gmail.com', 'a', 'a', 900000.00, 900000.00, 'cash', 'pending', '2025-09-06', '2026-03-06', 6, '2025-09-05 23:36:29', '2025-09-05 23:36:29'),
(17, 'ORD2025100273C18D', 5, 'Admin1', '0338775218', 'admin1@gmail.com', 'ojk;/,', NULL, 4140000.00, 4140000.00, 'cash', 'pending', '2025-10-02', '2026-04-02', 6, '2025-10-02 07:47:41', '2025-10-02 07:47:41'),
(18, 'ORD20251018CB7570', 5, 'Admin1', '33872569852', 'admin1@gmail.com', 'jghfgdfdfgfhfjgkh', NULL, 6240000.00, 6240000.00, 'cash', 'pending', '2025-10-18', '2026-10-18', 12, '2025-10-18 00:40:21', '2025-10-18 00:40:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_description` text COLLATE utf8mb4_unicode_ci,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rental_duration_months` int NOT NULL,
  `monthly_price` decimal(12,2) NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_description`, `product_image`, `rental_duration_months`, `monthly_price`, `total_price`, `quantity`, `created_at`, `updated_at`) VALUES
(3, 3, 12, 'MB20-VL', 'Linux-Based Hybrid Biometric \r\nTime & Attendance and Access Control Terminal  \r\nwith Visible Light Facial Recognition', '/storage/products/xkiQPEEYdx4GHttI1apbcjeR32veotV5RdBtXnL6.png', 6, 0.00, 1500000.00, 1, '2025-09-04 19:27:16', '2025-09-04 19:27:16'),
(4, 4, 12, 'MB20-VL', 'Linux-Based Hybrid Biometric \r\nTime & Attendance and Access Control Terminal  \r\nwith Visible Light Facial Recognition', '/storage/products/xkiQPEEYdx4GHttI1apbcjeR32veotV5RdBtXnL6.png', 12, 0.00, 3000000.00, 1, '2025-09-05 02:44:15', '2025-09-05 02:44:15'),
(5, 5, 11, 'K14 Pro', 'K14 Pro is a fingerprint Time & Attendance Terminal. The 2.8-inch TFT screen can display more information \r\nvividly, including fingerprint images and verification results, etc. TCP/IP communication is a standard function \r\nthat ensures smooth data transmission between the terminal and PC within several seconds. And the USB \r\nHost makes data management extremely easy. With an elegant appearance and reliable quality, you can get \r\nthe best from it', '/storage/products/7QdmX5u7DWFa75k6jWXPO4yVqNGJZpNkfZuPLbZ7.jpg', 12, 0.00, 1800000.00, 1, '2025-09-05 02:44:56', '2025-09-05 02:44:56'),
(6, 6, 13, 'K50 Pro', 'SSR Fingerprint  \r\nTime & Attendance Terminal', '/storage/products/6O8DAJagXxU45YE6XNIt6CnsMmKHQf7v6spy7sxP.webp', 6, 0.00, 900000.00, 1, '2025-09-05 02:46:35', '2025-09-05 02:46:35'),
(7, 7, 12, 'MB20-VL', 'Linux-Based Hybrid Biometric \r\nTime & Attendance and Access Control Terminal  \r\nwith Visible Light Facial Recognition', '/storage/products/xkiQPEEYdx4GHttI1apbcjeR32veotV5RdBtXnL6.png', 6, 0.00, 1500000.00, 1, '2025-09-05 02:50:46', '2025-09-05 02:50:46'),
(8, 8, 13, 'K50 Pro', 'SSR Fingerprint  \r\nTime & Attendance Terminal', '/storage/products/6O8DAJagXxU45YE6XNIt6CnsMmKHQf7v6spy7sxP.webp', 6, 0.00, 900000.00, 1, '2025-09-05 18:09:37', '2025-09-05 18:09:37'),
(9, 9, 13, 'K50 Pro', 'SSR Fingerprint  \r\nTime & Attendance Terminal', '/storage/products/6O8DAJagXxU45YE6XNIt6CnsMmKHQf7v6spy7sxP.webp', 6, 0.00, 900000.00, 1, '2025-09-05 18:28:44', '2025-09-05 18:28:44'),
(10, 10, 12, 'MB20-VL', 'Linux-Based Hybrid Biometric \r\nTime & Attendance and Access Control Terminal  \r\nwith Visible Light Facial Recognition', '/storage/products/xkiQPEEYdx4GHttI1apbcjeR32veotV5RdBtXnL6.png', 12, 0.00, 3000000.00, 1, '2025-09-05 18:32:39', '2025-09-05 18:32:39'),
(11, 10, 13, 'K50 Pro', 'SSR Fingerprint  \r\nTime & Attendance Terminal', '/storage/products/6O8DAJagXxU45YE6XNIt6CnsMmKHQf7v6spy7sxP.webp', 6, 0.00, 900000.00, 1, '2025-09-05 18:32:39', '2025-09-05 18:32:39'),
(12, 11, 14, 'MB160', 'Multi-Biometric Time Attendance \r\nTerminal with Access Control \r\nFunctionsa', '/storage/products/OtMZaq4xCeIkKEsFzdjgeRPaYA4jkhiKg94URAV1.jpg', 6, 0.00, 2340000.00, 1, '2025-09-05 18:35:48', '2025-09-05 18:35:48'),
(13, 12, 13, 'K50 Pro', 'SSR Fingerprint  \r\nTime & Attendance Terminal', '/storage/products/6O8DAJagXxU45YE6XNIt6CnsMmKHQf7v6spy7sxP.webp', 6, 0.00, 900000.00, 1, '2025-09-05 18:43:28', '2025-09-05 18:43:28'),
(14, 13, 12, 'MB20-VL', 'Linux-Based Hybrid Biometric \r\nTime & Attendance and Access Control Terminal  \r\nwith Visible Light Facial Recognition', '/storage/products/xkiQPEEYdx4GHttI1apbcjeR32veotV5RdBtXnL6.png', 6, 0.00, 1500000.00, 1, '2025-09-05 18:55:46', '2025-09-05 18:55:46'),
(15, 14, 13, 'K50 Pro', 'SSR Fingerprint  \r\nTime & Attendance Terminal', '/storage/products/6O8DAJagXxU45YE6XNIt6CnsMmKHQf7v6spy7sxP.webp', 6, 0.00, 900000.00, 1, '2025-09-05 19:11:17', '2025-09-05 19:11:17'),
(16, 15, 13, 'K50 Pro', 'SSR Fingerprint  \r\nTime & Attendance Terminal', '/storage/products/6O8DAJagXxU45YE6XNIt6CnsMmKHQf7v6spy7sxP.webp', 6, 0.00, 900000.00, 1, '2025-09-05 19:16:36', '2025-09-05 19:16:36'),
(17, 16, 13, 'K50 Pro', 'SSR Fingerprint  \r\nTime & Attendance Terminal', '/storage/products/6O8DAJagXxU45YE6XNIt6CnsMmKHQf7v6spy7sxP.webp', 6, 0.00, 900000.00, 1, '2025-09-05 23:36:29', '2025-09-05 23:36:29'),
(18, 17, 14, 'MB160', 'Multi-Biometric Time Attendance \r\nTerminal with Access Control \r\nFunctionsa', '/storage/products/OtMZaq4xCeIkKEsFzdjgeRPaYA4jkhiKg94URAV1.jpg', 6, 0.00, 2340000.00, 1, '2025-10-02 07:47:41', '2025-10-02 07:47:41'),
(19, 17, 13, 'K50 Pro', 'SSR Fingerprint  \r\nTime & Attendance Terminal', '/storage/products/6O8DAJagXxU45YE6XNIt6CnsMmKHQf7v6spy7sxP.webp', 6, 0.00, 1800000.00, 2, '2025-10-02 07:47:41', '2025-10-02 07:47:41'),
(20, 18, 13, 'K50 Pro', 'SSR Fingerprint  \r\nTime & Attendance Terminal', '/storage/products/6O8DAJagXxU45YE6XNIt6CnsMmKHQf7v6spy7sxP.webp', 6, 0.00, 900000.00, 1, '2025-10-18 00:40:21', '2025-10-18 00:40:21'),
(21, 18, 14, 'MB160', 'Multi-Biometric Time Attendance \r\nTerminal with Access Control \r\nFunctionsa', '/storage/products/OtMZaq4xCeIkKEsFzdjgeRPaYA4jkhiKg94URAV1.jpg', 6, 0.00, 2340000.00, 1, '2025-10-18 00:40:21', '2025-10-18 00:40:21'),
(22, 18, 12, 'MB20-VL', 'Linux-Based Hybrid Biometric \r\nTime & Attendance and Access Control Terminal  \r\nwith Visible Light Facial Recognition', '/storage/products/xkiQPEEYdx4GHttI1apbcjeR32veotV5RdBtXnL6.png', 12, 0.00, 3000000.00, 1, '2025-10-18 00:40:21', '2025-10-18 00:40:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('anhtuan1208204@gmail.com', '$2y$12$4GawuDVHmDwB9qQfUO.iU.lcXv20NEFri6U1y5M2BCLCi8rcttI2q', '2025-10-03 16:25:16'),
('hoanthang0307@gmail.com', '$2y$12$gWkS3.YYuxRcvNvK87tCQOrDSdGL6hPEq4duSkymdYJ4E1g/oqlSS', '2025-09-04 19:12:40'),
('ttt1@gmail.com', '$2y$12$GdDtrWSYwchWuNNjNdiQVeM/71/h9gqgVCogFzOi.nKaRmjLLhsBy', '2025-09-05 00:02:40');

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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rentals`
--

CREATE TABLE `rentals` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rental_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('pending','active','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rental_items`
--

CREATE TABLE `rental_items` (
  `id` bigint UNSIGNED NOT NULL,
  `rental_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `rental_period` enum('daily','weekly','monthly') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service_packages`
--

CREATE TABLE `service_packages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Xem Chi Tiết',
  `button_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'primary',
  `is_popular` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Đang đổ dữ liệu cho bảng `service_packages`
--

INSERT INTO `service_packages` (`id`, `name`, `duration`, `description`, `features`, `icon`, `button_text`, `button_icon`, `button_color`, `is_popular`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 'Gói 12 Tháng', '12 Tháng', 'Gói dịch vụ phổ biến với nhiều tính năng ưu đãi', '[\"T\\u1ea5t c\\u1ea3 d\\u1ecbch v\\u1ee5 g\\u00f3i 6 th\\u00e1ng\",\"H\\u1ed7 tr\\u1ee3 xu\\u1ea5t h\\u00f3a \\u0111\\u01a1n\",\"H\\u1ed7 tr\\u1ee3 xu\\u1ea5t ti\\u1ec1n l\\u01b0\\u01a1ng\",\"H\\u1ed7 tr\\u1ee3 b\\u1ea3o h\\u00e0nh l\\u1ed7i\",\"\\u01afu ti\\u00ean h\\u1ed7 tr\\u1ee3 k\\u1ef9 thu\\u1eadt\",\"C\\u1eadp nh\\u1eadt ph\\u1ea7n m\\u1ec1m mi\\u1ec5n ph\\u00ed\"]', 'crown', 'Chọn Gói', 'star', 'warning', 1, 1, 2, '2025-09-04 20:30:18', '2025-09-04 20:30:18'),
(3, 'Gói 24 Tháng', '24 Tháng', 'Gói dịch vụ cao cấp với nhiều ưu đãi đặc biệt', '[\"T\\u1ea5t c\\u1ea3 d\\u1ecbch v\\u1ee5 g\\u00f3i 12 th\\u00e1ng\",\"T\\u1eb7ng m\\u00e1y sau 24 th\\u00e1ng\",\"H\\u1ed7 tr\\u1ee3 k\\u1ef9 thu\\u1eadt nhanh t\\u1ea1i n\\u01a1i\",\"H\\u1ed7 tr\\u1ee3 license ph\\u1ea7n m\\u1ec1m\",\"H\\u1ed7 tr\\u1ee3 24\\/7\",\"\\u01afu \\u0111\\u00e3i \\u0111\\u1eb7c bi\\u1ec7t\"]', 'diamond', 'Đăng Ký Ngay', 'diamond', 'success', 0, 1, 3, '2025-09-04 20:30:18', '2025-09-04 20:30:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('t1WP2mtQJJAn4nMFqQWmZ5aBYve5nZWiNIEw0InI', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMHl5dnkzNktKS0pPVjdvMHJaM0duR1pYeThmZVZkaENhVm5pc2g2cyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1757047394),
('YBpr1LkAkl0a3ZZdvVYht41OyCensYnMjjkRJ06h', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidDZUZjRCTnl4aTZ4bko0TEdVd2JIV1JrV3E1cXV5UkV0UTRGdEp5dSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1757047798);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `email_verified_at`, `password`, `remember_token`, `is_admin`, `created_at`, `updated_at`) VALUES
(2, 'Thắnga', 'ttt1@gmail.com', NULL, NULL, NULL, '$2y$12$j21LqvJ9eIgmoiTmw.n4CORxwdWFPaN.pOJYM3NuJeWp/5BEJHonO', NULL, 1, '2025-08-28 18:08:38', '2025-10-08 23:13:13'),
(3, 'Thắngaaaa', 'hoanthang0307@gmail.com', NULL, NULL, NULL, '$2y$12$d4ANk5nND8OwsZ5FQmznvunO8xC7sLzMJ4S1SJ5Ub7eGr7dzPOM8K', NULL, 0, '2025-09-04 18:28:46', '2025-09-04 18:28:46'),
(4, 'thangau', '22211tt2387@mail.tdc.edu.vn', NULL, NULL, NULL, '$2y$12$5Un5kmtgLmiNkYNq6GyrwehV/a3zET5wCHY6dtx5usDbKVLc0JOD6', NULL, 0, '2025-09-04 19:01:56', '2025-09-04 19:25:42'),
(5, 'Admin1', 'admin1@gmail.com', NULL, NULL, NULL, '$2y$12$EucO3ocXusizuJwbyqbsCujM7tjyRcVjTEnqyqPcPM.Nty7nWCYRm', 'R1XdcME41csbSmI0qCRiLdiYzkmYtY05VPYdZMP2f1y1ysgbzDZog65vivgi', 1, '2025-09-04 20:13:29', '2025-09-04 20:13:29'),
(6, 'thang', 'ttt21@gmail.com', NULL, NULL, NULL, '$2y$12$ouODngfLvhN.JeoqRj3EeO9QTgvt/xxCoveguNzAxvDIM3Y7BXfgG', NULL, 0, '2025-09-05 00:04:15', '2025-09-05 00:04:15'),
(7, 'Phan Văn Anh Tuấn', 'anhtuan1208204@gmail.com', NULL, NULL, NULL, '$2y$12$Cbon7Xpx0tQFcAipmJEPJO7cRfdkKOyEfSALN7ucRa87z6tUyeX4O', NULL, 0, '2025-10-02 07:02:03', '2025-10-02 07:02:03');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_permissions_user_id_permission_unique` (`user_id`,`permission`);

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_status_index` (`user_id`,`status`),
  ADD KEY `orders_order_number_index` (`order_number`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_order_id_product_id_index` (`order_id`,`product_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rentals_rental_number_unique` (`rental_number`),
  ADD KEY `rentals_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `rental_items`
--
ALTER TABLE `rental_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rental_items_rental_id_foreign` (`rental_id`),
  ADD KEY `rental_items_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `service_packages`
--
ALTER TABLE `service_packages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `rental_items`
--
ALTER TABLE `rental_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `service_packages`
--
ALTER TABLE `service_packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD CONSTRAINT `admin_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `rental_items`
--
ALTER TABLE `rental_items`
  ADD CONSTRAINT `rental_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rental_items_rental_id_foreign` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
