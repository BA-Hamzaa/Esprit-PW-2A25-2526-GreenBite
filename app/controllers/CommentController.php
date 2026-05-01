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

    function ignorerSignalement($id)
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

    function bannirUtilisateur($pseudo, $pin)
    {
        $fichier = BASE_PATH . '/config/bannis.json';
        
        if (!file_exists($fichier)) {
            file_put_contents($fichier, '[]');
        }
        
        $bannis = json_decode(file_get_contents($fichier), true);
        if (!is_array($bannis)) $bannis = [];

        // Normaliser les anciens bannis (simples chaînes) en objets
        foreach ($bannis as $key => $entry) {
            if (is_string($entry)) {
                $bannis[$key] = ['pseudo' => $entry, 'pin' => null];
            }
        }

        // Vérifier si ce couple existe déjà
        foreach ($bannis as $entry) {
            if ($entry['pseudo'] === $pseudo && $entry['pin'] === $pin) {
                return false; // déjà banni
            }
        }

        $bannis[] = ['pseudo' => $pseudo, 'pin' => $pin];
        file_put_contents($fichier, json_encode($bannis, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return true;
    }

    function supprimerEtBannirBack()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id > 0) {
            $commentaire = $this->getCommentaire($id);
            if ($commentaire && !empty($commentaire['pseudo'])) {
                $pin = $commentaire['pin'] ?? null;
                $this->bannirUtilisateur($commentaire['pseudo'], $pin);
                $this->deleteCommentaire($id);
                $_SESSION['success'] = "Commentaire supprimé et <strong>" . htmlspecialchars($commentaire['pseudo']) . "</strong> est banni.";
            }
        }
        header('Location: ' . BASE_URL . '/?page=admin-comment&action=list');
        exit;
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

    function deleteBack()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id > 0) {
            $this->deleteCommentaire($id);
            $_SESSION['success'] = "Commentaire supprimé.";
        }
        header('Location: ' . BASE_URL . '/?page=admin-comment&action=list');
        exit;
    }

    function ignorerBack()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id > 0) {
            $this->ignorerSignalement($id);
            $_SESSION['success'] = "Signalement ignoré. Commentaire remis en valide.";
        }
        header('Location: ' . BASE_URL . '/?page=admin-comment&action=list');
        exit;
    }

}
?>