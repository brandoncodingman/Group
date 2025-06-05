<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../core/DBManager.php';

Session::requireLogin();

$userId = Session::getUserId();
if (!$userId) {
    die('User not logged in');
}

$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');

if ($title === '' || $content === '') {
    die('Title and content are required.');
}

$db = new DbManager();
$conn = $db->getConnection();

try {
    $conn->beginTransaction();

    // Insert diary entry
    $stmt = $conn->prepare("
        INSERT INTO diary (date, title, content, user_id)
        VALUES (NOW(), :title, :content, :user_id)
    ");
    $stmt->execute([
        ':title' => $title,
        ':content' => $content,
        ':user_id' => $userId
    ]);

    if ($stmt->rowCount() === 0) {
        throw new Exception("Failed to insert diary entry");
    }

    // Update user points (+10)
    $pointsToAdd = 10;
    $stmt = $conn->prepare("
        UPDATE user_info SET points = points + :points WHERE id = :user_id
    ");
    $stmt->execute([
        ':points' => $pointsToAdd,
        ':user_id' => $userId
    ]);

    if ($stmt->rowCount() === 0) {
        throw new Exception("Failed to update user points");
    }

    // Get updated points
    $stmt = $conn->prepare("SELECT points FROM user_info WHERE id = :user_id");
    $stmt->execute([':user_id' => $userId]);
    $updatedPoints = $stmt->fetchColumn();

    if ($updatedPoints === false) {
        throw new Exception("Failed to fetch updated points");
    }

    $conn->commit();

    // Update session points
    Session::updatePoints((int)$updatedPoints);

    // Redirect back to diary page
    header('Location: ../diary1.php');
    exit();

} catch (Exception $e) {
    $conn->rollBack();
    die("Transaction failed: " . $e->getMessage());
}
