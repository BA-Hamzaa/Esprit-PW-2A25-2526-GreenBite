<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/app/models/UserModel.php';

class UserController {

/////..............................Afficher............................../////
    function AfficherUsers() {
        $sql = "SELECT * FROM users";
$db = Database::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

/////..............................Afficher avec pagination............................../////
    function AfficherUsersPaginated($page = 1, $perPage = 10, $sortBy = 'created_at', $sortDir = 'DESC') {
        $offset = ($page - 1) * $perPage;
        
        // Validate sort column to prevent SQL injection
        $allowedColumns = ['username', 'email', 'role', 'is_active', 'created_at'];
        if (!in_array($sortBy, $allowedColumns)) {
            $sortBy = 'created_at';
        }
        
        // Validate sort direction
        $sortDir = strtoupper($sortDir) === 'ASC' ? 'ASC' : 'DESC';
        
        $sql = "SELECT * FROM users ORDER BY $sortBy $sortDir LIMIT :limit OFFSET :offset";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $query->bindValue(':offset', $offset, PDO::PARAM_INT);
            $query->execute();
            return $query;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

/////..............................Compter total utilisateurs............................../////
    function CountUsers() {
        $sql = "SELECT COUNT(*) as total FROM users";
        $db = Database::getConnexion();
        try {
            $result = $db->query($sql);
            return $result->fetch()['total'];
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

/////..............................Supprimer............................../////
    function SupprimerUser($id) {
        // Supprimer aussi l'avatar du serveur avant de supprimer le user
        $user = $this->RecupererUser($id);
        if ($user['avatar']) {
            $avatarPath = dirname(__FILE__).'/../../public/assets/images/avatars/' . $user['avatar'];
            if (file_exists($avatarPath)) {
                unlink($avatarPath);
            }
        }

        $sql = "DELETE FROM users WHERE id = :id";
$db = Database::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);
        try {
            $req->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

/////..............................Ajouter............................../////
    function AjouterUser($user, $avatarFile = null) {
        // Gestion de l'upload de l'avatar
        $avatarName = null;
        if ($avatarFile && $avatarFile['error'] === 0) {
            $avatarName = $this->uploadAvatar($avatarFile);
        }

        $sql = "INSERT INTO users (username, email, password, role, avatar, is_active) 
                VALUES (:username, :email, :password, :role, :avatar, :is_active)";
$db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'username'  => $user->getUsername(),
                'email'     => $user->getEmail(),
                'password'  => password_hash($user->getPassword(), PASSWORD_BCRYPT),
                'role'      => $user->getRole(),
                'avatar'    => $avatarName,
                'is_active' => $user->getIsActive(),
            ]);
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }

/////..............................Affichage par clé primaire............................../////
    function RecupererUser($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
$db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

/////..............................Affichage par Email............................../////
    function RecupererUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
$db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':email', $email);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

/////..............................Modifier............................../////
    function ModifierUser($user, $id, $avatarFile = null) {
        // Gestion de l'upload du nouvel avatar
        $avatarName = $user->getAvatar(); // garder l'ancien par défaut

        if ($avatarFile && $avatarFile['error'] === 0) {
            // Supprimer l'ancien avatar du serveur
            $oldUser = $this->RecupererUser($id);
            if ($oldUser['avatar']) {
                $oldPath = dirname(__FILE__).'/../../public/assets/images/avatars/' . $oldUser['avatar'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            // Uploader le nouveau
            $avatarName = $this->uploadAvatar($avatarFile);
        }

        $sql = "UPDATE users SET 
                    username  = :username,
                    email     = :email,
                    role      = :role,
                    avatar    = :avatar,
                    is_active = :is_active
                WHERE id = :id";
$db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'username'  => $user->getUsername(),
                'email'     => $user->getEmail(),
                'role'      => $user->getRole(),
                'avatar'    => $avatarName,
                'is_active' => $user->getIsActive(),
                'id'        => $id,
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

/////..............................Modifier Password............................../////
    function ModifierPassword($id, $newPassword) {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
$db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'password' => password_hash($newPassword, PASSWORD_BCRYPT),
                'id'       => $id,
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

/////..............................Recherche............................../////
    function RechercheUser($username) {
        $sql = "SELECT * FROM users WHERE username LIKE :username";
$db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':username', $username . '%');
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

/////..............................Tri............................../////
    function TriUsers() {
        $sql = "SELECT * FROM users ORDER BY username ASC";
$db = Database::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

/////..............................Activer / Désactiver............................../////
    function ToggleActive($id, $status) {
        $sql = "UPDATE users SET is_active = :is_active WHERE id = :id";
$db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'is_active' => $status,
                'id'        => $id,
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

/////..............................Upload Avatar (méthode privée)............................../////
    private function uploadAvatar($avatarFile) {
        $uploadDir     = dirname(__FILE__).'/../../public/assets/images/avatars/';
        $allowedTypes  = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $maxSize       = 2 * 1024 * 1024; // 2MB

        // Vérification du type et de la taille
        if (!in_array($avatarFile['type'], $allowedTypes)) {
            die('Erreur: Format image non supporté (jpg, png, webp, gif uniquement)');
        }
        if ($avatarFile['size'] > $maxSize) {
            die('Erreur: Image trop lourde (max 2MB)');
        }

        // Générer un nom unique pour éviter les conflits
        $extension  = pathinfo($avatarFile['name'], PATHINFO_EXTENSION);
        $avatarName = uniqid('avatar_', true) . '.' . $extension;
        $destination = $uploadDir . $avatarName;

        // Créer le dossier s'il n'existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Déplacer le fichier uploadé
        if (!move_uploaded_file($avatarFile['tmp_name'], $destination)) {
            die('Erreur: Échec de l\'upload de l\'avatar');
        }

        return $avatarName;
    }



    /////..............................Demande COACH............................../////
function DemandeCoach($userId, $certificateFile) {
    // Upload du certificat
    $certName = null;
    if ($certificateFile && $certificateFile['error'] === 0) {
        $allowed  = ['application/pdf', 'image/jpeg', 'image/png'];
        $maxSize  = 5 * 1024 * 1024; // 5MB

        if (!in_array($certificateFile['type'], $allowed)) {
            return ['error' => 'Format non supporté (PDF, JPG, PNG uniquement).'];
        }
        if ($certificateFile['size'] > $maxSize) {
            return ['error' => 'Fichier trop lourd (max 5MB).'];
        }

        $uploadDir = dirname(__FILE__) . '/../../public/assets/images/certificates/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $ext      = pathinfo($certificateFile['name'], PATHINFO_EXTENSION);
        $certName = uniqid('cert_', true) . '.' . $ext;

        if (!move_uploaded_file($certificateFile['tmp_name'], $uploadDir . $certName)) {
            return ['error' => "Échec de l'upload du certificat."];
        }
    } else {
        return ['error' => 'Le certificat est obligatoire.'];
    }

    $sql = "UPDATE users SET 
                certificate        = :certificate,
                coach_request      = 'pending',
                coach_request_date = NOW()
            WHERE id = :id";
    $db  = Database::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute([
            'certificate' => $certName,
            'id'          => $userId,
        ]);
        return ['success' => 'Demande envoyée avec succès.'];
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

/////..............................Accepter / Refuser COACH............................../////
function TraiterDemandeCoach($userId, $decision) {
    // $decision = 'accepted' ou 'refused'
    $role = $decision === 'accepted' ? 'COACH' : 'USER';
    $sql  = "UPDATE users SET coach_request = :decision, role = :role WHERE id = :id";
    $db   = Database::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute([
            'decision' => $decision,
            'role'     => $role,
            'id'       => $userId,
        ]);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

/////..............................Récupérer demandes en attente............................../////
function GetDemandesPending() {
    $sql = "SELECT * FROM users WHERE coach_request = 'pending'";
    $db  = Database::getConnexion();
    try {
        return $db->query($sql)->fetchAll();
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
}
?>