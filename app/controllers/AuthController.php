<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/app/models/UserModel.php';

class AuthController {

/////..............................Login............................../////
    function Login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email AND is_active = 1";
$db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':email', $email);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email']    = $user['email'];
                $_SESSION['role']     = $user['role'];
                $_SESSION['avatar']   = $user['avatar'];
                $_SESSION['loggedin'] = true;

                // Redirection selon le rôle
                if ($user['role'] === 'ADMIN') {
                    header('Location: ' . BASE_URL . '/?page=admin-users');
                } else {
                    header('Location: ' . BASE_URL . '/');
                }
                exit();
            } else {
                return ['error' => 'Email ou mot de passe incorrect.'];
            }
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

/////..............................Logout............................../////
    function Logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . '/?page=login');
        exit();
    }
}
?>