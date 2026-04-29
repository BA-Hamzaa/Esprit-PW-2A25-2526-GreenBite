<?php
class CommentaireRecette {
    private $id         = null;
    private $recette_id = null;
    private $auteur     = null;
    private $email      = null;
    private $note       = null;
    private $commentaire = null;
    private $statut     = null;
    private $created_at = null;

    function __construct($recette_id, $auteur, $note, $commentaire,
                         $email = null, $statut = 'en_attente') {
        $this->recette_id  = $recette_id;
        $this->auteur      = $auteur;
        $this->email       = $email;
        $this->note        = $note;
        $this->commentaire = $commentaire;
        $this->statut      = $statut;
    }

    // ==================== GETTERS ====================

    function getId()          { return $this->id; }
    function getRecetteId()   { return $this->recette_id; }
    function getAuteur()      { return $this->auteur; }
    function getEmail()       { return $this->email; }
    function getNote()        { return $this->note; }
    function getCommentaire() { return $this->commentaire; }
    function getStatut()      { return $this->statut; }
    function getCreatedAt()   { return $this->created_at; }

    // ==================== SETTERS ====================

    function setRecetteId(int $recette_id)       { $this->recette_id  = $recette_id; }
    function setAuteur(string $auteur)           { $this->auteur      = $auteur; }
    function setEmail(?string $email)            { $this->email       = $email; }
    function setNote(int $note)                  { $this->note        = $note; }
    function setCommentaire(string $commentaire) { $this->commentaire = $commentaire; }
    function setStatut(string $statut)           { $this->statut      = $statut; }
}
?>
