<?php
class Commentaire
{
    private $id = null;
    private $article_id = null;
    private $auteur = null;
    private $contenu = null;
    private $statut = null; // en_attente | valide
    private $created_at = null;

    function __construct($article_id, $auteur, $contenu, $statut = 'en_attente')
    {
        $this->article_id = $article_id;
        $this->auteur = $auteur;
        $this->contenu = $contenu;
        $this->statut = $statut;
    }

    // ==================== GETTERS ====================
    function getId()        { return $this->id; }
    function getArticleId() { return $this->article_id; }
    function getAuteur()    { return $this->auteur; }
    function getContenu()   { return $this->contenu; }
    function getStatut()    { return $this->statut; }
    function getCreatedAt() { return $this->created_at; }

    // ==================== SETTERS ====================
    function setAuteur(string $auteur)     { $this->auteur = $auteur; }
    function setContenu(string $contenu)   { $this->contenu = $contenu; }
    function setStatut(string $statut)     { $this->statut = $statut; }
}
?>

