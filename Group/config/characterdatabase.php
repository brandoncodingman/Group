<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Database configuration
$host = 'localhost';
$dbname = 'fluffy_planets';
$username = 'root';  
$password = '';  

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $query = "SELECT 
                c.character_key,
                c.name,
                c.img_src,
                c.points,
                cf.fact
              FROM characters c
              LEFT JOIN character_facts cf ON c.character_key = cf.character_key
              ORDER BY c.character_key, cf.sort_order";
    
    $stmt = $pdo->query($query);
    $results = $stmt->fetchAll();

    $characters = [];
    foreach ($results as $row) {
        $key = $row['character_key'];
        
        if (!isset($characters[$key])) {
            $characters[$key] = [
                'name' => $row['name'],
                'imgSrc' => $row['img_src'],
                'points' => (int)$row['points'], 
                'facts' => []
            ];
        }
        
        if (!empty($row['fact'])) {
            $characters[$key]['facts'][] = $row['fact'];
        }
    }

    echo json_encode($characters, JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}
