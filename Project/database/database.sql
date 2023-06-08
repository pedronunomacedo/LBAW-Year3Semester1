DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS AuthenticatedUser;
DROP TABLE IF EXISTS Administrator;
DROP TABLE IF EXISTS Adress;
DROP TABLE IF EXISTS purchaseNotification;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS ProductPurchase;
DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS ShopCart;
DROP TABLE IF EXISTS Whishlist;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS FAQ;


CREATE TABLE User (
    id serial PRIMARY KEY, 
    userName VARCHAR(255) NOT NULL, 
    email VARCHAR(255) UNIQUE NOT NULL, 
    phoneNumber VARCHAR(255) UNIQUE, 
    pass VARCHAR(255) NOT NULL
);

INSERT INTO User (id, userName, email, phoneNumber, pass) VALUES (1, 'pedromacedo', 'up202007531@fe.up.pt', '9344567829', 'admin');
INSERT INTO User (id, userName, email, phoneNumber, pass) VALUES (2, 'pedrobalazeiro', 'pedrobalazeiro@fe.up.pt', '934235467', 'admin');

CREATE TABLE AuthenticatedUser (
    idUser REFERENCE User
);

CREATE TABLE Administrator (
    idUser REFERENCE User
);

CREATE TABLE Adress (
    id SERIAL PRIMARY KEY, 
    street VARCHAR(255) NOT NULL, 
    postalCode VARCHAR(255) NOT NULL, 
    city VARCHAR(255) NOT NULL, 
    country VARCHAR(255) NOT NULL
);

CREATE TABLE purchaseNotification (
    id SERIAL PRIMARY KEY, 
    content VARCHAR(255) NOT NULL, 
    notificationDate DATE NOT NULL
);

CREATE TABLE Product (
    id SERIAL PRIMARY KEY, 
    prodName VARCHAR(255) NOT NULL, 
    price FLOAT NOT NULL, 
    prodDescription VARCHAR(255) NOT NULL, 
    launchDate DATE NOT NULL, 
    stock Integer NOT NULL CHECK (stock >= 0),
    rating INTEGER NOT NULL DEFAULT 0, 
    favoritesNum INTEGER NOT NULL DEFAULT 0, 
    [categoryName] VARCHAR(255) NOT NULL CHECK ([categoryName] IN ('Smartphones', 'Components', 'TVs', 'Laptops', 'Desktops'))
);

--INSERT INTO Product (id, prodName, price, prodDescription, launchDate, stock, categoryName) VALUES (1,'iPhone 14 Pro', 1349.00, "Very good smartPhone with a lot of benefits", '2022-09-16', 100, "Smartphones");

-- It's missing the REFERENCE to the order entity
CREATE TABLE ProductPurchase (
    idProductPurchase SERIAL PRIMARY KEY, 
    idProduct REFERENCES Product, 
    idOrder REFERENCES Orders(id)
);

CREATE TABLE Review (
    id SERIAL PRIMARY KEY, 
    idProduct REFERENCES Product(id), 
    idUser REFERENCES User(id), 
    reviewDate DATE NOT NULL, 
    content VARCHAR(255) NOT NULL, 
    score INTEGER CHECK (score >= 0 AND score <= 5)
);

--INSERT INTO Review (id, idProduct, idUser, reviewDate, content, score) VALUES (1, 1, 1, "2022-09-20", "Incredible product and specs!", 3);



CREATE TABLE ShopCart (
    id SERIAL PRIMARY KEY, 
    quantity INTEGER CHECK (quantity >= 0)
);

CREATE TABLE Whishlist (
    id SERIAL PRIMARY KEY, 
    quantity INTEGER CHECK (quantity >= 0)
);

CREATE TABLE Orders (
    id SERIAL PRIMARY KEY, 
    [orderState] VARCHAR(255) NOT NULL CHECK ([orderState] IN ('In process', 'Preparing', 'Dispatched', 'Delivered', 'Cancelled'))
);

CREATE TABLE FAQ (
    id SERIAL PRIMARY KEY, 
    question VARCHAR(255) NOT NULL, 
    answer VARCHAR(255) NOT NULL
);
