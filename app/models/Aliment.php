<?php
class Aliment {
    private $id        = null;
    private $nom       = null;
    private $calories  = null;
    private $proteines = null;
    private $glucides  = null;
    private $lipides   = null;
    private $unite     = null;

    function __construct($nom, $calories, $proteines = 0.0, $glucides = 0.0, $lipides = 0.0, $unite = 'g') {
        $this->nom       = $nom;
        $this->calories  = $calories;
        $this->proteines = $proteines;
        $this->glucides  = $glucides;
        $this->lipides   = $lipides;
        $this->unite     = $unite;
    }

    // ==================== GETTERS ====================

    function getId()        { return $this->id; }
    function getNom()       { return $this->nom; }
    function getCalories()  { return $this->calories; }
    function getProteines() { return $this->proteines; }
    function getGlucides()  { return $this->glucides; }
    function getLipides()   { return $this->lipides; }
    function getUnite()     { return $this->unite; }

    // ==================== SETTERS ====================

    function setNom(string $nom)        { $this->nom = $nom; }
    function setCalories(int $calories) { $this->calories = $calories; }
    function setProteines(float $prot)  { $this->proteines = $prot; }
    function setGlucides(float $gluc)   { $this->glucides = $gluc; }
    function setLipides(float $lip)     { $this->lipides = $lip; }
    function setUnite(string $unite)    { $this->unite = $unite; }
}
?>
