DROP TABLE IF EXISTS ADDRESS;
DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS PRODUCT;
DROP TABLE IF EXISTS SELLS;
DROP TABLE IF EXISTS REVIEWS;
DROP TABLE IF EXISTS EVENT;

PRAGMA foreign_keys = ON;

CREATE TABLE ADDRESS (
    address_id INT PRIMARY KEY,
    postal_code_first VARCHAR(4) NOT NULL,
    postal_code_second VARCHAR(3) NOT NULL,  
    address VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL
);

CREATE TABLE USER (
    username VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(9) NOT NULL,
    address_id INT,
    FOREIGN KEY (address_id) REFERENCES ADDRESS(address_id)
);

CREATE TABLE PRODUCT (
    product_id INT PRIMARY KEY,
    category VARCHAR(50) NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    seller_id VARCHAR(50) NOT NULL,
    event_id INTEGER,
    FOREIGN KEY (seller_id) REFERENCES USER(username),
    FOREIGN KEY (event_id) REFERENCES EVENT(event_id)
);

CREATE TABLE SELLS (
    sell_id INT PRIMARY KEY,
    seller_id VARCHAR(50) NOT NULL,
    buyer_id VARCHAR(50) NOT NULL,
    product_id INT NOT NULL,
    review_id INT,
    FOREIGN KEY (seller_id) REFERENCES USER(username),
    FOREIGN KEY (buyer_id) REFERENCES USER(username),
    FOREIGN KEY (product_id) REFERENCES PRODUCT(product_id),
    FOREIGN KEY (review_id) REFERENCES REVIEWS(review_id)
);

CREATE TABLE REVIEWS (
    review_id INTEGER PRIMARY KEY,
    seller_evaluation INTEGER NOT NULL CHECK (seller_evaluation >= 1 AND seller_evaluation <= 5),
    logistics_evaluation INTEGER NOT NULL CHECK (logistics_evaluation >= 1 AND logistics_evaluation <= 5),
    overall_evaluation INTEGER NOT NULL CHECK (overall_evaluation >= 1 AND overall_evaluation <= 5),
    platform_evaluation INTEGER NOT NULL CHECK (platform_evaluation >= 1 AND platform_evaluation <= 5),
    comment TEXT
);

CREATE TABLE EVENT (
    event_id INTEGER PRIMARY KEY,
    event_type TEXT CHECK (event_type IN ('flash_sale', 'holiday_discount')),
    discount_percentage DECIMAL(5,2) NOT NULL,
    sell_event TEXT
);

-- Inserting sample data into the ADDRESS table
INSERT INTO ADDRESS (address_id, postal_code_first, postal_code_second, address, city) VALUES
    (1, '1234', '567', '123 Main Street', 'City1'),
    (2, '5678', '901', '456 Elm Street', 'City2'),
    (3, '9012', '345', '789 Oak Street', 'City3'),
    (4, '3456', '789', '321 Pine Street', 'City4'),
    (5, '7890', '123', '654 Maple Street', 'City5');

-- Inserting sample data into the USER table
INSERT INTO USER (username, name, password, phone_number, address_id) VALUES
    ('user1', 'John Doe', 'password1', '912345678', 1),
    ('user2', 'Jane Smith', 'password2', '912345679', 2),
    ('user3', 'Alice Johnson', 'password3', '912345670', 3),
    ('user4', 'Bob Brown', 'password4', '912345671', 4),
    ('user5', 'Eve White', 'password5', '912345672', 5);

-- Inserting sample data into the PRODUCT table
INSERT INTO PRODUCT (product_id, category, title, description, price, seller_id, event_id) VALUES
    (1, 'Electronics', 'Smartphone', 'High-end smartphone with advanced features', 999.99, 'user1', 1),
    (2, 'Clothing', 'T-shirt', 'Comfortable cotton t-shirt in various colors', 19.99, 'user2', 2),
    (3, 'Books', 'Novel', 'Bestselling novel by a renowned author', 14.99, 'user3', 3),
    (4, 'Electronics', 'Laptop', 'Powerful laptop for work and entertainment', 1499.99, 'user4', NULL),
    (5, 'Home & Kitchen', 'Coffee Maker', 'Automatic coffee maker for brewing delicious coffee', 79.99, 'user5', 5);

-- Inserting sample data into the SELLS table
INSERT INTO SELLS (sell_id, seller_id, buyer_id, product_id, review_id) VALUES
    (1, 'user1', 'user2', 1, NULL),
    (2, 'user2', 'user3', 2, 1),
    (3, 'user3', 'user4', 3, NULL),
    (4, 'user4', 'user5', 4, 2),
    (5, 'user5', 'user1', 5, NULL);

-- Inserting sample data into the REVIEWS table
INSERT INTO REVIEWS (review_id, seller_evaluation, logistics_evaluation, overall_evaluation, platform_evaluation, comment) VALUES
    (1, 4, 5, 4, 5, 'Great seller! Product arrived on time and in perfect condition.'),
    (2, 5, 4, 5, 5, 'Excellent experience overall. Would buy again.'),
    (3, 3, 4, 3, 4, NULL),
    (4, 5, 5, 5, 5, 'Absolutely satisfied with the purchase and service.'),
    (5, 4, 3, 4, 4, NULL);

-- Inserting sample data into the EVENT table
INSERT INTO EVENT (event_id, event_type, discount_percentage, sell_event) VALUES
    (1, 'flash_sale', 10.00, 'flash_sale'),
    (2, 'holiday_discount', 15.00, 'holiday_discount'),
    (3, 'flash_sale', 20.00, 'flash_sale'),
    (4, 'holiday_discount', 25.00, 'holiday_discount'),
    (5, 'flash_sale', 30.00, 'flash_sale');

