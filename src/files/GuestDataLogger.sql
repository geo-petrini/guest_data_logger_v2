CREATE TABLE utente(
    username VARCHAR(25) PRIMARY KEY,
    nome VARCHAR(25),
    cognome VARCHAR(25),
    pass VARCHAR(25) NOT NULL,
    isOwner TINYINT(1) DEFAULT 0,
    isAdmin TINYINT(1) DEFAULT 0
);

CREATE TABLE stand(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(25) NOT NULL,
    luogo VARCHAR(25) NOT NULL,
    data_inizio DATETIME NOT NULL,
    data_fine DATETIME NOT NULL,
    proprietario VARCHAR(25) NOT NULL,
    isPublic TINYINT(1) DEFAULT 0,
    FOREIGN KEY(proprietario) REFERENCES user(username) 
	ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE stat(
    id INT AUTO_INCREMENT PRIMARY KEY,
    data TIMESTAMP NOT NULL,
    numero_persone INT NOT NULL,
    stand_id INT NOT NULL,
    num_webcam INT NOT NULL,
    FOREIGN KEY(stand_id) REFERENCES stand(id)
	ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE chiave(
    chiave VARCHAR(48) PRIMARY KEY,
    stand_id INT NOT NULL,
    num_webcam INT NOT NULL,
    FOREIGN KEY(stand_id) REFERENCES stand(id)
	ON UPDATE CASCADE
        ON DELETE CASCADE
);
