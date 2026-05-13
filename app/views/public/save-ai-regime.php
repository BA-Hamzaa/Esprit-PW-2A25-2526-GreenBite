<?php
/**
 * Save AI-generated regimes to database
 * Bypasses validation - AI-generated regimes are automatically accepted
 */

error_reporting(0);
ini_set('display_errors', 0);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// This file may be invoked directly by the PHP built-in server (document root
// is app/views/public). In that case BASE_PATH is not defined yet.
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(dirname(dirname(__DIR__))));
}

require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/app/models/RegimeAlimentaire.php';

$raw = file_get_contents('php://input');
$input = json_decode($raw, true);

if (!isset($input['regimes']) || !is_array($input['regimes'])) {
    echo json_encode(['error' => 'Invalid input: regimes array required']);
    exit;
}

$goal = $input['goal'] ?? 'sante_generale';
$soumis_par = $_SESSION['username'] ?? 'IA_GreenBot';
$db = Database::getConnexion();

$savedIds = [];
$errors = [];

foreach ($input['regimes'] as $idx => $regimeData) {
    try {
        // Parse duration to extract weeks
        $dureeStr = $regimeData['duree'] ?? '4 semaines';
        $dureeSemaines = (int) preg_replace('/[^0-9]/', '', $dureeStr);
        if ($dureeSemaines < 1) $dureeSemaines = 4;

        $calories = (int)($regimeData['calories_jour'] ?? 2000);
        if ($calories < 1000) $calories = 2000;

        $nom = $regimeData['nom'] ?? "Régime IA " . ($idx + 1);
        $description = $regimeData['description'] ?? '';
        $restrictions = $input['details'] ?? 'Aucune';

        $regime = new RegimeAlimentaire(
            $nom,
            $goal,
            $dureeSemaines,
            $calories,
            $soumis_par,
            'accepte', // Auto-accept AI-generated regimes
            $description,
            $restrictions
        );

        $sql = "INSERT INTO regime_alimentaire (nom, objectif, description, duree_semaines, calories_jour, restrictions, soumis_par, statut)
                VALUES (:nom, :objectif, :description, :duree_semaines, :calories_jour, :restrictions, :soumis_par, :statut)";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'nom' => $regime->getNom(),
            'objectif' => $regime->getObjectif(),
            'description' => $regime->getDescription(),
            'duree_semaines' => $regime->getDureeSemaines(),
            'calories_jour' => $regime->getCaloriesJour(),
            'restrictions' => $regime->getRestrictions(),
            'soumis_par' => $regime->getSoumisPar(),
            'statut' => $regime->getStatut(),
        ]);

        $savedIds[] = $db->lastInsertId();
    } catch (Exception $e) {
        $errors[] = "Régime " . ($idx + 1) . ": " . $e->getMessage();
    }
}

echo json_encode([
    'success' => count($savedIds) > 0,
    'saved_ids' => $savedIds,
    'count' => count($savedIds),
    'errors' => $errors
]);
