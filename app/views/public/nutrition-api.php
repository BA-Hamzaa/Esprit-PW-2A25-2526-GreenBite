<?php
/**
 * nutrition-api.php — Server-side proxy for USDA & Open Food Facts
 * Prevents exposing API keys to the browser.
 * Called via fetch() from nutrition widgets.
 */
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// Resolve project root: app/views/public/ → go 3 levels up
$projectRoot = dirname(dirname(dirname(__DIR__)));
require_once $projectRoot . '/config/nutrition_apis.php';

$action = $_GET['action'] ?? '';
$q      = trim($_GET['q'] ?? '');
$fdcId  = (int)($_GET['fdcId'] ?? 0);

function curlGet(string $url): ?array {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_USERAGENT      => 'GreenBite/1.0',
        CURLOPT_SSL_VERIFYPEER => false,
    ]);
    $resp = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($code !== 200 || !$resp) return null;
    return json_decode($resp, true);
}

switch ($action) {

    // ── USDA: search foods ─────────────────────────────────────────────────────
    case 'usda_search':
        if (!$q) { echo json_encode(['error'=>'Query required']); exit; }
        $url  = USDA_BASE_URL . '/foods/search?query=' . urlencode($q)
              . '&api_key=' . USDA_API_KEY
              . '&pageSize=8&dataType=Foundation,SR%20Legacy';
        $data = curlGet($url);
        if (!$data) { echo json_encode(['error'=>'USDA unavailable']); exit; }

        // Map: old-style nutrientNumber => French label
        $wantedByNumber = [
            203 => 'Protéines',    204 => 'Lipides',      205 => 'Glucides',
            291 => 'Fibres',       208 => 'Calories',
            401 => 'Vit. C',       320 => 'Vit. A',       328 => 'Vit. D',
            418 => 'Vit. B12',     415 => 'Vit. B6',      306 => 'Potassium',
            301 => 'Calcium',      303 => 'Fer',           304 => 'Magnésium',
            309 => 'Zinc',
        ];
        // Map: new-style nutrientId => French label (USDA search API uses these)
        $wantedById = [
            1003 => 'Protéines',   1004 => 'Lipides',     1005 => 'Glucides',
            1079 => 'Fibres',      1008 => 'Calories',
            1162 => 'Vit. C',      1106 => 'Vit. A',      1114 => 'Vit. D',
            1178 => 'Vit. B12',    1175 => 'Vit. B6',     1092 => 'Potassium',
            1087 => 'Calcium',     1089 => 'Fer',          1090 => 'Magnésium',
            1095 => 'Zinc',
        ];

        $results = [];
        foreach (($data['foods'] ?? []) as $f) {
            $nutrients = [];
            foreach (($f['foodNutrients'] ?? []) as $n) {
                $label = null;
                // Try nutrientNumber first (old-style, always matches our map)
                $num = (int)($n['nutrientNumber'] ?? 0);
                if ($num && isset($wantedByNumber[$num])) {
                    $label = $wantedByNumber[$num];
                }
                // Fallback: try nutrientId (new-style)
                if (!$label) {
                    $nid = (int)($n['nutrientId'] ?? 0);
                    if ($nid && isset($wantedById[$nid])) {
                        $label = $wantedById[$nid];
                    }
                }
                if ($label) {
                    $nutrients[$label] = [
                        'value' => round((float)($n['value'] ?? 0), 1),
                        'unit'  => $n['unitName'] ?? '',
                    ];
                }
            }
            $results[] = [
                'fdcId'       => $f['fdcId'],
                'name'        => $f['description'],
                'category'    => $f['foodCategory'] ?? '',
                'dataType'    => $f['dataType'] ?? '',
                'nutrients'   => $nutrients,
            ];
        }
        echo json_encode(['results' => $results]);
        break;

    // ── Open Food Facts: search by name ───────────────────────────────────────
    case 'off_search':
        if (!$q) { echo json_encode(['error'=>'Query required']); exit; }
        $url  = OFF_BASE_URL . '/cgi/search.pl?search_terms=' . urlencode($q)
              . '&search_simple=1&json=true&page_size=8&lc=fr'
              . '&fields=product_name,brands,nutriscore_grade,nova_group,'
              . 'ecoscore_grade,allergens_tags,additives_n,nutriments,'
              . 'image_thumb_url,quantity';
        $data = curlGet($url);
        if (!$data) { echo json_encode(['error'=>'Open Food Facts unavailable']); exit; }

        $results = [];
        foreach (($data['products'] ?? []) as $p) {
            $name = trim($p['product_name'] ?? '');
            if (!$name) continue;
            $results[] = [
                'name'        => $name,
                'brand'       => $p['brands'] ?? '',
                'quantity'    => $p['quantity'] ?? '',
                'nutriscore'  => strtoupper($p['nutriscore_grade'] ?? '?'),
                'nova'        => (int)($p['nova_group'] ?? 0),
                'ecoscore'    => strtoupper($p['ecoscore_grade'] ?? '?'),
                'additives'   => (int)($p['additives_n'] ?? 0),
                'allergens'   => array_map(
                    fn($a) => ucfirst(str_replace('en:', '', $a)),
                    $p['allergens_tags'] ?? []
                ),
                'kcal'        => round((float)($p['nutriments']['energy-kcal_100g'] ?? 0)),
                'image'       => $p['image_thumb_url'] ?? '',
            ];
        }
        echo json_encode(['results' => $results]);
        break;

    default:
        echo json_encode(['error' => 'Unknown action']);
}
