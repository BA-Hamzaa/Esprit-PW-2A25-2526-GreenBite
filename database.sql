-- =============================================
-- GreenBite — Base de données MySQL
-- =============================================

CREATE DATABASE IF NOT EXISTS greenbite CHARACTER SET utf8 COLLATE utf8_general_ci;
USE greenbite;

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
    latitude DECIMAL(10,7) NULL DEFAULT NULL,
    longitude DECIMAL(10,7) NULL DEFAULT NULL,
    total DECIMAL(8,2) DEFAULT 0,
    statut ENUM('en_attente','confirmee','livree','annulee') DEFAULT 'en_attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Migration (si table déjà existante) :
-- ALTER TABLE commande ADD COLUMN latitude DECIMAL(10,7) NULL DEFAULT NULL AFTER client_adresse;
-- ALTER TABLE commande ADD COLUMN longitude DECIMAL(10,7) NULL DEFAULT NULL AFTER latitude;

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

-- image vide : l’UI utilise des photos Unsplash par catégorie tant qu’aucun fichier n’est uploadé (voir app/helpers/media.php)
INSERT INTO produit (nom, description, prix, stock, categorie, image, producteur, is_bio) VALUES
('Tomates bio', 'Tomates fraîches cultivées en plein air, variété ancienne.', 3.50, 120, 'Légumes', '', 'Ferme Dupont', 1),
('Pain artisanal', 'Pain au levain, farine bio locale, cuit au feu de bois.', 4.20, 45, 'Boulangerie', '', 'Boulangerie Martin', 0),
('Salade verte', 'Salade feuille de chêne, cueillie le matin même.', 2.80, 80, 'Légumes', '', 'Les Vergers du Soleil', 1),
('Oeufs fermiers', 'Oeufs de poules élevées en plein air, calibre gros.', 5.50, 60, 'Produits laitiers', '', 'La Ferme aux Oeufs', 1),
('Pommes de terre', 'Pommes de terre nouvelles, variété Charlotte.', 2.20, 200, 'Légumes', '', 'Ferme Dupont', 0),
('Miel artisanal', 'Miel toutes fleurs, récolté à la main, non pasteurisé.', 12.50, 30, 'Épicerie', '', 'Rucher du Midi', 1),
('Fromage de chèvre', 'Fromage frais de chèvre, fabrication artisanale.', 6.80, 25, 'Produits laitiers', '', 'Chèvrerie des Alpes', 1),
('Huile d\'olive', 'Huile d\'olive extra-vierge, première pression à froid.', 9.90, 40, 'Épicerie', '', 'Moulin Provençal', 1);

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
('Salade César au poulet bio', 'Une salade fraîche et protéinée avec du poulet grillé bio.', 'Faites griller le poulet assaisonné. Lavez et coupez la laitue romaine. Préparez la sauce César maison avec de l\'huile d\'olive, du jus de citron, de l\'ail et du parmesan. Assemblez le tout et ajoutez des croûtons de pain complet.', 25, 'facile', 'Salade', '', 380, 1.20),
('Bowl quinoa végétarien', 'Un bol complet et nutritif avec du quinoa et des légumes.', 'Cuisez le quinoa selon les instructions. Rôtissez les patates douces et les pois chiches avec des épices. Coupez l\'avocat et les tomates. Assemblez dans un bol et arrosez de sauce tahini.', 35, 'facile', 'Bowl', '', 520, 0.80),
('Saumon grillé sauce citron-aneth', 'Un plat de saumon frais avec une sauce légère aux herbes.', 'Assaisonnez le saumon avec sel, poivre et aneth. Grillez à la poêle 4 minutes de chaque côté. Préparez la sauce avec du jus de citron, de l\'huile d\'olive et de l\'aneth frais. Servez avec des légumes vapeur.', 30, 'moyen', 'Poisson', '', 480, 2.10),
('Pasta aux légumes de saison', 'Des pâtes complètes avec des légumes frais du marché.', 'Faites cuire les pâtes complètes al dente. Sautez les courgettes, poivrons et tomates à l\'huile d\'olive. Ajoutez de l\'ail et du basilic frais. Mélangez avec les pâtes et servez avec du parmesan.', 20, 'facile', 'Pâtes', '', 420, 0.60),
('Smoothie bowl aux baies', 'Un petit-déjeuner vitaminé et coloré.', 'Mixez les baies congelées avec une banane et un peu de lait d\'amande. Versez dans un bol. Garnissez de granola, graines de chia, tranches de banane et baies fraîches.', 10, 'facile', 'Petit-déjeuner', '', 280, 0.40);

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
    regime_id INT NULL,
    date_debut DATE NOT NULL,
    soumis_par VARCHAR(150) DEFAULT NULL,
    statut ENUM('en_attente','accepte','refuse') DEFAULT 'en_attente',
    commentaire_admin TEXT,
    programme_activites TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    -- NOTE: FK to regime_alimentaire added below after that table is created
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

INSERT INTO plan_nutritionnel (nom, description, objectif_calories, duree_jours, type_objectif, date_debut, soumis_par, statut, programme_activites) VALUES
('Plan Équilibre Semaine',
 'Un plan alimentaire équilibré sur 7 jours pour maintenir un poids stable tout en mangeant sainement. Idéal pour les personnes actives souhaitant préserver leur forme sans contraintes excessives.',
 2000, 7, 'maintien', CURDATE(), 'Jean Dupont', 'accepte',
 'Lundi : 30 min marche rapide\nMercredi : 45 min natation\nVendredi : 30 min yoga\nDimanche : 1h randonnée légère'),

('Objectif Minceur 14j',
 'Programme de 14 jours focalisé sur la perte de poids progressive et saine. Repas légers, riches en fibres et protéines maigres, avec un déficit calorique modéré de 500 kcal/jour.',
 1500, 14, 'perte_poids', DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'Marie Laurent', 'accepte',
 'Lundi/Mercredi/Vendredi : 40 min HIIT\nMardi/Jeudi : 30 min course à pied\nSamedi : 1h vélo\nDimanche : repos actif (marche)'),

('Prise de Masse Musculaire',
 'Plan nutritionnel sur 28 jours conçu pour accompagner un programme de musculation. Apports caloriques élevés avec une répartition optimale : 40% glucides, 30% protéines, 30% lipides. Focus sur les aliments entiers et non transformés.',
 3000, 28, 'prise_masse', DATE_ADD(CURDATE(), INTERVAL 3 DAY), 'Thomas Dubois', 'accepte',
 'Lundi : Pectoraux + Triceps (1h15)\nMardi : Dos + Biceps (1h15)\nMercredi : Repos\nJeudi : Épaules + Abdos (1h)\nVendredi : Jambes (1h30)\nSamedi : Full body léger\nDimanche : Repos complet'),

('Détox Printanière 5 Jours',
 'Une cure détox légère de 5 jours pour repartir du bon pied. Basé sur des jus verts, des soupes de légumes et des repas légers riches en antioxydants. Idéal après les fêtes ou une période d\'excès.',
 1200, 5, 'perte_poids', DATE_SUB(CURDATE(), INTERVAL 3 DAY), 'Sophie Leclerc', 'accepte',
 'Chaque matin : 20 min étirements + méditation\nAprès-midi : 30 min marche en plein air\nSoir : 15 min respiration profonde'),

('Plan Méditerranéen',
 'Inspiré du régime méditerranéen traditionnel, ce plan de 21 jours met l\'accent sur l\'huile d\'olive, les poissons gras, les céréales complètes, les légumineuses et une abondance de fruits et légumes frais. Reconnu par l\'OMS comme l\'un des modèles alimentaires les plus sains.',
 1800, 21, 'maintien', DATE_ADD(CURDATE(), INTERVAL 14 DAY), 'Karim Ben Ali', 'accepte',
 'Lundi/Mercredi/Vendredi : 45 min marche méditerranéenne (bord de mer ou parc)\nMardi/Jeudi : 30 min gymnastique douce\nWeek-end : activités en plein air (jardinage, vélo)'),

('Programme Végétalien Sportif',
 'Plan 100% végétalien sur 14 jours, spécialement conçu pour les sportifs. Assure des apports complets en protéines végétales (légumineuses, tofu, tempeh, seitan), fer, B12 et oméga-3 d\'origine végétale.',
 2400, 14, 'maintien', DATE_ADD(CURDATE(), INTERVAL 5 DAY), 'Alice Martin', 'en_attente',
 'Lundi/Mercredi/Vendredi : Musculation (1h)\nMardi/Jeudi : Course 5km + abdos\nSamedi : Sport collectif (2h)\nDimanche : Yoga restauratif (45 min)'),

('Plan Anti-Stress & Bien-être',
 'Un programme de 10 jours axé sur les aliments qui réduisent le cortisol et favorisent la sérénité : magnésium (chocolat noir, amandes), oméga-3 (saumon, noix), tryptophane (banane, avoine). Combiné avec des activités relaxantes.',
 1900, 10, 'maintien', CURDATE(), 'Lina Ouali', 'en_attente',
 'Matin : 15 min méditation + respiration 4-7-8\nMidi : 20 min marche digestive\nSoir : 30 min lecture ou bain relaxant\n2x/semaine : séance de yoga Nidra'),

('Objectif -5kg en 30 Jours',
 'Plan structuré de 30 jours avec un déficit calorique contrôlé de 600 kcal/jour pour une perte de poids progressive et durable. Chaque semaine augmente légèrement l\'intensité sportive tout en maintenant des repas savoureux et rassasiants.',
 1600, 30, 'perte_poids', DATE_ADD(CURDATE(), INTERVAL 1 DAY), 'Romain Girard', 'accepte',
 'Semaine 1 : 3x 30min marche + 2x 20min renforcement\nSemaine 2 : 3x 40min jogging + 2x 25min HIIT\nSemaine 3 : 4x 40min course + 2x 30min musculation\nSemaine 4 : 4x 45min course + 3x 30min circuit training');

INSERT INTO plan_repas (plan_id, repas_id, jour) VALUES
-- Plan 1: Équilibre Semaine (7 jours)
(1, 1, 1), (1, 2, 1), (1, 3, 1),
(1, 4, 2), (1, 5, 2), (1, 3, 2),
(1, 1, 3), (1, 4, 3),
(1, 5, 4), (1, 2, 4), (1, 3, 4),
(1, 1, 5), (1, 4, 5),
(1, 5, 6), (1, 2, 6), (1, 3, 6),
(1, 1, 7), (1, 2, 7),
-- Plan 2: Minceur 14j
(2, 1, 1), (2, 3, 1),
(2, 5, 2), (2, 2, 2),
(2, 1, 3), (2, 3, 3),
(2, 5, 4), (2, 4, 4),
(2, 1, 5), (2, 3, 5),
-- Plan 3: Prise de Masse
(3, 5, 1), (3, 1, 1), (3, 2, 1), (3, 4, 1),
(3, 5, 2), (3, 1, 2), (3, 2, 2), (3, 3, 2),
-- Plan 4: Détox
(4, 3, 1), (4, 3, 2), (4, 3, 3),
-- Plan 5: Méditerranéen
(5, 1, 1), (5, 2, 1), (5, 3, 1),
(5, 5, 2), (5, 4, 2),
-- Plan 8: -5kg 30j
(8, 5, 1), (8, 3, 1),
(8, 1, 2), (8, 4, 2),
(8, 5, 3), (8, 2, 3);

-- =============================================
-- MODULE 4 : RÉGIMES ALIMENTAIRES
-- =============================================

CREATE TABLE IF NOT EXISTS regime_alimentaire (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    objectif VARCHAR(150) NOT NULL,
    description TEXT,
    duree_semaines INT NOT NULL,
    calories_jour INT NOT NULL,
    restrictions TEXT,
    soumis_par VARCHAR(150) NOT NULL,
    statut ENUM('en_attente', 'accepte', 'refuse') DEFAULT 'en_attente',
    commentaire_admin TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Relation Plan -> Régime (FK ajoutée après création de regime_alimentaire)
ALTER TABLE plan_nutritionnel
    ADD CONSTRAINT fk_plan_regime
    FOREIGN KEY (regime_id) REFERENCES regime_alimentaire(id) ON DELETE SET NULL;

-- Migration (si table plan_nutritionnel déjà existante sans cette colonne) :
-- ALTER TABLE plan_nutritionnel ADD COLUMN regime_id INT NULL AFTER type_objectif;
-- ALTER TABLE plan_nutritionnel ADD CONSTRAINT fk_plan_regime FOREIGN KEY (regime_id) REFERENCES regime_alimentaire(id) ON DELETE SET NULL;

-- =============================================
-- DONNÉES D'EXEMPLE — RÉGIMES ALIMENTAIRES
-- =============================================

INSERT INTO regime_alimentaire (nom, objectif, description, duree_semaines, calories_jour, restrictions, soumis_par, statut) VALUES
('Régime Méditerranéen',
 'Santé cardiovasculaire et longévité',
 'Basé sur l''alimentation traditionnelle des pays du pourtour méditerranéen. Riche en fruits, légumes, céréales complètes, légumineuses, noix et huile d''olive. Consommation modérée de poisson et volaille, limitée en viande rouge et produits transformés.',
 8, 1800, 'Limiter viande rouge (1x/semaine max), éviter sucres raffinés, produits ultra-transformés, sodas', 'Karim Ben Ali', 'accepte'),

('Régime Cétogène (Keto)',
 'Perte de poids rapide par cétose',
 'Régime très pauvre en glucides (< 50g/jour) et riche en graisses saines. Force le corps à utiliser les graisses comme source principale d''énergie. Efficace pour la perte de poids mais nécessite un suivi médical.',
 4, 1700, 'Interdit : pain, pâtes, riz, pommes de terre, fruits sucrés, sucre, céréales. Autorisé : viandes, poissons, œufs, fromages, avocats, noix, légumes verts', 'Thomas Dubois', 'accepte'),

('Végétalien Équilibré',
 'Éthique animale et empreinte carbone réduite',
 'Alimentation 100% végétale excluant tout produit d''origine animale. Nécessite une attention particulière aux apports en B12, fer, zinc, oméga-3 et protéines complètes via la combinaison légumineuses + céréales.',
 12, 2000, 'Aucun produit animal : viande, poisson, œufs, lait, fromage, miel. Supplémentation B12 obligatoire', 'Alice Martin', 'accepte'),

('Jeûne Intermittent 16:8',
 'Perte de poids et autophagie cellulaire',
 'Fenêtre alimentaire de 8 heures (12h-20h) suivie de 16 heures de jeûne. Pendant la fenêtre : alimentation équilibrée normale. Pendant le jeûne : eau, thé, café noir uniquement.',
 6, 1600, 'Pas de calories pendant la fenêtre de jeûne (16h). Éviter grignotage et aliments ultra-transformés pendant la fenêtre alimentaire', 'Marie Laurent', 'en_attente'),

('Régime DASH Anti-Hypertension',
 'Réduction de la pression artérielle',
 'Développé par le NIH américain, le régime DASH (Dietary Approaches to Stop Hypertension) privilégie fruits, légumes, produits laitiers allégés, céréales complètes et protéines maigres. Réduction drastique du sodium.',
 8, 2000, 'Sel limité à 2300mg/jour (idéal 1500mg). Réduire : charcuteries, fromages salés, plats préparés, snacks industriels', 'Sophie Leclerc', 'accepte'),

('Régime Anti-Inflammatoire',
 'Réduire l''inflammation chronique',
 'Inspiré des travaux du Dr. Andrew Weil, ce régime favorise les aliments anti-inflammatoires : poissons gras (oméga-3), curcuma, gingembre, baies, légumes crucifères, thé vert. Élimine les aliments pro-inflammatoires.',
 10, 1900, 'Éviter : sucres ajoutés, farines blanches, huiles végétales raffinées (tournesol, maïs), viandes transformées, alcool excessif', 'Lina Ouali', 'en_attente');

-- Link some plans to régimes
UPDATE plan_nutritionnel SET regime_id = 1 WHERE id = 5;  -- Plan Méditerranéen -> Régime Méditerranéen
UPDATE plan_nutritionnel SET regime_id = 3 WHERE id = 6;  -- Plan Végétalien Sportif -> Régime Végétalien
UPDATE plan_nutritionnel SET regime_id = 4 WHERE id = 2;  -- Objectif Minceur -> Jeûne Intermittent

-- =============================================
-- MODULE 3 BIS : COMMENTAIRES RECETTES
-- =============================================

CREATE TABLE IF NOT EXISTS commentaire_recette (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    recette_id   INT NOT NULL,
    auteur       VARCHAR(150) NOT NULL,
    email        VARCHAR(150) DEFAULT NULL,
    note         TINYINT NOT NULL DEFAULT 3 COMMENT 'Note de 1 à 5 étoiles',
    commentaire  TEXT NOT NULL,
    statut       ENUM('approuve','en_attente','refuse') DEFAULT 'en_attente',
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recette_id) REFERENCES recette(id) ON DELETE CASCADE,
    CONSTRAINT chk_note CHECK (note BETWEEN 1 AND 5)
);

-- =============================================
-- DONNÉES D'EXEMPLE — COMMENTAIRES RECETTES
-- =============================================

INSERT INTO commentaire_recette (recette_id, auteur, email, note, commentaire, statut) VALUES
(1, 'Alice Martin',    'alice@example.com',   5, 'Excellente recette, facile et délicieuse ! J\'ai adoré la sauce César maison.', 'approuve'),
(1, 'Karim Ben Ali',   'karim@example.com',   4, 'Très bon résultat, j\'ai ajouté un peu plus de citron pour relever le goût.', 'approuve'),
(1, 'Fatima Zahra',    NULL,                   3, 'Bonne recette mais un peu fade sans assaisonnement supplémentaire.', 'en_attente'),
(2, 'Sophie Leclerc',  'sophie@example.com',  5, 'Parfait pour un repas végétarien équilibré et rassasiant. Je recommande !', 'approuve'),
(2, 'Thomas Dupuis',   'thomas@example.com',  4, 'Le quinoa est super avec la sauce tahini, je referai cette recette sans hésiter.', 'approuve'),
(3, 'Marc Lefebvre',   'marc@example.com',    3, 'Bien mais un peu long à préparer pour un soir de semaine.', 'en_attente'),
(3, 'Inès Belhaj',     NULL,                   5, 'Le saumon grillé avec la sauce citron-aneth est divin !', 'approuve'),
(4, 'Lina Ouali',      'lina@example.com',    4, 'Les pâtes aux légumes de saison sont délicieuses et simples à faire.', 'approuve'),
(5, 'Romain Girard',   'romain@example.com',  5, 'Le smoothie bowl est parfait pour bien démarrer la journée, très coloré et vitaminé !', 'approuve'),
(5, 'Nadia Chkouri',   NULL,                   2, 'Trop sucré pour moi mais la présentation est magnifique.', 'refuse');

-- =============================================
-- MODULE 3 TER : INSTRUCTIONS PAR ÉTAPES
-- =============================================

CREATE TABLE IF NOT EXISTS instruction_recette (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    recette_id  INT NOT NULL,
    ordre       INT DEFAULT 1,
    titre       VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recette_id) REFERENCES recette(id) ON DELETE CASCADE
);

-- =============================================
-- MODULE 3 QUATER : MATÉRIELS DE CUISINE
-- =============================================

CREATE TABLE IF NOT EXISTS materiel (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(150) NOT NULL,
    description TEXT,
    propose_par VARCHAR(150) DEFAULT NULL,
    statut      ENUM('accepte','en_attente','refuse') DEFAULT 'accepte',
    motif_refus TEXT DEFAULT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS recette_materiel (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    recette_id  INT NOT NULL,
    materiel_id INT NOT NULL,
    UNIQUE KEY uq_recette_materiel (recette_id, materiel_id),
    FOREIGN KEY (recette_id)  REFERENCES recette(id)   ON DELETE CASCADE,
    FOREIGN KEY (materiel_id) REFERENCES materiel(id)  ON DELETE CASCADE
);

-- =============================================
-- DONNÉES D'EXEMPLE — MATÉRIELS (admin, acceptés)
-- =============================================

INSERT INTO materiel (nom, description, propose_par, statut) VALUES
('Couteau de chef',     'Couteau polyvalent pour couper, émincer et ciseler.',            NULL, 'accepte'),
('Planche à découper',  'Surface de coupe en bois ou plastique.',                         NULL, 'accepte'),
('Poêle antiadhésive',  'Poêle pour cuissons sans matière grasse.',                       NULL, 'accepte'),
('Casserole',           'Pour les cuissons à feu doux ou à ébullition.',                  NULL, 'accepte'),
('Mixeur plongeant',    'Pour mixer soupes, smoothies et sauces directement dans le plat.',NULL, 'accepte'),
('Fouet',               'Pour émulsionner, battre des œufs ou monter une crème.',          NULL, 'accepte'),
('Passoire',            'Pour égoutter les pâtes, légumes ou légumineuses.',               NULL, 'accepte'),
('Balance de cuisine',  'Pour peser les ingrédients avec précision.',                     NULL, 'accepte'),
('Four',                'Pour cuissons au four : rôtis, gratins, gâteaux.',                NULL, 'accepte'),
('Robot culinaire',     'Pour hacher, broyer et préparer les aliments rapidement.',        NULL, 'accepte');

-- =============================================
-- DONNÉES D'EXEMPLE — INSTRUCTIONS RECETTES
-- =============================================

INSERT INTO instruction_recette (recette_id, ordre, titre, description) VALUES
(1, 1, 'Grillez le poulet',    'Assaisonnez le poulet avec sel, poivre et herbes. Faites-le griller à feu moyen 6-8 min de chaque côté.'),
(1, 2, 'Préparez la laitue',   'Lavez et essorez la laitue romaine. Coupez-la en morceaux de taille moyenne.'),
(1, 3, 'Préparez la sauce',    'Mélangez huile d\'olive, jus de citron, ail émincé et parmesan râpé pour obtenir la sauce César.'),
(1, 4, 'Assemblez la salade',  'Disposez la laitue dans le plat, ajoutez le poulet tranché, la sauce et les croûtons.'),
(2, 1, 'Cuire le quinoa',      'Rincez le quinoa puis cuisez-le dans 2 fois son volume d\'eau pendant 15 min.'),
(2, 2, 'Rôtissez les légumes', 'Coupez patates douces et pois chiches, assaisonnez avec épices et enfournez à 200°C pendant 25 min.'),
(2, 3, 'Assemblez le bowl',    'Disposez le quinoa, les légumes rôtis, l\'avocat tranché et les tomates. Arrosez de sauce tahini.');
