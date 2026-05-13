-- =============================================
-- GreenBite — Base de données MySQL
-- Base : greenbite | user : root | pass : vide
-- =============================================
-- Contient tous les modules :
--   MODULE BLOG        : article, commentaire
--   MODULE NUTRITION   : repas, aliment, repas_aliment,
--                        plan_nutritionnel, plan_repas
--   MODULE MARKETPLACE : produit, commande, commande_produit
--   MODULE RECETTES    : recette, ingredient, recette_ingredient,
--                        commentaire_recette, instruction_recette,
--                        materiel, recette_materiel
--   MODULE RÉGIMES     : regime_alimentaire
-- =============================================

CREATE DATABASE IF NOT EXISTS greenbite CHARACTER SET utf8 COLLATE utf8_general_ci;
USE greenbite;

-- =============================================
-- MODULE 0 : UTILISATEURS & AUTHENTIFICATION
-- =============================================

CREATE TABLE IF NOT EXISTS users (
    id                   INT AUTO_INCREMENT PRIMARY KEY,
    username             VARCHAR(100)  NOT NULL,
    email                VARCHAR(150)  NOT NULL UNIQUE,
    password             VARCHAR(255)  NOT NULL,
    role                 ENUM('USER','COACH','ADMIN') DEFAULT 'USER',
    avatar               VARCHAR(255)  NULL,
    is_active            TINYINT(1)    DEFAULT 1,
    password_reset_token VARCHAR(255)  NULL,
    reset_token_expiry   DATETIME      NULL,
    face_descriptor      TEXT          NULL,
    certificate          VARCHAR(255)  NULL,
    coach_request        ENUM('none','pending','accepted','refused') DEFAULT 'none',
    coach_request_date   DATETIME      NULL,
    created_at           TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at           TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Données d'exemple — Utilisateurs
-- Mot de passe admin : Admin1234! (hash bcrypt PASSWORD_BCRYPT)
INSERT INTO users (username, email, password, role, is_active) VALUES
('admin', 'admin@greenbite.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMIN', 1),
('demo',  'demo@greenbite.com',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'USER',  1);

-- =============================================
-- MODULE BLOG : ARTICLES
-- =============================================

CREATE TABLE IF NOT EXISTS article (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    titre            VARCHAR(180)  NOT NULL,
    contenu          LONGTEXT      NOT NULL,
    auteur           VARCHAR(120)  DEFAULT 'Admin',
    pin              VARCHAR(10)   DEFAULT NULL,
    role_utilisateur VARCHAR(100)  DEFAULT 'Passionné de cuisine',
    statut           ENUM('brouillon','en_attente','publie') DEFAULT 'en_attente',
    date_publication TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at       TIMESTAMP     NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS idx_article_statut_date ON article(statut, date_publication);

-- =============================================
-- MODULE BLOG : COMMENTAIRES
-- =============================================

CREATE TABLE IF NOT EXISTS commentaire (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    article_id       INT           NOT NULL,
    pseudo           VARCHAR(120)  NOT NULL,
    pin              VARCHAR(10)   DEFAULT NULL,
    contenu          TEXT          NOT NULL,
    statut           ENUM('en_attente','valide','signale') DEFAULT 'valide',
    date_commentaire TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_commentaire_article
        FOREIGN KEY (article_id) REFERENCES article(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_commentaire_article_statut_date ON commentaire(article_id, statut, date_commentaire);

-- =============================================
-- MODULE 1 : SUIVI NUTRITIONNEL
-- =============================================

CREATE TABLE IF NOT EXISTS repas (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    nom            VARCHAR(100) NOT NULL,
    date_repas     DATE         NOT NULL,
    type_repas     ENUM('petit_dejeuner','dejeuner','diner','collation') NOT NULL,
    calories_total INT          DEFAULT 0,
    created_at     TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS aliment (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    nom       VARCHAR(100) NOT NULL,
    calories  INT          NOT NULL,
    proteines DECIMAL(5,2) DEFAULT 0,
    glucides  DECIMAL(5,2) DEFAULT 0,
    lipides   DECIMAL(5,2) DEFAULT 0,
    unite     VARCHAR(20)  DEFAULT 'g'
);

CREATE TABLE IF NOT EXISTS repas_aliment (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    repas_id   INT          NOT NULL,
    aliment_id INT          NOT NULL,
    quantite   DECIMAL(5,2) NOT NULL,
    FOREIGN KEY (repas_id)   REFERENCES repas(id)   ON DELETE CASCADE,
    FOREIGN KEY (aliment_id) REFERENCES aliment(id) ON DELETE CASCADE
);

-- =============================================
-- MODULE 1 BIS : PLANS NUTRITIONNELS
-- =============================================

CREATE TABLE IF NOT EXISTS plan_nutritionnel (
    id                   INT AUTO_INCREMENT PRIMARY KEY,
    nom                  VARCHAR(150) NOT NULL,
    description          TEXT,
    objectif_calories    INT          DEFAULT 2000,
    duree_jours          INT          DEFAULT 7,
    type_objectif        ENUM('perte_poids','maintien','prise_masse') DEFAULT 'maintien',
    regime_id            INT          NULL,
    date_debut           DATE         NOT NULL,
    soumis_par           VARCHAR(150) DEFAULT NULL,
    statut               ENUM('en_attente','accepte','refuse') DEFAULT 'en_attente',
    commentaire_admin    TEXT,
    programme_activites  TEXT,
    created_at           TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS plan_repas (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    plan_id  INT NOT NULL,
    repas_id INT NOT NULL,
    jour     INT NOT NULL,
    FOREIGN KEY (plan_id)  REFERENCES plan_nutritionnel(id) ON DELETE CASCADE,
    FOREIGN KEY (repas_id) REFERENCES repas(id)             ON DELETE CASCADE
);

-- =============================================
-- MODULE 2 : MARKETPLACE
-- =============================================

CREATE TABLE IF NOT EXISTS produit (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100) NOT NULL,
    description TEXT,
    prix        DECIMAL(8,2) NOT NULL,
    stock       INT          DEFAULT 0,
    categorie   VARCHAR(50),
    image       VARCHAR(255),
    producteur  VARCHAR(100),
    is_bio      TINYINT(1)   DEFAULT 0,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS commande (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    client_nom     VARCHAR(100)   NOT NULL,
    client_email   VARCHAR(150)   NOT NULL,
    client_adresse TEXT           NOT NULL,
    latitude       DECIMAL(10,7)  NULL DEFAULT NULL,
    longitude      DECIMAL(10,7)  NULL DEFAULT NULL,
    total          DECIMAL(8,2)   DEFAULT 0,
    statut         ENUM('en_attente','confirmee','livree','annulee') DEFAULT 'en_attente',
    created_at     TIMESTAMP      DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS commande_produit (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    commande_id   INT          NOT NULL,
    produit_id    INT          NOT NULL,
    quantite      INT          NOT NULL,
    prix_unitaire DECIMAL(8,2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commande(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id)  REFERENCES produit(id)  ON DELETE CASCADE
);

-- =============================================
-- MODULE 3 : RECETTES DURABLES
-- =============================================

CREATE TABLE IF NOT EXISTS recette (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    titre             VARCHAR(150) NOT NULL,
    description       TEXT,
    instructions      TEXT         NOT NULL,
    temps_preparation INT          DEFAULT 0,
    difficulte        ENUM('facile','moyen','difficile') DEFAULT 'facile',
    categorie         VARCHAR(50),
    image             VARCHAR(255),
    calories_total    INT          DEFAULT 0,
    score_carbone     DECIMAL(4,2) DEFAULT 0,
    statut            ENUM('acceptee','en_attente','refusee') DEFAULT 'acceptee',
    soumis_par        VARCHAR(150) DEFAULT NULL,
    created_at        TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS ingredient (
    id                 INT AUTO_INCREMENT PRIMARY KEY,
    nom                VARCHAR(100) NOT NULL,
    unite              VARCHAR(20)  DEFAULT 'g',
    calories_par_unite INT          DEFAULT 0,
    is_local           TINYINT(1)   DEFAULT 0
);

CREATE TABLE IF NOT EXISTS recette_ingredient (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    recette_id    INT          NOT NULL,
    ingredient_id INT          NOT NULL,
    quantite      DECIMAL(5,2) NOT NULL,
    FOREIGN KEY (recette_id)    REFERENCES recette(id)    ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredient(id) ON DELETE CASCADE
);

-- =============================================
-- MODULE 4 : RÉGIMES ALIMENTAIRES
-- =============================================

CREATE TABLE IF NOT EXISTS regime_alimentaire (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    nom               VARCHAR(150) NOT NULL,
    objectif          VARCHAR(150) NOT NULL,
    description       TEXT,
    duree_semaines    INT          NOT NULL,
    calories_jour     INT          NOT NULL,
    restrictions      TEXT,
    soumis_par        VARCHAR(150) NOT NULL,
    statut            ENUM('en_attente', 'accepte', 'refuse') DEFAULT 'en_attente',
    commentaire_admin TEXT,
    created_at        TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

-- FK plan_nutritionnel -> regime_alimentaire (after both tables exist)
ALTER TABLE plan_nutritionnel
    ADD CONSTRAINT fk_plan_regime
    FOREIGN KEY (regime_id) REFERENCES regime_alimentaire(id) ON DELETE SET NULL;

-- =============================================
-- MODULE 3 BIS : COMMENTAIRES RECETTES
-- =============================================

CREATE TABLE IF NOT EXISTS commentaire_recette (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    recette_id  INT            NOT NULL,
    auteur      VARCHAR(150)   NOT NULL,
    email       VARCHAR(150)   DEFAULT NULL,
    note        TINYINT        NOT NULL DEFAULT 3 COMMENT 'Note de 1 à 5 étoiles',
    commentaire TEXT           NOT NULL,
    statut      ENUM('approuve','en_attente','refuse') DEFAULT 'en_attente',
    created_at  TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recette_id) REFERENCES recette(id) ON DELETE CASCADE,
    CONSTRAINT chk_note CHECK (note BETWEEN 1 AND 5)
);

-- =============================================
-- MODULE 3 TER : INSTRUCTIONS PAR ÉTAPES
-- =============================================

CREATE TABLE IF NOT EXISTS instruction_recette (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    recette_id INT          NOT NULL,
    ordre      INT          DEFAULT 1,
    titre      VARCHAR(200) NOT NULL,
    description TEXT        NOT NULL,
    created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
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
    motif_refus TEXT         DEFAULT NULL,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS recette_materiel (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    recette_id  INT NOT NULL,
    materiel_id INT NOT NULL,
    UNIQUE KEY uq_recette_materiel (recette_id, materiel_id),
    FOREIGN KEY (recette_id)  REFERENCES recette(id)  ON DELETE CASCADE,
    FOREIGN KEY (materiel_id) REFERENCES materiel(id) ON DELETE CASCADE
);

-- =============================================
-- DONNÉES D'EXEMPLE — ALIMENTS
-- =============================================

INSERT INTO aliment (nom, calories, proteines, glucides, lipides, unite) VALUES
('Poulet grillé',  165,  31.00,  0.00,  3.60, 'g'),
('Riz complet',    123,   2.70, 25.60,  0.90, 'g'),
('Brocoli',         34,   2.80,  7.00,  0.40, 'g'),
('Avocat',         160,   2.00,  8.50, 14.70, 'g'),
('Oeuf',           155,  13.00,  1.10, 11.00, 'unité'),
('Pain complet',   247,  13.00, 41.00,  3.40, 'tranche'),
('Saumon',         208,  20.40,  0.00, 13.40, 'g'),
('Tomate',          18,   0.90,  3.90,  0.20, 'g'),
('Lentilles',      116,   9.00, 20.10,  0.40, 'g'),
('Yaourt nature',   59,  10.00,  3.60,  0.70, 'pot'),
('Banane',          89,   1.10, 22.80,  0.30, 'unité'),
('Épinards',        23,   2.90,  3.60,  0.40, 'g'),
('Quinoa',         120,   4.40, 21.30,  1.90, 'g'),
('Fromage chèvre', 364,  21.60,  0.90, 30.50, 'g'),
('Huile olive',    884,   0.00,  0.00, 100.00, 'ml');

-- =============================================
-- DONNÉES D'EXEMPLE — REPAS
-- =============================================

INSERT INTO repas (nom, date_repas, type_repas, calories_total) VALUES
('Toast avocat et oeuf',   CURDATE(),                            'petit_dejeuner', 420),
('Saumon grillé légumes',  CURDATE(),                            'dejeuner',       650),
('Salade de fruits frais', CURDATE(),                            'collation',      180),
('Poulet riz brocoli',     DATE_SUB(CURDATE(), INTERVAL 1 DAY), 'dejeuner',       520),
('Yaourt granola',         DATE_SUB(CURDATE(), INTERVAL 1 DAY), 'petit_dejeuner', 310);

INSERT INTO repas_aliment (repas_id, aliment_id, quantite) VALUES
(1, 4, 100), (1, 5, 2),   (1, 6, 2),
(2, 7, 200), (2, 3, 150), (2, 8, 100),
(3, 11, 2),
(4, 1, 200), (4, 2, 150), (4, 3, 100),
(5, 10, 1),  (5, 11, 1);

-- =============================================
-- DONNÉES D'EXEMPLE — RÉGIMES ALIMENTAIRES
-- =============================================

INSERT INTO regime_alimentaire (nom, objectif, description, duree_semaines, calories_jour, restrictions, soumis_par, statut) VALUES
('Régime Méditerranéen', 'Santé cardiovasculaire et longévité',
 'Basé sur l''alimentation traditionnelle des pays du pourtour méditerranéen. Riche en fruits, légumes, céréales complètes, légumineuses, noix et huile d''olive.',
 8, 1800, 'Limiter viande rouge (1x/semaine max), éviter sucres raffinés et produits ultra-transformés', 'Karim Ben Ali', 'accepte'),
('Régime Cétogène (Keto)', 'Perte de poids rapide par cétose',
 'Régime très pauvre en glucides (<50g/jour) et riche en graisses saines. Force le corps à utiliser les graisses comme source principale d''énergie.',
 4, 1700, 'Interdit : pain, pâtes, riz, pommes de terre, fruits sucrés, sucre, céréales', 'Thomas Dubois', 'accepte'),
('Végétalien Équilibré', 'Éthique animale et empreinte carbone réduite',
 'Alimentation 100% végétale excluant tout produit d''origine animale. Attention aux apports en B12, fer, zinc et oméga-3.',
 12, 2000, 'Aucun produit animal : viande, poisson, œufs, lait, fromage, miel. Supplémentation B12 obligatoire', 'Alice Martin', 'accepte'),
('Jeûne Intermittent 16:8', 'Perte de poids et autophagie cellulaire',
 'Fenêtre alimentaire de 8 heures (12h-20h) suivie de 16 heures de jeûne. Pendant le jeûne : eau, thé, café noir uniquement.',
 6, 1600, 'Pas de calories pendant la fenêtre de jeûne (16h). Éviter grignotage et aliments ultra-transformés', 'Marie Laurent', 'en_attente'),
('Régime DASH Anti-Hypertension', 'Réduction de la pression artérielle',
 'Développé par le NIH américain, le régime DASH privilégie fruits, légumes, produits laitiers allégés, céréales complètes et protéines maigres.',
 8, 2000, 'Sel limité à 2300mg/jour. Réduire : charcuteries, fromages salés, plats préparés', 'Sophie Leclerc', 'accepte'),
('Régime Anti-Inflammatoire', 'Réduire l''inflammation chronique',
 'Favorise les aliments anti-inflammatoires : poissons gras, curcuma, gingembre, baies, légumes crucifères, thé vert.',
 10, 1900, 'Éviter : sucres ajoutés, farines blanches, huiles raffinées, viandes transformées, alcool excessif', 'Lina Ouali', 'en_attente');

-- =============================================
-- DONNÉES D'EXEMPLE — PLANS NUTRITIONNELS
-- =============================================

INSERT INTO plan_nutritionnel (nom, description, objectif_calories, duree_jours, type_objectif, date_debut, soumis_par, statut, programme_activites) VALUES
('Plan Équilibre Semaine',
 'Un plan alimentaire équilibré sur 7 jours pour maintenir un poids stable tout en mangeant sainement.',
 2000, 7, 'maintien', CURDATE(), 'Jean Dupont', 'accepte',
 'Lundi : 30 min marche rapide\nMercredi : 45 min natation\nVendredi : 30 min yoga'),
('Objectif Minceur 14j',
 'Programme de 14 jours focalisé sur la perte de poids progressive et saine.',
 1500, 14, 'perte_poids', DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'Marie Laurent', 'accepte',
 'Lundi/Mercredi/Vendredi : 40 min HIIT\nMardi/Jeudi : 30 min course à pied'),
('Prise de Masse Musculaire',
 'Plan nutritionnel sur 28 jours pour accompagner un programme de musculation.',
 3000, 28, 'prise_masse', DATE_ADD(CURDATE(), INTERVAL 3 DAY), 'Thomas Dubois', 'accepte',
 'Lundi : Pectoraux + Triceps\nMardi : Dos + Biceps\nJeudi : Épaules + Abdos\nVendredi : Jambes'),
('Détox Printanière 5 Jours',
 'Une cure détox légère de 5 jours basée sur des jus verts et des repas légers riches en antioxydants.',
 1200, 5, 'perte_poids', DATE_SUB(CURDATE(), INTERVAL 3 DAY), 'Sophie Leclerc', 'accepte',
 'Chaque matin : 20 min étirements + méditation\nAprès-midi : 30 min marche'),
('Plan Méditerranéen',
 'Inspiré du régime méditerranéen, ce plan de 21 jours met l''accent sur l''huile d''olive, les poissons gras et les légumineuses.',
 1800, 21, 'maintien', DATE_ADD(CURDATE(), INTERVAL 14 DAY), 'Karim Ben Ali', 'accepte',
 'Lundi/Mercredi/Vendredi : 45 min marche\nMardi/Jeudi : 30 min gymnastique douce'),
('Programme Végétalien Sportif',
 'Plan 100% végétalien sur 14 jours, spécialement conçu pour les sportifs.',
 2400, 14, 'maintien', DATE_ADD(CURDATE(), INTERVAL 5 DAY), 'Alice Martin', 'en_attente',
 'Lundi/Mercredi/Vendredi : Musculation (1h)\nMardi/Jeudi : Course 5km\nSamedi : Sport collectif'),
('Plan Anti-Stress & Bien-être',
 'Un programme de 10 jours axé sur les aliments qui réduisent le cortisol et favorisent la sérénité.',
 1900, 10, 'maintien', CURDATE(), 'Lina Ouali', 'en_attente',
 'Matin : 15 min méditation\nMidi : 20 min marche digestive\nSoir : 30 min yoga'),
('Objectif -5kg en 30 Jours',
 'Plan structuré de 30 jours avec un déficit calorique contrôlé pour une perte de poids progressive.',
 1600, 30, 'perte_poids', DATE_ADD(CURDATE(), INTERVAL 1 DAY), 'Romain Girard', 'accepte',
 'Semaine 1 : 3x 30min marche + 2x 20min renforcement\nSemaine 2 : 3x 40min jogging + 2x HIIT');

-- Link plans to régimes
UPDATE plan_nutritionnel SET regime_id = 1 WHERE id = 5;
UPDATE plan_nutritionnel SET regime_id = 3 WHERE id = 6;
UPDATE plan_nutritionnel SET regime_id = 4 WHERE id = 2;

INSERT INTO plan_repas (plan_id, repas_id, jour) VALUES
(1, 1, 1), (1, 2, 1), (1, 3, 1),
(1, 4, 2), (1, 5, 2), (1, 3, 2),
(1, 1, 3), (1, 4, 3),
(2, 1, 1), (2, 3, 1),
(2, 5, 2), (2, 2, 2),
(3, 5, 1), (3, 1, 1), (3, 2, 1),
(4, 3, 1), (4, 3, 2), (4, 3, 3),
(5, 1, 1), (5, 2, 1), (5, 3, 1),
(8, 5, 1), (8, 3, 1), (8, 1, 2);

-- =============================================
-- DONNÉES D'EXEMPLE — PRODUITS
-- =============================================

INSERT INTO produit (nom, description, prix, stock, categorie, image, producteur, is_bio) VALUES
('Tomates bio',       'Tomates fraîches cultivées en plein air, variété ancienne.',      3.50, 120, 'Légumes',           'tomates.jpg',  'Ferme Dupont',          1),
('Pain artisanal',    'Pain au levain, farine bio locale, cuit au feu de bois.',         4.20,  45, 'Boulangerie',       'pain.jpg',     'Boulangerie Martin',    0),
('Salade verte',      'Salade feuille de chêne, cueillie le matin même.',                2.80,  80, 'Légumes',           'salade.jpg',   'Les Vergers du Soleil', 1),
('Oeufs fermiers',    'Oeufs de poules élevées en plein air, calibre gros.',             5.50,  60, 'Produits laitiers', 'oeufs.jpg',    'La Ferme aux Oeufs',    1),
('Pommes de terre',   'Pommes de terre nouvelles, variété Charlotte.',                    2.20, 200, 'Légumes',           'patates.jpg',  'Ferme Dupont',          0),
('Miel artisanal',    'Miel toutes fleurs, récolté à la main, non pasteurisé.',         12.50,  30, 'Épicerie',          'miel.jpg',     'Rucher du Midi',        1),
('Fromage de chèvre', 'Fromage frais de chèvre, fabrication artisanale.',                6.80,  25, 'Produits laitiers', 'fromage.jpg',  'Chèvrerie des Alpes',   1),
('Huile d\'olive',    'Huile d\'olive extra-vierge, première pression à froid.',         9.90,  40, 'Épicerie',          'huile.jpg',    'Moulin Provençal',      1);

-- =============================================
-- DONNÉES D'EXEMPLE — COMMANDES
-- =============================================

INSERT INTO commande (client_nom, client_email, client_adresse, total, statut) VALUES
('Jean Dupont',   'jean.dupont@email.com',   '12 rue des Lilas, 75001 Paris',         24.50, 'confirmee'),
('Marie Laurent', 'marie.laurent@email.com', '45 avenue Victor Hugo, 69002 Lyon',     18.70, 'en_attente'),
('Thomas Dubois', 'thomas.dubois@email.com', '8 boulevard Pasteur, 33000 Bordeaux',   35.20, 'livree');

INSERT INTO commande_produit (commande_id, produit_id, quantite, prix_unitaire) VALUES
(1, 1, 3, 3.50), (1, 2, 2, 4.20), (1, 3, 1, 2.80),
(2, 4, 2, 5.50), (2, 6, 1, 12.50),
(3, 7, 2, 6.80), (3, 8, 1, 9.90), (3, 5, 3, 2.20);

-- =============================================
-- DONNÉES D'EXEMPLE — RECETTES
-- =============================================

INSERT INTO recette (titre, description, instructions, temps_preparation, difficulte, categorie, image, calories_total, score_carbone) VALUES
('Salade César au poulet bio',
 'Une salade fraîche et protéinée avec du poulet grillé bio.',
 'Faites griller le poulet assaisonné. Lavez et coupez la laitue romaine. Préparez la sauce César maison avec de l\'huile d\'olive, du jus de citron, de l\'ail et du parmesan. Assemblez le tout et ajoutez des croûtons de pain complet.',
 25, 'facile', 'Salade', 'salade_cesar.jpg', 380, 1.20),
('Bowl quinoa végétarien',
 'Un bol complet et nutritif avec du quinoa et des légumes.',
 'Cuisez le quinoa selon les instructions. Rôtissez les patates douces et les pois chiches avec des épices. Coupez l\'avocat et les tomates. Assemblez dans un bol et arrosez de sauce tahini.',
 35, 'facile', 'Bowl', 'bowl_quinoa.jpg', 520, 0.80),
('Saumon grillé sauce citron-aneth',
 'Un plat de saumon frais avec une sauce légère aux herbes.',
 'Assaisonnez le saumon avec sel, poivre et aneth. Grillez à la poêle 4 minutes de chaque côté. Préparez la sauce avec du jus de citron, de l\'huile d\'olive et de l\'aneth frais. Servez avec des légumes vapeur.',
 30, 'moyen', 'Poisson', 'saumon.jpg', 480, 2.10),
('Pasta aux légumes de saison',
 'Des pâtes complètes avec des légumes frais du marché.',
 'Faites cuire les pâtes complètes al dente. Sautez les courgettes, poivrons et tomates à l\'huile d\'olive. Ajoutez de l\'ail et du basilic frais. Mélangez avec les pâtes et servez avec du parmesan.',
 20, 'facile', 'Pâtes', 'pasta.jpg', 420, 0.60),
('Smoothie bowl aux baies',
 'Un petit-déjeuner vitaminé et coloré.',
 'Mixez les baies congelées avec une banane et un peu de lait d\'amande. Versez dans un bol. Garnissez de granola, graines de chia, tranches de banane et baies fraîches.',
 10, 'facile', 'Petit-déjeuner', 'smoothie.jpg', 280, 0.40);

-- =============================================
-- DONNÉES D'EXEMPLE — INGRÉDIENTS
-- =============================================

INSERT INTO ingredient (nom, unite, calories_par_unite, is_local) VALUES
('Poulet bio',      'g',      2, 1),
('Quinoa',          'g',      1, 0),
('Avocat',          'unité', 160, 0),
('Tomate',          'g',      0, 1),
('Saumon frais',    'g',      2, 0),
('Citron',          'unité', 17, 1),
('Pâtes complètes', 'g',      1, 1),
('Courgette',       'g',      0, 1),
('Banane',          'unité', 89, 0),
('Baies mélangées', 'g',      1, 0),
('Laitue romaine',  'g',      0, 1),
('Patate douce',    'g',      1, 1),
('Pois chiches',    'g',      2, 0),
('Aneth frais',     'g',      0, 1),
('Parmesan',        'g',      4, 0);

INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite) VALUES
(1, 1, 200), (1, 11, 150), (1, 4, 100),  (1, 15, 30),
(2, 2, 150), (2, 12, 200), (2, 3, 1),    (2, 13, 100), (2, 4, 80),
(3, 5, 250), (3, 6, 2),    (3, 14, 10),
(4, 7, 200), (4, 8, 150),  (4, 4, 100),  (4, 15, 20),
(5, 9, 1),   (5, 10, 150);

-- =============================================
-- DONNÉES D'EXEMPLE — COMMENTAIRES RECETTES
-- =============================================

INSERT INTO commentaire_recette (recette_id, auteur, email, note, commentaire, statut) VALUES
(1, 'Alice Martin',   'alice@example.com',  5, 'Excellente recette, facile et délicieuse !', 'approuve'),
(1, 'Karim Ben Ali',  'karim@example.com',  4, 'Très bon résultat, j\'ai ajouté un peu plus de citron.', 'approuve'),
(1, 'Fatima Zahra',   NULL,                  3, 'Bonne recette mais un peu fade sans assaisonnement.', 'en_attente'),
(2, 'Sophie Leclerc', 'sophie@example.com', 5, 'Parfait pour un repas végétarien équilibré !', 'approuve'),
(2, 'Thomas Dupuis',  'thomas@example.com', 4, 'Le quinoa avec la sauce tahini, je referai sans hésiter.', 'approuve'),
(3, 'Inès Belhaj',    NULL,                  5, 'Le saumon grillé avec la sauce citron-aneth est divin !', 'approuve'),
(4, 'Lina Ouali',     'lina@example.com',   4, 'Les pâtes aux légumes de saison sont délicieuses.', 'approuve'),
(5, 'Romain Girard',  'romain@example.com', 5, 'Le smoothie bowl est parfait pour bien démarrer la journée !', 'approuve');

-- =============================================
-- DONNÉES D'EXEMPLE — MATÉRIELS
-- =============================================

INSERT INTO materiel (nom, description, propose_par, statut) VALUES
('Couteau de chef',    'Couteau polyvalent pour couper, émincer et ciseler.',             NULL, 'accepte'),
('Planche à découper', 'Surface de coupe en bois ou plastique.',                          NULL, 'accepte'),
('Poêle antiadhésive', 'Poêle pour cuissons sans matière grasse.',                        NULL, 'accepte'),
('Casserole',          'Pour les cuissons à feu doux ou à ébullition.',                   NULL, 'accepte'),
('Mixeur plongeant',   'Pour mixer soupes, smoothies et sauces directement dans le plat.',NULL, 'accepte'),
('Fouet',              'Pour émulsionner, battre des œufs ou monter une crème.',           NULL, 'accepte'),
('Passoire',           'Pour égoutter les pâtes, légumes ou légumineuses.',                NULL, 'accepte'),
('Balance de cuisine', 'Pour peser les ingrédients avec précision.',                      NULL, 'accepte'),
('Four',               'Pour cuissons au four : rôtis, gratins, gâteaux.',                 NULL, 'accepte'),
('Robot culinaire',    'Pour hacher, broyer et préparer les aliments rapidement.',         NULL, 'accepte');

-- =============================================
-- DONNÉES D'EXEMPLE — INSTRUCTIONS RECETTES
-- =============================================

INSERT INTO instruction_recette (recette_id, ordre, titre, description) VALUES
(1, 1, 'Grillez le poulet',   'Assaisonnez le poulet avec sel, poivre et herbes. Faites-le griller 6-8 min de chaque côté.'),
(1, 2, 'Préparez la laitue',  'Lavez et essorez la laitue romaine. Coupez-la en morceaux de taille moyenne.'),
(1, 3, 'Préparez la sauce',   'Mélangez huile d\'olive, jus de citron, ail émincé et parmesan pour obtenir la sauce César.'),
(1, 4, 'Assemblez la salade', 'Disposez la laitue, ajoutez le poulet tranché, la sauce et les croûtons.'),
(2, 1, 'Cuire le quinoa',     'Rincez le quinoa puis cuisez-le dans 2 fois son volume d\'eau pendant 15 min.'),
(2, 2, 'Rôtissez les légumes','Coupez patates douces et pois chiches, assaisonnez et enfournez à 200°C pendant 25 min.'),
(2, 3, 'Assemblez le bowl',   'Disposez le quinoa, les légumes rôtis, l\'avocat et les tomates. Arrosez de sauce tahini.');
