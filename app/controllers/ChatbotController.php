<?php
require_once BASE_PATH . '/config/chatbot.php';

class ChatbotController {
    
    /**
     * Obtenir une réponse du chatbot
     * 
     * @return array
     */
    function getResponse() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Méthode non autorisée']);
            exit();
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['message']) || empty($input['message'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Message requis']);
            exit();
        }
        
        $response = getChatbotResponse($input['message']);
        
        echo json_encode([
            'success' => true,
            'response' => $response['response'],
            'suggestions' => $response['suggestions']
        ]);
    }
    
    /**
     * Obtenir les suggestions du chatbot
     * 
     * @return array
     */
    function getSuggestions() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(['error' => 'Méthode non autorisée']);
            exit();
        }
        
        $suggestions = getChatbotSuggestions();
        
        echo json_encode([
            'success' => true,
            'suggestions' => $suggestions
        ]);
    }
}
