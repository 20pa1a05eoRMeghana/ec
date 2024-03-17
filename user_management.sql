CREATE TABLE adminlogin (
    id VARCHAR(100) NOT NULL ,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL
);

CREATE TABLE cart (
    product_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price INT(100) NOT NULL,
    pic VARCHAR(200) NOT NULL
);

CREATE TABLE orders (
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL
);

CREATE TABLE products (
    product_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    price INT(100) NOT NULL,
    pic VARCHAR(200) NOT NULL
);

INSERT INTO `products` (`product_id`, `name`, `price`, `pic`) VALUES
(1, 'book', '9', 'https://res.cloudinary.com/dlj8sy5vm/image/upload/v1710235393/book_yozawp.jpg'),
(2, 'books', '999', 'https://res.cloudinary.com/dlj8sy5vm/image/upload/v1710235393/books_ptepne.jpg'),
(3, 'iphone', '70000', 'https://res.cloudinary.com/dlj8sy5vm/image/upload/v1710233108/iphone_wn6uyf.jpg'),
(4, 'keyboard', '700', 'https://res.cloudinary.com/dlj8sy5vm/image/upload/v1710235518/keyboard_neryon.png'),
(5, 'dress', '1000', 'https://res.cloudinary.com/dlj8sy5vm/image/upload/v1710235393/dress_wljjtb.jpg'),
(6, 'pencil', '10', 'https://res.cloudinary.com/dlj8sy5vm/image/upload/v1710235511/pencil_xrv6gx.jpg'),
(7, 'pen', '20', 'https://res.cloudinary.com/dlj8sy5vm/image/upload/v1710235497/pen_cuftme.jpg'),
(8, 'soap', '30', 'https://res.cloudinary.com/dlj8sy5vm/image/upload/v1710235667/soap_urfg4d.jpg'),
(9, 'ball', '40', 'https://res.cloudinary.com/dlj8sy5vm/image/upload/v1710235667/ball_zckapn.jpg'),
(10, 'bat', '300', 'https://res.cloudinary.com/dlj8sy5vm/image/upload/v1710235680/bat_ecjonw.jpg'),
(11, 'shirt', '1999', 'https://res.cloudinary.com/dlj8sy5vm/image/upload/v1710259161/shirt_bdq51c.jpg'),
(12, 'toy', '500', 'https://res.cloudinary.com/dlj8sy5vm/image/upload/v1710259158/toy_s7ets0.jpg');

CREATE TABLE user (
    user_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(70) NOT NULL,
    user_password INT(45) NOT NULL,
    user_name VARCHAR(45) NOT NULL
);