-- Drop tables if they exist
DROP TABLE IF EXISTS ADDRESS;
DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS PRODUCT;
DROP TABLE IF EXISTS SELLS;
DROP TABLE IF EXISTS REVIEWS;
DROP TABLE IF EXISTS EVENT;
DROP TABLE IF EXISTS EXTRA_SELLS;

-- Enable foreign key support
PRAGMA foreign_keys = ON;

-- Create the ADDRESS table
CREATE TABLE ADDRESS (
    address_id INT PRIMARY KEY,
    postal_code VARCHAR(10) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL
);

-- Create the USER table
CREATE TABLE USER (
    username VARCHAR(50) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(9) NOT NULL,
    address_id INT,
    FOREIGN KEY (address_id) REFERENCES ADDRESS(address_id)
);

-- Create the PRODUCT table
CREATE TABLE PRODUCT (
    product_id INT PRIMARY KEY,
    category VARCHAR(50) NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    seller_id VARCHAR(50) NOT NULL,
    brand VARCHAR(100),
    scale VARCHAR(10),
    FOREIGN KEY (seller_id) REFERENCES USER(username)
);

-- Create the SELLS table
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

-- Create the REVIEWS table
CREATE TABLE REVIEWS (
    review_id INTEGER PRIMARY KEY,
    seller_evaluation INTEGER NOT NULL CHECK (seller_evaluation >= 1 AND seller_evaluation <= 5),
    logistics_evaluation INTEGER NOT NULL CHECK (logistics_evaluation >= 1 AND logistics_evaluation <= 5),
    overall_evaluation INTEGER NOT NULL CHECK (overall_evaluation >= 1 AND overall_evaluation <= 5),
    platform_evaluation INTEGER NOT NULL CHECK (platform_evaluation >= 1 AND platform_evaluation <= 5),
    comment TEXT
);

-- Create the EVENT table
CREATE TABLE EVENT (
    event_id INTEGER PRIMARY KEY,
    event_type TEXT CHECK (event_type IN ('flash_sale', 'holiday_discount')),
    discount_percentage DECIMAL(5,2) NOT NULL,
    sell_event TEXT
);

-- Create the EXTRA_SELLS table
CREATE TABLE EXTRA_SELLS (
    extra_sell_id INT PRIMARY KEY,
    product_id INT NOT NULL,
    category VARCHAR(50) NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    seller_id VARCHAR(50) NOT NULL,
    FOREIGN KEY (seller_id) REFERENCES USER(username),
    FOREIGN KEY (product_id) REFERENCES PRODUCT(product_id)
);

-- Inserting sample data into the ADDRESS table
INSERT INTO ADDRESS (address_id, postal_code, address, city) VALUES
    (1, '1234-567', '123 Main Street', 'City1'),
    (2, '5678-901', '456 Elm Street', 'City2'),
    (3, '9012-345', '789 Oak Street', 'City3'),
    (4, '3456-789', '321 Pine Street', 'City4'),
    (5, '7890-123', '654 Maple Street', 'City5'),
    (6, '2345-678', '567 Oak Avenue', 'City6'),
    (7, '6789-012', '890 Cedar Street', 'City7'),
    (8, '9012-456', '234 Pine Road', 'City8'),
    (9, '3456-789', '456 Elm Lane', 'City9'),
    (10, '7890-234', '678 Maple Drive', 'City10'),
    (11, '1234-567', '890 Oak Street', 'City11'),
    (12, '5678-901', '123 Pine Avenue', 'City12'),
    (13, '9012-345', '456 Elm Road', 'City13'),
    (14, '3456-789', '789 Cedar Drive', 'City14'),
    (15, '7890-123', '234 Maple Lane', 'City15');

-- Inserting sample data into the USER table
INSERT INTO USER (username, name, password, phone_number, address_id) VALUES
    ('user1', 'John Doe', 'password1', '912345678', 1),
    ('user2', 'Jane Smith', 'password2', '912345679', 2),
    ('user3', 'Alice Johnson', 'password3', '912345670', 3),
    ('user4', 'Bob Brown', 'password4', '912345671', 4),
    ('user5', 'Eve White', 'password5', '912345672', 5),
    ('user6', 'Michael Johnson', 'password6', '912345673', 6),
    ('user7', 'Emily Brown', 'password7', '912345674', 7),
    ('user8', 'William White', 'password8', '912345675', 8),
    ('user9', 'Sophia Taylor', 'password9', '912345676', 9),
    ('user10', 'Daniel Martinez', 'password10', '912345677', 10),
    ('user11', 'Olivia Garcia', 'password11', '912345678', 11),
    ('user12', 'James Rodriguez', 'password12', '912345679', 12),
    ('user13', 'Isabella Lopez', 'password13', '912345680', 13),
    ('user14', 'Alexander Hernandez', 'password14', '912345681', 14),
    ('user15', 'Mia Gonzalez', 'password15', '912345682', 15);

-- Inserting sample data into the PRODUCT table
INSERT INTO PRODUCT (product_id, category, title, description, price, seller_id, brand, scale) VALUES
    (1, 'Civil cars', 'Toyota Corolla', 'Detailed diecast model of Toyota Corolla', 29.99, 'user1', 'Toyota', '1/24'),
    (2, 'F1', 'Ferrari SF90', 'Scale model of Ferrari SF90 Formula 1 car', 39.99, 'user2', 'Ferrari', '1/18'),
    (3, 'Rally', 'Subaru Impreza WRC', 'Diecast model of Subaru Impreza WRC rally car', 19.99, 'user3', 'Subaru', '1/32'),
    (4, 'DTM', 'Audi RS5 DTM', 'Detailed miniature of Audi RS5 DTM touring car', 49.99, 'user4', 'Audi', '1/43'),
    (5, 'HOTWHEELS', 'Hot Wheels Nissan Skyline GT-R R34', 'Hot Wheels diecast model of Nissan Skyline GT-R R34', 4.99, 'user5', 'Nissan', '1/64'),
    (6, 'Le Mans', 'Porsche 917K', 'Diecast model of iconic Porsche 917K Le Mans racer', 59.99, 'user6', 'Porsche', '1/18'),
    (7, 'Rally', 'Ford Escort RS1600', 'Detailed miniature of Ford Escort RS1600 rally car', 24.99, 'user7', 'Ford', '1/32'),
    (8, 'F1', 'Mercedes AMG W11', 'Scale model of Mercedes AMG W11 Formula 1 car', 49.99, 'user8', 'Mercedes-Benz', '1/18'),
    (9, 'DTM', 'BMW M4 DTM', 'High-quality replica of BMW M4 DTM touring car', 39.99, 'user9', 'BMW', '1/43'),
    (10, 'Rally', 'Toyota Celica GT-Four', 'Diecast model of Toyota Celica GT-Four rally car', 29.99, 'user10', 'Toyota', '1/24'),
    (11, 'Civil cars', 'Volkswagen Beetle', 'Classic Volkswagen Beetle diecast model', 19.99, 'user11', 'Volkswagen', '1/32'),
    (12, 'F1', 'Red Bull RB16', 'Detailed miniature of Red Bull RB16 Formula 1 car', 44.99, 'user12', 'Red Bull Racing', '1/18'),
    (13, 'DTM', 'Audi RS5 DTM', 'Miniature of Audi RS5 DTM touring car', 34.99, 'user13', 'Audi', '1/43'),
    (14, 'HOTWHEELS', 'Hot Wheels Lamborghini Centenario', 'Hot Wheels diecast model of Lamborghini Centenario', 6.99, 'user14', 'Lamborghini', '1/64'),
    (15, 'Civil cars', 'Ford Mustang', 'Detailed diecast model of Ford Mustang', 27.99, 'user15', 'Ford', '1/24');

-- Inserting sample data into the SELLS table
INSERT INTO SELLS (sell_id, seller_id, buyer_id, product_id, review_id) VALUES
    (1, 'user1', 'user2', 1, NULL),
    (2, 'user2', 'user3', 2, 1),
    (3, 'user3', 'user4', 3, NULL),
    (4, 'user4', 'user5', 4, 2),
    (5, 'user5', 'user1', 5, NULL),
    (6, 'user6', 'user7', 6, NULL),
    (7, 'user7', 'user8', 7, 3),
    (8, 'user8', 'user9', 8, NULL),
    (9, 'user9', 'user10', 9, 4),
    (10, 'user10', 'user11', 10, NULL),
    (11, 'user11', 'user12', 11, 5),
    (12, 'user12', 'user13', 12, NULL),
    (13, 'user13', 'user14', 13, 1),
    (14, 'user14', 'user15', 14, NULL),
    (15, 'user15', 'user1', 15, 2);

-- Inserting sample data into the REVIEWS table
INSERT INTO REVIEWS (review_id, seller_evaluation, logistics_evaluation, overall_evaluation, platform_evaluation, comment) VALUES
    (1, 4, 5, 4, 5, 'Great seller! Product arrived on time and in perfect condition.'),
    (2, 5, 4, 5, 5, 'Excellent experience overall. Would buy again.'),
    (3, 3, 4, 3, 4, NULL),
    (4, 5, 5, 5, 5, 'Absolutely satisfied with the purchase and service.'),
    (5, 4, 3, 4, 4, NULL),
    (6, 5, 4, 5, 5, 'Excellent seller! Product was exactly as described.'),
    (7, 4, 5, 4, 5, 'Fast shipping and great communication. Highly recommended.'),
    (8, 5, 5, 5, 5, 'Fantastic experience overall. Will buy again.'),
    (9, 3, 4, 3, 4, NULL),
    (10, 5, 4, 5, 5, 'Perfect transaction. Thank you!'),
    (11, 4, 5, 4, 5, 'Item arrived well-packaged and in perfect condition.'),
    (12, 5, 5, 5, 5, 'Top-notch service. Highly satisfied.'),
    (13, 3, 3, 3, 3, 'Slight delay in delivery, but product quality is good.'),
    (14, 4, 4, 4, 4, 'Smooth transaction. No complaints.'),
    (15, 5, 5, 5, 5, 'Couldnt be happier with the purchase. Excellent seller!');

-- Inserting sample data into the EVENT table
INSERT INTO EVENT (event_id, event_type, discount_percentage, sell_event) VALUES
    (1, 'flash_sale', 10.00, 'flash_sale'),
    (2, 'holiday_discount', 15.00, 'holiday_discount'),
    (3, 'flash_sale', 20.00, 'flash_sale'),
    (4, 'holiday_discount', 25.00, 'holiday_discount'),
    (5, 'flash_sale', 30.00, 'flash_sale'),
    (6, 'holiday_discount', 20.00, 'holiday_discount'),
    (7, 'flash_sale', 15.00, 'flash_sale'),
    (8, 'holiday_discount', 25.00, 'holiday_discount'),
    (9, 'flash_sale', 30.00, 'flash_sale'),
    (10, 'holiday_discount', 10.00, 'holiday_discount');
    

-- Inserting sample data into the EXTRA_SELLS table
INSERT INTO EXTRA_SELLS (extra_sell_id, product_id, category, title, description, price, seller_id) VALUES
    (1, 6, 'Accessories', 'Miniature Racing Helmet', 'Replica of racing helmet, perfect for display', 9.99, 'user1'),
    (2, 7, 'Accessories', 'Racing Trophy', 'Trophy for the winner, made of high-quality materials', 19.99, 'user2'),
    (3, 8, 'Clothing', 'Racing Shirt', 'Official racing shirt, comfortable and stylish', 29.99, 'user3'),
    (4, 9, 'Accessories', 'Racing Cap', 'Adjustable cap with team logo, suitable for all sizes', 14.99, 'user4'),
    (5, 10, 'Others', 'LEGO Technic Supercar', 'Buildable LEGO Technic Supercar with realistic features', 99.99, 'user5'),
    (6, 11, 'Accessories', 'Racing Helmet Keychain', 'Miniature keychain replica of racing helmet', 4.99, 'user6'),
    (7, 12, 'Accessories', 'Miniature Racing Trophy', 'Miniature trophy for display purposes', 9.99, 'user7'),
    (8, 13, 'Clothing', 'Racing Jacket', 'Official racing jacket, stylish and comfortable', 59.99, 'user8'),
    (9, 14, 'Accessories', 'Racing Gloves', 'High-quality racing gloves for ultimate grip', 24.99, 'user9'),
    (10, 15, 'Others', 'LEGO Technic Rally Car', 'Buildable LEGO Technic Rally Car with functioning suspension', 129.99, 'user10');
