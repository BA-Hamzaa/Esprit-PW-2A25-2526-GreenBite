<?php
class Recette {
    private $id               = null;
    private $titre            = null;
    private $description      = null;
    private $instructions     = null;
    private $temps_preparation = null;
    private $difficulte       = null;
    private $categorie        = null;
    private $image            = null;
    private $calories_total   = null;
    private $score_carbone    = null;
    private $soumis_par       = null;
    private $statut           = null;
    private $created_at       = null;

    function __construct($titre, $description, $instructions, $temps_preparation, $difficulte,
                         $statut = 'en_attente', $categorie = '', $image = '',
                         $calories_total = 0, $score_carbone = 0.0, $soumis_par = '') {
        $this->titre             = $titre;
        $this->description       = $description;
        $this->instructions      = $instructions;
        $this->temps_preparation = $temps_preparation;
        $this->difficulte        = $difficulte;
        $this->statut            = $statut;
        $this->categorie         = $categorie;
        $this->image             = $image;
        $this->calories_total    = $calories_total;
        $this->score_carbone     = $score_carbone;
        $this->soumis_par        = $soumis_par;
    }

    // ==================== GETTERS ====================

    function getId()               { return $this->id; }
    function getTitre()            { return $this->titre; }
    function getDescription()      { return $this->description; }
    function getInstructions()     { return $this->instructions; }
    function getTempsPreparation() { return $this->temps_preparation; }
    function getDifficulte()       { return $this->difficulte; }
    function getCategorie()        { return $this->categorie; }
    function getImage()            { return $this->image; }
    function getCaloriesTotal()    { return $this->calories_total; }
    function getScoreCarbone()     { return $this->score_carbone; }
    function getSoumisPar()        { return $this->soumis_par; }
    function getStatut()           { return $this->statut; }
    function getCreatedAt()        { return $this->created_at; }

    // ==================== SETTERS ====================

    function setTitre(string $titre)                        { $this->titre = $titre; }
    function setDescription(string $description)            { $this->description = $description; }
    function setInstructions(string $instructions)          { $this->instructions = $instructions; }
    function setTempsPreparation(int $temps_preparation)    { $this->temps_preparation = $temps_preparation; }
    function setDifficulte(string $difficulte)              { $this->difficulte = $difficulte; }
    function setCategorie(string $categorie)                { $this->categorie = $categorie; }
    function setImage(string $image)                        { $this->image = $image; }
    function setCaloriesTotal(int $calories_total)          { $this->calories_total = $calories_total; }
    function setScoreCarbone(float $score_carbone)          { $this->score_carbone = $score_carbone; }
    function setSoumisPar(string $soumis_par)               { $this->soumis_par = $soumis_par; }
    function setStatut(string $statut)                      { $this->statut = $statut; }
}
?>
