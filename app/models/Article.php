<?php
class Article
{
    private $id = null;
    private $titre = null;
    private $contenu = null;
    private $auteur = null;
    private $role_utilisateur = null; // NEW: Passionné de cuisine, Chef, Nutritionniste, etc.
    private $statut = null; // brouillon | en_attente | publie
    private $date_publication = null;

    function __construct($titre, $contenu, $auteur = 'Admin', $role_utilisateur = 'Passionné de cuisine', $statut = 'brouillon')
    {
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->auteur = $auteur;
        $this->role_utilisateur = $role_utilisateur;
        $this->statut = $statut;
    }

    // ==================== GETTERS ====================
    function getId()               { return $this->id; }
    function getTitre()            { return $this->titre; }
    function getContenu()          { return $this->contenu; }
    function getAuteur()           { return $this->auteur; }
    function getRoleUtilisateur()  { return $this->role_utilisateur; } // NEW
    function getStatut()           { return $this->statut; }
    function getDatePublication()  { return $this->date_publication; }

    // ==================== SETTERS ====================
    function setTitre(string $titre)                       { $this->titre = $titre; }
    function setContenu(string $contenu)                   { $this->contenu = $contenu; }
    function setAuteur(string $auteur)                     { $this->auteur = $auteur; }
    function setRoleUtilisateur(string $role_utilisateur)  { $this->role_utilisateur = $role_utilisateur; } // NEW
    function setStatut(string $statut)                     { $this->statut = $statut; }
}
?>