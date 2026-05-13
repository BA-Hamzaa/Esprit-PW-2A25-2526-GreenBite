<?php
/**
 * OpenRouter AI Proxy — GreenBite
 * Multi-model fallback, no session dependency
 */

// Prevent any warnings/notices from corrupting JSON output
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

define('OR_KEY', '');
define('OR_URL', 'https://openrouter.ai/api/v1/chat/completions');

// ── Diagnostic endpoints ──────────────────────────────────────────────────────
if (isset($_GET['test'])) {
    // List all available free models from OpenRouter
    $ch = curl_init('https://openrouter.ai/api/v1/models');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . OR_KEY],
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);
    $resp = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    if ($err) {
        echo json_encode(['curl_error' => $err]);
        exit;
    }
    $data = json_decode($resp, true);
    $free = [];
    foreach (($data['data'] ?? []) as $m) {
        if (str_ends_with($m['id'] ?? '', ':free'))
            $free[] = $m['id'];
    }
    echo json_encode(['free_models' => $free, 'total_free' => count($free), 'api_key_prefix' => substr(OR_KEY, 0, 20) . '...']);
    exit;
}

if (isset($_GET['debug'])) {
    // Test a single model and return the raw response so we can see the exact error
    $model = $_GET['model'] ?? 'meta-llama/llama-3.1-8b-instruct:free';
    $body = [
        'model' => $model,
        'messages' => [
            ['role' => 'system', 'content' => 'Respond with one word only.'],
            ['role' => 'user', 'content' => 'Say "ok"'],
        ],
        'max_tokens' => 10,
    ];
    $ch = curl_init(OR_URL);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . OR_KEY,
            'Content-Type: application/json',
            'HTTP-Referer: http://localhost:8000',
            'X-Title: GreenBite',
        ],
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_TIMEOUT => 15,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);
    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr = curl_error($ch);
    curl_close($ch);
    $parsed = json_decode($resp, true);
    echo json_encode([
        'model' => $model,
        'http_code' => $httpCode,
        'curl_error' => $curlErr ?: null,
        'raw' => $parsed,
        'content' => $parsed['choices'][0]['message']['content'] ?? null,
        'api_error' => $parsed['error'] ?? null,
    ]);
    exit;
}

// Free models on OpenRouter
// 'openrouter/free' is the official auto-router — it picks any currently available free model.
// The remaining list are confirmed-valid models (verified returning 429 not 404).
$MODELS = [
    'openrouter/free',                              // ★ Official free auto-router (always tries this first)
    'meta-llama/llama-3.3-70b-instruct:free',
    'openai/gpt-oss-120b:free',
    'openai/gpt-oss-20b:free',
    'nousresearch/hermes-3-llama-3.1-405b:free',
    'google/gemma-3-27b-it:free',
    'qwen/qwen3-coder:free',
    'meta-llama/llama-3.2-3b-instruct:free',
];

$raw = file_get_contents('php://input');
$input = json_decode($raw, true);
$type = $input['type'] ?? 'chat';

// ── Build messages depending on request type ──────────────────────────────────
if ($type === 'chat') {
    $messages = $input['messages'] ?? [];
    if (empty($messages)) {
        echo json_encode(['error' => 'No messages provided']);
        exit;
    }
    array_unshift($messages, [
        'role' => 'system',
        'content' => "Tu es GreenBot, l'assistant IA de GreenBite, une application de nutrition durable. Tu parles toujours en français (ou dans la langue de l'utilisateur). Tu peux :\n- Créer des régimes alimentaires personnalisés\n- Suggérer des recettes avec des ingrédients disponibles à la maison\n- Donner des conseils santé, fitness et bien-être\n- Calculer des apports caloriques approximatifs\n- Proposer des programmes sportifs complémentaires\nSois précis, bienveillant et motivant. Utilise des emojis. Formate tes réponses en markdown simple.",
    ]);
    $bodyBase = ['messages' => $messages, 'max_tokens' => 1000, 'temperature' => 0.7];

} elseif ($type === 'generate_regimes') {
    $goal = $input['goal'] ?? 'sante_generale';
    $details = trim($input['details'] ?? '');
    $labels = [
        'perte_poids' => 'Perte de poids',
        'maintien' => 'Maintien du poids',
        'prise_masse' => 'Prise de masse musculaire',
        'sante_generale' => 'Santé générale',
        'vegetarien' => 'Végétarien',
        'vegan' => 'Vegan',
        'low_carb' => 'Low carb / Keto',
        'detox' => 'Détox',
    ];
    $goalLabel = $labels[$goal] ?? $goal;
    $constraint = $details ? " Contraintes: $details." : '';
    $messages = [
        ['role' => 'system', 'content' => 'Tu es un nutritionniste expert. Réponds UNIQUEMENT avec du JSON valide, aucun texte avant ou après, aucun markdown.'],
        ['role' => 'user', 'content' => "Crée 3 régimes alimentaires distincts pour l'objectif \"$goalLabel\".$constraint\nRéponds UNIQUEMENT avec ce JSON (remplace les ... par des vraies valeurs):\n{\"regimes\":[{\"nom\":\"...\",\"duree\":\"...\",\"calories_jour\":2000,\"description\":\"...\",\"avantages\":[\"...\",\"...\",\"...\"],\"jours_exemple\":[{\"jour\":\"Jour 1\",\"petit_dejeuner\":\"...\",\"dejeuner\":\"...\",\"diner\":\"...\",\"collation\":\"...\"}]},{\"nom\":\"...\",\"duree\":\"...\",\"calories_jour\":1800,\"description\":\"...\",\"avantages\":[\"...\",\"...\",\"...\"],\"jours_exemple\":[{\"jour\":\"Jour 1\",\"petit_dejeuner\":\"...\",\"dejeuner\":\"...\",\"diner\":\"...\",\"collation\":\"...\"}]},{\"nom\":\"...\",\"duree\":\"...\",\"calories_jour\":2200,\"description\":\"...\",\"avantages\":[\"...\",\"...\",\"...\"],\"jours_exemple\":[{\"jour\":\"Jour 1\",\"petit_dejeuner\":\"...\",\"dejeuner\":\"...\",\"diner\":\"...\",\"collation\":\"...\"}]}]}"],
    ];
    $bodyBase = ['messages' => $messages, 'max_tokens' => 1800, 'temperature' => 0.8];

} else {
    echo json_encode(['error' => 'Type inconnu: ' . $type]);
    exit;
}

// ── Call OpenRouter with one model ─────────────────────────────────────────────
function callModel(string $model, array $bodyBase): array
{
    $body = array_merge($bodyBase, ['model' => $model]);
    $ch = curl_init(OR_URL);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . OR_KEY,
            'Content-Type: application/json',
            'HTTP-Referer: http://localhost:8000',
            'X-Title: GreenBite',
        ],
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_TIMEOUT => 20,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_CONNECTTIMEOUT => 8,
    ]);
    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr = curl_error($ch);
    curl_close($ch);

    if ($curlErr)
        return ['error' => "curl($model): $curlErr"];
    $data = json_decode($resp, true);
    $content = $data['choices'][0]['message']['content'] ?? null;
    if ($content !== null)
        return ['ok' => true, 'content' => $content, 'model' => $model];
    $apiErr = $data['error']['message'] ?? 'Unknown';
    return ['error' => "HTTP{$httpCode}:{$model}: {$apiErr}", 'http_code' => $httpCode];
}

// ── Try models in order, with delay between attempts ──────────────────────────
$errors = [];
$allRateLimit = true;

foreach ($MODELS as $idx => $model) {
    if ($idx > 0)
        usleep(300000); // 0.3 s gap — daily limits won't reset with a short wait

    $result = callModel($model, $bodyBase);

    if (!empty($result['ok'])) {
        $content = $result['content'];

        if ($type === 'generate_regimes') {
            $content = preg_replace('/^\s*```(?:json)?\s*/s', '', $content);
            $content = preg_replace('/\s*```\s*$/s', '', $content);
            if (preg_match('/\{[\s\S]*\}/s', $content, $m))
                $content = $m[0];
            $parsed = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($parsed['regimes'])) {
                echo json_encode(['regimes' => $parsed['regimes'], '_model' => $result['model']]);
                exit;
            }
            $errors[$model] = 'JSON invalide: ' . json_last_error_msg();
            $allRateLimit = false;
            continue;
        }

        echo json_encode(['reply' => $content, '_model' => $result['model']]);
        exit;
    }

    $err = $result['error'] ?? '';
    $httpCode = $result['http_code'] ?? 0;
    $errors[$model] = $err;
    // 429 = rate-limited (temporary), 400 = bad request (model format issue, skip)
    // Any other code (500, 0, etc.) means it's a real failure, not just rate-limiting
    if ($httpCode !== 429 && $httpCode !== 400) {
        $allRateLimit = false;
    }
}

// All models failed
http_response_code(503);
if ($allRateLimit) {
    echo json_encode([
        'error' => '⏳ Les modèles IA gratuits sont momentanément surchargés. Attendez 30 secondes et réessayez.',
        'rate_limit' => true,
        'details' => $errors,
    ]);
} else {
    echo json_encode([
        'error' => 'Service temporairement indisponible. Réessayez dans quelques secondes.',
        'details' => $errors,
    ]);
}
