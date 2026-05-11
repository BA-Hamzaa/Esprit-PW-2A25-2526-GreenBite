<?php
require_once BASE_PATH . '/app/controllers/ChatbotController.php';

$chatbot = new ChatbotController();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'response':
        $chatbot->getResponse();
        break;
    case 'suggestions':
        $chatbot->getSuggestions();
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Action non trouvée']);
        break;
}
