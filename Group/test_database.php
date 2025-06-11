<?php
// Test database connection and check characters table structure
$host = 'localhost';
$dbname = 'fluffy_planets';
$username = 'root';  
$password = '';  

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    echo "<h2>Database Connection: SUCCESS</h2>";
    
    // Check if characters table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'characters'");
    $tableExists = $stmt->fetch();
    
    if ($tableExists) {
        echo "<h3>Characters table: EXISTS</h3>";
        
        // Check table structure
        echo "<h4>Table Structure:</h4>";
        $stmt = $pdo->query("DESCRIBE characters");
        $columns = $stmt->fetchAll();
        
        echo "<table border='1'>";
        echo "<tr><th>Column</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        
        $hasPointsColumn = false;
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>" . $column['Field'] . "</td>";
            echo "<td>" . $column['Type'] . "</td>";
            echo "<td>" . $column['Null'] . "</td>";
            echo "<td>" . $column['Key'] . "</td>";
            echo "<td>" . $column['Default'] . "</td>";
            echo "</tr>";
            
            if ($column['Field'] === 'points') {
                $hasPointsColumn = true;
            }
        }
        echo "</table>";
        
        if (!$hasPointsColumn) {
            echo "<p style='color: red;'><strong>ERROR: 'points' column is missing from characters table!</strong></p>";
            echo "<p>Run this SQL to add it:</p>";
            echo "<pre>ALTER TABLE characters ADD COLUMN points INT DEFAULT 0;</pre>";
        } else {
            echo "<p style='color: green;'><strong>Points column: EXISTS</strong></p>";
        }
        
        // Show sample data
        echo "<h4>Sample Data:</h4>";
        $stmt = $pdo->query("SELECT * FROM characters LIMIT 5");
        $sampleData = $stmt->fetchAll();
        
        if ($sampleData) {
            echo "<table border='1'>";
            echo "<tr>";
            foreach (array_keys($sampleData[0]) as $header) {
                echo "<th>$header</th>";
            }
            echo "</tr>";
            
            foreach ($sampleData as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No data found in characters table</p>";
        }
        
    } else {
        echo "<h3 style='color: red;'>Characters table: DOES NOT EXIST</h3>";
    }
    
    // Test the API endpoint
    echo "<h3>Testing API Endpoint:</h3>";
    $apiUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/config/characterdatabase.php';
    echo "<p>API URL: <a href='$apiUrl' target='_blank'>$apiUrl</a></p>";
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>Database Connection: FAILED</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
} catch (Exception $e) {
    echo "<h2 style='color: red;'>Error: " . $e->getMessage() . "</h2>";
}
?>