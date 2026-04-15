<?php
/**
 * Modèle Commande — Gestion des commandes et de la liaison commande ↔ produits
 */
class Commande {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /** Récupérer toutes les commandes */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM commande ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /** Récupérer une commande par ID */
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM commande WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Créer une commande */
    public function create($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO commande (client_nom, client_email, client_adresse, total, statut) 
             VALUES (?, ?, ?, ?, 'en_attente')"
        );
        $stmt->execute([
            $data['client_nom'],
            $data['client_email'],
            $data['client_adresse'],
            $data['total']
        ]);
        return $this->pdo->lastInsertId();
    }

    /** Ajouter un produit à la commande */
    public function addProduit($commandeId, $produitId, $quantite, $prixUnitaire) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO commande_produit (commande_id, produit_id, quantite, prix_unitaire) 
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$commandeId, $produitId, $quantite, $prixUnitaire]);
    }

    /** Récupérer les produits d'une commande */
    public function getProduits($commandeId) {
        $stmt = $this->pdo->prepare(
            "SELECT cp.*, p.nom, p.image 
             FROM commande_produit cp 
             JOIN produit p ON cp.produit_id = p.id 
             WHERE cp.commande_id = ?"
        );
        $stmt->execute([$commandeId]);
        return $stmt->fetchAll();
    }

    /** Mettre à jour le statut d'une commande */
    public function updateStatut($id, $statut) {
        $stmt = $this->pdo->prepare("UPDATE commande SET statut = ? WHERE id = ?");
        return $stmt->execute([$statut, $id]);
    }

    /** Supprimer une commande */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM commande WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
