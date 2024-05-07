DROP TABLE IF EXISTS ADDRESS;
DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS PRODUCT;
DROP TABLE IF EXISTS PRODUCT_IMAGES;
DROP TABLE IF EXISTS SELLS;
DROP TABLE IF EXISTS REVIEWS;
DROP TABLE IF EXISTS EVENT;
DROP TABLE IF EXISTS BRANDS;
DROP TABLE IF EXISTS CATEGORY;
DROP TABLE IF EXISTS SCALE;
DROP TABLE IF EXISTS ACCESSORIES;
DROP TABLE IF EXISTS ACCESSORY_CATEGORY;
DROP TABLE IF EXISTS WISH_LIST;
DROP TABLE IF EXISTS QA;

PRAGMA foreign_keys = ON;

CREATE TABLE ADDRESS (
    address_id INT PRIMARY KEY,
    postal_code VARCHAR(10) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL
);

CREATE TABLE USER (
    username VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR NOT NULL,
    address_id INT,
    FOREIGN KEY (address_id) REFERENCES ADDRESS(address_id)
);

CREATE TABLE PRODUCT (
    product_id INTEGER PRIMARY KEY AUTOINCREMENT,
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

CREATE TABLE PRODUCT_IMAGES (
    image_id INTEGER PRIMARY KEY,
    product_id INT NOT NULL,
    image_url TEXT,
    FOREIGN KEY (product_id) REFERENCES PRODUCT(product_id)
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
);

CREATE TABLE SCALE (
    scale_id INTEGER PRIMARY KEY,
    scale_name TEXT NOT NULL
);

CREATE TABLE ACCESSORIES (
    accessory_id INTEGER PRIMARY KEY,
    accessory_name TEXT NOT NULL,
    accessory_category INTEGER NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (accessory_category) REFERENCES ACCESSORY_CATEGORY(accessory_category_id)
);

CREATE TABLE ACCESSORY_CATEGORY (
    accessory_category_id INTEGER PRIMARY KEY,
    accessory_category_name TEXT NOT NULL
);

CREATE TABLE WISH_LIST (
    wish_id INTEGER PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    product_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES USER(username),
    FOREIGN KEY (product_id) REFERENCES PRODUCT(product_id)
);

CREATE TABLE QA (
    qa_id INTEGER PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    product_id INT NOT NULL,
    question TEXT NOT NULL,
    answer TEXT,
    FOREIGN KEY (user_id) REFERENCES USER(username),
    FOREIGN KEY (product_id) REFERENCES PRODUCT(product_id)
);

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
    (48, 'Other');

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
    (10, 'Other');

INSERT INTO SCALE (scale_id, scale_name) VALUES
    (1, '1/8'),
    (2, '1/12'),
    (3, '1/18'),
    (4, '1/24'),
    (5, '1/32'),
    (6, '1/43'),
    (7, '1/64'),
    (8, 'Other');

INSERT INTO ACCESSORY_CATEGORY (accessory_category_id, accessory_category_name) VALUES
    (1, 'Helmets'),
    (2, 'Trophies'),
    (3, 'Shirts'),
    (4, 'Caps'),
    (5, 'Legos');

INSERT INTO ADDRESS (address_id, postal_code, address, city, country) VALUES
    (1, '12345', '123 Main St', 'City A', 'Country A'),
    (2, '23456', '456 Elm St', 'City B', 'Country B'),
    (3, '34567', '789 Oak St', 'City C', 'Country C'),
    (4, '45678', '101 Pine St', 'City D', 'Country D'),
    (5, '56789', '202 Maple St', 'City E', 'Country E'),
    (6, '67890', '303 Cedar St', 'City F', 'Country F'),
    (7, '78901', '404 Walnut St', 'City G', 'Country G'),
    (8, '89012', '505 Birch St', 'City H', 'Country H'),
    (9, '90123', '606 Spruce St', 'City I', 'Country I'),
    (10, '01234', '707 Fir St', 'City J', 'Country J');

INSERT INTO USER (username, name, password, phone_number, address_id) VALUES
    ('user1', 'John Doe', 'e38ad214943daad1d64c102faec29de4afe9da3d', '123456789', 1),
    ('user2', 'Jane Smith', '2aa60a8ff7fcd473d321e0146afd9e26df395147', '234567890', 2),
    ('user3', 'Alice Johnson', '1119cfd37ee247357e034a08d844eea25f6fd20f', '345678901', 3),
    ('user4', 'Bob Brown', 'a1d7584daaca4738d499ad7082886b01117275d8', '456789012', 4),
    ('user5', 'Emma Davis', 'edba955d0ea15fdef4f61726ef97e5af507430c0', '567890123', 5),
    ('user6', 'James Wilson', '6d749e8a378a34cf19b4c02f7955f57fdba130a5', '678901234', 6),
    ('user7', 'Olivia Martinez', '330ba60e243186e9fa258f9992d8766ea6e88bc1', '789012345', 7),
    ('user8', 'William Anderson', 'a8dbbfa41cec833f8dd42be4d1fa9a13142c85c2', '890123456', 8),
    ('user9', 'Sophia Taylor', '024b01916e3eaec66a2c4b6fc587b1705f1a6fc8', '901234567', 9),
    ('user10', 'Michael Thomas', 'f68ec41cde16f6b806d7b04c705766b7318fbb1d', '012345678', 10);

INSERT INTO PRODUCT (product_id, category, title, description, price, seller_id, brand, scale) VALUES
    (1, 1, 'Acura NSX', 'Description for Acura NSX', 50.00, 'user1', 1, 1),
    (2, 1, 'Alfa Romeo Giulia', 'Description for Alfa Romeo Giulia', 45.00, 'user2', 2, 2),
    (3, 1, 'Aston Martin Vantage', 'Description for Aston Martin Vantage', 150.00, 'user3', 4, 3),
    (4, 1, 'Audi R8', 'Description for Audi R8', 175.00, 'user4', 5, 4),
    (5, 1, 'BMW M3', 'Description for BMW M3', 60.00, 'user5', 6, 5),
    (6, 1, 'Ferrari 488', 'Description for Ferrari 488', 250.00, 'user6', 13, 6),
    (7, 1, 'Ford Mustang', 'Description for Ford Mustang', 4.00, 'user7', 15, 7),
    (8, 1, 'Mercedes-Benz AMG GT', 'Description for Mercedes-Benz AMG GT', 10.00, 'user8', 33, 3),
    (9, 1, 'Porsche 911', 'Description for Porsche 911', 130.0, 'user9', 38, 4),
    (10, 1, 'Tesla Model S', 'Description for Tesla Model S', 80.99, 'user10', 42, 5);

INSERT INTO PRODUCT_IMAGES (image_id, product_id, image_url) VALUES
    (1, 1, '1.jpg'),
    (2, 2, '2.jpg'),
    (3, 3, '3.jpg'),
    (4, 4, '4.jpg'),
    (5, 5, '5.jpg'),
    (6, 6, '6.jpg'),
    (7, 7, '7.jpg'),
    (8, 8, '8.jpg'),
    (9, 9, '9.jpg'),
    (10, 10, '10.jpg'),
    (11, 4, '4_1.jpg');

INSERT INTO REVIEWS (review_id, seller_evaluation, logistics_evaluation, overall_evaluation, platform_evaluation, comment) VALUES
    (1, 5, 5, 5, 5, 'Great transaction, highly recommended seller!'),
    (2, 4, 5, 4, 4, 'Good product, fast shipping.'),
    (3, 5, 4, 4, 5, 'Beautiful car, minor delay in delivery.'),
    (4, 4, 4, 4, 4, 'Nice car, smooth transaction.'),
    (5, 3, 5, 3, 3, 'Decent car, delayed shipping.'),
    (6, 5, 5, 5, 5, 'Excellent car, fast shipping.'),
    (7, 4, 5, 4, 4, 'Good car, no issues.'),
    (8, 5, 5, 5, 5, 'Perfect car, smooth transaction.'),
    (9, 3, 4, 3, 3, 'Okay car, shipping took a while.'),
    (10, 4, 5, 4, 4, 'Satisfactory car, fast shipping.');

INSERT INTO SELLS (sell_id, seller_id, buyer_id, product_id, review_id) VALUES
    (1, 'user1', 'user2', 1, 1),
    (2, 'user2', 'user3', 2, 2),
    (3, 'user3', 'user4', 3, 3),
    (4, 'user4', 'user5', 4, 4),
    (5, 'user5', 'user6', 5, 5),
    (6, 'user6', 'user7', 6, 6),
    (7, 'user7', 'user8', 7, 7),
    (8, 'user8', 'user9', 8, 8),
    (9, 'user9', 'user10', 9, 9),
    (10, 'user10', 'user1', 10, 10);

INSERT INTO EVENT (event_id, event_type, discount_percentage, sell_event) VALUES
    (1, 'flash_sale', 10.00, 'Flash sale event for selected products.'),
    (2, 'holiday_discount', 20.00, 'Holiday discount event for all products.');

INSERT INTO ACCESSORIES (accessory_id, accessory_name, accessory_category, price) VALUES
    (1, 'Racing Helmet', 1, 100.00),
    (2, 'Champion Trophy', 2, 50.00),
    (3, 'Team Shirt', 3, 30.00),
    (4, 'Logo Cap', 4, 20.00),
    (5, 'Model Car', 5, 15.00),
    (6, 'Racing Helmet', 1, 100.00),
    (7, 'Champion Trophy', 2, 50.00),
    (8, 'Team Shirt', 3, 30.00),
    (9, 'Logo Cap', 4, 20.00),
    (10, 'Model Car', 5, 15.00);