<?php
/**
 * Configuration SMTP pour l'envoi d'emails
 * 
 * IMPORTANT: Ce fichier doit être modifié avec vos vraies informations SMTP
 */

// Importer PHPMailer
require_once BASE_PATH . '/vendor/PHPMailer-master/src/Exception.php';
require_once BASE_PATH . '/vendor/PHPMailer-master/src/PHPMailer.php';
require_once BASE_PATH . '/vendor/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Configuration Gmail SMTP (exemple avec mot de passe d'application)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 465); // Try port 465 with SSL
define('SMTP_PASSWORD', 'fdsgjzgulcwyjsux'); // Remplacez par votre mot de passe d'application
define('SMTP_USERNAME', 'hazem.marzougui@esprit.tn');  // Remplacez par votre email
define('SMTP_FROM_EMAIL', 'hazem.marzougui@esprit.tn'); // Email expéditeur
define('SMTP_FROM_NAME', 'NutriGreen');             // Nom de l'expéditeur
define('SMTP_ENCRYPTION', 'ssl');                   // ssl pour port 465

/**
 * Fonction pour envoyer un email via SMTP avec PHPMailer
 * 
 * @param string $to Email du destinataire
 * @param string $subject Sujet de l'email
 * @param string $body Contenu HTML de l'email
 * @return array ['success' => bool, 'message' => string]
 */
function sendEmail($to, $subject, $body) {
    // Vérifier que la configuration n'est pas par défaut
    if (SMTP_USERNAME === 'votre-email@gmail.com') {
        return [
            'success' => false, 
            'message' => 'Configuration SMTP non configurée. Veuillez modifier config/email.php avec vos informations.'
        ];
    }

    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP avec debug
        $mail->SMTPDebug = 0; // Mettre à 2 pour voir les erreurs détaillées
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = SMTP_PORT;
        
        // Options supplémentaires pour Gmail
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Destinataires
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress($to);

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->CharSet = 'UTF-8';

        $mail->send();
        return ['success' => true, 'message' => 'Email envoyé avec succès'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Échec de l\'envoi: ' . $mail->ErrorInfo];
    }
}

/**
 * Template HTML pour l'email de réinitialisation de mot de passe
 * 
 * @param string $resetLink Lien de réinitialisation
 * @param string $username Nom d'utilisateur (optionnel)
 * @return string HTML de l'email
 */
function getPasswordResetTemplate($resetLink, $username = '') {
    $greeting = $username ? "Bonjour $username," : "Bonjour,";
    
    return "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #1B4332 0%, #2d6a4f 100%); padding: 30px; text-align: center; }
            .header h1 { color: white; margin: 0; font-size: 24px; }
            .content { background: #f8f9fa; padding: 30px; border-radius: 8px; margin-top: 20px; }
            .button { display: inline-block; background: #2d6a4f; color: white; padding: 15px 30px; 
                      text-decoration: none; border-radius: 5px; margin: 20px 0; }
            .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
            .warning { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>🌿 NutriGreen</h1>
            </div>
            <div class='content'>
                <p>$greeting</p>
                <p>Vous avez demandé la réinitialisation de votre mot de passe. Cliquez sur le bouton ci-dessous pour créer un nouveau mot de passe :</p>
                
                <div style='text-align: center;'>
                    <a href='$resetLink' class='button'>Réinitialiser mon mot de passe</a>
                </div>
                
                <div class='warning'>
                    <strong>⚠️ Important :</strong> Ce lien expire dans 1 heure pour des raisons de sécurité.
                </div>
                
                <p>Si le bouton ne fonctionne pas, copiez et collez ce lien dans votre navigateur :</p>
                <p style='word-break: break-all; color: #2d6a4f;'>$resetLink</p>
                
                <p>Si vous n'avez pas demandé cette réinitialisation, ignorez simplement cet email. Votre mot de passe actuel restera inchangé.</p>
            </div>
            <div class='footer'>
                <p>Cet email a été envoyé automatiquement par NutriGreen.</p>
                <p>© " . date('Y') . " NutriGreen - Votre compagnon pour une alimentation durable</p>
            </div>
        </div>
    </body>
    </html>
    ";
}
