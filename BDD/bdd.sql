--  tp_notes_etudiants

DROP DATABASE IF EXISTS tp_notes_etudiants;
CREATE DATABASE tp_notes_etudiants;
USE tp_notes_etudiants;

-- tables + data
-- users
CREATE TABLE users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    role ENUM('admin', 'etudiant' , 'professeur')
);

INSERT INTO users (nom, email, password, role)
VALUES (
    'admin',
    'admin@gmail.com',
    '$2y$10$tt1ah6/g72.YEssE77MYlu5K/kzNIQkTDv/oFRuR8hd72y9cc5xoO',
    'admin'
);
