<?php
class Article
{
    private $id = null;
    private $titre = null;
    private $contenu = null;
    private $auteur = null;
    private $statut = null; // brouillon | en_attente | publie
    private $created_at = null;
    private $updated_at = null;

    function __construct($titre, $contenu, $auteur = 'Admin', $statut = 'brouillon')
    {
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->auteur = $auteur;
        $this->statut = $statut;
    }

    // ==================== GETTERS ====================
    function getId()        { return $this->id; }
    function getTitre()     { return $this->titre; }
    function getContenu()   { return $this->contenu; }
    function getAuteur()    { return $this->auteur; }
    function getStatut()    { return $this->statut; }
    function getCreatedAt() { return $this->created_at; }
    function getUpdatedAt() { return $this->updated_at; }

    // ==================== SETTERS ====================
    function setTitre(string $titre)       { $this->titre = $titre; }
    function setContenu(string $contenu)   { $this->contenu = $contenu; }
    function setAuteur(string $auteur)     { $this->auteur = $auteur; }
    function setStatut(string $statut)     { $this->statut = $statut; }
}
?>

