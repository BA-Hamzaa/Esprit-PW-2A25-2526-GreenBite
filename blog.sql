-- =============================================
-- GreenBite — Module Blog / Articles
-- Base: greenbite (user: root / pass: vide)
-- =============================================

CREATE DATABASE IF NOT EXISTS greenbite CHARACTER SET utf8 COLLATE utf8_general_ci;
USE greenbite;

CREATE TABLE IF NOT EXISTS article (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(180) NOT NULL,
    contenu LONGTEXT NOT NULL,
    auteur VARCHAR(120) DEFAULT 'Admin',
    statut ENUM('brouillon','en_attente','publie') DEFAULT 'brouillon',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS commentaire (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    auteur VARCHAR(120) NOT NULL,
    contenu TEXT NOT NULL,
    statut ENUM('en_attente','valide') DEFAULT 'en_attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_commentaire_article
        FOREIGN KEY (article_id) REFERENCES article(id) ON DELETE CASCADE
);

CREATE INDEX idx_article_statut_created ON article(statut, created_at);
CREATE INDEX idx_commentaire_article_statut_created ON commentaire(article_id, statut, created_at);

