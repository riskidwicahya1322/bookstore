CREATE DATABASE IF NOT EXISTS bookstore CHARACTER SET utf8mb4;
USE bookstore;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS order_items, orders, messages, users, books, categories;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  author VARCHAR(100) NOT NULL,
  category_id INT NOT NULL,
  price INT NOT NULL,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user'
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  address TEXT NOT NULL,
  total INT NOT NULL,
  status ENUM('pending','processing','shipped','completed','cancelled') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  book_id INT NOT NULL,
  title VARCHAR(150) NOT NULL,
  price INT NOT NULL,
  qty INT NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  subject VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categories (name) VALUES ('novel'), ('pengembangan diri'), ('sains'), ('sejarah');

INSERT INTO books (title, author, category_id, price) VALUES
('Dimana Asalnya Bulan', 'Mira Wulandari', 1, 89000),
('Senja di Tanah Jawa', 'Arif Budiman', 1, 105000),
('Mimpi di Sore Hari', 'Sari Citra', 1, 75000),
('Jalan Terukir', 'Dono Setiawan', 1, 92000),
('Manusia yang Lupa', 'Rina Purnama', 1, 68000);


-- admin: admin@gmail.com / admin123
INSERT INTO users (name, email, password, role) VALUES
('Admin', 'admin@gmail.com', '$2b$12$C2gVV19Wj9kmuCD31EyB.etv/Gut8DoWqXsCk6wpknEFXYhEmL.qO', 'admin');
