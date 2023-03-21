--Database creation
CREATE DATABASE orizon_db;

--Select database
USE orizon_db;

--Tables creation
CREATE TABLE country (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  country_name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE trips (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  destination VARCHAR(255) NOT NULL,
  available_seats INTEGER NOT NULL
);