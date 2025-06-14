<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Enable error reporting /remove later
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = 'mysql320.phy.lolipop.lan';
$dbname = 'LAA1651812-fluffy';
$username = 'LAA1651812';  
$password = 'root';  

try {
    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);

    $testQuery = "SELECT 1";
    $pdo->query($testQuery);

    $query = "SELECT 
                c.character_key,
                c.name,
                c.img_src,
                c.points,
                cf.fact
              FROM characters c
              LEFT JOIN character_facts cf ON c.character_key = cf.character_key
              ORDER BY c.character_key, cf.sort_order";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
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
    $errorResponse = [
        'error' => 'Database connection failed',
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'debug_info' => [
            'host' => $host,
            'database' => $dbname,
            'username' => $username
        ]
    ];
    echo json_encode($errorResponse, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    http_response_code(500);
    $errorResponse = [
        'error' => 'An error occurred',
        'message' => $e->getMessage(),
        'code' => $e->getCode()
    ];
    echo json_encode($errorResponse, JSON_PRETTY_PRINT);
}
?>