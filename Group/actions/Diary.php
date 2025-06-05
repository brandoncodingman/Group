<?php
require_once __DIR__ . '/../core/DBManager.php';

// class Diary {
//     public function insertDiary($title, $content, $date, $userId) {
//         try {
//             $dbManager = new DbManager();
//             $conn = $dbManager->getConnection();

//             $stmt = $conn->prepare("INSERT INTO diary (title, content, date, user_id) VALUES (:title, :content, :date, :user_id)");
//             $stmt->bindParam(':title', $title);
//             $stmt->bindParam(':content', $content);
//             $stmt->bindParam(':date', $date);
//             $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
//             $stmt->execute();

//             error_log("✅ Inserted diary entry: $title");

//         } catch (PDOException $e) {
//             error_log("❌ DB ERROR: " . $e->getMessage());
//             return false;
//         }

//         return true;
//     }
// }





