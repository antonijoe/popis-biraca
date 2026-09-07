CREATE DATABASE IF NOT EXISTS popis_biraca
CHARACTER SET utf8mb4
COLLATE utf8mb4_croatian_ci;

USE popis_biraca;


CREATE TABLE polling_places (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    naziv VARCHAR(150) NOT NULL,
    adresa VARCHAR(200) NOT NULL,

    PRIMARY KEY (id)
);


CREATE TABLE users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',

    PRIMARY KEY (id),
    UNIQUE (username)
);


CREATE TABLE voters (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    ime VARCHAR(80) NOT NULL,
    prezime VARCHAR(80) NOT NULL,
    oib CHAR(11) NOT NULL,
    legalna_adresa VARCHAR(200) NOT NULL,
    polling_place_id INT UNSIGNED NOT NULL,

    PRIMARY KEY (id),
    UNIQUE (oib),

    CONSTRAINT fk_voters_polling_place
        FOREIGN KEY (polling_place_id)
        REFERENCES polling_places(id)
        ON UPDATE CASCADE
);


INSERT INTO polling_places (naziv, adresa)
VALUES
('Biračko mjesto 1', 'Ulica kralja Tomislava 1, Đakovo'),
('Biračko mjesto 2', 'Ulica bana Jelačića 10, Đakovo'),
('Biračko mjesto 3', 'Trg Republike 5, Đakovo');


INSERT INTO users (username, password, role)
VALUES
('admin', 'admin123', 'admin'),
('korisnik', 'user123', 'user');


INSERT INTO voters (ime, prezime, oib, legalna_adresa, polling_place_id)
VALUES
('Ivan', 'Horvat', '12345678901', 'Ulica bana Jelačića 12, Đakovo', 2);