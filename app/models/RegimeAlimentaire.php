<?php
/**
 * Modèle RegimeAlimentaire — Gestion des régimes alimentaires
 * Workflow : soumis par l'utilisateur → validé / refusé par l'admin
 */
class RegimeAlimentaire {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /** Récupérer tous les régimes (admin) */
    public function getAll() {
        $stmt = $this->pdo->query(
            "SELECT * FROM regime_alimentaire ORDER BY created_at DESC"
        );
        return $stmt->fetchAll();
    }

    /** Récupérer uniquement les régimes acceptés (front public) */
    public function getAccepted() {
        $stmt = $this->pdo->query(
            "SELECT * FROM regime_alimentaire WHERE statut = 'accepte' ORDER BY created_at DESC"
        );
        return $stmt->fetchAll();
    }

    /** Récupérer les régimes en attente (admin) */
    public function getPending() {
        $stmt = $this->pdo->query(
            "SELECT * FROM regime_alimentaire WHERE statut = 'en_attente' ORDER BY created_at DESC"
        );
        return $stmt->fetchAll();
    }

    /** Récupérer les régimes d'un utilisateur par son nom (front) */
    public function getByUser($soumis_par) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM regime_alimentaire WHERE soumis_par = ? ORDER BY created_at DESC"
        );
        $stmt->execute([$soumis_par]);
        return $stmt->fetchAll();
    }

    /** Récupérer un régime par ID */
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM regime_alimentaire WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Créer un nouveau régime (statut = en_attente) */
    public function create($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO regime_alimentaire
             (nom, objectif, description, duree_semaines, calories_jour, restrictions, soumis_par, statut)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['nom'],
            $data['objectif'],
            $data['description'] ?? '',
            $data['duree_semaines'],
            $data['calories_jour'],
            $data['restrictions'] ?? '',
            $data['soumis_par'],
            $data['statut'] ?? 'en_attente'
        ]);
        return $this->pdo->lastInsertId();
    }

    /** Mettre à jour les données d'un régime */
    public function update($id, $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE regime_alimentaire
             SET nom = ?, objectif = ?, description = ?, duree_semaines = ?,
                 calories_jour = ?, restrictions = ?, statut = ?
             WHERE id = ?"
        );
        return $stmt->execute([
            $data['nom'],
            $data['objectif'],
            $data['description'] ?? '',
            $data['duree_semaines'],
            $data['calories_jour'],
            $data['restrictions'] ?? '',
            $data['statut'],
            $id
        ]);
    }

    /** Mettre à jour le statut (accept / refuse) + commentaire admin */
    public function updateStatut($id, $statut, $commentaire = null) {
        $stmt = $this->pdo->prepare(
            "UPDATE regime_alimentaire SET statut = ?, commentaire_admin = ? WHERE id = ?"
        );
        return $stmt->execute([$statut, $commentaire, $id]);
    }

    /** Supprimer un régime */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM regime_alimentaire WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /** Compter les régimes en attente (pour badge admin) */
    public function countPending() {
        $stmt = $this->pdo->query(
            "SELECT COUNT(*) as total FROM regime_alimentaire WHERE statut = 'en_attente'"
        );
        return $stmt->fetch()['total'];
    }

    /** Compter tous les régimes */
    public function count() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM regime_alimentaire");
        return $stmt->fetch()['total'];
    }
}
