/* 
    Thay YourDatabaseName bằng tên database SQL Server của bạn,
    sau đó chạy toàn bộ script này trong SSMS/sqlcmd.
*/
IF DB_ID(N'YourDatabaseName') IS NULL
BEGIN
    EXEC (N'CREATE DATABASE [YourDatabaseName];');
END;
GO

USE [YourDatabaseName];
GO

/* Dọn bảng theo thứ tự phụ thuộc (nếu cần chạy lại script nhiều lần) */
IF OBJECT_ID(N'dbo.check_ins', 'U') IS NOT NULL DROP TABLE dbo.check_ins;
IF OBJECT_ID(N'dbo.admin_permissions', 'U') IS NOT NULL DROP TABLE dbo.admin_permissions;
IF OBJECT_ID(N'dbo.comments', 'U') IS NOT NULL DROP TABLE dbo.comments;
IF OBJECT_ID(N'dbo.ratings', 'U') IS NOT NULL DROP TABLE dbo.ratings;
IF OBJECT_ID(N'dbo.carts', 'U') IS NOT NULL DROP TABLE dbo.carts;
IF OBJECT_ID(N'dbo.rental_items', 'U') IS NOT NULL DROP TABLE dbo.rental_items;
IF OBJECT_ID(N'dbo.rentals', 'U') IS NOT NULL DROP TABLE dbo.rentals;
IF OBJECT_ID(N'dbo.order_items', 'U') IS NOT NULL DROP TABLE dbo.order_items;
IF OBJECT_ID(N'dbo.orders', 'U') IS NOT NULL DROP TABLE dbo.orders;
IF OBJECT_ID(N'dbo.vouchers', 'U') IS NOT NULL DROP TABLE dbo.vouchers;
IF OBJECT_ID(N'dbo.products', 'U') IS NOT NULL DROP TABLE dbo.products;
IF OBJECT_ID(N'dbo.categories', 'U') IS NOT NULL DROP TABLE dbo.categories;
IF OBJECT_ID(N'dbo.service_packages', 'U') IS NOT NULL DROP TABLE dbo.service_packages;
IF OBJECT_ID(N'dbo.banners', 'U') IS NOT NULL DROP TABLE dbo.banners;
IF OBJECT_ID(N'dbo.notifications', 'U') IS NOT NULL DROP TABLE dbo.notifications;
IF OBJECT_ID(N'dbo.failed_jobs', 'U') IS NOT NULL DROP TABLE dbo.failed_jobs;
IF OBJECT_ID(N'dbo.job_batches', 'U') IS NOT NULL DROP TABLE dbo.job_batches;
IF OBJECT_ID(N'dbo.jobs', 'U') IS NOT NULL DROP TABLE dbo.jobs;
IF OBJECT_ID(N'dbo.cache_locks', 'U') IS NOT NULL DROP TABLE dbo.cache_locks;
IF OBJECT_ID(N'dbo.cache', 'U') IS NOT NULL DROP TABLE dbo.cache;
IF OBJECT_ID(N'dbo.sessions', 'U') IS NOT NULL DROP TABLE dbo.sessions;
IF OBJECT_ID(N'dbo.password_reset_tokens', 'U') IS NOT NULL DROP TABLE dbo.password_reset_tokens;
IF OBJECT_ID(N'dbo.users', 'U') IS NOT NULL DROP TABLE dbo.users;
GO

/* USERS + liên quan */
CREATE TABLE dbo.users (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    name NVARCHAR(255) NOT NULL,
    email NVARCHAR(255) NOT NULL UNIQUE,
    email_verified_at DATETIME2(0) NULL,
    password NVARCHAR(255) NOT NULL,
    remember_token NVARCHAR(100) NULL,
    is_admin BIT NOT NULL CONSTRAINT DF_users_is_admin DEFAULT (0),
    phone NVARCHAR(255) NULL,
    address NVARCHAR(MAX) NULL,
    avatar NVARCHAR(255) NULL,
    two_factor_enabled BIT NOT NULL CONSTRAINT DF_users_two_factor_enabled DEFAULT (0),
    two_factor_code NVARCHAR(255) NULL,
    two_factor_expires_at DATETIME2(0) NULL,
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL
);
GO

CREATE TABLE dbo.password_reset_tokens (
    email NVARCHAR(255) NOT NULL PRIMARY KEY,
    token NVARCHAR(255) NOT NULL,
    created_at DATETIME2(0) NULL
);
GO

CREATE TABLE dbo.sessions (
    id NVARCHAR(255) NOT NULL PRIMARY KEY,
    user_id BIGINT NULL,
    ip_address NVARCHAR(45) NULL,
    user_agent NVARCHAR(MAX) NULL,
    payload NVARCHAR(MAX) NOT NULL,
    last_activity INT NOT NULL
);
GO

CREATE INDEX IX_sessions_user_id ON dbo.sessions(user_id);
CREATE INDEX IX_sessions_last_activity ON dbo.sessions(last_activity);
GO

/* CACHE & JOBS */
CREATE TABLE dbo.cache (
    [key] NVARCHAR(255) NOT NULL PRIMARY KEY,
    value NVARCHAR(MAX) NOT NULL,
    expiration INT NOT NULL
);
GO

CREATE TABLE dbo.cache_locks (
    [key] NVARCHAR(255) NOT NULL PRIMARY KEY,
    owner NVARCHAR(255) NOT NULL,
    expiration INT NOT NULL
);
GO

CREATE TABLE dbo.jobs (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    queue NVARCHAR(255) NOT NULL,
    payload NVARCHAR(MAX) NOT NULL,
    attempts TINYINT NOT NULL,
    reserved_at INT NULL,
    available_at INT NOT NULL,
    created_at INT NOT NULL
);
GO

CREATE INDEX IX_jobs_queue ON dbo.jobs(queue);
GO

CREATE TABLE dbo.job_batches (
    id NVARCHAR(255) NOT NULL PRIMARY KEY,
    name NVARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids NVARCHAR(MAX) NOT NULL,
    options NVARCHAR(MAX) NULL,
    cancelled_at INT NULL,
    created_at INT NOT NULL,
    finished_at INT NULL
);
GO

CREATE TABLE dbo.failed_jobs (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    uuid NVARCHAR(255) NOT NULL UNIQUE,
    connection NVARCHAR(MAX) NOT NULL,
    queue NVARCHAR(MAX) NOT NULL,
    payload NVARCHAR(MAX) NOT NULL,
    exception NVARCHAR(MAX) NOT NULL,
    failed_at DATETIME2(0) NOT NULL CONSTRAINT DF_failed_jobs_failed_at DEFAULT (SYSUTCDATETIME())
);
GO

/* NOTIFICATIONS */
CREATE TABLE dbo.notifications (
    id UNIQUEIDENTIFIER NOT NULL PRIMARY KEY,
    type NVARCHAR(255) NOT NULL,
    notifiable_type NVARCHAR(255) NOT NULL,
    notifiable_id BIGINT NOT NULL,
    data NVARCHAR(MAX) NOT NULL,
    read_at DATETIME2(0) NULL,
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL
);
GO

CREATE INDEX IX_notifications_notifiable ON dbo.notifications(notifiable_type, notifiable_id);
GO

/* CATEGORIES */
CREATE TABLE dbo.categories (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    name NVARCHAR(255) NOT NULL,
    description NVARCHAR(MAX) NULL,
    icon NVARCHAR(255) NULL,
    color NVARCHAR(20) NULL,
    sort_order INT NOT NULL CONSTRAINT DF_categories_sort_order DEFAULT (0),
    image NVARCHAR(255) NULL,
    slug NVARCHAR(255) NOT NULL UNIQUE,
    is_active BIT NOT NULL CONSTRAINT DF_categories_is_active DEFAULT (1),
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL
);
GO

/* PRODUCTS */
CREATE TABLE dbo.products (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    name NVARCHAR(255) NOT NULL,
    description NVARCHAR(MAX) NOT NULL,
    features NVARCHAR(MAX) NULL,
    image NVARCHAR(255) NOT NULL,
    slug NVARCHAR(255) NOT NULL UNIQUE,
    category_id BIGINT NOT NULL,
    daily_price DECIMAL(12,2) NOT NULL CONSTRAINT DF_products_daily_price DEFAULT (0),
    weekly_price DECIMAL(12,2) NOT NULL CONSTRAINT DF_products_weekly_price DEFAULT (0),
    monthly_price DECIMAL(12,2) NOT NULL CONSTRAINT DF_products_monthly_price DEFAULT (0),
    stock_quantity INT NOT NULL CONSTRAINT DF_products_stock_quantity DEFAULT (0),
    status NVARCHAR(20) NOT NULL CONSTRAINT DF_products_status DEFAULT (N'available'),
    is_featured BIT NOT NULL CONSTRAINT DF_products_is_featured DEFAULT (0),
    is_active BIT NOT NULL CONSTRAINT DF_products_is_active DEFAULT (1),
    min_rental_months INT NOT NULL CONSTRAINT DF_products_min_rental_months DEFAULT (6),
    price_6_months DECIMAL(12,2) NULL,
    price_1_month DECIMAL(10,2) NULL,
    price_12_months DECIMAL(12,2) NULL,
    price_18_months DECIMAL(12,2) NULL,
    price_24_months DECIMAL(12,2) NULL,
    promotion_badge NVARCHAR(255) NULL,
    promotion_description NVARCHAR(MAX) NULL,
    promotion_start_date DATE NULL,
    promotion_end_date DATE NULL,
    warranty_info NVARCHAR(255) NULL,
    has_warranty_support BIT NOT NULL CONSTRAINT DF_products_has_warranty_support DEFAULT (0),
    rental_terms NVARCHAR(MAX) NULL,
    delivery_info NVARCHAR(MAX) NULL,
    specs NVARCHAR(MAX) NULL,
    serial_number NVARCHAR(255) NULL,
    model NVARCHAR(255) NULL,
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL,
    CONSTRAINT CK_products_status CHECK (status IN (N'available', N'rented', N'maintenance'))
);
GO

ALTER TABLE dbo.products
ADD CONSTRAINT FK_products_categories FOREIGN KEY (category_id)
    REFERENCES dbo.categories(id) ON DELETE CASCADE;
GO

/* BANNERS */
CREATE TABLE dbo.banners (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    title NVARCHAR(255) NULL,
    image_path NVARCHAR(255) NOT NULL,
    link_url NVARCHAR(255) NULL,
    sort_order INT NOT NULL CONSTRAINT DF_banners_sort_order DEFAULT (0),
    is_active BIT NOT NULL CONSTRAINT DF_banners_is_active DEFAULT (1),
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL
);
GO

/* SERVICE PACKAGES */
CREATE TABLE dbo.service_packages (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    name NVARCHAR(255) NOT NULL,
    duration NVARCHAR(255) NOT NULL,
    description NVARCHAR(MAX) NULL,
    features NVARCHAR(MAX) NOT NULL,
    icon NVARCHAR(255) NULL,
    button_text NVARCHAR(255) NOT NULL CONSTRAINT DF_service_packages_button_text DEFAULT (N'Xem Chi Tiết'),
    button_icon NVARCHAR(255) NULL,
    button_color NVARCHAR(50) NOT NULL CONSTRAINT DF_service_packages_button_color DEFAULT (N'primary'),
    is_popular BIT NOT NULL CONSTRAINT DF_service_packages_is_popular DEFAULT (0),
    is_active BIT NOT NULL CONSTRAINT DF_service_packages_is_active DEFAULT (1),
    sort_order INT NOT NULL CONSTRAINT DF_service_packages_sort_order DEFAULT (0),
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL
);
GO

/* VOUCHERS */
CREATE TABLE dbo.vouchers (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    code NVARCHAR(255) NOT NULL UNIQUE,
    name NVARCHAR(255) NOT NULL,
    description NVARCHAR(MAX) NULL,
    type NVARCHAR(20) NOT NULL,
    value DECIMAL(10,2) NOT NULL,
    min_order_amount DECIMAL(10,2) NULL,
    max_discount DECIMAL(10,2) NULL,
    usage_limit INT NULL,
    used_count INT NOT NULL CONSTRAINT DF_vouchers_used_count DEFAULT (0),
    starts_at DATETIME2(0) NULL,
    expires_at DATETIME2(0) NULL,
    is_active BIT NOT NULL CONSTRAINT DF_vouchers_is_active DEFAULT (1),
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL,
    CONSTRAINT CK_vouchers_type CHECK (type IN (N'percentage', N'fixed'))
);
GO

/* ORDERS */
CREATE TABLE dbo.orders (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    order_number NVARCHAR(255) NOT NULL,
    user_id BIGINT NOT NULL,
    customer_name NVARCHAR(255) NOT NULL,
    customer_phone NVARCHAR(255) NOT NULL,
    customer_email NVARCHAR(255) NOT NULL,
    customer_address NVARCHAR(MAX) NOT NULL,
    notes NVARCHAR(MAX) NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    total_amount DECIMAL(12,2) NOT NULL,
    payment_method NVARCHAR(255) NOT NULL CONSTRAINT DF_orders_payment_method DEFAULT (N'cash'),
    status NVARCHAR(255) NOT NULL CONSTRAINT DF_orders_status DEFAULT (N'pending'),
    rental_start_date DATE NOT NULL,
    rental_end_date DATE NOT NULL,
    total_months INT NOT NULL,
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL
);
GO

ALTER TABLE dbo.orders
ADD CONSTRAINT UQ_orders_order_number UNIQUE (order_number);

CREATE INDEX IX_orders_user_status ON dbo.orders(user_id, status);
GO

ALTER TABLE dbo.orders
ADD CONSTRAINT FK_orders_users FOREIGN KEY (user_id)
    REFERENCES dbo.users(id) ON DELETE CASCADE;
GO

/* ORDER ITEMS */
CREATE TABLE dbo.order_items (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    order_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    product_name NVARCHAR(255) NOT NULL,
    product_description NVARCHAR(MAX) NULL,
    product_image NVARCHAR(255) NULL,
    rental_duration_months INT NOT NULL,
    monthly_price DECIMAL(12,2) NOT NULL,
    total_price DECIMAL(12,2) NOT NULL,
    quantity INT NOT NULL CONSTRAINT DF_order_items_quantity DEFAULT (1),
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL
);
GO

CREATE INDEX IX_order_items_order_product ON dbo.order_items(order_id, product_id);
GO

ALTER TABLE dbo.order_items
ADD CONSTRAINT FK_order_items_orders FOREIGN KEY (order_id)
    REFERENCES dbo.orders(id) ON DELETE CASCADE;

ALTER TABLE dbo.order_items
ADD CONSTRAINT FK_order_items_products FOREIGN KEY (product_id)
    REFERENCES dbo.products(id) ON DELETE CASCADE;
GO

/* RENTALS */
CREATE TABLE dbo.rentals (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    rental_number NVARCHAR(255) NOT NULL UNIQUE,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status NVARCHAR(20) NOT NULL CONSTRAINT DF_rentals_status DEFAULT (N'pending'),
    total_amount DECIMAL(10,2) NOT NULL,
    deposit_amount DECIMAL(10,2) NOT NULL CONSTRAINT DF_rentals_deposit DEFAULT (0),
    notes NVARCHAR(MAX) NULL,
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL,
    CONSTRAINT CK_rentals_status CHECK (status IN (N'pending', N'active', N'completed', N'cancelled'))
);
GO

ALTER TABLE dbo.rentals
ADD CONSTRAINT FK_rentals_users FOREIGN KEY (user_id)
    REFERENCES dbo.users(id) ON DELETE CASCADE;
GO

/* RENTAL ITEMS */
CREATE TABLE dbo.rental_items (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    rental_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    rental_period NVARCHAR(20) NOT NULL,
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL,
    CONSTRAINT CK_rental_items_period CHECK (rental_period IN (N'daily', N'weekly', N'monthly'))
);
GO

ALTER TABLE dbo.rental_items
ADD CONSTRAINT FK_rental_items_rentals FOREIGN KEY (rental_id)
    REFERENCES dbo.rentals(id) ON DELETE CASCADE;

ALTER TABLE dbo.rental_items
ADD CONSTRAINT FK_rental_items_products FOREIGN KEY (product_id)
    REFERENCES dbo.products(id) ON DELETE CASCADE;
GO

/* CARTS */
CREATE TABLE dbo.carts (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    rental_duration TINYINT NOT NULL,
    quantity INT NOT NULL CONSTRAINT DF_carts_quantity DEFAULT (1),
    price_per_month BIGINT NOT NULL CONSTRAINT DF_carts_price_per_month DEFAULT (0),
    total_price BIGINT NOT NULL CONSTRAINT DF_carts_total_price DEFAULT (0),
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL
);
GO

CREATE INDEX IX_carts_user ON dbo.carts(user_id);
CREATE INDEX IX_carts_product ON dbo.carts(product_id);
GO

ALTER TABLE dbo.carts
ADD CONSTRAINT FK_carts_users FOREIGN KEY (user_id)
    REFERENCES dbo.users(id) ON DELETE CASCADE;

ALTER TABLE dbo.carts
ADD CONSTRAINT FK_carts_products FOREIGN KEY (product_id)
    REFERENCES dbo.products(id) ON DELETE CASCADE;
GO

/* RATINGS */
CREATE TABLE dbo.ratings (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    product_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,
    stars TINYINT NOT NULL,
    content NVARCHAR(MAX) NULL,
    is_anonymous BIT NOT NULL CONSTRAINT DF_ratings_is_anonymous DEFAULT (0),
    package_months TINYINT NULL,
    status NVARCHAR(20) NOT NULL CONSTRAINT DF_ratings_status DEFAULT (N'pending'),
    reviewed_at DATETIME2(0) NULL,
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL,
    CONSTRAINT CK_ratings_stars CHECK (stars BETWEEN 1 AND 5)
);
GO

ALTER TABLE dbo.ratings
ADD CONSTRAINT UQ_ratings_product_user UNIQUE (product_id, user_id);

CREATE INDEX IX_ratings_status ON dbo.ratings(status);
GO

ALTER TABLE dbo.ratings
ADD CONSTRAINT FK_ratings_products FOREIGN KEY (product_id)
    REFERENCES dbo.products(id) ON DELETE CASCADE;

ALTER TABLE dbo.ratings
ADD CONSTRAINT FK_ratings_users FOREIGN KEY (user_id)
    REFERENCES dbo.users(id) ON DELETE CASCADE;
GO

/* COMMENTS */
CREATE TABLE dbo.comments (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    product_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL,
    content NVARCHAR(MAX) NOT NULL,
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL
);
GO

ALTER TABLE dbo.comments
ADD CONSTRAINT FK_comments_products FOREIGN KEY (product_id)
    REFERENCES dbo.products(id) ON DELETE CASCADE;

ALTER TABLE dbo.comments
ADD CONSTRAINT FK_comments_users FOREIGN KEY (user_id)
    REFERENCES dbo.users(id) ON DELETE CASCADE;
GO

/* ADMIN PERMISSIONS */
CREATE TABLE dbo.admin_permissions (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    permission NVARCHAR(255) NOT NULL,
    granted BIT NOT NULL CONSTRAINT DF_admin_permissions_granted DEFAULT (0),
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL
);
GO

ALTER TABLE dbo.admin_permissions
ADD CONSTRAINT UQ_admin_permissions UNIQUE (user_id, permission);

ALTER TABLE dbo.admin_permissions
ADD CONSTRAINT FK_admin_permissions_users FOREIGN KEY (user_id)
    REFERENCES dbo.users(id) ON DELETE CASCADE;
GO

/* CHECK-INS */
CREATE TABLE dbo.check_ins (
    id BIGINT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    check_in_date DATE NOT NULL,
    day_number INT NOT NULL,
    reward_type NVARCHAR(255) NULL,
    reward_value NVARCHAR(255) NULL,
    reward_description NVARCHAR(MAX) NULL,
    is_claimed BIT NOT NULL CONSTRAINT DF_check_ins_is_claimed DEFAULT (0),
    claimed_at DATETIME2(0) NULL,
    created_at DATETIME2(0) NULL,
    updated_at DATETIME2(0) NULL
);
GO

ALTER TABLE dbo.check_ins
ADD CONSTRAINT UQ_check_ins_user_date UNIQUE (user_id, check_in_date);

ALTER TABLE dbo.check_ins
ADD CONSTRAINT FK_check_ins_users FOREIGN KEY (user_id)
    REFERENCES dbo.users(id) ON DELETE CASCADE;
GO