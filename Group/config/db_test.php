<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = 'mysql320.phy.lolipop.lan';
$dbname = 'LAA1651812-fluffy';
$username = 'LAA1651812';  
$password = 'root';

$tests = [];

// Test 1: Basic connection
try {
    $dsn = "mysql:host={$host};charset=utf8";
    $pdo = new PDO($dsn, $username, $password);
    $tests['basic_connection'] = ['status' => 'success', 'message' => 'Connected to MySQL server'];
} catch (PDOException $e) {
    $tests['basic_connection'] = ['status' => 'failed', 'message' => $e->getMessage()];
    echo json_encode(['tests' => $tests], JSON_PRETTY_PRINT);
    exit;
}

// Test 2: Database selection
try {
    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8";
    $pdo = new PDO($dsn, $username, $password);
    $tests['database_selection'] = ['status' => 'success', 'message' => 'Connected to database'];
} catch (PDOException $e) {
    $tests['database_selection'] = ['status' => 'failed', 'message' => $e->getMessage()];
    echo json_encode(['tests' => $tests], JSON_PRETTY_PRINT);
    exit;
}

// Test 3: Check if tables exist
try {
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $tests['tables_exist'] = [
        'status' => 'success', 
        'message' => 'Found tables: ' . implode(', ', $tables),
        'tables' => $tables
    ];
} catch (PDOException $e) {
    $tests['tables_exist'] = ['status' => 'failed', 'message' => $e->getMessage()];
}

// Test 4: Check characters table
try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM characters");
    $result = $stmt->fetch();
    $tests['characters_table'] = [
        'status' => 'success', 
        'message' => 'Characters table has ' . $result['count'] . ' records'
    ];
} catch (PDOException $e) {
    $tests['characters_table'] = ['status' => 'failed', 'message' => $e->getMessage()];
}

// Test 5: Check character_facts table
try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM character_facts");
    $result = $stmt->fetch();
    $tests['character_facts_table'] = [
        'status' => 'success', 
        'message' => 'Character_facts table has ' . $result['count'] . ' records'
    ];
} catch (PDOException $e) {
    $tests['character_facts_table'] = ['status' => 'failed', 'message' => $e->getMessage()];
}

// Test 6: Sample data query
try {
    $stmt = $pdo->query("SELECT character_key, name FROM characters LIMIT 3");
    $samples = $stmt->fetchAll();
    $tests['sample_data'] = [
        'status' => 'success', 
        'message' => 'Sample characters found',
        'data' => $samples
    ];
} catch (PDOException $e) {
    $tests['sample_data'] = ['status' => 'failed', 'message' => $e->getMessage()];
}

echo json_encode(['tests' => $tests], JSON_PRETTY_PRINT);
?>