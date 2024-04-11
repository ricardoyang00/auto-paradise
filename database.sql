DROP TABLE IF EXISTS ADDRESS;
DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS PRODUCT;
DROP TABLE IF EXISTS SELLS;
DROP TABLE IF EXISTS REVIEWS;
DROP TABLE IF EXISTS EVENT;
DROP TABLE IF EXISTS BRANDS;

PRAGMA foreign_keys = ON;

CREATE TABLE ADDRESS (
    address_id INT PRIMARY KEY,
    postal_code VARCHAR(10) NOT NULL,
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
    category INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    seller_id VARCHAR(50) NOT NULL,
    brand INT NOT NULL,
    scale VARCHAR(10),
    FOREIGN KEY (seller_id) REFERENCES USER(username),
    FOREIGN KEY (brand) REFERENCES BRANDS(brand_id),
    FOREIGN KEY (category) REFERENCES CATEGORY(category_id)
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

CREATE TABLE BRANDS (
    brand_id INTEGER PRIMARY KEY,
    brand_name TEXT NOT NULL
);

CREATE TABLE CATEGORY (
    category_id INTEGER PRIMARY KEY,
    category_name TEXT NOT NULL
)
