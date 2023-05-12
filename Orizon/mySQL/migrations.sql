--Database creation
CREATE DATABASE orizon_db;

--Select database
USE orizon_db;

--Tables creation
CREATE TABLE countries (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  country_name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE trips (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  destination VARCHAR(255) NOT NULL UNIQUE,
  available_seats INTEGER NOT NULL
);



--Values creation
INSERT INTO countries (country_name) VALUES 
('United Kingdom'),
('Italy'),
('Netherlands'),
('Spain'),
('Sweden'),
('Switzerland'),
('France');


INSERT INTO trips (destination, available_seats) VALUES 
('New Zeland', 3),
('Switzerland', 4),
('Usa', 7),
('Netherlands', 5),
('Norway', 12),
('United Kingdom', 3),
('France', 0),
('Spain', 0);

