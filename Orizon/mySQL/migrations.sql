--Database creation
CREATE DATABASE orizon_db;

--Select database
USE orizon_db;

--Tables creation
CREATE TABLE paesi (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome_paese VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE viaggi (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome_paese VARCHAR(255) NOT NULL,
  posti_disponibili INTEGER NOT NULL
);