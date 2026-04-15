<?php
/**
 * Modèle Recette — Gestion des recettes et liaison recette ↔ ingrédients
 */
class Recette {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /** Récupérer toutes les recettes (admin — tous statuts) */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM recette ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /** Récupérer uniquement les recettes acceptées (frontoffice) */
    public function getAccepted() {
        $stmt = $this->pdo->query("SELECT * FROM recette WHERE statut = 'acceptee' ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /** Récupérer les recettes en attente (admin — modération) */
    public function getPending() {
        $stmt = $this->pdo->query("SELECT * FROM recette WHERE statut = 'en_attente' ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /** Récupérer les recettes refusées (admin) */
    public function getRefused() {
        $stmt = $this->pdo->query("SELECT * FROM recette WHERE statut = 'refusee' ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /** Récupérer une recette par ID */
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM recette WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /** Recherche et filtrage de recettes (acceptées uniquement pour le front) */
    public function search($difficulte = '', $categorie = '', $onlyAccepted = true) {
        $sql = "SELECT * FROM recette WHERE 1=1";
        $params = [];

        if ($onlyAccepted) {
            $sql .= " AND statut = 'acceptee'";
        }
        if (!empty($difficulte)) {
            $sql .= " AND difficulte = ?";
            $params[] = $difficulte;
        }
        if (!empty($categorie)) {
            $sql .= " AND categorie = ?";
            $params[] = $categorie;
        }

        $sql .= " ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /** Récupérer les catégories distinctes (acceptées seulement) */
    public function getCategories() {
        $stmt = $this->pdo->query("SELECT DISTINCT categorie FROM recette WHERE categorie IS NOT NULL AND statut = 'acceptee' ORDER BY categorie");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /** Créer une recette (admin — directement acceptée) */
    public function create($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO recette (titre, description, instructions, temps_preparation, difficulte, categorie, image, calories_total, score_carbone, statut, soumis_par) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['titre'], $data['description'], $data['instructions'],
            $data['temps_preparation'], $data['difficulte'], $data['categorie'],
            $data['image'], $data['calories_total'], $data['score_carbone'],
            $data['statut'] ?? 'acceptee',
            $data['soumis_par'] ?? null
        ]);
        return $this->pdo->lastInsertId();
    }

    /** Soumettre une suggestion de recette (client — statut en_attente) */
    public function suggestByClient($data) {
        $data['statut'] = 'en_attente';
        return $this->create($data);
    }

    /** Changer le statut d'une recette (acceptee / refusee) */
    public function updateStatut($id, $statut) {
        $allowed = ['acceptee', 'refusee', 'en_attente'];
        if (!in_array($statut, $allowed)) return false;
        $stmt = $this->pdo->prepare("UPDATE recette SET statut = ? WHERE id = ?");
        return $stmt->execute([$statut, $id]);
    }

    /** Mettre à jour une recette */
    public function update($id, $data) {
        $sql = "UPDATE recette SET titre=?, description=?, instructions=?, temps_preparation=?, difficulte=?, categorie=?, calories_total=?, score_carbone=?";
        $params = [
            $data['titre'], $data['description'], $data['instructions'],
            $data['temps_preparation'], $data['difficulte'], $data['categorie'],
            $data['calories_total'], $data['score_carbone']
        ];

        if (!empty($data['image'])) {
            $sql .= ", image=?";
            $params[] = $data['image'];
        }

        $sql .= " WHERE id=?";
        $params[] = $id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /** Supprimer une recette */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM recette WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /** Ajouter un ingrédient à la recette */
    public function addIngredient($recetteId, $ingredientId, $quantite) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO recette_ingredient (recette_id, ingredient_id, quantite) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$recetteId, $ingredientId, $quantite]);
    }

    /** Supprimer tous les ingrédients d'une recette */
    public function removeIngredients($recetteId) {
        $stmt = $this->pdo->prepare("DELETE FROM recette_ingredient WHERE recette_id = ?");
        return $stmt->execute([$recetteId]);
    }

    /** Récupérer les ingrédients d'une recette */
    public function getIngredients($recetteId) {
        $stmt = $this->pdo->prepare(
            "SELECT ri.*, i.nom, i.unite, i.calories_par_unite, i.is_local 
             FROM recette_ingredient ri 
             JOIN ingredient i ON ri.ingredient_id = i.id 
             WHERE ri.recette_id = ?"
        );
        $stmt->execute([$recetteId]);
        return $stmt->fetchAll();
    }

    /** Récupérer les recettes d'un utilisateur par nom (soumis_par) */
    public function getByUser($soumis_par) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM recette WHERE soumis_par = ? ORDER BY created_at DESC"
        );
        $stmt->execute([$soumis_par]);
        return $stmt->fetchAll();
    }

    /** Compter les recettes en attente (pour badge admin) */
    public function countPending() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM recette WHERE statut = 'en_attente'");
        return (int)$stmt->fetchColumn();
    }
}
