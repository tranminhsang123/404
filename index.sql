-- Bảng seller: lưu thông tin người bán
CREATE TABLE seller (
    seller_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    shop_name VARCHAR(100) NOT NULL,
    shop_description TEXT,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Bảng product: lưu thông tin sản phẩm của người bán
CREATE TABLE product (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    seller_id INT,
    product_name VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    price DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES seller(seller_id) ON DELETE CASCADE
);

-- Bảng order: lưu thông tin đơn hàng do khách hàng tạo
CREATE TABLE `order` (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    seller_id INT,
    customer_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2),
    status ENUM('pending', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (seller_id) REFERENCES seller(seller_id) ON DELETE SET NULL
);

-- Bảng order_item: lưu chi tiết từng sản phẩm trong đơn hàng
CREATE TABLE order_item (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES `order`(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE
);

-- Bảng transaction: lưu thông tin về doanh thu và lịch sử thanh toán cho người bán
CREATE TABLE transaction (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    seller_id INT,
    amount DECIMAL(10, 2) NOT NULL,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description VARCHAR(255),
    transaction_type ENUM('sale', 'refund', 'commission', 'withdrawal') NOT NULL,
    FOREIGN KEY (seller_id) REFERENCES seller(seller_id) ON DELETE CASCADE
);


// người mua 
-- Bảng customer: Lưu thông tin người mua
CREATE TABLE customer (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Bảng motorcycle: Lưu thông tin chi tiết các xe mô tô do người bán cung cấp
CREATE TABLE motorcycle (
    motorcycle_id INT PRIMARY KEY AUTO_INCREMENT,
    seller_id INT,
    model_name VARCHAR(100) NOT NULL,
    brand VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    engine_capacity INT, -- dung tích động cơ (cc)
    price DECIMAL(15, 2) NOT NULL,
    color VARCHAR(30),
    mileage INT, -- số km đã đi nếu là xe đã qua sử dụng
    condition ENUM('new', 'used') DEFAULT 'new', -- tình trạng xe
    stock INT DEFAULT 0,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES seller(seller_id) ON DELETE SET NULL
);

-- Bảng motorcycle_image: Lưu ảnh của từng xe mô tô (mỗi xe có thể có nhiều ảnh)
CREATE TABLE motorcycle_image (
    image_id INT PRIMARY KEY AUTO_INCREMENT,
    motorcycle_id INT,
    image_url VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (motorcycle_id) REFERENCES motorcycle(motorcycle_id) ON DELETE CASCADE
);

-- Bảng order: Lưu thông tin đơn hàng của người mua
CREATE TABLE `order` (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(15, 2),
    status ENUM('pending', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE SET NULL
);

-- Bảng order_item: Lưu chi tiết từng xe mô tô trong đơn hàng
CREATE TABLE order_item (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    motorcycle_id INT,
    quantity INT NOT NULL,
    price DECIMAL(15, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES `order`(order_id) ON DELETE CASCADE,
    FOREIGN KEY (motorcycle_id) REFERENCES motorcycle(motorcycle_id) ON DELETE CASCADE
);

-- Bảng transaction: Lưu thông tin về các giao dịch liên quan đến đơn hàng của người mua
CREATE TABLE transaction (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    order_id INT,
    amount DECIMAL(15, 2) NOT NULL,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description VARCHAR(255),
    transaction_type ENUM('payment', 'refund') NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE SET NULL,
    FOREIGN KEY (order_id) REFERENCES `order`(order_id) ON DELETE CASCADE
);





// -- Bảng admin: Lưu thông tin tài khoản quản trị viên
CREATE TABLE admin (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    role ENUM('superadmin', 'moderator') DEFAULT 'moderator',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng seller: Lưu thông tin người bán
CREATE TABLE seller (
    seller_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    shop_name VARCHAR(100) NOT NULL,
    shop_description TEXT,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Bảng customer: Lưu thông tin người mua
CREATE TABLE customer (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Bảng motorcycle: Lưu thông tin chi tiết các xe mô tô do người bán cung cấp
CREATE TABLE motorcycle (
    motorcycle_id INT PRIMARY KEY AUTO_INCREMENT,
    seller_id INT,
    model_name VARCHAR(100) NOT NULL,
    brand VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    engine_capacity INT, -- dung tích động cơ (cc)
    price DECIMAL(15, 2) NOT NULL,
    color VARCHAR(30),
    mileage INT, -- số km đã đi (áp dụng cho xe cũ)
    condition ENUM('new', 'used') DEFAULT 'new', -- tình trạng xe
    stock INT DEFAULT 0,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES seller(seller_id) ON DELETE SET NULL
);

-- Bảng order: Lưu thông tin đơn hàng do khách hàng tạo
CREATE TABLE `order` (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(15, 2),
    status ENUM('pending', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE SET NULL
);

-- Bảng order_item: Lưu chi tiết từng xe mô tô trong đơn hàng
CREATE TABLE order_item (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    motorcycle_id INT,
    quantity INT NOT NULL,
    price DECIMAL(15, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES `order`(order_id) ON DELETE CASCADE,
    FOREIGN KEY (motorcycle_id) REFERENCES motorcycle(motorcycle_id) ON DELETE CASCADE
);

-- Bảng transaction: Lưu thông tin về các giao dịch liên quan đến đơn hàng
CREATE TABLE transaction (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    order_id INT,
    amount DECIMAL(15, 2) NOT NULL,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description VARCHAR(255),
    transaction_type ENUM('payment', 'refund') NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE SET NULL,
    FOREIGN KEY (order_id) REFERENCES `order`(order_id) ON DELETE CASCADE
);

-- Bảng admin_activity_log: Lưu lịch sử hoạt động của admin để quản lý hệ thống
CREATE TABLE admin_activity_log (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT,
    activity_type ENUM('create', 'update', 'delete', 'suspend', 'activate') NOT NULL,
    target_type ENUM('seller', 'customer', 'motorcycle', 'order') NOT NULL,
    target_id INT NOT NULL,
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    details TEXT,
    FOREIGN KEY (admin_id) REFERENCES admin(admin_id) ON DELETE SET NULL
);

-- Bảng feedback: Lưu phản hồi từ người mua hoặc người bán, để admin quản lý
CREATE TABLE feedback (
    feedback_id INT PRIMARY KEY AUTO_INCREMENT,
    user_type ENUM('customer', 'seller') NOT NULL,
    user_id INT NOT NULL,
    target_id INT, -- Mục tiêu của phản hồi có thể là một sản phẩm hoặc đơn hàng
    feedback_type ENUM('product', 'order') NOT NULL,
    content TEXT NOT NULL,
    rating INT CHECK(rating BETWEEN 1 AND 5), -- Đánh giá từ 1 đến 5 sao
    feedback_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) 
        REFERENCES CASE WHEN user_type = 'customer' THEN customer(customer_id) ELSE seller(seller_id) END
);

