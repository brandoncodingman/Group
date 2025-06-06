<?php
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../core/DBManager.php';

header('Content-Type: application/json');

if (!Session::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

try {
    $dbManager = new DbManager();
    $pdo = $dbManager->getConnection();
    
    $userId = Session::getUserId();
    
    // Get user's selected character
    $stmt = $pdo->prepare("
        SELECT 
            ui.selected_character,
            c.name,
            c.img_src,
            c.points
        FROM user_info ui
        LEFT JOIN characters c ON ui.selected_character = c.character_key
        WHERE ui.id = ?
    ");
    $stmt->execute([$userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        echo json_encode(['error' => 'User not found']);
        exit();
    }
    
    if (!$result['selected_character']) {
        echo json_encode(['success' => false, 'message' => 'No character selected']);
        exit();
    }
    
    echo json_encode([
        'success' => true,
        'character_key' => $result['selected_character'],
        'character_data' => [
            'name' => $result['name'],
            'img_src' => $result['img_src'],
            'points' => (int)$result['points']
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to get user character: ' . $e->getMessage()]);
}
?>