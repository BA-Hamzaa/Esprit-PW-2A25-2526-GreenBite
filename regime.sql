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
