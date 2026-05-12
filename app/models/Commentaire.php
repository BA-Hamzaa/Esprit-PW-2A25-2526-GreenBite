<?php
class Commentaire
{
    private $id = null;
    private $article_id = null;
    private $auteur = null;
    private $contenu = null;
    private $statut = null; // en_attente | valide | signale
    private $created_at = null;

    function __construct($article_id, $auteur, $contenu, $statut = 'valide')
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

    // ==================== STATIC QUERIES ====================

    static function getById($id)
    {
        $sql = "SELECT * FROM commentaire WHERE id = :id";
        $db = Database::getConnexion();
        $q = $db->prepare($sql);
        $q->bindValue(':id', $id, PDO::PARAM_INT);
        $q->execute();
        return $q->fetch();
    }

    static function updateContenu($id, $pseudo, $contenu)
    {
        $sql = "UPDATE commentaire SET contenu = :contenu WHERE id = :id AND pseudo = :pseudo";
        $db = Database::getConnexion();
        $q = $db->prepare($sql);
        return $q->execute([
            'contenu' => $contenu,
            'id'      => $id,
            'pseudo'  => $pseudo,
        ]);
    }

    static function deleteByOwner($id, $pseudo)
    {
        $sql = "DELETE FROM commentaire WHERE id = :id AND pseudo = :pseudo";
        $db = Database::getConnexion();
        $q = $db->prepare($sql);
        return $q->execute(['id' => $id, 'pseudo' => $pseudo]);
    }

    static function report($id)
    {
        $sql = "UPDATE commentaire SET statut = 'signale' WHERE id = :id";
        $db = Database::getConnexion();
        $q = $db->prepare($sql);
        return $q->execute(['id' => $id]);
    }
}
?>