<?php
class Repas {
    private $id             = null;
    private $nom            = null;
    private $date_repas     = null;
    private $type_repas     = null;
    private $calories_total = null;
    private $statut         = 'en_attente';
    private $admin_comment  = null;
    private $soumis_par     = null;

    function __construct($nom, $date_repas, $type_repas, $calories_total = 0, $statut = 'en_attente', $admin_comment = null, $soumis_par = null) {
        $this->nom            = $nom;
        $this->date_repas     = $date_repas;
        $this->type_repas     = $type_repas;
        $this->calories_total = $calories_total;
        $this->statut         = $statut;
        $this->admin_comment  = $admin_comment;
        $this->soumis_par     = $soumis_par;
    }

    // ==================== GETTERS ====================

    function getId()            { return $this->id; }
    function getNom()           { return $this->nom; }
    function getDateRepas()     { return $this->date_repas; }
    function getTypeRepas()     { return $this->type_repas; }
    function getCaloriesTotal() { return $this->calories_total; }
    function getStatut()        { return $this->statut; }
    function getAdminComment()  { return $this->admin_comment; }
    function getSoumisPar()     { return $this->soumis_par; }

    // ==================== SETTERS ====================

    function setId($id)                            { $this->id = $id; }
    function setNom(string $nom)                   { $this->nom = $nom; }
    function setDateRepas(string $date_repas)      { $this->date_repas = $date_repas; }
    function setTypeRepas(string $type_repas)      { $this->type_repas = $type_repas; }
    function setCaloriesTotal(int $calories_total) { $this->calories_total = $calories_total; }
    function setStatut(string $statut)             { $this->statut = $statut; }
    function setAdminComment(?string $c)           { $this->admin_comment = $c; }
    function setSoumisPar(?string $s)              { $this->soumis_par = $s; }
}
?>
