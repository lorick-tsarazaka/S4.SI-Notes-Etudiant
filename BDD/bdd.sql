--  tp_notes_etudiants

DROP DATABASE IF EXISTS tp_notes_etudiants;
CREATE DATABASE tp_notes_etudiants;
USE tp_notes_etudiants;

CREATE TABLE users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    role ENUM('admin', 'etudiant' , 'professeur')
);
