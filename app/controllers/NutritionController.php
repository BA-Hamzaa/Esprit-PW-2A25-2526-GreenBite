<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/app/models/Repas.php';
require_once BASE_PATH . '/app/models/Aliment.php';
require_once BASE_PATH . '/app/models/PlanNutritionnel.php';
require_once BASE_PATH . '/app/models/RegimeAlimentaire.php';

class NutritionController
{

    //==========================================================================
    // CRUD — REPAS
    //==========================================================================

    /////..............................Afficher Repas du Jour (Front)............................../////
    function AfficherRepasJour()
    {
        $sql = "SELECT * FROM repas WHERE date_repas = CURDATE()
                ORDER BY FIELD(type_repas, 'petit_dejeuner', 'dejeuner', 'collation', 'diner')";
        $db = Database::getConnexion();
        try {
            $liste = $db->query($sql)->fetchAll();
            foreach ($liste as &$r) {
                $r['aliments'] = $this->AfficherAlimentsRepas($r['id']);
            }
            return $liste;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Afficher tous les Repas (Back)............................../////
    function AfficherTousRepas()
    {
        $sql = "SELECT * FROM repas ORDER BY date_repas DESC";
        $db = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Récupérer un Repas par ID............................../////
    function RecupererRepas($id)
    {
        $sql = "SELECT * FROM repas WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Afficher Aliments d'un Repas............................../////
    function AfficherAlimentsRepas($repas_id)
    {
        $sql = "SELECT ra.*, a.nom, a.calories, a.proteines, a.glucides, a.lipides, a.unite
                FROM repas_aliment ra
                JOIN aliment a ON ra.aliment_id = a.id
                WHERE ra.repas_id = :repas_id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':repas_id', $repas_id);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Ajouter Repas............................../////
    function AjouterRepas(Repas $repas)
    {
        $sql = "INSERT INTO repas (nom, date_repas, type_repas, calories_total)
                VALUES (:nom, :date_repas, :type_repas, :calories_total)";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $repas->getNom(),
                'date_repas' => $repas->getDateRepas(),
                'type_repas' => $repas->getTypeRepas(),
                'calories_total' => $repas->getCaloriesTotal(),
            ]);
            return $db->lastInsertId();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Lier Aliment à un Repas............................../////
    function LierAlimentRepas($repas_id, $aliment_id, $quantite)
    {
        $sql = "INSERT INTO repas_aliment (repas_id, aliment_id, quantite)
                VALUES (:repas_id, :aliment_id, :quantite)";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'repas_id' => $repas_id,
                'aliment_id' => $aliment_id,
                'quantite' => $quantite,
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Supprimer liens Aliments d'un Repas............................../////
    function SupprimerAlimentsRepas($repas_id)
    {
        $sql = "DELETE FROM repas_aliment WHERE repas_id = :repas_id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':repas_id', $repas_id);
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Modifier Repas............................../////
    function ModifierRepas(Repas $repas, $id)
    {
        $sql = "UPDATE repas SET
                    nom            = :nom,
                    date_repas     = :date_repas,
                    type_repas     = :type_repas,
                    calories_total = :calories_total
                WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $repas->getNom(),
                'date_repas' => $repas->getDateRepas(),
                'type_repas' => $repas->getTypeRepas(),
                'calories_total' => $repas->getCaloriesTotal(),
                'id' => $id,
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Supprimer Repas............................../////
    function SupprimerRepas($id)
    {
        $sql = "DELETE FROM repas WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    //==========================================================================
    // CRUD — ALIMENTS
    //==========================================================================

    /////..............................Afficher tous les Aliments............................../////
    function AfficherAliments()
    {
        $sql = "SELECT * FROM aliment ORDER BY nom ASC";
        $db = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Récupérer un Aliment par ID............................../////
    function RecupererAliment($id)
    {
        $sql = "SELECT * FROM aliment WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Ajouter Aliment............................../////
    function AjouterAliment(Aliment $aliment)
    {
        $sql = "INSERT INTO aliment (nom, calories, proteines, glucides, lipides, unite)
                VALUES (:nom, :calories, :proteines, :glucides, :lipides, :unite)";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $aliment->getNom(),
                'calories' => $aliment->getCalories(),
                'proteines' => $aliment->getProteines(),
                'glucides' => $aliment->getGlucides(),
                'lipides' => $aliment->getLipides(),
                'unite' => $aliment->getUnite(),
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Modifier Aliment............................../////
    function ModifierAliment(Aliment $aliment, $id)
    {
        $sql = "UPDATE aliment SET
                    nom       = :nom,
                    calories  = :calories,
                    proteines = :proteines,
                    glucides  = :glucides,
                    lipides   = :lipides,
                    unite     = :unite
                WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $aliment->getNom(),
                'calories' => $aliment->getCalories(),
                'proteines' => $aliment->getProteines(),
                'glucides' => $aliment->getGlucides(),
                'lipides' => $aliment->getLipides(),
                'unite' => $aliment->getUnite(),
                'id' => $id,
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /////..............................Supprimer Aliment............................../////
    function SupprimerAliment($id)
    {
        $sql = "DELETE FROM aliment WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    //==========================================================================
    // CRUD — PLANS NUTRITIONNELS
    //==========================================================================

    /////..............................Afficher tous les Plans............................../////
    function AfficherPlans()
    {
        $sql = "SELECT * FROM plan_nutritionnel ORDER BY date_debut DESC, created_at DESC";
        $db = Database::getConnexion();
        try {
            $plans = $db->query($sql)->fetchAll();
            foreach ($plans as &$p) {
                $stmt = $db->prepare("SELECT COUNT(*) FROM plan_repas WHERE plan_id = :plan_id");
                $stmt->bindValue(':plan_id', $p['id']);
                $stmt->execute();
                $p['nb_repas'] = $stmt->fetchColumn();

                $stmt = $db->prepare(
                    "SELECT pr.jour, r.* FROM plan_repas pr
                     JOIN repas r ON pr.repas_id = r.id
                     WHERE pr.plan_id = :plan_id ORDER BY pr.jour ASC"
                );
                $stmt->bindValue(':plan_id', $p['id']);
                $stmt->execute();
                $p['repas'] = $stmt->fetchAll();
            }
            return $plans;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Afficher Plans (Back)............................../////
    function AfficherPlansBack()
    {
        $sql = "SELECT * FROM plan_nutritionnel ORDER BY created_at DESC";
        $db = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Récupérer un Plan par ID............................../////
    function RecupererPlan($id)
    {
        $sql = "SELECT * FROM plan_nutritionnel WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Récupérer Repas d'un Plan (par jour)............................../////
    function RecupererRepasPlan($plan_id)
    {
        $sql = "SELECT pr.jour, r.* FROM plan_repas pr
                JOIN repas r ON pr.repas_id = r.id
                WHERE pr.plan_id = :plan_id
                ORDER BY pr.jour ASC, FIELD(r.type_repas,'petit_dejeuner','dejeuner','collation','diner')";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':plan_id', $plan_id);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Récupérer liens plan_repas............................../////
    function RecupererLiensPlanRepas($plan_id)
    {
        $sql = "SELECT * FROM plan_repas WHERE plan_id = :plan_id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':plan_id', $plan_id);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Ajouter Plan............................../////
    function AjouterPlan(PlanNutritionnel $plan)
    {
        $sql = "INSERT INTO plan_nutritionnel (nom, description, objectif_calories, duree_jours, type_objectif, date_debut)
                VALUES (:nom, :description, :objectif_calories, :duree_jours, :type_objectif, :date_debut)";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $plan->getNom(),
                'description' => $plan->getDescription(),
                'objectif_calories' => $plan->getObjectifCalories(),
                'duree_jours' => $plan->getDureeJours(),
                'type_objectif' => $plan->getTypeObjectif(),
                'date_debut' => $plan->getDateDebut(),
            ]);
            return $db->lastInsertId();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Lier Repas à un Plan............................../////
    function LierRepasPlan($plan_id, $repas_id, $jour)
    {
        $sql = "INSERT INTO plan_repas (plan_id, repas_id, jour) VALUES (:plan_id, :repas_id, :jour)";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['plan_id' => $plan_id, 'repas_id' => $repas_id, 'jour' => $jour]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Supprimer liens Repas d'un Plan............................../////
    function SupprimerRepasPlan($plan_id)
    {
        $sql = "DELETE FROM plan_repas WHERE plan_id = :plan_id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':plan_id', $plan_id);
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Modifier Plan............................../////
    function ModifierPlan(PlanNutritionnel $plan, $id)
    {
        $sql = "UPDATE plan_nutritionnel SET
                    nom               = :nom,
                    description       = :description,
                    objectif_calories = :objectif_calories,
                    duree_jours       = :duree_jours,
                    type_objectif     = :type_objectif,
                    date_debut        = :date_debut
                WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $plan->getNom(),
                'description' => $plan->getDescription(),
                'objectif_calories' => $plan->getObjectifCalories(),
                'duree_jours' => $plan->getDureeJours(),
                'type_objectif' => $plan->getTypeObjectif(),
                'date_debut' => $plan->getDateDebut(),
                'id' => $id,
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Supprimer Plan............................../////
    function SupprimerPlan($id)
    {
        $sql = "DELETE FROM plan_nutritionnel WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    //==========================================================================
    // CRUD — RÉGIMES ALIMENTAIRES
    //==========================================================================

    /////..............................Afficher Régimes Acceptés (Front)............................../////
    function AfficherRegimesAcceptes()
    {
        $sql = "SELECT * FROM regime_alimentaire WHERE statut = 'accepte' ORDER BY created_at DESC";
        $db = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Afficher Régimes d'un Client (par nom)............................../////
    function AfficherRegimesClient($soumis_par)
    {
        $sql = "SELECT * FROM regime_alimentaire WHERE soumis_par = :soumis_par ORDER BY created_at DESC";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':soumis_par', $soumis_par);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Afficher tous les Régimes (Back)............................../////
    function AfficherTousRegimes()
    {
        $sql = "SELECT * FROM regime_alimentaire ORDER BY created_at DESC";
        $db = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Compter Régimes en Attente............................../////
    function CompterRegimesEnAttente()
    {
        $sql = "SELECT COUNT(*) FROM regime_alimentaire WHERE statut = 'en_attente'";
        $db = Database::getConnexion();
        try {
            return $db->query($sql)->fetchColumn();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Récupérer un Régime par ID............................../////
    function RecupererRegime($id)
    {
        $sql = "SELECT * FROM regime_alimentaire WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Ajouter Régime............................../////
    function AjouterRegime(RegimeAlimentaire $regime)
    {
        $sql = "INSERT INTO regime_alimentaire (nom, objectif, description, duree_semaines, calories_jour, restrictions, soumis_par, statut)
                VALUES (:nom, :objectif, :description, :duree_semaines, :calories_jour, :restrictions, :soumis_par, :statut)";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $regime->getNom(),
                'objectif' => $regime->getObjectif(),
                'description' => $regime->getDescription(),
                'duree_semaines' => $regime->getDureeSemaines(),
                'calories_jour' => $regime->getCaloriesJour(),
                'restrictions' => $regime->getRestrictions(),
                'soumis_par' => $regime->getSoumisPar(),
                'statut' => $regime->getStatut(),
            ]);
            return $db->lastInsertId();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Modifier Régime............................../////
    function ModifierRegime(RegimeAlimentaire $regime, $id)
    {
        $sql = "UPDATE regime_alimentaire SET
                    nom            = :nom,
                    objectif       = :objectif,
                    description    = :description,
                    duree_semaines = :duree_semaines,
                    calories_jour  = :calories_jour,
                    restrictions   = :restrictions,
                    statut         = :statut,
                    commentaire_admin = NULL
                WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $regime->getNom(),
                'objectif' => $regime->getObjectif(),
                'description' => $regime->getDescription(),
                'duree_semaines' => $regime->getDureeSemaines(),
                'calories_jour' => $regime->getCaloriesJour(),
                'restrictions' => $regime->getRestrictions(),
                'statut' => $regime->getStatut(),
                'id' => $id,
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Modifier Statut Régime (Back)............................../////
    function ModifierStatutRegime($id, $statut, $commentaire = null)
    {
        $sql = "UPDATE regime_alimentaire SET statut = :statut, commentaire_admin = :commentaire WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['statut' => $statut, 'commentaire' => $commentaire, 'id' => $id]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    /////..............................Supprimer Régime............................../////
    function SupprimerRegime($id)
    {
        $sql = "DELETE FROM regime_alimentaire WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    //==========================================================================
    // VALIDATION
    //==========================================================================

    function ValiderRepas($post)
    {
        $errors = [];
        if (empty(trim($post['nom'] ?? ''))) {
            $errors[] = "Le nom du repas est obligatoire.";
        }
        if (empty($post['date_repas'] ?? '') || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $post['date_repas'])) {
            $errors[] = "La date doit être au format AAAA-MM-JJ.";
        }
        $typesValides = ['petit_dejeuner', 'dejeuner', 'diner', 'collation'];
        if (empty($post['type_repas'] ?? '') || !in_array($post['type_repas'], $typesValides)) {
            $errors[] = "Le type de repas est invalide.";
        }
        return $errors;
    }

    function ValiderAliment($post)
    {
        $errors = [];
        if (empty(trim($post['nom'] ?? ''))) {
            $errors[] = "Le nom de l'aliment est obligatoire.";
        }
        if (!isset($post['calories']) || !is_numeric($post['calories']) || (int) $post['calories'] < 0) {
            $errors[] = "Les calories doivent être un nombre positif.";
        }
        if (!isset($post['proteines']) || !is_numeric($post['proteines']) || (float) $post['proteines'] < 0) {
            $errors[] = "Les protéines doivent être un nombre positif.";
        }
        if (!isset($post['glucides']) || !is_numeric($post['glucides']) || (float) $post['glucides'] < 0) {
            $errors[] = "Les glucides doivent être un nombre positif.";
        }
        if (!isset($post['lipides']) || !is_numeric($post['lipides']) || (float) $post['lipides'] < 0) {
            $errors[] = "Les lipides doivent être un nombre positif.";
        }
        if (empty(trim($post['unite'] ?? ''))) {
            $errors[] = "L'unité est obligatoire.";
        }
        return $errors;
    }

    function ValiderPlan($post)
    {
        $errors = [];
        if (empty(trim($post['nom'] ?? ''))) {
            $errors[] = "Le nom du plan est obligatoire.";
        }
        if (!isset($post['objectif_calories']) || !is_numeric($post['objectif_calories']) || (int) $post['objectif_calories'] <= 0) {
            $errors[] = "L'objectif calorique doit être un nombre positif.";
        }
        if (!isset($post['duree_jours']) || !is_numeric($post['duree_jours']) || (int) $post['duree_jours'] <= 0) {
            $errors[] = "La durée doit être d'au moins 1 jour.";
        }
        $typesValides = ['perte_poids', 'maintien', 'prise_masse'];
        if (empty($post['type_objectif'] ?? '') || !in_array($post['type_objectif'], $typesValides)) {
            $errors[] = "Le type d'objectif est invalide.";
        }
        if (empty($post['date_debut'] ?? '') || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $post['date_debut'])) {
            $errors[] = "La date de début est obligatoire (format AAAA-MM-JJ).";
        }
        return $errors;
    }

    function ValiderRegime($post)
    {
        $errors = [];
        if (empty(trim($post['nom'] ?? ''))) {
            $errors[] = "Le nom du régime est obligatoire.";
        }
        $objectives = ['perte_poids', 'maintien', 'prise_masse', 'sante_generale'];
        if (empty($post['objectif'] ?? '') || !in_array($post['objectif'], $objectives)) {
            $errors[] = "L'objectif est invalide.";
        }
        if (!isset($post['duree_semaines']) || !is_numeric($post['duree_semaines']) || (int) $post['duree_semaines'] <= 0) {
            $errors[] = "La durée doit être d'au moins 1 semaine.";
        }
        if (!isset($post['calories_jour']) || !is_numeric($post['calories_jour']) || (int) $post['calories_jour'] <= 0) {
            $errors[] = "L'apport calorique journalier doit être un nombre positif.";
        }
        if (empty(trim($post['description'] ?? ''))) {
            $errors[] = "La description est obligatoire.";
        }
        if (empty(trim($post['restrictions'] ?? ''))) {
            $errors[] = "Les restrictions sont obligatoires.";
        }
        if (empty(trim($post['soumis_par'] ?? ''))) {
            $errors[] = "Votre nom est obligatoire.";
        }
        return $errors;
    }

    //==========================================================================
    // ROUTING — FRONTOFFICE
    //==========================================================================

    /////..............................FRONTOFFICE — Liste Repas............................../////
    function listFront()
    {
        $repas = $this->AfficherRepasJour();
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/nutrition/list.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Ajouter Repas............................../////
    function addFront()
    {
        $errors = [];
        $aliments = $this->AfficherAliments();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderRepas($_POST);
            if (empty($errors)) {
                $calTotal = 0;
                if (!empty($_POST['aliment_ids'])) {
                    foreach ($_POST['aliment_ids'] as $i => $alimentId) {
                        $quantite = $_POST['quantites'][$i];
                        $a = $this->RecupererAliment($alimentId);
                        if ($a) {
                            $calTotal += ($a['calories'] * $quantite) / 100;
                        }
                    }
                }
                $repas = new Repas(
                    trim($_POST['nom']),
                    $_POST['date_repas'],
                    $_POST['type_repas'],
                    round($calTotal)
                );
                $repasId = $this->AjouterRepas($repas);
                if (!empty($_POST['aliment_ids'])) {
                    foreach ($_POST['aliment_ids'] as $i => $alimentId) {
                        $quantite = $_POST['quantites'][$i];
                        if (!empty($alimentId) && $quantite > 0) {
                            $this->LierAlimentRepas($repasId, $alimentId, $quantite);
                        }
                    }
                }
                $_SESSION['success'] = "Repas ajouté avec succès !";
                header('Location: ' . BASE_URL . '/?page=nutrition');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/nutrition/add.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Liste Plans............................../////
    function listPlans()
    {
        $plans = $this->AfficherPlans();
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/nutrition/plans.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Détail Plan............................../////
    function detailPlan()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $plan = $this->RecupererPlan($id);
        if (!$plan) {
            $_SESSION['error'] = "Plan introuvable.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=plans');
            exit;
        }
        $planRepas = $this->RecupererRepasPlan($id);
        $repasByDay = [];
        foreach ($planRepas as $pr) {
            $jour = $pr['jour'];
            if (!isset($repasByDay[$jour])) {
                $repasByDay[$jour] = [];
            }
            $pr['aliments'] = $this->AfficherAlimentsRepas($pr['id']);
            $repasByDay[$jour][] = $pr;
        }
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/nutrition/plan_detail.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Ajouter Plan............................../////
    function addPlan()
    {
        $errors = [];
        $repas = $this->AfficherTousRepas();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderPlan($_POST);
            if (empty($errors)) {
                $plan = new PlanNutritionnel(
                    trim($_POST['nom']),
                    (int) $_POST['objectif_calories'],
                    (int) $_POST['duree_jours'],
                    $_POST['type_objectif'],
                    $_POST['date_debut'],
                    trim($_POST['description'] ?? '')
                );
                $planId = $this->AjouterPlan($plan);
                if (!empty($_POST['repas_ids'])) {
                    foreach ($_POST['repas_ids'] as $i => $repasId) {
                        $jour = $_POST['jours'][$i] ?? 1;
                        if (!empty($repasId) && $jour > 0) {
                            $this->LierRepasPlan($planId, $repasId, $jour);
                        }
                    }
                }
                $_SESSION['success'] = "Plan nutritionnel créé avec succès !";
                header('Location: ' . BASE_URL . '/?page=nutrition&action=plans');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/nutrition/plan_add.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Modifier Plan............................../////
    function editPlan()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $plan = $this->RecupererPlan($id);
        if (!$plan) {
            $_SESSION['error'] = "Plan introuvable.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=plans');
            exit;
        }
        $errors = [];
        $repas = $this->AfficherTousRepas();
        $planRepas = $this->RecupererLiensPlanRepas($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderPlan($_POST);
            if (empty($errors)) {
                $p = new PlanNutritionnel(
                    trim($_POST['nom']),
                    (int) $_POST['objectif_calories'],
                    (int) $_POST['duree_jours'],
                    $_POST['type_objectif'],
                    $_POST['date_debut'],
                    trim($_POST['description'] ?? '')
                );
                $this->ModifierPlan($p, $id);
                $this->SupprimerRepasPlan($id);
                if (!empty($_POST['repas_ids'])) {
                    foreach ($_POST['repas_ids'] as $i => $repasId) {
                        $jour = $_POST['jours'][$i] ?? 1;
                        if (!empty($repasId) && $jour > 0) {
                            $this->LierRepasPlan($id, $repasId, $jour);
                        }
                    }
                }
                $_SESSION['success'] = "Plan modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=nutrition&action=plans');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/nutrition/plan_edit.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Supprimer Plan............................../////
    function deletePlan()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $this->SupprimerPlan($id);
        $_SESSION['success'] = "Plan supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=nutrition&action=plans');
        exit;
    }

    /////..............................FRONTOFFICE — Liste Régimes............................../////
    function listRegimes()
    {
        $regimes = $this->AfficherRegimesAcceptes();
        $myName = $_SESSION['regime_user'] ?? '';
        $myIds = $_SESSION['my_regime_ids'] ?? [];
        $myRegimes = [];
        if (!empty($myName)) {
            foreach ($this->AfficherRegimesClient($myName) as $r) {
                $myRegimes[$r['id']] = $r;
            }
        }
        foreach ($myIds as $id) {
            if (!isset($myRegimes[$id])) {
                $r = $this->RecupererRegime($id);
                if ($r) {
                    $myRegimes[$r['id']] = $r;
                }
            }
        }
        $filtered = [];
        foreach ($myRegimes as $r) {
            if ($r['statut'] === 'en_attente' || $r['statut'] === 'refuse') {
                $filtered[] = $r;
            }
        }
        $myRegimes = $filtered;
        usort($myRegimes, function ($a, $b) {
            return strtotime($b['created_at']) <=> strtotime($a['created_at']); });

        // --- FILTERING (SEARCH) ---
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        if ($search !== '') {
            $regimes = array_filter($regimes, function($r) use ($search) {
                return stripos($r['nom'], $search) !== false || 
                       stripos(str_replace('_', ' ', $r['objectif']), $search) !== false || 
                       stripos($r['restrictions'] ?? '', $search) !== false;
            });
            $myRegimes = array_filter($myRegimes, function($r) use ($search) {
                return stripos($r['nom'], $search) !== false || 
                       stripos(str_replace('_', ' ', $r['objectif']), $search) !== false || 
                       stripos($r['restrictions'] ?? '', $search) !== false;
            });
        }

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/nutrition/regimes.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Détail Régime............................../////
    function detailRegimeFront()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $regime = $this->RecupererRegime($id);
        if (!$regime) {
            $_SESSION['error'] = "Régime introuvable.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
            exit;
        }
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/nutrition/regime_detail.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Proposer Régime............................../////
    function addRegime()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderRegime($_POST);
            if (empty($errors)) {
                $regime = new RegimeAlimentaire(
                    trim($_POST['nom']),
                    $_POST['objectif'],
                    (int) $_POST['duree_semaines'],
                    (int) $_POST['calories_jour'],
                    trim($_POST['soumis_par']),
                    'en_attente',
                    trim($_POST['description'] ?? ''),
                    trim($_POST['restrictions'] ?? '')
                );
                $regimeId = $this->AjouterRegime($regime);
                $_SESSION['regime_user'] = $regime->getSoumisPar();
                if (!isset($_SESSION['my_regime_ids'])) {
                    $_SESSION['my_regime_ids'] = [];
                }
                $_SESSION['my_regime_ids'][] = $regimeId;
                $_SESSION['success'] = "Votre régime a été soumis ! Il sera examiné par notre équipe.";
                header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/nutrition/regime_add.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Modifier Régime............................../////
    function editRegime()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $regime = $this->RecupererRegime($id);
        if (!$regime) {
            $_SESSION['error'] = "Régime introuvable.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
            exit;
        }
        $myName = $_SESSION['regime_user'] ?? '';
        $myIds = $_SESSION['my_regime_ids'] ?? [];
        $isAuthorized = (!empty($myName) && $regime['soumis_par'] === $myName) || in_array($id, $myIds);
        if (!$isAuthorized) {
            $_SESSION['error'] = "Non autorisé.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
            exit;
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderRegime($_POST);
            if (empty($errors)) {
                $r = new RegimeAlimentaire(
                    trim($_POST['nom']),
                    $_POST['objectif'],
                    (int) $_POST['duree_semaines'],
                    (int) $_POST['calories_jour'],
                    $regime['soumis_par'],
                    'en_attente',
                    trim($_POST['description'] ?? ''),
                    trim($_POST['restrictions'] ?? '')
                );
                $this->ModifierRegime($r, $id);
                $_SESSION['success'] = "Votre régime a été mis à jour et resoumis.";
                header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/nutrition/regime_edit.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    /////..............................FRONTOFFICE — Supprimer Régime (Client)............................../////
    function deleteRegimeFront()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $regime = $this->RecupererRegime($id);
        if (!$regime) {
            $_SESSION['error'] = "Régime introuvable.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
            exit;
        }
        $myName = $_SESSION['regime_user'] ?? '';
        $myIds = $_SESSION['my_regime_ids'] ?? [];
        $isAuthorized = (!empty($myName) && $regime['soumis_par'] === $myName) || in_array($id, $myIds);
        if (!$isAuthorized) {
            $_SESSION['error'] = "Non autorisé.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
            exit;
        }
        if ($regime['statut'] === 'accepte') {
            $_SESSION['error'] = "Vous ne pouvez pas supprimer un régime déjà accepté.";
            header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
            exit;
        }
        $this->SupprimerRegime($id);
        $_SESSION['success'] = "Votre proposition a été supprimée.";
        header('Location: ' . BASE_URL . '/?page=nutrition&action=regimes');
        exit;
    }

    //==========================================================================
    // ROUTING — BACKOFFICE
    //==========================================================================

    function listBack()
    {
        $repas = $this->AfficherTousRepas();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/nutrition/list.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function addBack()
    {
        $errors = [];
        $aliments = $this->AfficherAliments();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderRepas($_POST);
            if (empty($errors)) {
                $calTotal = 0;
                if (!empty($_POST['aliment_ids'])) {
                    foreach ($_POST['aliment_ids'] as $i => $alimentId) {
                        $quantite = $_POST['quantites'][$i];
                        $a = $this->RecupererAliment($alimentId);
                        if ($a) {
                            $calTotal += ($a['calories'] * $quantite) / 100;
                        }
                    }
                }
                $repas = new Repas(trim($_POST['nom']), $_POST['date_repas'], $_POST['type_repas'], round($calTotal));
                $repasId = $this->AjouterRepas($repas);
                if (!empty($_POST['aliment_ids'])) {
                    foreach ($_POST['aliment_ids'] as $i => $alimentId) {
                        $quantite = $_POST['quantites'][$i] ?? 0;
                        if (!empty($alimentId) && $quantite > 0) {
                            $this->LierAlimentRepas($repasId, $alimentId, $quantite);
                        }
                    }
                }
                $_SESSION['success'] = "Repas ajouté avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=list');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/nutrition/add.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function editBack()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $repas = $this->RecupererRepas($id);
        if (!$repas) {
            $_SESSION['error'] = "Repas introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=list');
            exit;
        }
        $errors = [];
        $aliments = $this->AfficherAliments();
        $repasAliments = $this->AfficherAlimentsRepas($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderRepas($_POST);
            if (empty($errors)) {
                $calTotal = 0;
                if (!empty($_POST['aliment_ids'])) {
                    foreach ($_POST['aliment_ids'] as $i => $alimentId) {
                        $quantite = $_POST['quantites'][$i];
                        $a = $this->RecupererAliment($alimentId);
                        if ($a) {
                            $calTotal += ($a['calories'] * $quantite) / 100;
                        }
                    }
                }
                $r = new Repas(trim($_POST['nom']), $_POST['date_repas'], $_POST['type_repas'], round($calTotal));
                $this->ModifierRepas($r, $id);
                $this->SupprimerAlimentsRepas($id);
                if (!empty($_POST['aliment_ids'])) {
                    foreach ($_POST['aliment_ids'] as $i => $alimentId) {
                        $quantite = $_POST['quantites'][$i];
                        if (!empty($alimentId) && $quantite > 0) {
                            $this->LierAlimentRepas($id, $alimentId, $quantite);
                        }
                    }
                }
                $_SESSION['success'] = "Repas modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=list');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/nutrition/edit.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function deleteBack()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $this->SupprimerRepas($id);
        $_SESSION['success'] = "Repas supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=list');
        exit;
    }

    function listAliments()
    {
        $aliments = $this->AfficherAliments();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/nutrition/aliments.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function addAliment()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderAliment($_POST);
            if (empty($errors)) {
                $a = new Aliment(
                    trim($_POST['nom']),
                    (int) $_POST['calories'],
                    (float) $_POST['proteines'],
                    (float) $_POST['glucides'],
                    (float) $_POST['lipides'],
                    trim($_POST['unite'])
                );
                $this->AjouterAliment($a);
                $_SESSION['success'] = "Aliment ajouté avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=aliments');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/nutrition/aliment_add.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function editAliment()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $aliment = $this->RecupererAliment($id);
        if (!$aliment) {
            $_SESSION['error'] = "Aliment introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=aliments');
            exit;
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderAliment($_POST);
            if (empty($errors)) {
                $a = new Aliment(
                    trim($_POST['nom']),
                    (int) $_POST['calories'],
                    (float) $_POST['proteines'],
                    (float) $_POST['glucides'],
                    (float) $_POST['lipides'],
                    trim($_POST['unite'])
                );
                $this->ModifierAliment($a, $id);
                $_SESSION['success'] = "Aliment modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=aliments');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/nutrition/aliment_edit.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function deleteAliment()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $this->SupprimerAliment($id);
        $_SESSION['success'] = "Aliment supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=aliments');
        exit;
    }

    function listPlansBack()
    {
        $plans = $this->AfficherPlansBack();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/nutrition/plans.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function addPlanBack()
    {
        $errors = [];
        $repas = $this->AfficherTousRepas();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderPlan($_POST);
            if (empty($errors)) {
                $plan = new PlanNutritionnel(
                    trim($_POST['nom']),
                    (int) $_POST['objectif_calories'],
                    (int) $_POST['duree_jours'],
                    $_POST['type_objectif'],
                    $_POST['date_debut'],
                    trim($_POST['description'] ?? '')
                );
                $planId = $this->AjouterPlan($plan);
                if (!empty($_POST['repas_ids'])) {
                    foreach ($_POST['repas_ids'] as $i => $repasId) {
                        $jour = $_POST['jours'][$i] ?? 1;
                        if (!empty($repasId) && $jour > 0) {
                            $this->LierRepasPlan($planId, $repasId, $jour);
                        }
                    }
                }
                $_SESSION['success'] = "Plan créé avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=plans');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/nutrition/plan_add.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function editPlanBack()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $plan = $this->RecupererPlan($id);
        if (!$plan) {
            $_SESSION['error'] = "Plan introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=plans');
            exit;
        }
        $errors = [];
        $repas = $this->AfficherTousRepas();
        $planRepas = $this->RecupererLiensPlanRepas($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderPlan($_POST);
            if (empty($errors)) {
                $p = new PlanNutritionnel(
                    trim($_POST['nom']),
                    (int) $_POST['objectif_calories'],
                    (int) $_POST['duree_jours'],
                    $_POST['type_objectif'],
                    $_POST['date_debut'],
                    trim($_POST['description'] ?? '')
                );
                $this->ModifierPlan($p, $id);
                $this->SupprimerRepasPlan($id);
                if (!empty($_POST['repas_ids'])) {
                    foreach ($_POST['repas_ids'] as $i => $repasId) {
                        $jour = $_POST['jours'][$i] ?? 1;
                        if (!empty($repasId) && $jour > 0) {
                            $this->LierRepasPlan($id, $repasId, $jour);
                        }
                    }
                }
                $_SESSION['success'] = "Plan modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=plans');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/nutrition/plan_edit.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function deletePlanBack()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $this->SupprimerPlan($id);
        $_SESSION['success'] = "Plan supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=plans');
        exit;
    }

    function listRegimesBack()
    {
        $regimes = $this->AfficherTousRegimes();
        $nbPending = $this->CompterRegimesEnAttente();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/nutrition/regimes.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function acceptRegime()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $commentaire = isset($_POST['commentaire_admin']) ? trim($_POST['commentaire_admin']) : null;
        $this->ModifierStatutRegime($id, 'accepte', $commentaire);
        $_SESSION['success'] = "Régime approuvé avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
        exit;
    }

    function refuseRegime()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $commentaire = isset($_POST['commentaire_admin']) ? trim($_POST['commentaire_admin']) : null;
        $this->ModifierStatutRegime($id, 'refuse', $commentaire);
        $_SESSION['success'] = "Régime refusé.";
        header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
        exit;
    }

    function deleteRegimeBack()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $this->SupprimerRegime($id);
        $_SESSION['success'] = "Régime supprimé avec succès !";
        header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
        exit;
    }

    function addRegimeBack()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderRegime($_POST);
            if (empty($errors)) {
                $r = new RegimeAlimentaire(
                    trim($_POST['nom']),
                    $_POST['objectif'],
                    (int) $_POST['duree_semaines'],
                    (int) $_POST['calories_jour'],
                    trim($_POST['soumis_par'] ?? 'Admin'),
                    'accepte',
                    trim($_POST['description'] ?? ''),
                    trim($_POST['restrictions'] ?? '')
                );
                $this->AjouterRegime($r);
                $_SESSION['success'] = "Régime ajouté et publié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/nutrition/regime_add.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function editRegimeBack()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $regime = $this->RecupererRegime($id);
        if (!$regime) {
            $_SESSION['error'] = "Régime introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
            exit;
        }
        if ($regime['statut'] !== 'accepte') {
            $_SESSION['error'] = "Vous ne pouvez modifier que les régimes acceptés.";
            header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
            exit;
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->ValiderRegime($_POST);
            if (empty($errors)) {
                $r = new RegimeAlimentaire(
                    trim($_POST['nom']),
                    $_POST['objectif'],
                    (int) $_POST['duree_semaines'],
                    (int) $_POST['calories_jour'],
                    $regime['soumis_par'],
                    'accepte',
                    trim($_POST['description'] ?? ''),
                    trim($_POST['restrictions'] ?? '')
                );
                $this->ModifierRegime($r, $id);
                $_SESSION['success'] = "Régime modifié avec succès !";
                header('Location: ' . BASE_URL . '/?page=admin-nutrition&action=regimes');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/nutrition/regime_edit.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }
}
?>