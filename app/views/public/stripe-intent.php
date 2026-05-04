<?php
/**
 * GreenBite — Stripe PaymentIntent AJAX Endpoint
 * Called by order.php JS to create a PaymentIntent
 * Returns JSON: { client_secret: "..." }
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['error' => 'Method not allowed']));
}

define('BASE_PATH', dirname(dirname(dirname(__DIR__))));
require_once BASE_PATH . '/config/stripe.php';

$data   = json_decode(file_get_contents('php://input'), true);
$amount = isset($data['amount']) ? (int) round((float) $data['amount'] * 100) : 0; // cents

if ($amount <= 50) { // Stripe minimum is 50 cents
    http_response_code(400);
    exit(json_encode(['error' => 'Montant invalide ou trop faible.']));
}

// Create PaymentIntent via cURL (no Composer needed)
$ch = curl_init('https://api.stripe.com/v1/payment_intents');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query([
        'amount'                   => $amount,
        'currency'                 => 'eur',
        'payment_method_types[]'   => 'card',
        'description'              => 'Commande GreenBite',
        'metadata[source]'         => 'greenbite_marketplace',
    ]),
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . STRIPE_SECRET_KEY,
    ],
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result = json_decode($response, true);

if ($httpCode !== 200 || empty($result['client_secret'])) {
    http_response_code(400);
    exit(json_encode(['error' => $result['error']['message'] ?? 'Erreur Stripe inconnue.']));
}

echo json_encode(['client_secret' => $result['client_secret']]);
