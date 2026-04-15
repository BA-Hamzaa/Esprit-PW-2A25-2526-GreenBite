<?php
/**
 * Modèle Aliment — Gestion des aliments de référence
 */
class Aliment {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /** Récupérer tous les aliments */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM aliment ORDER BY nom ASC");
        return $stmt->fetchAll();
    }

    /** Récupérer un aliment par ID */
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM aliment WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Créer un aliment */
    public function create($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO aliment (nom, calories, proteines, glucides, lipides, unite) VALUES (?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['nom'],
            $data['calories'],
            $data['proteines'],
            $data['glucides'],
            $data['lipides'],
            $data['unite']
        ]);
    }

    /** Mettre à jour un aliment */
    public function update($id, $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE aliment SET nom = ?, calories = ?, proteines = ?, glucides = ?, lipides = ?, unite = ? WHERE id = ?"
        );
        return $stmt->execute([
            $data['nom'],
            $data['calories'],
            $data['proteines'],
            $data['glucides'],
            $data['lipides'],
            $data['unite'],
            $id
        ]);
    }

    /** Supprimer un aliment */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM aliment WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
