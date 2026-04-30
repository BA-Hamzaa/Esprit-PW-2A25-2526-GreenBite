-- =============================================
-- GreenBite — Migration Blog (adaptée à greenbite.sql)
-- Ajoute "en_attente" pour validation d'articles
-- Ajoute modération des commentaires (statut)
-- =============================================

USE greenbite;

-- 1) Articles : ajouter le statut "en_attente"
ALTER TABLE article
  MODIFY statut ENUM('brouillon','en_attente','publie') DEFAULT 'en_attente';

-- 2) Commentaires : ajouter statut + valeurs par défaut
ALTER TABLE commentaire
  ADD COLUMN statut ENUM('en_attente','valide') DEFAULT 'en_attente' AFTER contenu;

-- 3) Index utiles
CREATE INDEX idx_article_statut_date ON article(statut, date_publication);
CREATE INDEX idx_commentaire_article_statut_date ON commentaire(article_id, statut, date_commentaire);

