<?php
/**
 * Session Configuration and Management
 * Student: Kheni Urval (24CE055)
 * Assignment 10: PHP Sessions and Cookies
 * Course: WDF: ITUE203
 * Medium-Level Implementation
 */

// Session configuration - MUST be set BEFORE session_start()
ini_set('session.gc_maxlifetime', 3600); // 1 hour garbage collection
ini_set('session.cookie_lifetime', 3600); // 1 hour cookie lifetime

// Start session with custom configuration
session_start([
    'cookie_lifetime' => 3600, // 1 hour
    'cookie_httponly' => true,
    'cookie_secure' => false, // Set to true for HTTPS
    'cookie_samesite' => 'Lax',
    'use_strict_mode' => true,
    'use_only_cookies' => true
]);

/**
 * User data for authentication (in real app, this would be from database)
 */
$users = [
    'admin' => [
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
        'email' => 'admin@example.com',
        'role' => 'Administrator',
        'created' => '2024-01-15'
    ],
    'kheni' => [
        'password' => password_hash('password123', PASSWORD_DEFAULT),
        'email' => 'kheni.urval@example.com',
        'role' => 'Student',
        'created' => '2024-01-20'
    ],
    'user' => [
        'password' => password_hash('user123', PASSWORD_DEFAULT),
        'email' => 'user@example.com',
        'role' => 'User',
        'created' => '2024-01-25'
    ],
    'demo' => [
        'password' => password_hash('demo123', PASSWORD_DEFAULT),
        'email' => 'demo@example.com',
        'role' => 'Demo User',
        'created' => '2024-02-01'
    ]
];

/**
 * Session Management Class
 */
class SessionManager {
    private static $sessionTimeout = 3600; // 1 hour
    private static $rememberMeTimeout = 2592000; // 30 days
    
    /**
     * Initialize session with security measures
     */
    public static function initialize() {
        // Check if session is expired
        if (self::isSessionExpired()) {
            self::destroySession();
            return false;
        }
        
        // Update last activity time
        $_SESSION['last_activity'] = time();
        
        // Regenerate session ID periodically for security
        if (!isset($_SESSION['created'])) {
            $_SESSION['created'] = time();
        } elseif (time() - $_SESSION['created'] > 1800) { // 30 minutes
            session_regenerate_id(true);
            $_SESSION['created'] = time();
        }
        
        return true;
    }
    
    /**
     * Check if session is expired
     */
    public static function isSessionExpired() {
        if (isset($_SESSION['last_activity'])) {
            return (time() - $_SESSION['last_activity']) > self::$sessionTimeout;
        }
        return false;
    }
    
    /**
     * Check if user is logged in
     */
    public static function isLoggedIn() {
        return isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
    }
    
    /**
     * Login user with credentials
     */
    public static function login($username, $password, $rememberMe = false) {
        global $users;
        
        if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
            // Set session variables
            $_SESSION['user_logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_data'] = $users[$username];
            $_SESSION['login_time'] = time();
            $_SESSION['last_activity'] = time();
            $_SESSION['created'] = time();
            $_SESSION['login_ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            
            // Handle "Remember Me" functionality
            if ($rememberMe) {
                self::setRememberMeCookie($username);
            }
            
            // Log successful login
            self::logActivity($username, 'login', 'Successful login');
            
            return true;
        }
        
        // Log failed login attempt
        self::logActivity($username, 'login_failed', 'Failed login attempt');
        return false;
    }
    
    /**
     * Logout user and cleanup
     */
    public static function logout() {
        if (self::isLoggedIn()) {
            $username = $_SESSION['username'];
            
            // Log logout activity
            self::logActivity($username, 'logout', 'User logged out');
            
            // Clear remember me cookie
            self::clearRememberMeCookie();
            
            // Destroy session
            self::destroySession();
            
            return true;
        }
        return false;
    }
    
    /**
     * Destroy session completely
     */
    public static function destroySession() {
        // Unset all session variables
        $_SESSION = array();
        
        // Delete session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroy session
        session_destroy();
    }
    
    /**
     * Set remember me cookie
     */
    private static function setRememberMeCookie($username) {
        $token = bin2hex(random_bytes(32));
        $cookieValue = $username . ':' . $token;
        $hashedCookie = hash('sha256', $cookieValue);
        
        // Store in cookie (encrypted for security)
        setcookie('remember_me', $hashedCookie, 
                 time() + self::$rememberMeTimeout, 
                 '/', '', false, true);
        
        // In real application, store token in database
        $_SESSION['remember_token'] = $token;
    }
    
    /**
     * Check remember me cookie
     */
    public static function checkRememberMeCookie() {
        if (isset($_COOKIE['remember_me']) && !self::isLoggedIn()) {
            // In real application, validate token against database
            if (isset($_SESSION['remember_token'])) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Clear remember me cookie
     */
    private static function clearRememberMeCookie() {
        if (isset($_COOKIE['remember_me'])) {
            setcookie('remember_me', '', time() - 3600, '/', '', false, true);
            unset($_COOKIE['remember_me']);
        }
        unset($_SESSION['remember_token']);
    }
    
    /**
     * Get current user data
     */
    public static function getCurrentUser() {
        if (self::isLoggedIn()) {
            return $_SESSION['user_data'];
        }
        return null;
    }
    
    /**
     * Get session statistics
     */
    public static function getSessionStats() {
        if (self::isLoggedIn()) {
            $loginTime = isset($_SESSION['login_time']) ? $_SESSION['login_time'] : time();
            $lastActivity = isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : time();
            
            return [
                'username' => $_SESSION['username'],
                'login_time' => $loginTime,
                'last_activity' => $lastActivity,
                'session_duration' => time() - $loginTime,
                'time_since_activity' => time() - $lastActivity,
                'session_id' => session_id(),
                'login_ip' => $_SESSION['login_ip'] ?? 'Unknown',
                'user_agent' => $_SESSION['user_agent'] ?? 'Unknown'
            ];
        }
        return null;
    }
    
    /**
     * Log user activity (simple file-based logging)
     */
    private static function logActivity($username, $action, $description) {
        $logEntry = sprintf(
            "[%s] User: %s | Action: %s | Description: %s | IP: %s\n",
            date('Y-m-d H:i:s'),
            $username,
            $action,
            $description,
            $_SERVER['REMOTE_ADDR']
        );
        
        // Write to log file (in real app, use proper logging library)
        file_put_contents(__DIR__ . '/session_logs.txt', $logEntry, FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Clean expired sessions (garbage collection)
     */
    public static function cleanExpiredSessions() {
        // This would typically be handled by PHP's garbage collection
        // In a real application, you might implement custom cleanup
        if (rand(1, 100) <= 5) { // 5% chance to trigger cleanup
            session_gc();
        }
    }
    
    /**
     * Set flash message for one-time display
     */
    public static function setFlashMessage($type, $message) {
        $_SESSION['flash_messages'][] = [
            'type' => $type,
            'message' => $message,
            'timestamp' => time()
        ];
    }
    
    /**
     * Get and clear flash messages
     */
    public static function getFlashMessages() {
        $messages = $_SESSION['flash_messages'] ?? [];
        unset($_SESSION['flash_messages']);
        return $messages;
    }
    
    /**
     * Store user preferences in session
     */
    public static function setUserPreference($key, $value) {
        if (!isset($_SESSION['user_preferences'])) {
            $_SESSION['user_preferences'] = [];
        }
        $_SESSION['user_preferences'][$key] = $value;
    }
    
    /**
     * Get user preference from session
     */
    public static function getUserPreference($key, $default = null) {
        return $_SESSION['user_preferences'][$key] ?? $default;
    }
    
    /**
     * Get all user preferences
     */
    public static function getAllUserPreferences() {
        return $_SESSION['user_preferences'] ?? [];
    }
}

// Initialize session on every page load
SessionManager::initialize();

/**
 * Cookie Management Class
 */
class CookieManager {
    /**
     * Set a secure cookie
     */
    public static function set($name, $value, $expiry = 3600, $httpOnly = true) {
        return setcookie($name, $value, time() + $expiry, '/', '', false, $httpOnly);
    }
    
    /**
     * Get cookie value
     */
    public static function get($name, $default = null) {
        return $_COOKIE[$name] ?? $default;
    }
    
    /**
     * Delete cookie
     */
    public static function delete($name) {
        if (isset($_COOKIE[$name])) {
            setcookie($name, '', time() - 3600, '/');
            unset($_COOKIE[$name]);
            return true;
        }
        return false;
    }
    
    /**
     * Check if cookie exists
     */
    public static function exists($name) {
        return isset($_COOKIE[$name]);
    }
    
    /**
     * Set user theme preference
     */
    public static function setTheme($theme) {
        self::set('user_theme', $theme, 2592000); // 30 days
    }
    
    /**
     * Get user theme preference
     */
    public static function getTheme() {
        return self::get('user_theme', 'light');
    }
    
    /**
     * Set language preference
     */
    public static function setLanguage($language) {
        self::set('user_language', $language, 2592000); // 30 days
    }
    
    /**
     * Get language preference
     */
    public static function getLanguage() {
        return self::get('user_language', 'en');
    }
}

// Function to get available demo users
function getDemoUsers() {
    return [
        'admin' => 'Password: admin123 | Role: Administrator',
        'kheni' => 'Password: password123 | Role: Student (24CE055)',
        'user' => 'Password: user123 | Role: User',
        'demo' => 'Password: demo123 | Role: Demo User'
    ];
}

// Function to format time duration
function formatDuration($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;
    
    if ($hours > 0) {
        return sprintf('%d hours, %d minutes, %d seconds', $hours, $minutes, $seconds);
    } elseif ($minutes > 0) {
        return sprintf('%d minutes, %d seconds', $minutes, $seconds);
    } else {
        return sprintf('%d seconds', $seconds);
    }
}

// Function to get client information
function getClientInfo() {
    return [
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'accept_language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'Unknown',
        'referer' => $_SERVER['HTTP_REFERER'] ?? 'Direct',
        'request_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME'])
    ];
}

echo "<!-- Session Management System Loaded by Kheni Urval (24CE055) -->\n";
?>
