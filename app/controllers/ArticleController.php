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
                WHERE c.article_id = :article_id AND c.statut IN ('valide', 'signale')
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

    function addCommentaire(Commentaire $commentaire, $pin = null)
    {
        $sql = "INSERT INTO commentaire (article_id, pseudo, pin, contenu, statut)
                VALUES (:article_id, :pseudo, :pin, :contenu, :statut)";
        $db = Database::getConnexion();
        try {
            $q = $db->prepare($sql);
            $q->execute([
                'article_id' => $commentaire->getArticleId(),
                'pseudo'     => $commentaire->getAuteur(),
                'pin'        => $pin,
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
        $role_utilisateur = trim($post['role_utilisateur'] ?? '');
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
        if ($role_utilisateur === '') {
            $errors[] = "Veuillez sélectionner votre profil.";
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
        // Vider la session "Mes activités" quand on arrive sur le blog
        unset($_SESSION['mes_activites_auteur'], $_SESSION['mes_activites_pin']);

        $keyword  = trim($_GET['q'] ?? '');
        $articles = $keyword !== ''
            ? $this->rechercherArticles($keyword)
            : $this->listArticlesPublies();

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/article/list.php';
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
            $pseudo = trim($_POST['auteur'] ?? '');
            $pin    = trim($_POST['pin'] ?? '');

            if (!preg_match('/^\d{4}$/', $pin)) {
                $errors[] = "Le PIN doit contenir exactement 4 chiffres.";
            }

            // Check ban list
            if (empty($errors)) {
                $fichierBannis = BASE_PATH . '/config/bannis.json';
                $bannis = [];
                if (file_exists($fichierBannis)) {
                    $bannis = json_decode(file_get_contents($fichierBannis), true);
                    if (!is_array($bannis)) $bannis = [];
                }

                foreach ($bannis as $entry) {
                    $bpseudo = is_string($entry) ? $entry : ($entry['pseudo'] ?? '');
                    $bpin    = is_string($entry) ? null   : ($entry['pin'] ?? null);
                    if ($bpseudo === $pseudo && $bpin === $pin) {
                        $errors[] = "⛔ Vous êtes banni et ne pouvez plus commenter.";
                        break;
                    }
                }
            }

            // Check PIN consistency
            if (empty($errors)) {
                $db = Database::getConnexion();

                $q = $db->prepare("SELECT pin FROM commentaire WHERE pseudo = :pseudo AND pin IS NOT NULL LIMIT 1");
                $q->execute(['pseudo' => $pseudo]);
                $existingComment = $q->fetch();

                if (!$existingComment) {
                    $q = $db->prepare("SELECT pin FROM article WHERE auteur = :auteur LIMIT 1");
                    $q->execute(['auteur' => $pseudo]);
                    $existingComment = $q->fetch();
                }

                if ($existingComment && $existingComment['pin'] !== $pin) {
                    $errors[] = "PIN incorrect pour ce nom. Si vous avez oublié votre PIN, utilisez un autre nom.";
                }
            }

            if (empty($errors)) {
                $c = new Commentaire(
                    $article_id,
                    $pseudo,
                    trim($_POST['contenu']),
                    'valide'
                );
                $this->addCommentaire($c, $pin);
                $_SESSION['success'] = "Commentaire publié ! ✅ Votre PIN est <strong>" . htmlspecialchars($pin) . "</strong> — gardez-le pour retrouver vos commentaires.";
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
    // COMMENT ACTIONS (Edit / Delete / Report) — AJAX
    //==========================================================================

    function editCommentFront()
    {
        header('Content-Type: application/json');

        $id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $user    = trim($_POST['user'] ?? '');
        $contenu = trim($_POST['contenu'] ?? '');

        if ($id === 0 || $user === '') {
            echo json_encode(['success' => false, 'error' => 'Données manquantes.']);
            exit;
        }
        if (mb_strlen($contenu) < 5) {
            echo json_encode(['success' => false, 'error' => 'Le commentaire doit contenir au moins 5 caractères.']);
            exit;
        }

        $comment = Commentaire::getById($id);
        if (!$comment || ($comment['pseudo'] ?? '') !== $user) {
            echo json_encode(['success' => false, 'error' => 'Action non autorisée.']);
            exit;
        }

        Commentaire::updateContenu($id, $user, $contenu);
        echo json_encode(['success' => true]);
        exit;
    }

    function deleteCommentFront()
    {
        header('Content-Type: application/json');

        $id   = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $user = trim($_POST['user'] ?? '');

        if ($id === 0 || $user === '') {
            echo json_encode(['success' => false, 'error' => 'Données manquantes.']);
            exit;
        }

        $comment = Commentaire::getById($id);
        if (!$comment || ($comment['pseudo'] ?? '') !== $user) {
            echo json_encode(['success' => false, 'error' => 'Action non autorisée.']);
            exit;
        }

        Commentaire::deleteByOwner($id, $user);
        echo json_encode(['success' => true]);
        exit;
    }

    function reportCommentFront()
    {
        header('Content-Type: application/json');

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id === 0) {
            echo json_encode(['success' => false, 'error' => 'ID manquant.']);
            exit;
        }

        Commentaire::report($id);
        echo json_encode(['success' => true]);
        exit;
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
                // Sanitize role: if the submitted role is actually a status, reset to default
                $role = trim($_POST['role_utilisateur'] ?? '');
                if (empty($role) || in_array($role, ['brouillon', 'en_attente', 'publie'])) {
                    $role = 'Passionné de cuisine';
                }

                $a = new Article(
                    trim($_POST['titre']),
                    trim($_POST['contenu']),
                    trim($_POST['auteur']),
                    $role,
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
                // Sanitize role
                $role = trim($_POST['role_utilisateur'] ?? $article['role_utilisateur'] ?? '');
                if (empty($role) || in_array($role, ['brouillon', 'en_attente', 'publie'])) {
                    $role = $article['role_utilisateur'] ?? 'Passionné de cuisine';
                }

                $a = new Article(
                    trim($_POST['titre']),
                    trim($_POST['contenu']),
                    trim($_POST['auteur']),
                    $role,
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

    //==========================================================================
    // PIN — SAVE + VERIFY
    //==========================================================================

    function addArticleWithPin(Article $article, $pin)
    {
        $sql = "INSERT INTO article (titre, contenu, auteur, pin, role_utilisateur, statut)
                VALUES (:titre, :contenu, :auteur, :pin, :role_utilisateur, :statut)";
        $db = Database::getConnexion();
        try {
            $q = $db->prepare($sql);
            $q->execute([
                'titre'            => $article->getTitre(),
                'contenu'          => $article->getContenu(),
                'auteur'           => $article->getAuteur(),
                'pin'              => $pin,
                'role_utilisateur' => $article->getRoleUtilisateur(),
                'statut'           => $article->getStatut(),
            ]);
            return $db->lastInsertId();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function verifyPin($article_id, $pin)
    {
        $sql = "SELECT id FROM article WHERE id = :id AND pin = :pin";
        $db  = Database::getConnexion();
        try {
            $q = $db->prepare($sql);
            $q->execute(['id' => $article_id, 'pin' => $pin]);
            return $q->fetch() !== false;
        } catch (Exception $e) {
            return false;
        }
    }

    function getMesArticles($auteur, $pin)
    {
        $db = Database::getConnexion();

        // Check PIN validity via article or commentaire
        $valid = false;
        $q = $db->prepare("SELECT id FROM article WHERE auteur = :auteur AND pin = :pin LIMIT 1");
        $q->execute(['auteur' => $auteur, 'pin' => $pin]);
        if ($q->fetch()) $valid = true;
        if (!$valid) {
            $q = $db->prepare("SELECT id FROM commentaire WHERE pseudo = :pseudo AND pin = :pin LIMIT 1");
            $q->execute(['pseudo' => $auteur, 'pin' => $pin]);
            if ($q->fetch()) $valid = true;
        }
        if (!$valid) return [];

        $sql = "SELECT * FROM article
                WHERE auteur = :auteur
                ORDER BY date_publication DESC";
        $q = $db->prepare($sql);
        $q->execute(['auteur' => $auteur]);
        return $q->fetchAll();
    }

    function updateArticleUser(Article $article, $id)
    {
        $sql = "UPDATE article SET
                    titre            = :titre,
                    contenu          = :contenu,
                    auteur           = :auteur,
                    role_utilisateur = :role_utilisateur,
                    statut           = 'en_attente'
                WHERE id = :id";
        $db = Database::getConnexion();
        try {
            $q = $db->prepare($sql);
            $q->execute([
                'titre'            => $article->getTitre(),
                'contenu'          => $article->getContenu(),
                'auteur'           => $article->getAuteur(),
                'role_utilisateur' => $article->getRoleUtilisateur(),
                'id'               => $id,
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    //==========================================================================
    // ROUTING — MES ACTIVITÉS (front user space)
    //==========================================================================

    function mesActivitesFront()
    {
        $errors      = [];
        $mesArticles  = [];
        $mesCommentaires = [];
        $auteurSaisi = '';
        $pinSaisi    = '';

        // 1. If user already in session, load automatically
        if (!empty($_SESSION['mes_activites_auteur']) && !empty($_SESSION['mes_activites_pin'])) {
            $auteurSaisi = $_SESSION['mes_activites_auteur'];
            $pinSaisi    = $_SESSION['mes_activites_pin'];
            $mesArticles = $this->getMesArticles($auteurSaisi, $pinSaisi);
            $mesCommentaires = $this->getMesCommentaires($auteurSaisi, $pinSaisi);
        }

        // 2. Process login form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auteurSaisi = trim($_POST['auteur'] ?? '');
            $pinSaisi    = trim($_POST['pin'] ?? '');

            if (mb_strlen($auteurSaisi) < 2) {
                $errors[] = "Veuillez entrer votre nom (min 2 caractères).";
            }
            if (!preg_match('/^\d{4}$/', $pinSaisi)) {
                $errors[] = "Le PIN doit contenir exactement 4 chiffres.";
            }
            if (empty($errors)) {
                $mesArticles = $this->getMesArticles($auteurSaisi, $pinSaisi);
                $mesCommentaires = $this->getMesCommentaires($auteurSaisi, $pinSaisi);
                if (empty($mesArticles) && empty($mesCommentaires)) {
                    $errors[] = "Aucune activité trouvée. Vérifiez votre nom et votre PIN.";
                } else {
                    // Store in session for seamless navigation
                    $_SESSION['mes_activites_auteur'] = $auteurSaisi;
                    $_SESSION['mes_activites_pin']    = $pinSaisi;
                }
            }
        }

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/article/mes_activites.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    function getMesCommentaires($auteur, $pin)
    {
        $db = Database::getConnexion();

        // Verify PIN from commentaire or article
        $q = $db->prepare("SELECT id FROM commentaire WHERE pseudo = :pseudo AND pin = :pin LIMIT 1");
        $q->execute(['pseudo' => $auteur, 'pin' => $pin]);
        if (!$q->fetch()) {
            $q = $db->prepare("SELECT id FROM article WHERE auteur = :auteur AND pin = :pin LIMIT 1");
            $q->execute(['auteur' => $auteur, 'pin' => $pin]);
            if (!$q->fetch()) return [];
        }

        $sql = "SELECT c.*, a.titre AS article_titre, a.statut AS article_statut
                FROM commentaire c
                JOIN article a ON a.id = c.article_id
                WHERE c.pseudo = :pseudo
                ORDER BY c.date_commentaire DESC";
        $q = $db->prepare($sql);
        $q->execute(['pseudo' => $auteur]);
        return $q->fetchAll();
    }

    function editMesCommentairesFront()
    {
        $id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $pseudo  = trim($_GET['pseudo'] ?? '');
        $pin     = trim($_GET['pin'] ?? '');

        $db = Database::getConnexion();
        // Verify PIN belongs to this user
        $q = $db->prepare("SELECT id FROM article WHERE auteur = :auteur AND pin = :pin LIMIT 1");
        $q->execute(['auteur' => $pseudo, 'pin' => $pin]);
        if (!$q->fetch()) {
            $q = $db->prepare("SELECT id FROM commentaire WHERE pseudo = :pseudo AND pin = :pin LIMIT 1");
            $q->execute(['pseudo' => $pseudo, 'pin' => $pin]);
            if (!$q->fetch()) {
                $_SESSION['error'] = "Action non autorisée.";
                header('Location: ' . BASE_URL . '/?page=article&action=mes-activites');
                exit;
            }
        }

        $comment = Commentaire::getById($id);
        if (!$comment || ($comment['pseudo'] ?? '') !== $pseudo) {
            $_SESSION['error'] = "Action non autorisée.";
            header('Location: ' . BASE_URL . '/?page=article&action=mes-activites');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contenu = trim($_POST['contenu'] ?? '');
            if (mb_strlen($contenu) < 5) {
                $_SESSION['error'] = "Le commentaire doit contenir au moins 5 caractères.";
            } else {
                Commentaire::updateContenu($id, $pseudo, $contenu);
                $_SESSION['success'] = "Commentaire modifié !";
                header('Location: ' . BASE_URL . '/?page=article&action=mes-activites');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/article/edit_mes_commentaires.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    function deleteMesCommentairesFront()
    {
        $id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $pseudo  = trim($_GET['pseudo'] ?? '');
        $pin     = trim($_GET['pin'] ?? '');

        $db = Database::getConnexion();
        $q = $db->prepare("SELECT id FROM article WHERE auteur = :auteur AND pin = :pin LIMIT 1");
        $q->execute(['auteur' => $pseudo, 'pin' => $pin]);
        if (!$q->fetch()) {
            $q = $db->prepare("SELECT id FROM commentaire WHERE pseudo = :pseudo AND pin = :pin LIMIT 1");
            $q->execute(['pseudo' => $pseudo, 'pin' => $pin]);
            if (!$q->fetch()) {
                $_SESSION['error'] = "Action non autorisée.";
                header('Location: ' . BASE_URL . '/?page=article&action=mes-activites');
                exit;
            }
        }

        Commentaire::deleteByOwner($id, $pseudo);
        $_SESSION['success'] = "Commentaire supprimé.";
        header('Location: ' . BASE_URL . '/?page=article&action=mes-activites');
        exit;
    }

    function addFront()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['statut'] = 'en_attente';
            $errors = $this->validerArticleFront($_POST);
            if (empty($errors)) {
                $a = new Article(
                    trim($_POST['titre']),
                    trim($_POST['contenu']),
                    trim($_POST['auteur']),
                    trim($_POST['role_utilisateur'] ?? 'Passionné de cuisine'),
                    'en_attente'
                );
                $pin = trim($_POST['pin']);
                $this->addArticleWithPin($a, $pin);
                $_SESSION['success'] = "Article soumis ! 🎉 Votre PIN est <strong>" . htmlspecialchars($pin) . "</strong> — gardez-le précieusement pour retrouver vos articles.";
                header('Location: ' . BASE_URL . '/?page=article&action=list');
                exit;
            }
        }
        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/article/add.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    function validerArticleFront($post)
    {
        $errors = [];
        $titre   = trim($post['titre'] ?? '');
        $contenu = trim($post['contenu'] ?? '');
        $auteur  = trim($post['auteur'] ?? '');
        $pin     = trim($post['pin'] ?? '');
        $role    = trim($post['role_utilisateur'] ?? '');

        if ($titre === '' || mb_strlen($titre) < 3)    $errors[] = "Titre obligatoire (min 3 caractères).";
        if (mb_strlen($titre) > 150)                   $errors[] = "Titre max 150 caractères.";
        if ($contenu === '' || mb_strlen($contenu) < 20) $errors[] = "Contenu obligatoire (min 20 caractères).";
        if ($auteur === '' || mb_strlen($auteur) < 2)  $errors[] = "Nom obligatoire (min 2 caractères).";
        if (!preg_match('/^\d{4}$/', $pin))            $errors[] = "Le PIN doit contenir exactement 4 chiffres.";
        if ($role === '')                              $errors[] = "Veuillez sélectionner votre profil.";

        return $errors;
    }

    function editMesArticlesFront()
    {
        $id  = isset($_GET['id'])  ? (int)$_GET['id']        : 0;
        $pin = isset($_GET['pin']) ? trim($_GET['pin'])       : '';
        $auteur = isset($_GET['auteur']) ? trim($_GET['auteur']) : '';

        $article = $this->getArticle($id);

        if (!$article || !$this->verifyPin($id, $pin)) {
            $_SESSION['error'] = "Action non autorisée.";
            header('Location: ' . BASE_URL . '/?page=article&action=mes-activites');
            exit;
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Force author to the original article's author (cannot be changed)
            $_POST['auteur'] = $article['auteur'];
            $errors = $this->validerArticleFront($_POST);
            // Remove errors about PIN (already verified) and author (pre-filled)
            $errors = array_filter($errors, function($e) {
                return strpos($e, 'PIN') === false && strpos($e, 'Nom obligatoire') === false;
            });
            $errors = array_values($errors);

            if (empty($errors)) {
                $a = new Article(
                    trim($_POST['titre']),
                    trim($_POST['contenu']),
                    $article['auteur'], // keep original author
                    trim($_POST['role_utilisateur'] ?? $article['role_utilisateur']),
                    'en_attente'
                );
                $this->updateArticleUser($a, $id);
                $_SESSION['success'] = "Article modifié ! Il repassera en validation avant publication.";
                header('Location: ' . BASE_URL . '/?page=article&action=mes-activites');
                exit;
            }
        }

        require_once BASE_PATH . '/app/views/layouts/front_header.php';
        require_once BASE_PATH . '/app/views/front/article/edit_mes_articles.php';
        require_once BASE_PATH . '/app/views/layouts/front_footer.php';
    }

    function deleteMesArticlesFront()
    {
        $id     = isset($_GET['id'])     ? (int)$_GET['id']        : 0;
        $pin    = isset($_GET['pin'])    ? trim($_GET['pin'])       : '';
        $auteur = isset($_GET['auteur']) ? trim($_GET['auteur'])    : '';

        if (!$this->verifyPin($id, $pin)) {
            $_SESSION['error'] = "Action non autorisée.";
            header('Location: ' . BASE_URL . '/?page=article&action=mes-activites');
            exit;
        }

        $this->deleteArticle($id);
        $_SESSION['success'] = "Article supprimé.";
        header('Location: ' . BASE_URL . '/?page=article&action=mes-activites');
        exit;
    }

    // Deprecated: kept for backward compatibility (if any old links exist)
    function mesArticlesFront()
    {
        // Simply redirect to new mes-activites
        header('Location: ' . BASE_URL . '/?page=article&action=mes-activites');
        exit;
    }
}
?>