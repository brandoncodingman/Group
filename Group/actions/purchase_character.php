<?php
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../core/DBManager.php';

header('Content-Type: application/json');

if (!Session::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['character_key'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Character key is required']);
    exit();
}

try {
    $dbManager = new DbManager();
    $pdo = $dbManager->getConnection();
    
    $userId = Session::getUserId();
    $characterKey = $input['character_key'];
    
    $pdo->beginTransaction();
    
    // Get character info
    $stmt = $pdo->prepare("SELECT name, img_src, points FROM characters WHERE character_key = ?");
    $stmt->execute([$characterKey]);
    $character = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$character) {
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode(['error' => 'Character not found']);
        exit();
    }
    
    // Get user's current points
    $stmt = $pdo->prepare("SELECT points FROM user_info WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit();
    }
    
    $characterCost = (int)$character['points'];
    $userPoints = (int)$user['points'];
    
    // Check if user has enough points
    if ($userPoints < $characterCost) {
        $pdo->rollBack();
        http_response_code(400);
        echo json_encode([
            'error' => 'Insufficient points',
            'required' => $characterCost,
            'available' => $userPoints
        ]);
        exit();
    }
    
    // Calculatebalance
    $newPoints = $userPoints - $characterCost;
    
    $stmt = $pdo->prepare("UPDATE user_info SET points = ? WHERE id = ?");
    $stmt->execute([$newPoints, $userId]);
    

    $stmt = $pdo->prepare("UPDATE user_info SET selected_character = ? WHERE id = ?");
    $stmt->execute([$characterKey, $userId]);
    
    $pdo->commit();
    
    Session::updatePoints($newPoints);
    
    echo json_encode([
        'success' => true,
        'character' => [
            'key' => $characterKey,
            'name' => $character['name'],
            'imgSrc' => $character['img_src']
        ],
        'newPoints' => $newPoints,
        'spent' => $characterCost
    ]);
    
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Purchase failed: ' . $e->getMessage()]);
}
?>