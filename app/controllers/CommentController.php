<?php
require_once BASE_PATH . '/config/database.php';

class CommentController
{
    //==========================================================================
    // QUERIES
    //==========================================================================

    function listCommentairesBack()
    {
        $sql = "SELECT c.*, a.titre AS article_titre
                FROM commentaire c
                JOIN article a ON a.id = c.article_id
                ORDER BY c.date_commentaire DESC";
        $db = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function getCommentaire($id)
    {
        $sql = "SELECT * FROM commentaire WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $q = $db->prepare($sql);
            $q->bindValue(':id', $id, PDO::PARAM_INT);
            $q->execute();
            return $q->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function validerCommentaireBack($id)
    {
        $sql = "UPDATE commentaire SET statut = 'valide' WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $q = $db->prepare($sql);
            $q->bindValue(':id', $id, PDO::PARAM_INT);
            $q->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function deleteCommentaire($id)
    {
        $sql = "DELETE FROM commentaire WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $q = $db->prepare($sql);
            $q->bindValue(':id', $id, PDO::PARAM_INT);
            $q->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    //==========================================================================
    // ROUTING — BACKOFFICE
    //==========================================================================

    function listBack()
    {
        $commentaires = $this->listCommentairesBack();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/comment/list.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function validateBack()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $c = $this->getCommentaire($id);
        if (!$c) {
            $_SESSION['error'] = "Commentaire introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-comment&action=list');
            exit;
        }
        $this->validerCommentaireBack($id);
        $_SESSION['success'] = "Commentaire validé.";
        header('Location: ' . BASE_URL . '/?page=admin-comment&action=list');
        exit;
    }

    function deleteBack()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $this->deleteCommentaire($id);
        $_SESSION['success'] = "Commentaire supprimé.";
        header('Location: ' . BASE_URL . '/?page=admin-comment&action=list');
        exit;
    }
}
?>

