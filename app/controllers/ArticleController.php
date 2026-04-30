<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/app/models/Article.php';
require_once BASE_PATH . '/app/models/Commentaire.php';

class ArticleController
{
    //==========================================================================
    // QUERIES — ARTICLES
    //==========================================================================

    function listArticlesPublies()
    {
        $sql = "SELECT * FROM article WHERE statut = 'publie' ORDER BY date_publication DESC";
        $db = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function listArticlesEnAttente()
    {
        $sql = "SELECT * FROM article WHERE statut = 'en_attente' ORDER BY date_publication DESC";
        $db = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function listArticlesBack()
    {
        $sql = "SELECT a.*,
                       (SELECT COUNT(*) FROM commentaire c WHERE c.article_id = a.id) AS nb_commentaires
                FROM article a
                ORDER BY a.date_publication DESC";
        $db = Database::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // RECHERCHE — articles publiés dont le titre, contenu ou auteur contient le mot-clé
    function rechercherArticles($keyword)
    {
        $sql = "SELECT * FROM article
                WHERE statut = 'publie'
                AND (titre LIKE :kw OR contenu LIKE :kw OR auteur LIKE :kw)
                ORDER BY date_publication DESC";
        $db = Database::getConnexion();
        try {
            $q = $db->prepare($sql);
            $q->execute(['kw' => '%' . $keyword . '%']);
            return $q->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function getArticle($id)
    {
        $sql = "SELECT * FROM article WHERE id = :id";
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

    function addArticle(Article $article)
    {
        // UPDATED: now includes role_utilisateur
        $sql = "INSERT INTO article (titre, contenu, auteur, role_utilisateur, statut)
                VALUES (:titre, :contenu, :auteur, :role_utilisateur, :statut)";
        $db = Database::getConnexion();
        try {
            $q = $db->prepare($sql);
            $q->execute([
                'titre'            => $article->getTitre(),
                'contenu'          => $article->getContenu(),
                'auteur'           => $article->getAuteur(),
                'role_utilisateur' => $article->getRoleUtilisateur(),
                'statut'           => $article->getStatut(),
            ]);
            return $db->lastInsertId();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function updateArticle(Article $article, $id)
    {
        // UPDATED: now includes role_utilisateur
        $sql = "UPDATE article SET
                    titre            = :titre,
                    contenu          = :contenu,
                    auteur           = :auteur,
                    role_utilisateur = :role_utilisateur,
                    statut           = :statut
                WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $q = $db->prepare($sql);
            $q->execute([
                'titre'            => $article->getTitre(),
                'contenu'          => $article->getContenu(),
                'auteur'           => $article->getAuteur(),
                'role_utilisateur' => $article->getRoleUtilisateur(),
                'statut'           => $article->getStatut(),
                'id'               => $id,
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function deleteArticle($id)
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $q = $db->prepare($sql);
            $q->bindValue(':id', $id, PDO::PARAM_INT);
            $q->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function publishArticle($id)
    {
        $sql = "UPDATE article SET statut = 'publie' WHERE id = :id";
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
    // QUERIES — COMMENTAIRES
    //==========================================================================

    function listCommentairesValides($article_id)
    {
        $sql = "SELECT c.*, a.titre AS article_titre
                FROM commentaire c
                JOIN article a ON a.id = c.article_id
                WHERE c.article_id = :article_id AND c.statut = 'valide'
                ORDER BY c.date_commentaire DESC";
        $db = Database::getConnexion();
        try {
            $q = $db->prepare($sql);
            $q->bindValue(':article_id', $article_id, PDO::PARAM_INT);
            $q->execute();
            return $q->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function addCommentaire(Commentaire $commentaire)
    {
        $sql = "INSERT INTO commentaire (article_id, pseudo, contenu, statut)
                VALUES (:article_id, :pseudo, :contenu, :statut)";
        $db = Database::getConnexion();
        try {
            $q = $db->prepare($sql);
            $q->execute([
                'article_id' => $commentaire->getArticleId(),
                'pseudo'     => $commentaire->getAuteur(),
                'contenu'    => $commentaire->getContenu(),
                'statut'     => $commentaire->getStatut(),
            ]);
            return $db->lastInsertId();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    //==========================================================================
    // VALIDATION (PHP)
    //==========================================================================

    function validerArticle($post)
    {
        $errors = [];

        $titre            = trim($post['titre'] ?? '');
        $contenu          = trim($post['contenu'] ?? '');
        $auteur           = trim($post['auteur'] ?? '');
        $role_utilisateur = trim($post['role_utilisateur'] ?? ''); // NEW
        $statut           = $post['statut'] ?? 'brouillon';

        if ($titre === '' || mb_strlen($titre) < 3) {
            $errors[] = "Le titre est obligatoire (min 3 caractères).";
        }
        if (mb_strlen($titre) > 150) {
            $errors[] = "Le titre ne peut pas dépasser 150 caractères.";
        }
        if ($contenu === '' || mb_strlen($contenu) < 20) {
            $errors[] = "Le contenu est obligatoire (min 20 caractères).";
        }
        if ($auteur === '' || mb_strlen($auteur) < 2) {
            $errors[] = "L'auteur est obligatoire (min 2 caractères).";
        }
        // NEW: validate role
        if ($role_utilisateur === '') {
            $errors[] = "Veuillez sélectionner votre profil (qui êtes-vous ?).";
        }
        $statutsValides = ['brouillon', 'en_attente', 'publie'];
        if (!in_array($statut, $statutsValides)) {
            $errors[] = "Statut d'article invalide.";
        }

        return $errors;
    }

    function validerCommentaire($post)
    {
        $errors = [];
        $auteur  = trim($post['auteur'] ?? '');
        $contenu = trim($post['contenu'] ?? '');

        if ($auteur === '' || mb_strlen($auteur) < 2) {
            $errors[] = "Votre nom est obligatoire (min 2 caractères).";
        }
        if ($contenu === '' || mb_strlen($contenu) < 5) {
            $errors[] = "Le commentaire est obligatoire (min 5 caractères).";
        }
        if (mb_strlen($contenu) > 2000) {
            $errors[] = "Le commentaire ne peut pas dépasser 2000 caractères.";
        }
        return $errors;
    }

    //==========================================================================
    // ROUTING — FRONTOFFICE
    //==========================================================================

    function listFront()
    {
        $keyword  = trim($_GET['q'] ?? '');
        $articles = $keyword !== ''
            ? $this->rechercherArticles($keyword)
            : $this->listArticlesPublies();

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/article/list.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    function addFront()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['statut'] = 'en_attente';
            $errors = $this->validerArticle($_POST);
            if (empty($errors)) {
                // UPDATED: now passes role_utilisateur to Article constructor
                $a = new Article(
                    trim($_POST['titre']),
                    trim($_POST['contenu']),
                    trim($_POST['auteur']),
                    trim($_POST['role_utilisateur'] ?? 'Passionné de cuisine'), // NEW
                    'en_attente'
                );
                $this->addArticle($a);
                $_SESSION['success'] = "Article soumis. Il sera publié après validation par un admin.";
                header('Location: ' . BASE_URL . '/?page=article&action=list');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/article/add.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    function detailFront()
    {
        $id      = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $article = $this->getArticle($id);
        if (!$article || $article['statut'] !== 'publie') {
            $_SESSION['error'] = "Article introuvable.";
            header('Location: ' . BASE_URL . '/?page=article&action=list');
            exit;
        }
        $commentaires = $this->listCommentairesValides($id);
        $errors       = [];
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/article/detail.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    function addCommentFront()
    {
        $article_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $article    = $this->getArticle($article_id);
        if (!$article || $article['statut'] !== 'publie') {
            $_SESSION['error'] = "Article introuvable.";
            header('Location: ' . BASE_URL . '/?page=article&action=list');
            exit;
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validerCommentaire($_POST);
            if (empty($errors)) {
                $c = new Commentaire(
                    $article_id,
                    trim($_POST['auteur']),
                    trim($_POST['contenu']),
                    'en_attente'
                );
                $this->addCommentaire($c);
                $_SESSION['success'] = "Commentaire envoyé. Il sera visible après validation.";
                header('Location: ' . BASE_URL . '/?page=article&action=detail&id=' . $article_id);
                exit;
            }
        }

        $commentaires = $this->listCommentairesValides($article_id);
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/article/detail.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    //==========================================================================
    // ROUTING — BACKOFFICE
    //==========================================================================

    function listBack()
    {
        $articles = $this->listArticlesBack();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/article/list.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function pendingBack()
    {
        $articles = $this->listArticlesEnAttente();
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/article/pending.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function addBack()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validerArticle($_POST);
            if (empty($errors)) {
                // UPDATED: now passes role_utilisateur to Article constructor
                $a = new Article(
                    trim($_POST['titre']),
                    trim($_POST['contenu']),
                    trim($_POST['auteur']),
                    trim($_POST['role_utilisateur'] ?? 'Passionné de cuisine'), // NEW
                    $_POST['statut'] ?? 'brouillon'
                );
                $this->addArticle($a);
                $_SESSION['success'] = "Article ajouté.";
                header('Location: ' . BASE_URL . '/?page=admin-article&action=list');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/article/add.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function editBack()
    {
        $id      = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $article = $this->getArticle($id);
        if (!$article) {
            $_SESSION['error'] = "Article introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-article&action=list');
            exit;
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validerArticle($_POST);
            if (empty($errors)) {
                // UPDATED: now passes role_utilisateur to Article constructor
                $a = new Article(
                    trim($_POST['titre']),
                    trim($_POST['contenu']),
                    trim($_POST['auteur']),
                    trim($_POST['role_utilisateur'] ?? $article['role_utilisateur'] ?? 'Passionné de cuisine'), // NEW
                    $_POST['statut'] ?? 'brouillon'
                );
                $this->updateArticle($a, $id);
                $_SESSION['success'] = "Article modifié.";
                header('Location: ' . BASE_URL . '/?page=admin-article&action=list');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/back_header.php';
        require_once BASE_PATH . '/app/views/back/article/edit.php';
        require_once BASE_PATH . '/app/views/layouts/back_footer.php';
    }

    function deleteBack()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $this->deleteArticle($id);
        $_SESSION['success'] = "Article supprimé.";
        header('Location: ' . BASE_URL . '/?page=admin-article&action=list');
        exit;
    }

    function publishBack()
    {
        $id      = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $article = $this->getArticle($id);
        if (!$article) {
            $_SESSION['error'] = "Article introuvable.";
            header('Location: ' . BASE_URL . '/?page=admin-article&action=list');
            exit;
        }
        $this->publishArticle($id);
        $_SESSION['success'] = "Article publié avec succès.";
        header('Location: ' . BASE_URL . '/?page=admin-article&action=list');
        exit;
    }
}
?>