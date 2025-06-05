<?php

require_once __DIR__ . '/../core/DBManager.php';
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

        // DEBUG: Show what we're searching for
        echo "DEBUG: Searching for username: " . htmlspecialchars($username) . "<br>";
        echo "DEBUG: Password length: " . strlen($password) . "<br>";
        echo "DEBUG: Password (first 3 chars): " . substr($password, 0, 3) . "...<br>";

        // Get user from database
        $stmt = $this->pdo->prepare("SELECT id, name, pass, points FROM user_info WHERE name = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "DEBUG: No user found in database<br>";
            echo "ユーザー名またはパスワードが間違っています。";
            return false;
        }

        echo "DEBUG: User found - ID: " . $user['id'] . ", Name: " . htmlspecialchars($user['name']) . "<br>";
        echo "DEBUG: Stored hash: " . $user['pass'] . "<br>";
        echo "DEBUG: Hash info: " . print_r(password_get_info($user['pass']), true) . "<br>";

        // Test password verification with detailed output
        echo "DEBUG: Testing password verification...<br>";
        $passwordMatch = password_verify($password, $user['pass']);
        echo "DEBUG: Password verification result: " . ($passwordMatch ? 'SUCCESS' : 'FAILED') . "<br>";

        // Additional debugging - try creating a new hash with the same password
        $testHash = password_hash($password, PASSWORD_DEFAULT);
        echo "DEBUG: New hash for same password: " . $testHash . "<br>";
        echo "DEBUG: New hash verifies: " . (password_verify($password, $testHash) ? 'YES' : 'NO') . "<br>";

        if (!$passwordMatch) {
            echo "<br><strong>SOLUTION: The password hash in the database doesn't match. Options:</strong><br>";
            echo "1. Re-register the user<br>";
            echo "2. Manually update the password hash in the database<br>";
            echo "3. Check if there are whitespace/encoding issues<br>";
            echo "<br>ユーザー名またはパスワードが間違っています。";
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

    // Method to manually fix a user's password (for debugging)
    public function fixUserPassword(string $username, string $newPassword): bool {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $stmt = $this->pdo->prepare("UPDATE user_info SET pass = ? WHERE name = ?");
        $result = $stmt->execute([$hashedPassword, $username]);
        
        if ($result) {
            echo "DEBUG: Password updated successfully for user: " . htmlspecialchars($username) . "<br>";
            echo "DEBUG: New hash: " . $hashedPassword . "<br>";
            return true;
        }
        
        return false;
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

// Handle password fix request (temporary debugging feature)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'fix_password') {
    if (isset($_POST['username']) && isset($_POST['new_password'])) {
        $dbManager = new DbManager();
        $login = new Login($dbManager);
        $login->fixUserPassword($_POST['username'], $_POST['new_password']);
        echo "<br><strong>Try logging in now with the updated password.</strong><br>";
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