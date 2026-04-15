<?php
/**
 * Modèle Ingredient — Gestion des ingrédients de référence
 */
class Ingredient {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /** Récupérer tous les ingrédients */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM ingredient ORDER BY nom ASC");
        return $stmt->fetchAll();
    }

    /** Récupérer un ingrédient par ID */
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM ingredient WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Créer un ingrédient */
    public function create($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO ingredient (nom, unite, calories_par_unite, is_local) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['nom'],
            $data['unite'],
            $data['calories_par_unite'],
            $data['is_local']
        ]);
    }

    /** Mettre à jour un ingrédient */
    public function update($id, $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE ingredient SET nom=?, unite=?, calories_par_unite=?, is_local=? WHERE id=?"
        );
        return $stmt->execute([
            $data['nom'],
            $data['unite'],
            $data['calories_par_unite'],
            $data['is_local'],
            $id
        ]);
    }

    /** Supprimer un ingrédient */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM ingredient WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
