<?php
class PlanNutritionnel {
    private $id                = null;
    private $nom               = null;
    private $description       = null;
    private $objectif_calories = null;
    private $duree_jours       = null;
    private $type_objectif     = null;
    private $date_debut        = null;
    private $created_at        = null;

    function __construct($nom, $objectif_calories, $duree_jours, $type_objectif, $date_debut, $description = '') {
        $this->nom               = $nom;
        $this->objectif_calories = $objectif_calories;
        $this->duree_jours       = $duree_jours;
        $this->type_objectif     = $type_objectif;
        $this->date_debut        = $date_debut;
        $this->description       = $description;
    }

    // ==================== GETTERS ====================

    function getId()               { return $this->id; }
    function getNom()              { return $this->nom; }
    function getDescription()      { return $this->description; }
    function getObjectifCalories() { return $this->objectif_calories; }
    function getDureeJours()       { return $this->duree_jours; }
    function getTypeObjectif()     { return $this->type_objectif; }
    function getDateDebut()        { return $this->date_debut; }
    function getCreatedAt()        { return $this->created_at; }

    // ==================== SETTERS ====================

    function setNom(string $nom)                         { $this->nom = $nom; }
    function setDescription(string $description)         { $this->description = $description; }
    function setObjectifCalories(int $objectif_calories) { $this->objectif_calories = $objectif_calories; }
    function setDureeJours(int $duree_jours)             { $this->duree_jours = $duree_jours; }
    function setTypeObjectif(string $type_objectif)      { $this->type_objectif = $type_objectif; }
    function setDateDebut(string $date_debut)            { $this->date_debut = $date_debut; }
}
?>
