<?php
class Article
{
    private $id = null;
    private $titre = null;
    private $contenu = null;
    private $auteur = null;
    private $pin = null;
    private $role_utilisateur = null;
    private $statut = null;
    private $date_publication = null;

    function __construct($titre, $contenu, $auteur = 'Admin', $pin = null, $role_utilisateur = 'Passionné de cuisine', $statut = 'brouillon')
    {
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->auteur = $auteur;
        $this->pin = $pin;
        $this->role_utilisateur = $role_utilisateur;
        $this->statut = $statut;
    }

    // ==================== GETTERS ====================
    function getId()               { return $this->id; }
    function getTitre()            { return $this->titre; }
    function getContenu()          { return $this->contenu; }
    function getAuteur()           { return $this->auteur; }
    function getPin()              { return $this->pin; }
    function getRoleUtilisateur()  { return $this->role_utilisateur; }
    function getStatut()           { return $this->statut; }
    function getDatePublication()  { return $this->date_publication; }

    // ==================== SETTERS ====================
    function setTitre(string $titre)                       { $this->titre = $titre; }
    function setContenu(string $contenu)                   { $this->contenu = $contenu; }
    function setAuteur(string $auteur)                     { $this->auteur = $auteur; }
    function setPin($pin)                                  { $this->pin = $pin; }
    function setRoleUtilisateur(string $role_utilisateur)  { $this->role_utilisateur = $role_utilisateur; }
    function setStatut(string $statut)                     { $this->statut = $statut; }
}
?>