<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/app/models/UserModel.php';
require_once BASE_PATH . '/app/controllers/UserController.php';

class FaceAuthController {

    public function registerFace($userId, $descriptorJson) {
        $db = Database::getConnexion();
        try {
            $stmt = $db->prepare("UPDATE users SET face_descriptor = :descriptor WHERE id = :id");
            $stmt->execute([
                'descriptor' => $descriptorJson,
                'id' => $userId
            ]);
            return ['success' => true];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function loginFace($clientDescriptorJson) {
        $db = Database::getConnexion();
        $clientDesc = json_decode($clientDescriptorJson, true);
        
        // Wait, face-api might send an object with numbered keys (0 to 127) if JSON.stringify is used directly on Float32Array. Let's make sure we extract values correctly.
        if (is_object($clientDesc)) {
            $clientDesc = array_values((array)$clientDesc);
        }
        
        if (!is_array($clientDesc) || count($clientDesc) !== 128) {
            return ['error' => 'Descripteur facial invalide'];
        }

        try {
            $stmt = $db->query("SELECT id, username, email, role, avatar, face_descriptor FROM users WHERE face_descriptor IS NOT NULL");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $bestMatch = null;
            $minDistance = 0.45; // Seuil de tolérance (plus c'est bas, plus c'est strict)

            foreach ($users as $user) {
                $dbDesc = json_decode($user['face_descriptor'], true);
                if (is_object($dbDesc)) $dbDesc = array_values((array)$dbDesc);
                
                if (is_array($dbDesc) && count($dbDesc) === 128) {
                    $distance = $this->euclideanDistance($clientDesc, $dbDesc);
                    if ($distance < $minDistance) {
                        $minDistance = $distance;
                        $bestMatch = $user;
                    }
                }
            }

            if ($bestMatch) {
                // Login the user
                $_SESSION['user_id']  = $bestMatch['id'];
                $_SESSION['username'] = $bestMatch['username'];
                $_SESSION['email']    = $bestMatch['email'];
                $_SESSION['role']     = $bestMatch['role'];
                $_SESSION['avatar']   = $bestMatch['avatar'];
                $_SESSION['loggedin'] = true;

                return [
                    'success' => true, 
                    'user' => [
                        'id' => $bestMatch['id'], 
                        'username' => $bestMatch['username'],
                        'role' => $bestMatch['role']
                    ]
                ];
            } else {
                return ['error' => 'Visage non reconnu'];
            }

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    private function euclideanDistance($a, $b) {
        $sum = 0;
        for ($i = 0; $i < 128; $i++) {
            $sum += pow($a[$i] - $b[$i], 2);
        }
        return sqrt($sum);
    }
}
?>
