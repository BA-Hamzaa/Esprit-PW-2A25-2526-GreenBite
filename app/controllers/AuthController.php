<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/config/google.php';
require_once BASE_PATH . '/config/email.php';
require_once BASE_PATH . '/app/models/UserModel.php';
require_once BASE_PATH . '/app/controllers/UserController.php';

class AuthController {

    private function loginUser(array $user) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email']    = $user['email'];
        $_SESSION['role']     = $user['role'];
        $_SESSION['avatar']   = $user['avatar'];
        $_SESSION['loggedin'] = true;

        if ($user['role'] === 'ADMIN') {
            header('Location: ' . BASE_URL . '/?page=admin-users&id=' . $user['id']);
        } else {
            header('Location: ' . BASE_URL . '/?id=' . $user['id']);
        }
        exit();
    }

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
                $this->loginUser($user);
            } else {
                return ['error' => 'Email ou mot de passe incorrect.'];
            }
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function RedirectToGoogle() {
        $params = [
            'client_id'     => GOOGLE_CLIENT_ID,
            'redirect_uri'  => GOOGLE_REDIRECT_URI,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'access_type'   => 'offline',
            'prompt'        => 'select_account',
        ];

        header('Location: https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params));
        exit();
    }

    function HandleGoogleCallback() {
        if (!isset($_GET['code']) || empty($_GET['code'])) {
            return ['error' => 'Aucun code Google reçu.'];
        }

        $code = $_GET['code'];
        $tokenResponse = $this->fetchGoogleToken($code);
        if (!isset($tokenResponse['access_token'])) {
            return ['error' => 'Impossible de récupérer le jeton Google.'];
        }

        $profile = $this->fetchGoogleProfile($tokenResponse['access_token']);
        if (!isset($profile['email'])) {
            return ['error' => 'Impossible de récupérer vos informations Google.'];
        }

        $userCtrl = new UserController();
        $existing = $userCtrl->RecupererUserByEmail($profile['email']);
        if ($existing) {
            $this->loginUser($existing);
        }

        $username = preg_replace('/[^A-Za-z0-9_]/', '', strtolower(explode('@', $profile['email'])[0]));
        if (empty($username)) {
            $username = 'googleuser_' . bin2hex(random_bytes(4));
        }
        $username = substr($username, 0, 30);
        $randomPassword = bin2hex(random_bytes(16));

        $user = new User($username, $profile['email'], $randomPassword, 'USER', null, 1);
        $userCtrl->AjouterUser($user, null);

        $newUser = $userCtrl->RecupererUserByEmail($profile['email']);
        if (!$newUser) {
            return ['error' => 'Impossible de créer votre compte Google.'];
        }

        $this->loginUser($newUser);
    }

    private function fetchGoogleToken($code) {
        $url = 'https://oauth2.googleapis.com/token';
        $body = [
            'code'          => $code,
            'client_id'     => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'redirect_uri'  => GOOGLE_REDIRECT_URI,
            'grant_type'    => 'authorization_code',
        ];

        $response = $this->makeHttpRequest($url, http_build_query($body), ['Content-Type: application/x-www-form-urlencoded']);
        return json_decode($response, true);
    }

    private function fetchGoogleProfile($accessToken) {
        $url = 'https://www.googleapis.com/oauth2/v3/userinfo';
        $headers = [
            'Authorization: Bearer ' . $accessToken,
        ];

        $response = $this->makeHttpRequest($url, null, $headers);
        return json_decode($response, true);
    }

    private function makeHttpRequest($url, $postFields = null, $headers = []) {
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            if ($postFields !== null) {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                die('Erreur cURL Google OAuth: ' . htmlspecialchars($error));
            }
            curl_close($ch);
            return $response;
        }

        $options = ['http' => ['header' => implode("\r\n", $headers) . "\r\n", 'method' => $postFields ? 'POST' : 'GET']];
        if ($postFields !== null) {
            $options['http']['content'] = $postFields;
        }
        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }

/////..............................Logout............................../////
    function Logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . '/?page=login');
        exit();
    }

/////..............................Forgot Password............................../////
    function RequestPasswordReset($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':email', $email);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                // Don't reveal if email exists or not for security
                return ['success' => 'Si cet email existe, un lien de réinitialisation a été envoyé.'];
            }

            // Generate secure token
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Update user with reset token
            $updateSql = "UPDATE users SET password_reset_token = :token, reset_token_expiry = :expiry WHERE id = :id";
            $updateQuery = $db->prepare($updateSql);
            $updateQuery->bindValue(':token', $token);
            $updateQuery->bindValue(':expiry', $expiry);
            $updateQuery->bindValue(':id', $user['id']);
            $updateQuery->execute();

            // Generate reset link
            $resetLink = FULL_BASE_URL . '/?page=reset-password&token=' . $token;
            
            // Send email via SMTP
            $subject = 'Réinitialisation de votre mot de passe - NutriGreen';
            $body = getPasswordResetTemplate($resetLink, $user['username']);
            $emailResult = sendEmail($email, $subject, $body);
            
            if ($emailResult['success']) {
                return ['success' => 'Un email de réinitialisation a été envoyé à votre adresse. Veuillez vérifier votre boîte de réception.'];
            } else {
                // Fallback: if email fails, still allow testing mode
                $_SESSION['reset_link'] = $resetLink;
                $_SESSION['reset_email'] = $email;
                return ['success' => 'Si cet email existe, un lien de réinitialisation a été envoyé. (Mode test - Email non envoyé: ' . $emailResult['message'] . ')'];
            }
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

/////..............................Reset Password............................../////
    function ResetPassword($token, $newPassword) {
        $sql = "SELECT * FROM users WHERE password_reset_token = :token AND reset_token_expiry > NOW()";
        $db = Database::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':token', $token);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return ['error' => 'Le lien de réinitialisation est invalide ou a expiré.'];
            }

            // Hash new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update password and clear reset token
            $updateSql = "UPDATE users SET password = :password, password_reset_token = NULL, reset_token_expiry = NULL WHERE id = :id";
            $updateQuery = $db->prepare($updateSql);
            $updateQuery->bindValue(':password', $hashedPassword);
            $updateQuery->bindValue(':id', $user['id']);
            $updateQuery->execute();

            return ['success' => 'Votre mot de passe a été réinitialisé avec succès.'];
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
?>