-- =============================================
-- NutriGreen — Base de données MySQL
-- =============================================

CREATE DATABASE IF NOT EXISTS nutrigreen CHARACTER SET utf8 COLLATE utf8_general_ci;
USE nutrigreen;

-- =============================================
-- MODULE 1 : SUIVI NUTRITIONNEL
-- =============================================

CREATE TABLE repas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    date_repas DATE NOT NULL,
    type_repas ENUM('petit_dejeuner','dejeuner','diner','collation') NOT NULL,
    calories_total INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE aliment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    calories INT NOT NULL,
    proteines DECIMAL(5,2) DEFAULT 0,
    glucides DECIMAL(5,2) DEFAULT 0,
    lipides DECIMAL(5,2) DEFAULT 0,
    unite VARCHAR(20) DEFAULT 'g'
);

CREATE TABLE repas_aliment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    repas_id INT NOT NULL,
    aliment_id INT NOT NULL,
    quantite DECIMAL(5,2) NOT NULL,
    FOREIGN KEY (repas_id) REFERENCES repas(id) ON DELETE CASCADE,
    FOREIGN KEY (aliment_id) REFERENCES aliment(id) ON DELETE CASCADE
);

-- =============================================
-- MODULE 2 : MARKETPLACE
-- =============================================

CREATE TABLE produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    prix DECIMAL(8,2) NOT NULL,
    stock INT DEFAULT 0,
    categorie VARCHAR(50),
    image VARCHAR(255),
    producteur VARCHAR(100),
    is_bio TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_nom VARCHAR(100) NOT NULL,
    client_email VARCHAR(150) NOT NULL,
    client_adresse TEXT NOT NULL,
    total DECIMAL(8,2) DEFAULT 0,
    statut ENUM('en_attente','confirmee','livree','annulee') DEFAULT 'en_attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE commande_produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(8,2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commande(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produit(id) ON DELETE CASCADE
);

-- =============================================
-- MODULE 3 : RECETTES DURABLES
-- =============================================

CREATE TABLE recette (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(150) NOT NULL,
    description TEXT,
    instructions TEXT NOT NULL,
    temps_preparation INT DEFAULT 0,
    difficulte ENUM('facile','moyen','difficile') DEFAULT 'facile',
    categorie VARCHAR(50),
    image VARCHAR(255),
    calories_total INT DEFAULT 0,
    score_carbone DECIMAL(4,2) DEFAULT 0,
    statut ENUM('acceptee','en_attente','refusee') DEFAULT 'acceptee',
    soumis_par VARCHAR(150) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- MIGRATION (si table déjà existante) :
-- ALTER TABLE recette ADD COLUMN statut ENUM('acceptee','en_attente','refusee') DEFAULT 'acceptee';
-- ALTER TABLE recette ADD COLUMN soumis_par VARCHAR(150) DEFAULT NULL;
-- =============================================

CREATE TABLE ingredient (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    unite VARCHAR(20) DEFAULT 'g',
    calories_par_unite INT DEFAULT 0,
    is_local TINYINT(1) DEFAULT 0
);

CREATE TABLE recette_ingredient (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recette_id INT NOT NULL,
    ingredient_id INT NOT NULL,
    quantite DECIMAL(5,2) NOT NULL,
    FOREIGN KEY (recette_id) REFERENCES recette(id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredient(id) ON DELETE CASCADE
);

-- =============================================
-- DONNÉES D'EXEMPLE — ALIMENTS
-- =============================================

INSERT INTO aliment (nom, calories, proteines, glucides, lipides, unite) VALUES
('Poulet grillé', 165, 31.00, 0.00, 3.60, 'g'),
('Riz complet', 123, 2.70, 25.60, 0.90, 'g'),
('Brocoli', 34, 2.80, 7.00, 0.40, 'g'),
('Avocat', 160, 2.00, 8.50, 14.70, 'g'),
('Oeuf', 155, 13.00, 1.10, 11.00, 'unité'),
('Pain complet', 247, 13.00, 41.00, 3.40, 'tranche'),
('Saumon', 208, 20.40, 0.00, 13.40, 'g'),
('Tomate', 18, 0.90, 3.90, 0.20, 'g'),
('Lentilles', 116, 9.00, 20.10, 0.40, 'g'),
('Yaourt nature', 59, 10.00, 3.60, 0.70, 'pot'),
('Banane', 89, 1.10, 22.80, 0.30, 'unité'),
('Épinards', 23, 2.90, 3.60, 0.40, 'g'),
('Quinoa', 120, 4.40, 21.30, 1.90, 'g'),
('Fromage chèvre', 364, 21.60, 0.90, 30.50, 'g'),
('Huile olive', 884, 0.00, 0.00, 100.00, 'ml');

-- =============================================
-- DONNÉES D'EXEMPLE — REPAS
-- =============================================

INSERT INTO repas (nom, date_repas, type_repas, calories_total) VALUES
('Toast avocat et oeuf', CURDATE(), 'petit_dejeuner', 420),
('Saumon grillé légumes', CURDATE(), 'dejeuner', 650),
('Salade de fruits frais', CURDATE(), 'collation', 180),
('Poulet riz brocoli', DATE_SUB(CURDATE(), INTERVAL 1 DAY), 'dejeuner', 520),
('Yaourt granola', DATE_SUB(CURDATE(), INTERVAL 1 DAY), 'petit_dejeuner', 310);

INSERT INTO repas_aliment (repas_id, aliment_id, quantite) VALUES
(1, 4, 100), (1, 5, 2), (1, 6, 2),
(2, 7, 200), (2, 3, 150), (2, 8, 100),
(3, 11, 2),
(4, 1, 200), (4, 2, 150), (4, 3, 100),
(5, 10, 1), (5, 11, 1);

-- =============================================
-- DONNÉES D'EXEMPLE — PRODUITS
-- =============================================

INSERT INTO produit (nom, description, prix, stock, categorie, image, producteur, is_bio) VALUES
('Tomates bio', 'Tomates fraîches cultivées en plein air, variété ancienne.', 3.50, 120, 'Légumes', 'tomates.jpg', 'Ferme Dupont', 1),
('Pain artisanal', 'Pain au levain, farine bio locale, cuit au feu de bois.', 4.20, 45, 'Boulangerie', 'pain.jpg', 'Boulangerie Martin', 0),
('Salade verte', 'Salade feuille de chêne, cueillie le matin même.', 2.80, 80, 'Légumes', 'salade.jpg', 'Les Vergers du Soleil', 1),
('Oeufs fermiers', 'Oeufs de poules élevées en plein air, calibre gros.', 5.50, 60, 'Produits laitiers', 'oeufs.jpg', 'La Ferme aux Oeufs', 1),
('Pommes de terre', 'Pommes de terre nouvelles, variété Charlotte.', 2.20, 200, 'Légumes', 'patates.jpg', 'Ferme Dupont', 0),
('Miel artisanal', 'Miel toutes fleurs, récolté à la main, non pasteurisé.', 12.50, 30, 'Épicerie', 'miel.jpg', 'Rucher du Midi', 1),
('Fromage de chèvre', 'Fromage frais de chèvre, fabrication artisanale.', 6.80, 25, 'Produits laitiers', 'fromage.jpg', 'Chèvrerie des Alpes', 1),
('Huile d\'olive', 'Huile d\'olive extra-vierge, première pression à froid.', 9.90, 40, 'Épicerie', 'huile.jpg', 'Moulin Provençal', 1);

-- =============================================
-- DONNÉES D'EXEMPLE — COMMANDES
-- =============================================

INSERT INTO commande (client_nom, client_email, client_adresse, total, statut) VALUES
('Jean Dupont', 'jean.dupont@email.com', '12 rue des Lilas, 75001 Paris', 24.50, 'confirmee'),
('Marie Laurent', 'marie.laurent@email.com', '45 avenue Victor Hugo, 69002 Lyon', 18.70, 'en_attente'),
('Thomas Dubois', 'thomas.dubois@email.com', '8 boulevard Pasteur, 33000 Bordeaux', 35.20, 'livree');

INSERT INTO commande_produit (commande_id, produit_id, quantite, prix_unitaire) VALUES
(1, 1, 3, 3.50), (1, 2, 2, 4.20), (1, 3, 1, 2.80),
(2, 4, 2, 5.50), (2, 6, 1, 12.50),
(3, 7, 2, 6.80), (3, 8, 1, 9.90), (3, 5, 3, 2.20);

-- =============================================
-- DONNÉES D'EXEMPLE — RECETTES
-- =============================================

INSERT INTO recette (titre, description, instructions, temps_preparation, difficulte, categorie, image, calories_total, score_carbone) VALUES
('Salade César au poulet bio', 'Une salade fraîche et protéinée avec du poulet grillé bio.', 'Faites griller le poulet assaisonné. Lavez et coupez la laitue romaine. Préparez la sauce César maison avec de l\'huile d\'olive, du jus de citron, de l\'ail et du parmesan. Assemblez le tout et ajoutez des croûtons de pain complet.', 25, 'facile', 'Salade', 'salade_cesar.jpg', 380, 1.20),
('Bowl quinoa végétarien', 'Un bol complet et nutritif avec du quinoa et des légumes.', 'Cuisez le quinoa selon les instructions. Rôtissez les patates douces et les pois chiches avec des épices. Coupez l\'avocat et les tomates. Assemblez dans un bol et arrosez de sauce tahini.', 35, 'facile', 'Bowl', 'bowl_quinoa.jpg', 520, 0.80),
('Saumon grillé sauce citron-aneth', 'Un plat de saumon frais avec une sauce légère aux herbes.', 'Assaisonnez le saumon avec sel, poivre et aneth. Grillez à la poêle 4 minutes de chaque côté. Préparez la sauce avec du jus de citron, de l\'huile d\'olive et de l\'aneth frais. Servez avec des légumes vapeur.', 30, 'moyen', 'Poisson', 'saumon.jpg', 480, 2.10),
('Pasta aux légumes de saison', 'Des pâtes complètes avec des légumes frais du marché.', 'Faites cuire les pâtes complètes al dente. Sautez les courgettes, poivrons et tomates à l\'huile d\'olive. Ajoutez de l\'ail et du basilic frais. Mélangez avec les pâtes et servez avec du parmesan.', 20, 'facile', 'Pâtes', 'pasta.jpg', 420, 0.60),
('Smoothie bowl aux baies', 'Un petit-déjeuner vitaminé et coloré.', 'Mixez les baies congelées avec une banane et un peu de lait d\'amande. Versez dans un bol. Garnissez de granola, graines de chia, tranches de banane et baies fraîches.', 10, 'facile', 'Petit-déjeuner', 'smoothie.jpg', 280, 0.40);

-- =============================================
-- DONNÉES D'EXEMPLE — INGRÉDIENTS
-- =============================================

INSERT INTO ingredient (nom, unite, calories_par_unite, is_local) VALUES
('Poulet bio', 'g', 2, 1),
('Quinoa', 'g', 1, 0),
('Avocat', 'unité', 160, 0),
('Tomate', 'g', 0, 1),
('Saumon frais', 'g', 2, 0),
('Citron', 'unité', 17, 1),
('Pâtes complètes', 'g', 1, 1),
('Courgette', 'g', 0, 1),
('Banane', 'unité', 89, 0),
('Baies mélangées', 'g', 1, 0),
('Laitue romaine', 'g', 0, 1),
('Patate douce', 'g', 1, 1),
('Pois chiches', 'g', 2, 0),
('Aneth frais', 'g', 0, 1),
('Parmesan', 'g', 4, 0);

INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite) VALUES
(1, 1, 200), (1, 11, 150), (1, 4, 100), (1, 15, 30),
(2, 2, 150), (2, 12, 200), (2, 3, 1), (2, 13, 100), (2, 4, 80),
(3, 5, 250), (3, 6, 2), (3, 14, 10),
(4, 7, 200), (4, 8, 150), (4, 4, 100), (4, 15, 20),
(5, 9, 1), (5, 10, 150);

-- =============================================
-- MODULE 1 BIS : PLANS NUTRITIONNELS
-- =============================================

CREATE TABLE plan_nutritionnel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    objectif_calories INT DEFAULT 2000,
    duree_jours INT DEFAULT 7,
    type_objectif ENUM('perte_poids','maintien','prise_masse') DEFAULT 'maintien',
    date_debut DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE plan_repas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    plan_id INT NOT NULL,
    repas_id INT NOT NULL,
    jour INT NOT NULL,
    FOREIGN KEY (plan_id) REFERENCES plan_nutritionnel(id) ON DELETE CASCADE,
    FOREIGN KEY (repas_id) REFERENCES repas(id) ON DELETE CASCADE
);

-- =============================================
-- DONNÉES D'EXEMPLE — PLANS NUTRITIONNELS
-- =============================================

INSERT INTO plan_nutritionnel (nom, description, objectif_calories, duree_jours, type_objectif, date_debut) VALUES
('Plan Équilibre Semaine', 'Un plan alimentaire équilibré sur 7 jours pour maintenir un poids stable tout en mangeant sainement.', 2000, 7, 'maintien', CURDATE()),
('Objectif Minceur 14j', 'Programme de 14 jours focalisé sur la perte de poids avec des repas légers et nutritifs.', 1500, 14, 'perte_poids', DATE_ADD(CURDATE(), INTERVAL 7 DAY));

INSERT INTO plan_repas (plan_id, repas_id, jour) VALUES
(1, 1, 1), (1, 2, 1), (1, 3, 1),
(1, 4, 2), (1, 5, 2),
(2, 1, 1), (2, 3, 1),
(2, 5, 2), (2, 2, 3);
