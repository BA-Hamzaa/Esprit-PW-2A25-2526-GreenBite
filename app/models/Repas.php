<?php
class Repas {
    private $id             = null;
    private $nom            = null;
    private $date_repas     = null;
    private $type_repas     = null;
    private $calories_total = null;

    function __construct($nom, $date_repas, $type_repas, $calories_total = 0) {
        $this->nom            = $nom;
        $this->date_repas     = $date_repas;
        $this->type_repas     = $type_repas;
        $this->calories_total = $calories_total;
    }

    // ==================== GETTERS ====================

    function getId()            { return $this->id; }
    function getNom()           { return $this->nom; }
    function getDateRepas()     { return $this->date_repas; }
    function getTypeRepas()     { return $this->type_repas; }
    function getCaloriesTotal() { return $this->calories_total; }

    // ==================== SETTERS ====================

    function setNom(string $nom)                   { $this->nom = $nom; }
    function setDateRepas(string $date_repas)      { $this->date_repas = $date_repas; }
    function setTypeRepas(string $type_repas)      { $this->type_repas = $type_repas; }
    function setCaloriesTotal(int $calories_total) { $this->calories_total = $calories_total; }
}
?>
