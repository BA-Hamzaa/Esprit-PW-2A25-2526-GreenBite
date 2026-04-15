<?php
/**
 * Modèle PlanNutritionnel — Gestion des plans nutritionnels et liaison plan ↔ repas
 */
class PlanNutritionnel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /** Récupérer tous les plans */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM plan_nutritionnel ORDER BY date_debut DESC, created_at DESC");
        return $stmt->fetchAll();
    }

    /** Récupérer un plan par ID */
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM plan_nutritionnel WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Créer un plan */
    public function create($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO plan_nutritionnel (nom, description, objectif_calories, duree_jours, type_objectif, date_debut) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['nom'],
            $data['description'],
            $data['objectif_calories'],
            $data['duree_jours'],
            $data['type_objectif'],
            $data['date_debut']
        ]);
        return $this->pdo->lastInsertId();
    }

    /** Mettre à jour un plan */
    public function update($id, $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE plan_nutritionnel SET nom = ?, description = ?, objectif_calories = ?, duree_jours = ?, type_objectif = ?, date_debut = ? WHERE id = ?"
        );
        return $stmt->execute([
            $data['nom'],
            $data['description'],
            $data['objectif_calories'],
            $data['duree_jours'],
            $data['type_objectif'],
            $data['date_debut'],
            $id
        ]);
    }

    /** Supprimer un plan */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM plan_nutritionnel WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /** Ajouter un repas à un jour du plan */
    public function addRepas($planId, $repasId, $jour) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO plan_repas (plan_id, repas_id, jour) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$planId, $repasId, $jour]);
    }

    /** Supprimer tous les repas d'un plan */
    public function removeRepas($planId) {
        $stmt = $this->pdo->prepare("DELETE FROM plan_repas WHERE plan_id = ?");
        return $stmt->execute([$planId]);
    }

    /** Récupérer les repas d'un plan avec détails, triés par jour */
    public function getRepas($planId) {
        $stmt = $this->pdo->prepare(
            "SELECT pr.jour, r.*
             FROM plan_repas pr
             JOIN repas r ON pr.repas_id = r.id
             WHERE pr.plan_id = ?
             ORDER BY pr.jour ASC, FIELD(r.type_repas, 'petit_dejeuner', 'dejeuner', 'collation', 'diner')"
        );
        $stmt->execute([$planId]);
        return $stmt->fetchAll();
    }

    /** Compter le nombre de plans */
    public function count() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM plan_nutritionnel");
        return $stmt->fetch()['total'];
    }
}
