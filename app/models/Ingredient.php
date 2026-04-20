<?php
class Ingredient {
    private $id                 = null;
    private $nom                = null;
    private $unite              = null;
    private $calories_par_unite = null;
    private $is_local           = null;

    function __construct($nom, $unite, $calories_par_unite = 0, $is_local = 0) {
        $this->nom                = $nom;
        $this->unite              = $unite;
        $this->calories_par_unite = $calories_par_unite;
        $this->is_local           = $is_local;
    }

    // ==================== GETTERS ====================

    function getId()               { return $this->id; }
    function getNom()              { return $this->nom; }
    function getUnite()            { return $this->unite; }
    function getCaloriesParUnite() { return $this->calories_par_unite; }
    function getIsLocal()          { return $this->is_local; }

    // ==================== SETTERS ====================

    function setNom(string $nom)                          { $this->nom = $nom; }
    function setUnite(string $unite)                      { $this->unite = $unite; }
    function setCaloriesParUnite(int $calories_par_unite) { $this->calories_par_unite = $calories_par_unite; }
    function setIsLocal(int $is_local)                    { $this->is_local = $is_local; }
}
?>
