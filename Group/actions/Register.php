<?php
require_once __DIR__ . '/../core/DBManager.php';
require_once __DIR__ . '/../core/Session.php';

Class Register {
    private PDO $pdo;

    public function __construct(DbManager $dbManager) {
        $this->pdo = $dbManager->getConnection();
    }

    public function registerUser(string $username, string $password): void {
        if (empty($username) || empty($password)) {
            echo "ユーザー名とパスワードは必須です。";
            return;
        }

        // Check if username already exists
        $stmt = $this->pdo->prepare("SELECT id FROM user_info WHERE name = ?");
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            echo "このユーザー名はすでに登録されています。";
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user with 3000 points
        $insert = $this->pdo->prepare("INSERT INTO user_info (name, pass, points) VALUES (?, ?, 3000)");
        $insert->execute([$username, $hashedPassword]);

        // Get the newly created user's ID
        $userId = $this->pdo->lastInsertId();

        // Automatically log in the user after registration
        Session::start();
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['points'] = 3000;
        $_SESSION['logged_in'] = true;

        // Redirect to index page
        header('Location: ../index.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbManager = new DbManager();
    $register = new Register($dbManager);
    $register->registerUser($_POST['username'], $_POST['password']);
}