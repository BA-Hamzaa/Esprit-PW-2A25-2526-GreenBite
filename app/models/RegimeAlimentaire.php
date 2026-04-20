<?php
class RegimeAlimentaire {
    private $id                = null;
    private $nom               = null;
    private $objectif          = null;
    private $description       = null;
    private $duree_semaines    = null;
    private $calories_jour     = null;
    private $restrictions      = null;
    private $soumis_par        = null;
    private $statut            = null;
    private $commentaire_admin = null;
    private $created_at        = null;

    function __construct($nom, $objectif, $duree_semaines, $calories_jour, $soumis_par,
                         $statut = 'en_attente', $description = '', $restrictions = '') {
        $this->nom            = $nom;
        $this->objectif       = $objectif;
        $this->duree_semaines = $duree_semaines;
        $this->calories_jour  = $calories_jour;
        $this->soumis_par     = $soumis_par;
        $this->statut         = $statut;
        $this->description    = $description;
        $this->restrictions   = $restrictions;
    }

    // ==================== GETTERS ====================

    function getId()               { return $this->id; }
    function getNom()              { return $this->nom; }
    function getObjectif()         { return $this->objectif; }
    function getDescription()      { return $this->description; }
    function getDureeSemaines()    { return $this->duree_semaines; }
    function getCaloriesJour()     { return $this->calories_jour; }
    function getRestrictions()     { return $this->restrictions; }
    function getSoumisPar()        { return $this->soumis_par; }
    function getStatut()           { return $this->statut; }
    function getCommentaireAdmin() { return $this->commentaire_admin; }
    function getCreatedAt()        { return $this->created_at; }

    // ==================== SETTERS ====================

    function setNom(string $nom)                     { $this->nom = $nom; }
    function setObjectif(string $objectif)           { $this->objectif = $objectif; }
    function setDescription(string $description)     { $this->description = $description; }
    function setDureeSemaines(int $duree_semaines)   { $this->duree_semaines = $duree_semaines; }
    function setCaloriesJour(int $calories_jour)     { $this->calories_jour = $calories_jour; }
    function setRestrictions(string $restrictions)   { $this->restrictions = $restrictions; }
    function setSoumisPar(string $soumis_par)        { $this->soumis_par = $soumis_par; }
    function setStatut(string $statut)               { $this->statut = $statut; }
    function setCommentaireAdmin($commentaire_admin) { $this->commentaire_admin = $commentaire_admin; }
}
?>
