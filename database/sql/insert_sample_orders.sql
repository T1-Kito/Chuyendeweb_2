-- File: database/sql/insert_sample_orders.sql
-- Chèn dữ liệu mẫu vào bảng `orders` để test biểu đồ đơn hàng / doanh thu
-- Lưu ý: đảm bảo trong bảng `users` đã có user với id = 1 (hoặc chỉnh lại user_id bên dưới).

INSERT INTO `orders` (
    `order_number`,
    `user_id`,
    `customer_name`,
    `customer_phone`,
    `customer_email`,
    `customer_address`,
    `notes`,
    `subtotal`,
    `total_amount`,
    `payment_method`,
    `status`,
    `rental_start_date`,
    `rental_end_date`,
    `total_months`,
    `created_at`,
    `updated_at`
) VALUES
-- Đơn cách đây 6 ngày
('ORD20251123A', 1, 'Khách Hàng 1', '0900000001', 'kh1@example.com', 'Địa chỉ 1', NULL,
 5000000, 5500000, 'cash', 'completed', '2025-11-01', '2025-11-30', 1, '2025-11-23 10:10:00', '2025-11-23 10:10:00'),

-- Đơn cách đây 5 ngày
('ORD20251124B', 1, 'Khách Hàng 2', '0900000002', 'kh2@example.com', 'Địa chỉ 2', NULL,
 8000000, 8800000, 'bank_transfer', 'completed', '2025-11-05', '2026-05-05', 6, '2025-11-24 11:20:00', '2025-11-24 11:20:00'),

-- Đơn cách đây 4 ngày
('ORD20251125C', 1, 'Khách Hàng 3', '0900000003', 'kh3@example.com', 'Địa chỉ 3', NULL,
 3000000, 3300000, 'cash', 'completed', '2025-11-10', '2026-11-10', 12, '2025-11-25 09:05:00', '2025-11-25 09:05:00'),

-- Đơn cách đây 3 ngày
('ORD20251126D', 1, 'Khách Hàng 4', '0900000004', 'kh4@example.com', 'Địa chỉ 4', NULL,
 10000000, 11000000, 'bank_transfer', 'completed', '2025-11-15', '2026-11-15', 12, '2025-11-26 14:30:00', '2025-11-26 14:30:00'),

-- Đơn cách đây 2 ngày
('ORD20251127E', 1, 'Khách Hàng 5', '0900000005', 'kh5@example.com', 'Địa chỉ 5', NULL,
 2000000, 2200000, 'cash', 'completed', '2025-11-20', '2026-05-20', 6, '2025-11-27 16:45:00', '2025-11-27 16:45:00'),

-- Đơn cách đây 1 ngày
('ORD20251128F', 1, 'Khách Hàng 6', '0900000006', 'kh6@example.com', 'Địa chỉ 6', NULL,
 7500000, 8000000, 'bank_transfer', 'completed', '2025-11-22', '2026-11-22', 12, '2025-11-28 13:15:00', '2025-11-28 13:15:00'),

-- Đơn hôm nay
('ORD20251129G', 1, 'Khách Hàng 7', '0900000007', 'kh7@example.com', 'Địa chỉ 7', NULL,
 4500000, 5000000, 'cash', 'completed', '2025-11-25', '2026-05-25', 6, '2025-11-29 09:55:00', '2025-11-29 09:55:00');
