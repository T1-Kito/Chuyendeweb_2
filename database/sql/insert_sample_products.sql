-- File: database/sql/insert_sample_products.sql
-- Chèn 1 sản phẩm mẫu vào bảng `products`
-- Lưu ý: cần có sẵn bản ghi trong bảng `categories` với id = 1

INSERT INTO `products` (
    `name`,
    `description`,
    `features`,
    `image`,
    `slug`,
    `category_id`,
    `daily_price`,
    `weekly_price`,
    `monthly_price`,
    `stock_quantity`,
    `status`,
    `is_featured`,
    `is_active`,
    `min_rental_months`
) VALUES (
    'Sản phẩm demo 1',
    'Mô tả chi tiết cho sản phẩm demo 1.',
    'Tính năng 1, Tính năng 2, Tính năng 3',
    'products/demo-1.jpg',
    'san-pham-demo-1',
    1,              -- category_id: sửa lại cho đúng id danh mục của bạn
    50000.00,       -- daily_price
    300000.00,      -- weekly_price
    1000000.00,     -- monthly_price
    10,             -- stock_quantity
    'available',    -- status (available | rented | maintenance)
    1,              -- is_featured (1 = true, 0 = false)
    1,              -- is_active (1 = true, 0 = false)
    6               -- min_rental_months
);
