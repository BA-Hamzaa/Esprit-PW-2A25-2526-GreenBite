<?php
class Materiel {
    private $id          = null;
    private $nom         = null;
    private $description = null;
    private $propose_par = null;
    private $statut      = 'en_attente';
    private $created_at  = null;

    function __construct($nom, $description = '', $propose_par = null, $statut = 'en_attente') {
        $this->nom         = $nom;
        $this->description = $description;
        $this->propose_par = $propose_par;
        $this->statut      = $statut;
    }

    // ==================== GETTERS ====================
    function getId()          { return $this->id; }
    function getNom()         { return $this->nom; }
    function getDescription() { return $this->description; }
    function getProposePar()  { return $this->propose_par; }
    function getStatut()      { return $this->statut; }
    function getCreatedAt()   { return $this->created_at; }

    // ==================== SETTERS ====================
    function setNom(string $nom)              { $this->nom         = $nom; }
    function setDescription(string $desc)     { $this->description = $desc; }
    function setProposePar($propose_par)      { $this->propose_par = $propose_par; }
    function setStatut(string $statut)        { $this->statut      = $statut; }
}
?>
