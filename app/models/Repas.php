<?php
/**
 * Modèle Repas — Gestion des repas et de la liaison repas ↔ aliments
 */
class Repas {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /** Récupérer tous les repas */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM repas ORDER BY date_repas DESC, created_at DESC");
        return $stmt->fetchAll();
    }

    /** Récupérer les repas d'aujourd'hui */
    public function getToday() {
        $stmt = $this->pdo->prepare("SELECT * FROM repas WHERE date_repas = CURDATE() ORDER BY FIELD(type_repas, 'petit_dejeuner', 'dejeuner', 'collation', 'diner')");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Récupérer un repas par ID */
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM repas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Créer un repas */
    public function create($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO repas (nom, date_repas, type_repas, calories_total) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['nom'],
            $data['date_repas'],
            $data['type_repas'],
            $data['calories_total']
        ]);
        return $this->pdo->lastInsertId();
    }

    /** Mettre à jour un repas */
    public function update($id, $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE repas SET nom = ?, date_repas = ?, type_repas = ?, calories_total = ? WHERE id = ?"
        );
        return $stmt->execute([
            $data['nom'],
            $data['date_repas'],
            $data['type_repas'],
            $data['calories_total'],
            $id
        ]);
    }

    /** Supprimer un repas */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM repas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /** Ajouter un aliment au repas */
    public function addAliment($repasId, $alimentId, $quantite) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO repas_aliment (repas_id, aliment_id, quantite) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$repasId, $alimentId, $quantite]);
    }

    /** Supprimer tous les aliments d'un repas */
    public function removeAliments($repasId) {
        $stmt = $this->pdo->prepare("DELETE FROM repas_aliment WHERE repas_id = ?");
        return $stmt->execute([$repasId]);
    }

    /** Récupérer les aliments d'un repas avec détails */
    public function getAliments($repasId) {
        $stmt = $this->pdo->prepare(
            "SELECT ra.*, a.nom, a.calories, a.proteines, a.glucides, a.lipides, a.unite
             FROM repas_aliment ra
             JOIN aliment a ON ra.aliment_id = a.id
             WHERE ra.repas_id = ?"
        );
        $stmt->execute([$repasId]);
        return $stmt->fetchAll();
    }

    /** Calculer le total de calories d'un repas */
    public function calculerCalories($repasId) {
        $aliments = $this->getAliments($repasId);
        $total = 0;
        foreach ($aliments as $a) {
            $total += ($a['calories'] * $a['quantite']) / 100;
        }
        return round($total);
    }
}
