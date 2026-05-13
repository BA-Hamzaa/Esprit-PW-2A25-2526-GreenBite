<?php
require_once 'config/database.php';
$db = Database::getConnexion();
$db->exec("ALTER TABLE repas ADD COLUMN statut ENUM('en_attente', 'accepte', 'refuse') DEFAULT 'en_attente'");
$db->exec("ALTER TABLE repas ADD COLUMN admin_comment TEXT NULL");
$db->exec("ALTER TABLE repas ADD COLUMN soumis_par VARCHAR(100) DEFAULT 'Utilisateur'");
echo "Success";
