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
    scale INT NOT NULL,
    FOREIGN KEY (seller_id) REFERENCES USER(username),
    FOREIGN KEY (brand) REFERENCES BRANDS(brand_id),
    FOREIGN KEY (category) REFERENCES CATEGORY(category_id),
    FOREIGN KEY (scale) REFERENCES SCALE(scale_id)
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

CREATE TABLE SCALE {
    scale_id INTEGER PRIMARY KEY,
    scale_name TEXT NOT NULL
}

CREATE TABLE ACCESSORIES (
    accessory_id INTEGER PRIMARY KEY,
    accessory_name TEXT NOT NULL,
    accessory_category INTEGER NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (accessory_category) REFERENCES ACCESSORY_CATEGORY(accessory_category_id)
)

CREATE TABLE ACCESSORY_CATEGORY {
    accessory_category_id INTEGER PRIMARY KEY,
    accessory_category_name TEXT NOT NULL
}

INSERT INTO BRANDS (brand_id, brand_name) VALUES 
    (1, 'Acura'),
    (2, 'Alfa Romeo'),
    (3, 'Alpine'),
    (4, 'Aston Martin'),
    (5, 'Audi'),
    (6, 'BMW'),
    (7, 'Bugatti'),
    (8, 'Buick'),
    (9, 'Cadillac'),
    (10, 'Chevrolet'),
    (11, 'Chrysler'),
    (12, 'Dodge'),
    (13, 'Ferrari'),
    (14, 'Fiat'),
    (15, 'Ford'),
    (16, 'Genesis'),
    (17, 'GMC'),
    (18, 'Haas'),
    (19, 'Honda'),
    (20, 'Hyundai'),
    (21, 'Infiniti'),
    (22, 'Jaguar'),
    (23, 'Jeep'),
    (24, 'Kia'),
    (25, 'Lamborghini'),
    (26, 'Land Rover'),
    (27, 'Lexus'),
    (28, 'Lincoln'),
    (29, 'Lotus'),
    (30, 'Maserati'),
    (31, 'Mazda'),
    (32, 'McLaren'),
    (33, 'Mercedes-Benz'),
    (34, 'Mini'),
    (35, 'Mitsubishi'),
    (36, 'Nissan'),
    (37, 'Pagani'),
    (38, 'Porsche'),
    (39, 'Ram'),
    (40, 'Rolls-Royce'),
    (41, 'Subaru'),
    (42, 'Tesla'),
    (43, 'Toyota'),
    (44, 'Volkswagen'),
    (45, 'Volvo'),
    (46, 'Red Bull Racing'),
    (47, 'Williams Racing'),
    (48, 'Others');

INSERT INTO CATEGORY (category_id, category_name) VALUES
    (1, 'Civil cars'),
    (2, 'DTM'),
    (3, 'F1'),
    (4, 'GT'),
    (5, 'Indy'),
    (6, 'Le Mans'),
    (7, 'Nascar'),
    (8, 'Rally'),
    (9, 'Touring'),
    (10, 'Others');

INSERT INTO SCALE (scale_id, scale_name) VALUES
    (1, '1/8'),
    (2, '1/12'),
    (3, '1/18'),
    (4, '1/24'),
    (5, '1/32'),
    (6, '1/43'),
    (7, '1/64');

INSERT INTO ACCESSORY_CATEGORY (accessory_category_id, accessory_category_name) VALUES
    (1, 'Helmets'),
    (2, 'Trophies'),
    (3, 'Shirts'),
    (4, 'Caps'),
    (5, 'Legos');
