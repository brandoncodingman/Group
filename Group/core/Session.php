<?php
Class Session {
    
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function isLoggedIn(): bool {
        self::start();
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public static function getUsername(): ?string {
        self::start();
        return $_SESSION['username'] ?? null;
    }

    public static function getUserId(): ?int {
        self::start();
        return $_SESSION['user_id'] ?? null;
    }

    public static function getPoints(): ?int {
        self::start();
        return $_SESSION['points'] ?? null;
    }

    public static function updatePoints(int $points): void {
        self::start();
        $_SESSION['points'] = $points;
    }

    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            header('Location: login_register.php');
            exit();
        }
    }

    // New method to redirect non-logged-in users to login_register.php
    public static function requireLoginForAllPages(): void {
        if (!self::isLoggedIn()) {
            // Get the current page name
            $currentPage = basename($_SERVER['PHP_SELF']);
            
            // Allow access to login/register related pages
            $allowedPages = [
                'login_register.php',
                'login.php', 
                'register.php'
            ];
            
            if (!in_array($currentPage, $allowedPages)) {
                header('Location: login_register.php');
                exit();
            }
        }
    }

    public static function getLoginStatus(): array {
        self::start();
        if (self::isLoggedIn()) {
            return [
                'logged_in' => true,
                'username' => self::getUsername(),
                'points' => self::getPoints()
            ];
        }
        return ['logged_in' => false];
    }

    public static function logout(): void {
        self::start();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        
        // Redirect to login page
        header('Location: login_register.php');
        exit();
    }
}