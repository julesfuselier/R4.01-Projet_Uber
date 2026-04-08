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

-- =============================================================
-- Données de base UberDB
-- =============================================================

-- Utilisateurs (3 rôles : ADMIN, RESTAURANT_OWNER, CUSTOMER)
INSERT INTO users (firstName, lastName, email, password, role) VALUES
('Alice',   'Martin',    'alice.martin@email.com',    'Admin1234!',      'ADMIN'),
('Bruno',   'Lefevre',   'bruno.lefevre@email.com',   'Bruno5678!',      'RESTAURANT_OWNER'),
('Claire',  'Dupont',    'claire.dupont@email.com',   'Claire9012!',     'RESTAURANT_OWNER'),
('David',   'Moreau',    'david.moreau@email.com',    'David3456!',      'CUSTOMER'),
('Emilie',  'Bernard',   'emilie.bernard@email.com',  'Emilie7890!',     'CUSTOMER'),
('Francois','Petit',     'francois.petit@email.com',  'Francois2345!',   'CUSTOMER');

-- Plats (owner_id 2 = Bruno, owner_id 3 = Claire)
INSERT INTO dishes (name, description, price, is_available, owner_id) VALUES
-- Restaurant de Bruno (cuisine française)
('Steak frites',        'Entrecôte grillée 200g avec frites maison et sauce béarnaise',    18.50, TRUE,  2),
('Croque-monsieur',     'Pain de mie, jambon blanc, emmental fondu, béchamel',              9.90,  TRUE,  2),
('Soupe à l\'oignon',   'Soupe gratinée à l\'oignon avec croûtons et gruyère',              8.50,  TRUE,  2),
('Tarte Tatin',         'Tarte aux pommes caramélisées, servie tiède avec crème fraîche',   7.00,  FALSE, 2),

-- Restaurant de Claire (cuisine asiatique)
('Pad Thaï',            'Nouilles sautées au poulet, cacahuètes, œuf, sauce tamarin',       13.90, TRUE,  3),
('Rouleaux de printemps','Rouleaux frais au crevettes, vermicelles et menthe (x3)',          7.50,  TRUE,  3),
('Riz cantonais',        'Riz sauté aux légumes, œufs et jambon',                           10.50, TRUE,  3),
('Soupe pho',            'Bouillon de bœuf, nouilles de riz, herbes fraîches',              12.00, TRUE,  3);