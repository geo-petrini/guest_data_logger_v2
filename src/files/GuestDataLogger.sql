DROP SCHEMA IF EXISTS GuestDataLogger;
CREATE SCHEMA GuestDataLogger;
USE GuestDataLogger;

CREATE TABLE user(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(25),
    cognome VARCHAR(25),
    username VARCHAR(25) NOT NULL,
    isAdmin TINYINT(1) DEFAULT 0
);

CREATE TABLE stand(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(25) NOT NULL,
    luogo VARCHAR(25) NOT NULL,
    data_inizio DATETIME NOT NULL,
    data_fine DATETIME NOT NULL
);

CREATE TABLE webcam(
    id INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE stat(
    id INT AUTO_INCREMENT PRIMARY KEY,
    data TIMESTAMP NOT NULL,
    numero_persone INT NOT NULL
);

CREATE TABLE chiave(
    chiave VARCHAR(48) PRIMARY KEY,
    stand_id INT NOT NULL,
    webcam_id INT NOT NULL,
    FOREIGN KEY(stand_id) REFERENCES stand(id),
    FOREIGN KEY(webcam_id) REFERENCES webcam(id)
);
