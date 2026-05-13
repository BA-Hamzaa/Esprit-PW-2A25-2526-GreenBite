<?php
/**
 * Configuration Google reCAPTCHA
 * 
 * IMPORTANT: Pour utiliser reCAPTCHA, vous devez:
 * 1. Créer un compte sur https://www.google.com/recaptcha/admin
 * 2. Obtenir votre Site Key et Secret Key
 * 3. Remplacer les valeurs ci-dessous
 */

// Clé du site (à utiliser dans le frontend)
define('RECAPTCHA_SITE_KEY', '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI');

// Clé secrète (à utiliser dans le backend)
define('RECAPTCHA_SECRET_KEY', '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe');

// Version reCAPTCHA (v2)
define('RECAPTCHA_VERSION', 'v2');

/**
 * Vérifier la réponse reCAPTCHA
 * 
 * @param string $response Token reCAPTCHA reçu du formulaire
 * @return array ['success' => bool, 'message' => string]
 */
function verifyRecaptcha($response) {
    if (empty($response)) {
        return ['success' => false, 'message' => 'Veuillez cocher la case reCAPTCHA.'];
    }

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => RECAPTCHA_SECRET_KEY,
        'response' => $response
    ];

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $resultJson = json_decode($result, true);

    if ($resultJson['success']) {
        return ['success' => true, 'message' => 'reCAPTCHA validé avec succès.'];
    } else {
        return ['success' => false, 'message' => 'La validation reCAPTCHA a échoué. Veuillez réessayer.'];
    }
}
