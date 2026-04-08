-- =============================================================
-- Script d'initialisation de la base de données UberDB
-- Généré à partir des entités JPA (EclipseLink / GlassFish)
-- =============================================================

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id         BIGINT       NOT NULL AUTO_INCREMENT,
    firstName  VARCHAR(100) NOT NULL,
    lastName   VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    role       VARCHAR(50)  NOT NULL,
    PRIMARY KEY (id)
);

-- Table des plats
CREATE TABLE IF NOT EXISTS dishes (
    id           BIGINT       NOT NULL AUTO_INCREMENT,
    name         VARCHAR(255) NOT NULL,
    description  VARCHAR(500),
    price        DOUBLE       NOT NULL,
    is_available BOOLEAN      DEFAULT TRUE,
    owner_id     BIGINT       NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (owner_id) REFERENCES users(id)
);
