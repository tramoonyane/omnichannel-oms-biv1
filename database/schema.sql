CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    email VARCHAR(255) NOT NULL UNIQUE,

    password_hash VARCHAR(255) NOT NULL,

    role ENUM(
        'admin',
        'warehouse',
        'manager'
    ) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    sku VARCHAR(100) NOT NULL UNIQUE,

    title VARCHAR(255) NOT NULL,

    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,

    stock_qty INT NOT NULL DEFAULT 0,

    low_threshold INT NOT NULL DEFAULT 5
);

CREATE TABLE orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    channel_source ENUM(
        'webfront',
        'shopify',
        'bigcommerce',
        'woo'
    ) DEFAULT 'webfront',

    channel_ref_id VARCHAR(100),

    customer_name VARCHAR(255) NOT NULL,

    order_status ENUM(
        'pending',
        'processing',
        'shipped',
        'cancelled'
    ) DEFAULT 'pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    order_id BIGINT UNSIGNED NOT NULL,

    product_id BIGINT UNSIGNED NOT NULL,

    quantity INT NOT NULL,

    price_at_sale DECIMAL(10,2) NOT NULL,

    CONSTRAINT fk_order_items_order
        FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_order_items_product
        FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON UPDATE RESTRICT
);