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

CREATE TABLE classes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255)
);

CREATE TABLE options(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255)
);

CREATE TABLE semestres(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    id_option INT,
    id_classe INT,
    FOREIGN KEY (id_option) REFERENCES options(id),
    FOREIGN KEY (id_classe) REFERENCES classes(id)
);

CREATE TABLE etudiants(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    date_naissance DATE,
    lieu_naissance VARCHAR(255),
    num_inscription VARCHAR(255),
    id_classe_actuelle INT,
    FOREIGN KEY (id_classe_actuelle) REFERENCES classes(id)
);

CREATE TABLE matieres(
    id INT PRIMARY KEY AUTO_INCREMENT,
    ue VARCHAR(255),
    intitule VARCHAR(255),
    id_semestre INT,
    credits INT,
    FOREIGN KEY (id_semestre) REFERENCES semestres(id)
);

CREATE TABLE groupes_optionnels(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255),
    id_semestre INT,
    credits INT,
    FOREIGN KEY (id_semestre) REFERENCES semestres(id)
);

CREATE TABLE groupes_optionnels_matieres(
    id_groupe INT,
    id_matiere INT,
    PRIMARY KEY (id_groupe, id_matiere),
    FOREIGN KEY (id_groupe) REFERENCES groupes_optionnels(id),
    FOREIGN KEY (id_matiere) REFERENCES matieres(id)
);

CREATE TABLE notes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_etudiant INT,
    id_matiere INT,
    id_semestre INT,
    valeur DECIMAL(10,2),
    FOREIGN KEY (id_etudiant) REFERENCES etudiants(id),
    FOREIGN KEY (id_matiere) REFERENCES matieres(id),
    FOREIGN KEY (id_semestre) REFERENCES semestres(id)
);

DROP VIEW IF EXISTS v_etudiant_semestre_matiere_note;
CREATE VIEW v_etudiant_semestre_matiere_note AS
SELECT
    e.id AS id_etudiant,
    e.nom AS etudiant_nom,
    e.prenom AS etudiant_prenom,
    s.id AS id_semestre,
    s.nom AS semestre_nom,
    m.id AS id_matiere,
    m.ue AS matiere_ue,
    m.intitule AS matiere_intitule,
    n.valeur AS note_valeur
FROM etudiants e
JOIN matieres m ON 1 = 1
JOIN semestres s ON s.id = m.id_semestre
LEFT JOIN notes n
    ON n.id_etudiant = e.id
    AND n.id_matiere = m.id
    AND n.id_semestre = s.id;

INSERT INTO classes (nom) VALUES
('L2');

INSERT INTO options (nom) VALUES
('Tronc commun'),
('Developpement'),
('Bases de Donnees et Reseaux'),
('Web et Design');

INSERT INTO semestres (nom, id_option, id_classe) VALUES
('S3', (SELECT id FROM options WHERE nom = 'Tronc commun' LIMIT 1), (SELECT id FROM classes WHERE nom = 'L2' LIMIT 1)),
('S4 - Developpement', (SELECT id FROM options WHERE nom = 'Developpement' LIMIT 1), (SELECT id FROM classes WHERE nom = 'L2' LIMIT 1)),
('S4 - Bases de Donnees et Reseaux', (SELECT id FROM options WHERE nom = 'Bases de Donnees et Reseaux' LIMIT 1), (SELECT id FROM classes WHERE nom = 'L2' LIMIT 1)),
('S4 - Web et Design', (SELECT id FROM options WHERE nom = 'Web et Design' LIMIT 1), (SELECT id FROM classes WHERE nom = 'L2' LIMIT 1));

INSERT INTO etudiants (nom, prenom, date_naissance, lieu_naissance, num_inscription, id_classe_actuelle) VALUES
('Rakoto', 'Andry', '2004-05-12', 'Antananarivo', 'ETU002369', (SELECT id FROM classes WHERE nom = 'L2' LIMIT 1)),
('Razafy', 'Fanja', '2004-09-03', 'Antsirabe', 'ETU002587', (SELECT id FROM classes WHERE nom = 'L2' LIMIT 1)),
('Ranaivo', 'Hery', '2004-02-21', 'Toamasina', 'ETU002356', (SELECT id FROM classes WHERE nom = 'L2' LIMIT 1)),
('Rabenja', 'Lalao', '2004-11-18', 'Mahajanga', 'ETU003122', (SELECT id FROM classes WHERE nom = 'L2' LIMIT 1)),
('Tsarafidy', 'Miora', '2004-07-27', 'Fianarantsoa', 'ETU002467', (SELECT id FROM classes WHERE nom = 'L2' LIMIT 1));

-- Semestre 3 (tronc commun)
INSERT INTO matieres (ue, intitule, id_semestre, credits) VALUES
('INF201', 'Programmation orientee objet', (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 6),
('INF202', 'Bases de donnees objets', (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 6),
('INF203', 'Programmation systeme', (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 4),
('INF208', 'Reseaux informatiques', (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 6),
('MTH201', 'Methodes numeriques', (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 4),
('ORG201', 'Bases de gestion', (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 4);

-- Semestre 4 - Developpement
INSERT INTO matieres (ue, intitule, id_semestre, credits) VALUES
('INF204', 'Systeme d information geographique', (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 6),
('INF205', 'Systeme d information', (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 6),
('INF206', 'Interface Homme/Machine', (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 6),
('INF207', 'Elements d algorithmique', (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 6),
('INF210', 'Mini-projet de developpement', (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 10),
('MTH204', 'Geometrie', (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 4),
('MTH205', 'Equations differentielles', (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 4),
('MTH206', 'Optimisation', (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 4),
('MTH203', 'MAO', (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 4);

-- Semestre 4 - Bases de Donnees et Reseaux
INSERT INTO matieres (ue, intitule, id_semestre, credits) VALUES
('INF205', 'Systeme d information', (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 6),
('INF204', 'Systeme d information geographique', (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 6),
('INF206', 'Interface Homme/Machine', (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 6),
('INF207', 'Elements d algorithmique', (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 6),
('INF211', 'Mini-projet bases de donnees et/ou reseaux', (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 10),
('MTH202', 'Analyse des donnees', (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 4),
('MTH205', 'Equations differentielles', (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 4),
('MTH206', 'Optimisation', (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 4),
('MTH203', 'MAO', (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 4);

-- Semestre 4 - Web et Design
INSERT INTO matieres (ue, intitule, id_semestre, credits) VALUES
('INF204', 'Systeme d information geographique', (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 6),
('INF205', 'Systeme d information', (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 6),
('INF206', 'Interface Homme/Machine', (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 6),
('INF209', 'Web dynamique', (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 6),
('INF212', 'Mini-projet de Web et design', (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 10),
('MTH202', 'Analyse des donnees', (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 4),
('MTH204', 'Geometrie', (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 4),
('MTH206', 'Optimisation', (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 4),
('MTH203', 'MAO', (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 4);

-- Groupes optionnels S4
INSERT INTO groupes_optionnels (nom, id_semestre, credits) VALUES
('S4 DEV - UE Info', (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 6),
('S4 DEV - UE Maths', (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 4),
('S4 BDR - UE Info', (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 6),
('S4 BDR - UE Maths', (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 4),
('S4 WD - UE Info', (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 6),
('S4 WD - UE Maths', (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 4);

INSERT INTO groupes_optionnels_matieres (id_groupe, id_matiere) VALUES
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 DEV - UE Info' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF204' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 DEV - UE Info' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF205' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 DEV - UE Info' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF206' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 DEV - UE Maths' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH204' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 DEV - UE Maths' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH205' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 DEV - UE Maths' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH206' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1)),

((SELECT id FROM groupes_optionnels WHERE nom = 'S4 BDR - UE Info' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF204' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 BDR - UE Info' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF206' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 BDR - UE Info' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF207' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 BDR - UE Maths' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH202' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 BDR - UE Maths' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH205' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 BDR - UE Maths' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH206' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1)),

((SELECT id FROM groupes_optionnels WHERE nom = 'S4 WD - UE Info' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF204' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 WD - UE Info' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF205' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 WD - UE Info' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF206' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 WD - UE Maths' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH202' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 WD - UE Maths' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH204' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1) LIMIT 1)),
((SELECT id FROM groupes_optionnels WHERE nom = 'S4 WD - UE Maths' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH206' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1) LIMIT 1));

-- Notes S3 pour 5 etudiants
INSERT INTO notes (id_etudiant, id_matiere, id_semestre, valeur) VALUES
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002369' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 14.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002369' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF202' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 12.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002369' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF203' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 11.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002369' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF208' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 13.75),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002369' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 10.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002369' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'ORG201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 15.00),

((SELECT id FROM etudiants WHERE num_inscription = 'ETU002587' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 9.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002587' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF202' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 10.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002587' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF203' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 8.75),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002587' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF208' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 12.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002587' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 11.25),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002587' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'ORG201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 13.00),

((SELECT id FROM etudiants WHERE num_inscription = 'ETU002356' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 15.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002356' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF202' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 14.25),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002356' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF203' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 13.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002356' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF208' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 16.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002356' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 12.75),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002356' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'ORG201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 14.50),

((SELECT id FROM etudiants WHERE num_inscription = 'ETU003122' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 11.75),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU003122' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF202' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 12.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU003122' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF203' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 10.25),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU003122' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF208' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 9.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU003122' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 8.75),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU003122' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'ORG201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 12.50),

((SELECT id FROM etudiants WHERE num_inscription = 'ETU002467' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 13.25),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002467' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF202' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 11.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002467' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF203' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 12.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002467' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF208' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 14.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002467' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 13.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002467' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'ORG201' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S3' LIMIT 1), 12.75);

-- Notes S4 par parcours
INSERT INTO notes (id_etudiant, id_matiere, id_semestre, valeur) VALUES
-- ETU002369 (Developpement)
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002369' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF205' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 12.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002369' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF207' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 13.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002369' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF210' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 15.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002369' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH205' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 11.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002369' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH203' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 14.00),

-- ETU002587 (Bases de Donnees et Reseaux)
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002587' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF205' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 10.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002587' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF206' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 12.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002587' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF211' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 14.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002587' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH202' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 11.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002587' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH203' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 13.00),

-- ETU002356 (Web et Design)
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002356' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF206' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 13.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002356' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF209' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 15.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002356' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF212' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 16.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002356' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH204' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 12.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002356' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH203' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Web et Design' LIMIT 1), 14.50),

-- ETU003122 (Bases de Donnees et Reseaux)
((SELECT id FROM etudiants WHERE num_inscription = 'ETU003122' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF205' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 12.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU003122' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF204' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 11.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU003122' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF211' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 13.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU003122' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH206' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 10.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU003122' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH203' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Bases de Donnees et Reseaux' LIMIT 1), 12.50),

-- ETU002467 (Developpement)
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002467' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF204' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 14.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002467' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF207' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 12.50),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002467' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'INF210' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 16.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002467' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH204' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 13.00),
((SELECT id FROM etudiants WHERE num_inscription = 'ETU002467' LIMIT 1), (SELECT id FROM matieres WHERE ue = 'MTH203' AND id_semestre = (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1) LIMIT 1), (SELECT id FROM semestres WHERE nom = 'S4 - Developpement' LIMIT 1), 15.00);


INSERT INTO users (nom, email, password, role)
VALUES (
    'admin',
    'admin@gmail.com',
    '$2y$10$tt1ah6/g72.YEssE77MYlu5K/kzNIQkTDv/oFRuR8hd72y9cc5xoO',
    'admin'
);
