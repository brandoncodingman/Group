<?php

require_once __DIR__ . '/../core/DbManager.php';
Class Login {

    private PDO $pdo;

    public function __construct(DbManager $dbManager) {
        $this->pdo = $dbManager->getConnection();
    }

    public function loginUser(string $username, string $password): bool {
        if (empty($username) || empty($password)) {
            echo "ユーザー名とパスワードは必須です。";
            return false;
        }

        // Get user from database
        $stmt = $this->pdo->prepare("SELECT id, name, pass, points FROM user_info WHERE name = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "ユーザー名またはパスワードが間違っています。";
            return false;
        }

        // Verify password
        if (!password_verify($password, $user['pass'])) {
            echo "ユーザー名またはパスワードが間違っています。";
            return false;
        }

        // Clean session and login
        $this->cleanSession();
        session_start();
        session_regenerate_id(true);
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['name'];
        $_SESSION['points'] = $user['points'];
        $_SESSION['logged_in'] = true;

        header('Location: ../index.php');
        exit();
    }

    // Method to manually fix a user's password (for debugging - remove in production)
    public function fixUserPassword(string $username, string $newPassword): bool {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $stmt = $this->pdo->prepare("UPDATE user_info SET pass = ? WHERE name = ?");
        $result = $stmt->execute([$hashedPassword, $username]);
        
        return $result;
    }

    private function cleanSession(): void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        $_SESSION = array();
    }

    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        
        header('Location: ../login_register.php');
        exit();
    }
}

// Handle password fix request (remove in production)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'fix_password') {
    if (isset($_POST['username']) && isset($_POST['new_password'])) {
        $dbManager = new DbManager();
        $login = new Login($dbManager);
        if ($login->fixUserPassword($_POST['username'], $_POST['new_password'])) {
            echo "Password updated successfully. Try logging in now.";
        } else {
            echo "Failed to update password.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
    $dbManager = new DbManager();
    $login = new Login($dbManager);
    $login->logout();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password']) && !isset($_POST['action'])) {
    $dbManager = new DbManager();
    $login = new Login($dbManager);
    $login->loginUser($_POST['username'], $_POST['password']);
}
?>