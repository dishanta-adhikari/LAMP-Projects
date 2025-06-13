-- Create the database
CREATE DATABASE IF NOT EXISTS travel_booking;
USE travel_booking;

-- Users (Customers & Admins)
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15),
    address TEXT,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

-- Travel Packages
CREATE TABLE packages (
    package_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    image VARCHAR(255) -- for optional package image
);

-- Places
CREATE TABLE places (
    place_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    guide VARCHAR(100)
);

-- Hotels (each belongs to one place)
CREATE TABLE hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address TEXT,
    place_id INT NOT NULL,
    FOREIGN KEY (place_id) REFERENCES places(place_id) ON DELETE CASCADE
);

-- M:N Relation: Package ↔ Places
CREATE TABLE package_place (
    id INT AUTO_INCREMENT PRIMARY KEY,
    package_id INT NOT NULL,
    place_id INT NOT NULL,
    FOREIGN KEY (package_id) REFERENCES packages(package_id) ON DELETE CASCADE,
    FOREIGN KEY (place_id) REFERENCES places(place_id) ON DELETE CASCADE
);

-- Booking Info
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    package_id INT NOT NULL,
    book_date DATE NOT NULL DEFAULT CURRENT_DATE,
    pay_status ENUM('Pending', 'Paid') DEFAULT 'Pending',
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (package_id) REFERENCES packages(package_id) ON DELETE CASCADE
);

-- Mark Visited Packages
CREATE TABLE visited (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    package_id INT NOT NULL,
    visit_date DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (package_id) REFERENCES packages(package_id) ON DELETE CASCADE
);
