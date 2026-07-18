-- =====================================
-- USERS
-- =====================================

INSERT INTO users
(
    email,
    password_hash,
    role
)
VALUES
(
    'demo@omsbi.com',
    '$2y$10$WgUIRZ13ZTwBwdo7Vv7naeLB6t.G0Aku2VlufInOOorRwirD/9Cyu',
    'admin'
);



-- =====================================
-- PRODUCTS
-- =====================================

INSERT INTO products
(
    sku,
    title,
    price,
    stock_qty,
    low_threshold
)
VALUES

(
    'SKU001',
    'Laptop',
    12000.00,
    4,
    3
),

(
    'SKU002',
    'Keyboard',
    500.00,
    25,
    5
),

(
    'SKU003',
    'Mouse',
    250.00,
    40,
    5
);



-- =====================================
-- ORDERS
-- =====================================

INSERT INTO orders
(
    channel_source,
    channel_ref_id,
    customer_name,
    order_status
)
VALUES

(
    'webfront',
    NULL,
    'John Doe',
    'pending'
),

(
    'shopify',
    'SHOP-1001',
    'Mary Smith',
    'processing'
);



-- =====================================
-- ORDER ITEMS
-- =====================================

INSERT INTO order_items
(
    order_id,
    product_id,
    quantity,
    price_at_sale
)
VALUES

(
    1,
    1,
    6,
    12000.00
),

(
    2,
    2,
    2,
    500.00
),

(
    2,
    3,
    3,
    250.00
);