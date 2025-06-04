<?php
require_once __DIR__ . '/../core/DBManager.php';


class Register {
    private PDO $pdo;

    public function __construct(DbManager $dbManager) {
        $this->pdo = $dbManager->getConnection();
    }

    public function registerUser(string $username, string $password): void {
        if (empty($username) || empty($password)) {
            echo "ユーザー名とパスワードは必須です。";
            return;
        }

        
        $stmt = $this->pdo->prepare("SELECT id FROM user_info WHERE name = ?");
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            echo "このユーザー名はすでに登録されています。";
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // ポイントは300
        $insert = $this->pdo->prepare("INSERT INTO user_info (name, pass, points) VALUES (?, ?, 3000)");
        $insert->execute([$username, $hashedPassword]);

        echo "登録が完了しました！（ポイント: 3000）";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbManager = new DbManager();
    $register = new Register($dbManager);
    $register->registerUser($_POST['username'], $_POST['password']);
}
