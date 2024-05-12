DROP TABLE IF EXISTS ADDRESS;
DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS ADMIN;
DROP TABLE IF EXISTS PRODUCT;
DROP TABLE IF EXISTS PRODUCT_IMAGES;
DROP TABLE IF EXISTS PRODUCT_STATE;
DROP TABLE IF EXISTS ORDERS;
DROP TABLE IF EXISTS SELLS;
DROP TABLE IF EXISTS REVIEWS;
DROP TABLE IF EXISTS EVENT;
DROP TABLE IF EXISTS BRANDS;
DROP TABLE IF EXISTS CATEGORY;
DROP TABLE IF EXISTS SCALE;
DROP TABLE IF EXISTS ACCESSORIES;
DROP TABLE IF EXISTS ACCESSORY_CATEGORY;
DROP TABLE IF EXISTS WISHLIST;
DROP TABLE IF EXISTS QA;
DROP TABLE IF EXISTS BAN;

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

CREATE TABLE ORDERS (
    order_id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_username VARCHAR(50) NOT NULL,
    product_id INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    seller_username VARCHAR(50) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_method VARCHAR(10) NOT NULL,
    phone_number VARCHAR(15),
    card_number VARCHAR(20),
    FOREIGN KEY (client_username) REFERENCES USER(username),
    FOREIGN KEY (product_id) REFERENCES PRODUCT(product_id),
    FOREIGN KEY (seller_username) REFERENCES USER(username)
);

CREATE TABLE ADMIN (
    admin_id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(50) NOT NULL,
    FOREIGN KEY (username) REFERENCES USER(username)
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
    FOREIGN KEY (product_id) REFERENCES PRODUCT(product_id) ON DELETE CASCADE
);

CREATE TABLE PRODUCT_STATE (
    product_id INT PRIMARY KEY,
    status VARCHAR(16) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES PRODUCT(product_id) ON DELETE CASCADE
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

CREATE TABLE WISHLIST (
    wish_id INTEGER PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    product_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES USER(username),
    FOREIGN KEY (product_id) REFERENCES PRODUCT(product_id) ON DELETE CASCADE
);

CREATE TABLE QA (
    qa_id INTEGER PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    product_id INT NOT NULL,
    question TEXT NOT NULL,
    answer TEXT,
    FOREIGN KEY (user_id) REFERENCES USER(username),
    FOREIGN KEY (product_id) REFERENCES PRODUCT(product_id) ON DELETE CASCADE
);

CREATE TABLE BAN (
    ban_id INTEGER PRIMARY KEY, 
    product_id INT NOT NULL,
    reason TEXT NOT NULL,
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
    (10, '01234', '707 Fir St', 'City J', 'Country J'),
    (11, '00000', '0 Zero St', 'City K', 'Country K');

INSERT INTO USER (username, name, password, phone_number, address_id) VALUES
    ('user1', 'John Doe', '$2y$12$OAxx8x8115OTpUvqDPSzNeb7PK1uEYRGY3O6Qjos2NbDlFlAkfZFm', '123456789', 1),
    ('user2', 'Jane Smith', '$2y$12$vkeecxf8upaqp9F.B5kcWOHN/jpUSbidFvVvRBhEzdpVSv.A8BePK', '234567890', 2),
    ('user3', 'Alice Johnson', '$2y$12$RbTqk21koVz5N/amgPYxh.DNJ5TOrZgYNLe8gpfTrbgrUzfi82/yu', '345678901', 3),
    ('user4', 'Bob Brown', '$2y$12$RbkHXgCUAfys/5b.qz/oXefIVTc8i2xMrjFEDzZsDoAJW2.Z2kpdW', '456789012', 4),
    ('user5', 'Emma Davis', '$2y$12$v4kE2GooFKmc3HJreLkg/eSm1JGkeXqn2KGGKC7Rjx7.Dd6p.QlDq', '567890123', 5),
    ('user6', 'James Wilson', '$2y$12$YBTTrLwsjjd8OPvjWpMl.uY6.dtGFOpLHtU3qNdG68RoUMkqL2gwi', '678901234', 6),
    ('user7', 'Olivia Martinez', '$2y$12$m7TiTsj4PR2DLgR2ZNRueeNndfdnlgUKgSYbDg4y9VJwSX9tTR2z2', '789012345', 7),
    ('user8', 'William Anderson', '$2y$12$6Ig4AsBkrYKMFqu1O/ZnveKlvFFWZsQugSqktYS1DOv.9CcMihJ8S', '890123456', 8),
    ('user9', 'Sophia Taylor', '$2y$12$sJaIYaVlEtACnmicsaDngOET2nTaV1sKpiSTw6mev/5YpH925s85.', '901234567', 9),
    ('user10', 'Michael Thomas', '$2y$12$dmEa4APx2d397jli.B2bgul29i59wIKMq0WGkY71zIch1o4k4txli', '012345678', 10),
    ('admin', 'Admin', '$2y$12$AHXcZyJTi/uKoI.zAmTaQOUPl3GetpcQ3HqOX6zBTMs1miS/Zzqdi', '0', 11);

INSERT INTO ADMIN (username) VALUES
    ('admin');

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
    (10, 1, 'Tesla Model S', 'Description for Tesla Model S', 80.99, 'user10', 42, 5),
    (11, 2, 'BMW M4 DTM', 'Description for BMW M4 DTM', 70.00, 'user1', 6, 3),
    (12, 3, 'Mercedes-AMG Petronas F1 W12 E Performance', 'Description for Mercedes-AMG Petronas F1 W12 E Performance', 200.00, 'user1', 33, 6),
    (13, 4, 'Chevrolet Corvette C8.R', 'Description for Chevrolet Corvette C8.R', 90.00, 'user1', 10, 4),
    (14, 5, 'Honda Indy V6 Turbo', 'Description for Honda Indy V6 Turbo', 55.00, 'user2', 19, 5),
    (15, 6, 'Toyota TS050 Hybrid', 'Description for Toyota TS050 Hybrid', 120.00, 'user1', 43, 3),
    (16, 7, 'Ford Mustang Nascar', 'Description for Ford Mustang Nascar', 40.00, 'user2', 15, 7),
    (17, 8, 'Subaru Impreza WRC', 'Description for Subaru Impreza WRC', 65.00, 'user3', 41, 4),
    (18, 9, 'BMW 3 Series Touring Car', 'Description for BMW 3 Series Touring Car', 85.00, 'user1', 6, 2),
    (19, 10, 'Red Bull Racing RB16B', 'Description for Red Bull Racing RB16B', 180.00, 'user1', 46, 6),
    (20, 2, 'Audi RS5 DTM', 'Description for Audi RS5 DTM', 75.00, 'user2', 5, 3),
    (21, 3, 'Scuderia Ferrari SF21', 'Description for Scuderia Ferrari SF21', 220.00, 'user10', 13, 6),
    (22, 2, 'Ferrari 488 DTM', 'Description for Ferrari 488 DTM', 85.00, 'user2', 13, 3),
    (23, 3, 'Scuderia Ferrari SF1000', 'Description for Scuderia Ferrari SF1000', 250.00, 'user2', 13, 6),
    (24, 4, 'Ferrari 488 GT3', 'Description for Ferrari 488 GT3', 150.00, 'user1', 13, 4),
    (25, 5, 'Ferrari Indy Turbo', 'Description for Ferrari Indy Turbo', 120.00, 'user1', 13, 5),
    (26, 6, 'Ferrari 488 GTE', 'Description for Ferrari 488 GTE', 180.00, 'user1', 13, 3),
    (27, 7, 'Ferrari Nascar', 'Description for Ferrari Nascar', 100.00, 'user1', 13, 7),
    (28, 8, 'Ferrari 308 GTB Rally', 'Description for Ferrari 308 GTB Rally', 90.00, 'user1', 13, 4),
    (29, 9, 'Ferrari 328 Touring', 'Description for Ferrari 328 Touring', 80.00, 'user2', 13, 3),
    (30, 10, 'Ferrari SF90 Stradale', 'Description for Ferrari SF90 Stradale', 300.00, 'user3', 13, 8),
    (31, 3, 'Mercedes-AMG Petronas W13', 'Description for Mercedes-AMG Petronas W13', 300.00, 'user1', 33, 6),
    (32, 3, 'Red Bull Racing RB18', 'Description for Red Bull Racing RB18', 290.00, 'user1', 46, 6),
    (33, 3, 'McLaren MCL36', 'Description for McLaren MCL36', 280.00, 'user2', 32, 6),
    (34, 3, 'Alpine A522', 'Description for Alpine A522', 270.00, 'user3', 3, 6),
    (35, 3, 'Aston Martin AMR22', 'Description for Aston Martin AMR22', 260.00, 'user5', 4, 6),
    (36, 3, 'Alfa Romeo C42', 'Description for Alfa Romeo C42', 250.00, 'user6', 2, 6),
    (37, 3, 'Williams FW45', 'Description for Williams FW45', 240.00, 'user7', 47, 6),
    (38, 3, 'Haas VF-22', 'Description for Haas VF-22', 230.00, 'user8', 18, 6),
    (39, 3, 'AlphaTauri AT04', 'Description for AlphaTauri AT04', 220.00, 'user3', 46, 6),
    (40, 3, 'Sauber C42', 'Description for Sauber C42', 210.00, 'user1', 42, 6),
    (41, 3, 'Lotus E24', 'Description for Lotus E24', 200.00, 'user1', 29, 6),
    (42, 3, 'Caterham CT05', 'Description for Caterham CT05', 190.00, 'user4', 48, 6),
    (43, 3, 'Marussia MR03', 'Description for Marussia MR03', 180.00, 'user1', 48, 6);

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

INSERT INTO PRODUCT_IMAGES (product_id, image_url) VALUES
    (11, '11.jpg'),
    (11, '11_1.jpg'),
    (12, '12.jpg'),
    (12, '12_1.jpg'),
    (13, '13.jpg'),
    (14, '14.jpg'),
    (15, '15.jpg'),
    (16, '16.jpg'),
    (17, '17.jpg'),
    (18, '18.jpg'),
    (19, '19.jpg'),
    (20, '20.jpg'),
    (21, '21.jpg'),
    (22, '22.jpg'),
    (23, '23.jpg'),
    (24, '24.jpg'),
    (24, '24_1.jpg'),
    (25, '25.jpg'),
    (26, '26.jpg'),
    (27, '27.jpg'),
    (28, '28.jpg'),
    (29, '29.jpg'),
    (30, '30.jpg'),
    (31, '31.jpg'),
    (32, '32.jpg'),
    (33, '33.jpg'),
    (34, '34.jpg'),
    (35, '35.jpg'),
    (36, '36.jpg'),
    (37, '37.jpg'),
    (38, '38.jpg'),
    (39, '39.jpg'),
    (40, '40.jpg'),
    (41, '41.jpg'),
    (42, '42.jpg'),
    (43, '43.jpg');

INSERT INTO ORDERS (order_id, client_username, product_id, total_price, seller_username, order_date, payment_method, phone_number, card_number) VALUES
    (1, 'user1', 2, 50.99, 'user2', '2024-02-08 19:05:36', 'Credit Card', null, '1234567890123456'),
    (2, 'user1', 3, 150.00, 'user3', '2024-03-18 10:26:54', 'Credit Card', null, '1234567890123456'),
    (3, 'user1', 4, 180.99, 'user4', '2024-04-01 03:07:29', 'MBWAY', '965727473', null),
    (4, 'user2', 41, 205.99, 'user1', '2024-04-15 14:45:12', 'MBWAY', '926473827', null);

INSERT INTO PRODUCT_STATE (product_id, status) VALUES
    (1, 'Available'),
    (2, 'Sold'),
    (3, 'Sold'),
    (4, 'Sold'),
    (5, 'Available'),
    (6, 'Available'),
    (7, 'Available'),
    (8, 'Available'),
    (9, 'Available'),
    (10, 'Available'),
    (11, 'Available'),
    (12, 'Available'),
    (13, 'Available'),
    (14, 'Available'),
    (15, 'Available'),
    (16, 'Available'),
    (17, 'Available'),
    (18, 'Available'),
    (19, 'Available'),
    (20, 'Available'),
    (21, 'Available'),
    (22, 'Available'),
    (23, 'Available'),
    (24, 'Available'),
    (25, 'Available'),
    (26, 'Available'),
    (27, 'Available'),
    (28, 'Available'),
    (29, 'Available'),
    (30, 'Available'),
    (31, 'Available'),
    (32, 'Available'),
    (33, 'Available'),
    (34, 'Available'),
    (35, 'Available'),
    (36, 'Available'),
    (37, 'Available'),
    (38, 'Available'),
    (39, 'Available'),
    (40, 'Available'),
    (41, 'Sold'),
    (42, 'Available'),
    (43, 'Available');

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

INSERT INTO QA (user_id, product_id, question, answer) VALUES
    ('user1', 5, 'How many colors does this product come in?', 'This product comes in three colors: red, blue, and green.'),
    ('user2', 1, 'Is the product in good conditions?', 'Yes, this product almost brand new'),
    ('user3', 1, 'What is the material of this product?', 'The material of this product is stainless steel.'),
    ('user6', 1, 'What are the dimensions of this product?', NULL),
    ('user4', 1, 'Does this product come with a warranty?', NULL);