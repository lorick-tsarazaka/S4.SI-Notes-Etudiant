DROP DATABASE bibliotheque;

CREATE DATABASE bibliotheque;

use bibliotheque;

-- tables + data
-- auteurs
CREATE TABLE auteurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255)
);  

INSERT INTO auteurs (nom) VALUES
('Antoine de Saint-Exupéry'),
('George Orwell'),
('J.K. Rowling'),
('Paulo Coelho'),
('Robert C. Martin'),
('J.R.R. Tolkien'),
('Frank Herbert'),
('Isaac Asimov'),
('Aldous Huxley'),
('Fiodor Dostoïevski'),
('Victor Hugo'),
('Miguel de Cervantes'),
('Stendhal'),
('Gustave Flaubert'),
('Homère'),
('Alexandre Dumas'),
('Bram Stoker'),
('Mary Shelley'),
('Andrew Hunt'),
('Erich Gamma'),
('Martin Fowler'),
('Cal Newport'),
('James Clear'),
('Yuval Noah Harari'),
('Simon Sinek'),
('Eric Ries'),
('Peter Thiel');


-- livres
CREATE TABLE livres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255),
    id_auteur INT,
    ISBN VARCHAR(20) UNIQUE,
    anneePublication INT,
    categorie VARCHAR(255),
    resume TEXT,
    fichierCouverture TEXT,
    statut ENUM('disponible', 'prêté'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    Constraint fk_livres_auteur foreign key (id_auteur) references
    auteurs(id)
);

INSERT INTO livres (titre, id_auteur, ISBN, anneePublication, categorie, resume, fichierCouverture, statut, created_at, modified_at)
VALUES
('Le Petit Prince', 1, '9780156012195', 1943, 'Conte', "Un pilote rencontre un petit prince venu d\'une autre planète.", 'petit_prince.jpg', 'disponible', NOW(), NOW()),
('1984', 2, "9780451524935", 1949, 'Dystopie', 'Un monde totalitaire où la surveillance est omniprésente.', '1984.jpg', 'disponible', NOW(), NOW()),
("Harry Potter à l\'école des sorciers", 3, "9780747532699", 1997, 'Fantasy', 'Un jeune garçon découvre qu’il est un sorcier.', 'harry_potter1.jpg', 'disponible', NOW(), NOW()),
("L\'Alchimiste", 4, "9780061122415", 1988, 'Philosophie', 'Un berger part à la recherche d’un trésor.', 'alchimiste.jpg', 'disponible', NOW(), NOW()),
('Clean Code', 5, "9780132350884", 2008, 'Programmation', 'Bonnes pratiques pour écrire du code propre.', 'cleancode.jpg', 'disponible', NOW(), NOW());

INSERT INTO livres (titre, id_auteur, ISBN, anneePublication, categorie, resume, fichierCouverture, statut, created_at, modified_at)
VALUES
('Le Hobbit', 6, '9780261102217', 1937, 'Fantasy', 'Bilbo part à l’aventure avec des nains.', 'hobbit.jpg', 'disponible', NOW(), NOW()),
('Le Seigneur des Anneaux', 6, '9780261102385', 1954, 'Fantasy', 'La quête de l’anneau unique.', 'lotr.jpg', 'disponible', NOW(), NOW()),
('Dune', 7, '9780441013593', 1965, 'Science-fiction', 'Une planète désertique et des intrigues politiques.', 'dune.jpg', 'disponible', NOW(), NOW()),
('Fondation', 8, '9780553293357', 1951, 'Science-fiction', 'Préserver le savoir de l’humanité.', 'fondation.jpg', 'disponible', NOW(), NOW()),
('Brave New World', 9, '9780060850524', 1932, 'Dystopie', 'Une société contrôlée par la technologie.', 'bravenewworld.jpg', 'disponible', NOW(), NOW()),
('Crime et Châtiment', 10, '9780140449136', 1866, 'Roman', 'Un étudiant commet un crime.', 'crime.jpg', 'disponible', NOW(), NOW()),
('Les Misérables', 11, '9782070409189', 1862, 'Roman', 'La vie de Jean Valjean.', 'miserables.jpg', 'disponible', NOW(), NOW()),
('Don Quichotte', 12, '9780060934347', 1605, 'Classique', 'Un chevalier idéaliste.', 'donquichotte.jpg', 'disponible', NOW(), NOW()),
('Le Rouge et le Noir', 13, '9780140449464', 1830, 'Roman', 'Ambition et amour.', 'rouge_noir.jpg', 'disponible', NOW(), NOW()),
('Madame Bovary', 14, '9780140449129', 1857, 'Roman', 'Une vie d’ennui et de rêves.', 'bovary.jpg', 'disponible', NOW(), NOW()),
('L’Odyssée', 15, '9780140268867', -800, 'Épopée', 'Le voyage d’Ulysse.', 'odyssee.jpg', 'disponible', NOW(), NOW()),
('Iliade', 15, '9780140275360', -750, 'Épopée', 'La guerre de Troie.', 'iliade.jpg', 'disponible', NOW(), NOW()),
('Le Comte de Monte-Cristo', 16, '9780140449266', 1844, 'Aventure', 'Une vengeance magistrale.', 'montecristo.jpg', 'disponible', NOW(), NOW()),
('Dracula', 17, '9780141439846', 1897, 'Horreur', 'Le célèbre vampire.', 'dracula.jpg', 'disponible', NOW(), NOW()),
('Frankenstein', 18, '9780141439471', 1818, 'Horreur', 'Un monstre créé par la science.', 'frankenstein.jpg', 'disponible', NOW(), NOW()),
('The Pragmatic Programmer', 19, '9780201616224', 1999, 'Programmation', 'Bonnes pratiques dev.', 'pragmatic.jpg', 'disponible', NOW(), NOW()),
('Design Patterns', 20, '9780201633610', 1994, 'Programmation', 'Patterns de conception.', 'design_patterns.jpg', 'disponible', NOW(), NOW()),
('Refactoring', 21, '9780201485677', 1999, 'Programmation', 'Améliorer le code existant.', 'refactoring.jpg', 'disponible', NOW(), NOW()),
('Deep Work', 22, '9781455586691', 2016, 'Productivité', 'Se concentrer profondément.', 'deepwork.jpg', 'disponible', NOW(), NOW()),
('Atomic Habits', 23, '9780735211292', 2018, 'Développement personnel', 'Changer ses habitudes.', 'atomic.jpg', 'disponible', NOW(), NOW()),
('Sapiens', 24, '9780062316097', 2011, 'Histoire', 'Histoire de l’humanité.', 'sapiens.jpg', 'disponible', NOW(), NOW()),
('Homo Deus', 24, '9780062464316', 2015, 'Histoire', 'Le futur de l’humanité.', 'homodeus.jpg', 'disponible', NOW(), NOW()),
('Start With Why', 25, '9781591846444', 2009, 'Business', 'Trouver son pourquoi.', 'why.jpg', 'disponible', NOW(), NOW()),
('The Lean Startup', 26, '9780307887894', 2011, 'Business', 'Créer une startup efficacement.', 'lean.jpg', 'disponible', NOW(), NOW()),
('Zero to One', 27, '9780804139298', 2014, 'Business', 'Créer quelque chose de nouveau.', 'zerotoone.jpg', 'disponible', NOW(), NOW());

-- users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    role ENUM('admin', 'bibliothecaire', 'lecteur')
);

INSERT INTO users (nom, email, password, role) VALUES
('Alice', 'alice@gmail.com', '$2y$12$KztJ.LqNDCft78BPIVgdh.kHMG2AWI7p.Me6K4hoJ2xYxDqDxLLLm', 'admin'),
('Jean', 'jean@gmail.com', '$2y$12$vD6Fajbn4oSM8OaGOtBwMeKCBl3oenudC3YWM/QqmINI1df7PX0nO', 'bibliothecaire'),
('Marie', 'marie@gmail.com', '$2y$12$EmNaZfY6tNolRGrOOPf5l.7qfUnZkJ9oyEVeInrESVw3j/ryYDMqq', 'lecteur'),
('Paul', 'paul@gmail.com', '$2y$12$YaX.xO2M39v/BQ/LTVvin.Z/vZ1FNuuTHNGITWtRUuZgZUG9VwACm', 'lecteur'),
('Fara', 'fara@gmail.com', '$2y$12$GDhAy2lsvF6HFG2PeUT0ZeIjGGaMUQDpBgc4t2P267HMKpi5G7ioC', 'lecteur');


-- emprunts
CREATE TABLE emprunts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_livre INT,
    id_user INT,
    dateEmprunt DATE,
    dateRetour DATE,

    Constraint fk_emprunts_user foreign key (id_user) references
    users(id),
    Constraint fk_emprunts_livre foreign key (id_livre) references
    livres(id)
);

ALTER TABLE emprunts
ADD dateRetard DATE NOT NULL;

INSERT INTO emprunts (id_livre, id_user, dateEmprunt, dateRetard) VALUES
(1, 1, "2026-04-1", "2026-04-8"),
(2, 1, "2026-04-25", "2026-05-2");


-- reservations
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_livre INT,
    id_user INT,
    dateReservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    Constraint fk_reservations_user foreign key (id_user) references
    users(id),
    Constraint fk_reservations_livre foreign key (id_livre) references
    livres(id)
);

ALTER TABLE reservations 
ADD statut ENUM('en cours', 'terminer');


-- notes
CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_livre INT,
    valeur DECIMAL(2,1),

    Constraint fk_notes_user foreign key (id_user) references
    users(id),
    Constraint fk_notes_livre foreign key (id_livre) references
    livres(id)
);


-- commentaires
CREATE TABLE commentaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_livre INT,
    commentaire TEXT,

    Constraint fk_commentaires_user foreign key (id_user) references
    users(id),
    Constraint fk_commentaires_livre foreign key (id_livre) references
    livres(id)
);