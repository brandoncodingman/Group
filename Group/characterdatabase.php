<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'fluffy_planets';
    private $username = 'your_username';  // Replace with your MySQL username
    private $password = 'your_password';  // Replace with your MySQL password
    private $pdo;

    public function connect() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            return $this->pdo;
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    public function getCharacters() {
        $pdo = $this->connect();
        
        $query = "SELECT 
                    c.character_key,
                    c.name,
                    c.img_src,
                    cf.fact,
                    cf.sort_order
                  FROM characters c
                  LEFT JOIN character_facts cf ON c.character_key = cf.character_key
                  ORDER BY c.character_key, cf.sort_order";
        
        $stmt = $pdo->query($query);
        $results = $stmt->fetchAll();

        // Group facts by character
        $characters = [];
        foreach ($results as $row) {
            $key = $row['character_key'];
            
            if (!isset($characters[$key])) {
                $characters[$key] = [
                    'name' => $row['name'],
                    'imgSrc' => $row['img_src'],
                    'facts' => []
                ];
            }
            
            if (!empty($row['fact'])) {
                $characters[$key]['facts'][] = $row['fact'];
            }
        }

        return $characters;
    }

    public function addCharacter($characterKey, $name, $imgSrc, $facts = []) {
        $pdo = $this->connect();
        
        try {
            $pdo->beginTransaction();
            
            // Insert character
            $stmt = $pdo->prepare("INSERT INTO characters (character_key, name, img_src) VALUES (?, ?, ?)");
            $stmt->execute([$characterKey, $name, $imgSrc]);
            
            // Insert facts
            if (!empty($facts)) {
                $stmt = $pdo->prepare("INSERT INTO character_facts (character_key, fact, sort_order) VALUES (?, ?, ?)");
                foreach ($facts as $index => $fact) {
                    $stmt->execute([$characterKey, $fact, $index + 1]);
                }
            }
            
            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public function updateCharacter($characterKey, $name = null, $imgSrc = null, $facts = null) {
        $pdo = $this->connect();
        
        try {
            $pdo->beginTransaction();
            
            // Update character if name or imgSrc provided
            if ($name !== null || $imgSrc !== null) {
                $setParts = [];
                $params = [];
                
                if ($name !== null) {
                    $setParts[] = "name = ?";
                    $params[] = $name;
                }
                if ($imgSrc !== null) {
                    $setParts[] = "img_src = ?";
                    $params[] = $imgSrc;
                }
                
                $params[] = $characterKey;
                $query = "UPDATE characters SET " . implode(', ', $setParts) . " WHERE character_key = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
            }
            
            // Update facts if provided
            if ($facts !== null) {
                // Delete existing facts
                $stmt = $pdo->prepare("DELETE FROM character_facts WHERE character_key = ?");
                $stmt->execute([$characterKey]);
                
                // Insert new facts
                if (!empty($facts)) {
                    $stmt = $pdo->prepare("INSERT INTO character_facts (character_key, fact, sort_order) VALUES (?, ?, ?)");
                    foreach ($facts as $index => $fact) {
                        $stmt->execute([$characterKey, $fact, $index + 1]);
                    }
                }
            }
            
            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public function deleteCharacter($characterKey) {
        $pdo = $this->connect();
        
        // Facts will be automatically deleted due to CASCADE
        $stmt = $pdo->prepare("DELETE FROM characters WHERE character_key = ?");
        return $stmt->execute([$characterKey]);
    }
}
?>