<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = 'mysql320.phy.lolipop.lan';
$dbname = 'LAA1651812-fluffy';
$username = 'LAA1651812';  
$password = 'root';  

try {
    // Create PDO connection with proper DSN format
    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);

    // Test the connection first
    $testQuery = "SELECT 1";
    $pdo->query($testQuery);

    // Main query to get characters and facts
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

    // Process results into the expected format
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

    // Return the data
    echo json_encode($characters, JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    // Database specific errors
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
    // General errors
    http_response_code(500);
    $errorResponse = [
        'error' => 'An error occurred',
        'message' => $e->getMessage(),
        'code' => $e->getCode()
    ];
    echo json_encode($errorResponse, JSON_PRETTY_PRINT);
}
?>