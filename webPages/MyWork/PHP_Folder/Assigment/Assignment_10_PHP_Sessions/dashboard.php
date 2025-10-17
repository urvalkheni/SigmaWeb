<?php
/**
 * Dashboard - PHP Sessions and Cookies Demo
 * Student: Kheni Urval (24CE055)
 * Assignment 10: PHP Sessions and Cookies
 * Course: WDF: ITUE203
 * Medium-Level Implementation
 */

require_once 'session_manager.php';

// Redirect if not logged in
if (!SessionManager::isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Handle logout
if (isset($_GET['logout'])) {
    SessionManager::logout();
    header('Location: login.php');
    exit;
}

// Handle preference updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_preferences'])) {
        $theme = $_POST['theme'] ?? 'light';
        $language = $_POST['language'] ?? 'en';
        $notifications = isset($_POST['notifications']) ? 'enabled' : 'disabled';
        
        // Store in session
        SessionManager::setUserPreference('theme', $theme);
        SessionManager::setUserPreference('language', $language);
        SessionManager::setUserPreference('notifications', $notifications);
        
        // Store in cookies for persistence
        CookieManager::setTheme($theme);
        CookieManager::setLanguage($language);
        CookieManager::set('notifications', $notifications, 2592000); // 30 days
        
        SessionManager::setFlashMessage('success', 'Preferences updated successfully!');
        header('Location: dashboard.php');
        exit;
    }
}

// Get current user data
$current_user = SessionManager::getCurrentUser();
$session_stats = SessionManager::getSessionStats();
$flash_messages = SessionManager::getFlashMessages();
$user_preferences = SessionManager::getAllUserPreferences();

// Get current theme from cookie or session
$current_theme = CookieManager::getTheme();
$current_language = CookieManager::getLanguage();
$notifications_enabled = CookieManager::get('notifications', 'enabled') === 'enabled';

// Sample session data for demonstration
$sample_data = [
    'cart_items' => $_SESSION['cart_items'] ?? [],
    'recent_views' => $_SESSION['recent_views'] ?? [],
    'search_history' => $_SESSION['search_history'] ?? []
];

// Add some sample data if none exists
if (empty($sample_data['cart_items'])) {
    $_SESSION['cart_items'] = [
        ['id' => 1, 'name' => 'Web Development Book', 'price' => 29.99],
        ['id' => 2, 'name' => 'PHP Programming Guide', 'price' => 39.99]
    ];
    $sample_data['cart_items'] = $_SESSION['cart_items'];
}

if (empty($sample_data['recent_views'])) {
    $_SESSION['recent_views'] = [
        'JavaScript Tutorial',
        'PHP Sessions Guide',
        'Cookie Management',
        'Web Security Best Practices'
    ];
    $sample_data['recent_views'] = $_SESSION['recent_views'];
}

if (empty($sample_data['search_history'])) {
    $_SESSION['search_history'] = [
        'PHP sessions',
        'cookie security',
        'web authentication',
        'session timeout'
    ];
    $sample_data['search_history'] = $_SESSION['search_history'];
}

$client_info = getClientInfo();
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo htmlspecialchars($current_theme); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PHP Sessions & Cookies Demo</title>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --error-color: #e74c3c;
            --text-color: #2c3e50;
            --bg-color: #ecf0f1;
            --card-bg: white;
            --border-color: #e0e0e0;
        }

        [data-theme="dark"] {
            --text-color: #ecf0f1;
            --bg-color: #2c3e50;
            --card-bg: #34495e;
            --border-color: #4a5568;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            transition: all 0.3s ease;
        }

        .navbar {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            font-size: 1.5em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 15px;
            border-radius: 20px;
        }

        .logout-btn {
            background: var(--error-color);
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .card h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-item {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .stat-item .value {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-item .label {
            font-size: 0.9em;
            opacity: 0.9;
        }

        .info-grid {
            display: grid;
            gap: 10px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background: var(--bg-color);
            border-radius: 5px;
        }

        .info-item .label {
            font-weight: 500;
        }

        .info-item .value {
            color: var(--primary-color);
        }

        .preferences-form {
            display: grid;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-weight: 500;
            color: var(--text-color);
        }

        .form-group select,
        .form-group input {
            padding: 10px;
            border: 2px solid var(--border-color);
            border-radius: 5px;
            background: var(--card-bg);
            color: var(--text-color);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            background: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .flash-messages {
            margin-bottom: 20px;
        }

        .flash-message {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .flash-message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .flash-message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .sample-data {
            margin-top: 15px;
        }

        .data-list {
            background: var(--bg-color);
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
        }

        .data-item {
            padding: 8px 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .data-item:last-child {
            border-bottom: none;
        }

        .theme-toggle {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .full-width {
            grid-column: 1 / -1;
        }

        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .navbar-content {
                flex-direction: column;
                gap: 15px;
            }

            .navbar-actions {
                flex-wrap: wrap;
                justify-content: center;
            }

            .stat-grid {
                grid-template-columns: 1fr;
            }
        }

        .security-info {
            background: linear-gradient(45deg, var(--warning-color), #e67e22);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
        }

        .security-info h4 {
            margin-bottom: 10px;
        }

        .security-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .btn-secondary {
            background: var(--warning-color);
        }

        .btn-danger {
            background: var(--error-color);
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: var(--border-color);
            border-radius: 4px;
            margin-top: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(45deg, var(--success-color), #229954);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .cookie-info {
            background: linear-gradient(45deg, #9b59b6, #8e44ad);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
        }

        .cookie-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .cookie-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <h1>
                🏠 Dashboard
                <span style="font-size: 0.7em; font-weight: normal;">by Kheni Urval (24CE055)</span>
            </h1>
            <div class="navbar-actions">
                <button class="theme-toggle" onclick="toggleTheme()">
                    🌓 Toggle Theme
                </button>
                <div class="user-info">
                    <span>👤 <?php echo htmlspecialchars($current_user['role']); ?></span>
                    <span>|</span>
                    <span><?php echo htmlspecialchars($session_stats['username']); ?></span>
                </div>
                <a href="?logout=1" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">
                    🚪 Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Flash Messages -->
        <?php if (!empty($flash_messages)): ?>
            <div class="flash-messages">
                <?php foreach ($flash_messages as $message): ?>
                    <div class="flash-message <?php echo htmlspecialchars($message['type']); ?>">
                        <span><?php echo $message['type'] === 'success' ? '✅' : '❌'; ?></span>
                        <?php echo htmlspecialchars($message['message']); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="dashboard-grid">
            <!-- Session Statistics -->
            <div class="card">
                <h2>📊 Session Statistics</h2>
                <div class="stat-grid">
                    <div class="stat-item">
                        <div class="value"><?php echo formatDuration($session_stats['session_duration']); ?></div>
                        <div class="label">Session Duration</div>
                    </div>
                    <div class="stat-item">
                        <div class="value"><?php echo formatDuration($session_stats['time_since_activity']); ?></div>
                        <div class="label">Last Activity</div>
                    </div>
                </div>
                
                <div class="info-grid">
                    <div class="info-item">
                        <span class="label">Login Time:</span>
                        <span class="value"><?php echo date('Y-m-d H:i:s', $session_stats['login_time']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Session ID:</span>
                        <span class="value"><?php echo substr($session_stats['session_id'], 0, 16) . '...'; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Login IP:</span>
                        <span class="value"><?php echo htmlspecialchars($session_stats['login_ip']); ?></span>
                    </div>
                </div>

                <div class="security-info">
                    <h4>🛡️ Security Status</h4>
                    <div class="security-item">
                        <span>✅</span> Session encryption enabled
                    </div>
                    <div class="security-item">
                        <span>✅</span> HttpOnly cookies active
                    </div>
                    <div class="security-item">
                        <span>✅</span> Session timeout configured
                    </div>
                    <div class="security-item">
                        <span>✅</span> IP address validation
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <div class="card">
                <h2>👤 User Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="label">Username:</span>
                        <span class="value"><?php echo htmlspecialchars($session_stats['username']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Email:</span>
                        <span class="value"><?php echo htmlspecialchars($current_user['email']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Role:</span>
                        <span class="value"><?php echo htmlspecialchars($current_user['role']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Account Created:</span>
                        <span class="value"><?php echo htmlspecialchars($current_user['created']); ?></span>
                    </div>
                </div>

                <div class="cookie-info">
                    <h4>🍪 Cookie Information</h4>
                    <div class="cookie-item">
                        <span>Theme:</span>
                        <span><?php echo htmlspecialchars($current_theme); ?></span>
                    </div>
                    <div class="cookie-item">
                        <span>Language:</span>
                        <span><?php echo htmlspecialchars($current_language); ?></span>
                    </div>
                    <div class="cookie-item">
                        <span>Notifications:</span>
                        <span><?php echo $notifications_enabled ? 'Enabled' : 'Disabled'; ?></span>
                    </div>
                    <div class="cookie-item">
                        <span>Remember Me:</span>
                        <span><?php echo CookieManager::exists('remember_me') ? 'Active' : 'Inactive'; ?></span>
                    </div>
                </div>
            </div>

            <!-- User Preferences -->
            <div class="card">
                <h2>⚙️ User Preferences</h2>
                <form method="POST" class="preferences-form">
                    <div class="form-group">
                        <label for="theme">🎨 Theme:</label>
                        <select id="theme" name="theme">
                            <option value="light" <?php echo $current_theme === 'light' ? 'selected' : ''; ?>>Light</option>
                            <option value="dark" <?php echo $current_theme === 'dark' ? 'selected' : ''; ?>>Dark</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="language">🌐 Language:</label>
                        <select id="language" name="language">
                            <option value="en" <?php echo $current_language === 'en' ? 'selected' : ''; ?>>English</option>
                            <option value="es" <?php echo $current_language === 'es' ? 'selected' : ''; ?>>Español</option>
                            <option value="fr" <?php echo $current_language === 'fr' ? 'selected' : ''; ?>>Français</option>
                            <option value="de" <?php echo $current_language === 'de' ? 'selected' : ''; ?>>Deutsch</option>
                        </select>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="notifications" name="notifications" <?php echo $notifications_enabled ? 'checked' : ''; ?>>
                        <label for="notifications">🔔 Enable notifications</label>
                    </div>
                    
                    <button type="submit" name="update_preferences" class="btn">
                        💾 Save Preferences
                    </button>
                </form>

                <div class="action-buttons">
                    <button class="btn btn-secondary" onclick="clearSessionData()">
                        🗑️ Clear Session Data
                    </button>
                    <button class="btn btn-danger" onclick="clearAllCookies()">
                        🍪 Clear All Cookies
                    </button>
                </div>
            </div>

            <!-- Sample Session Data -->
            <div class="card">
                <h2>💾 Sample Session Data</h2>
                
                <div class="sample-data">
                    <h4>🛒 Shopping Cart (<?php echo count($sample_data['cart_items']); ?> items)</h4>
                    <div class="data-list">
                        <?php foreach ($sample_data['cart_items'] as $item): ?>
                            <div class="data-item">
                                <span><?php echo htmlspecialchars($item['name']); ?></span>
                                <span>$<?php echo number_format($item['price'], 2); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="sample-data">
                    <h4>👁️ Recent Views</h4>
                    <div class="data-list">
                        <?php foreach ($sample_data['recent_views'] as $index => $view): ?>
                            <div class="data-item">
                                <span><?php echo htmlspecialchars($view); ?></span>
                                <span><?php echo $index + 1; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="sample-data">
                    <h4>🔍 Search History</h4>
                    <div class="data-list">
                        <?php foreach ($sample_data['search_history'] as $search): ?>
                            <div class="data-item">
                                <span><?php echo htmlspecialchars($search); ?></span>
                                <span>🔍</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Client Information -->
            <div class="card full-width">
                <h2>🌐 Client & Server Information</h2>
                <div class="stat-grid">
                    <div class="info-item">
                        <span class="label">IP Address:</span>
                        <span class="value"><?php echo htmlspecialchars($client_info['ip_address']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">User Agent:</span>
                        <span class="value"><?php echo htmlspecialchars(substr($client_info['user_agent'], 0, 60)) . '...'; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Request Time:</span>
                        <span class="value"><?php echo htmlspecialchars($client_info['request_time']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Server:</span>
                        <span class="value">PHP <?php echo phpversion(); ?></span>
                    </div>
                </div>

                <div class="security-info">
                    <h4>🔧 Session Configuration</h4>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="label">Session Timeout:</span>
                            <span class="value"><?php echo ini_get('session.gc_maxlifetime'); ?> seconds</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Cookie Lifetime:</span>
                            <span class="value"><?php echo ini_get('session.cookie_lifetime'); ?> seconds</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Session Save Path:</span>
                            <span class="value"><?php echo session_save_path() ?: 'Default'; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="label">Session Name:</span>
                            <span class="value"><?php echo session_name(); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-theme', newTheme);
            
            // Update form
            document.getElementById('theme').value = newTheme;
            
            // Save to cookie
            document.cookie = `user_theme=${newTheme}; path=/; max-age=2592000`;
            
            console.log(`Theme switched to: ${newTheme}`);
        }

        function clearSessionData() {
            if (confirm('Are you sure you want to clear all session data? This will remove cart items, search history, etc.')) {
                fetch('session_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=clear_session_data'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Session data cleared successfully!');
                        location.reload();
                    } else {
                        alert('Error clearing session data: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while clearing session data.');
                });
            }
        }

        function clearAllCookies() {
            if (confirm('Are you sure you want to clear all cookies? This will reset all your preferences.')) {
                // Clear client-side cookies
                document.cookie.split(";").forEach(function(c) { 
                    document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); 
                });
                
                // Clear server-side cookies
                fetch('session_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=clear_cookies'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('All cookies cleared successfully!');
                        location.reload();
                    } else {
                        alert('Error clearing cookies: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while clearing cookies.');
                });
            }
        }

        // Auto-refresh session timer
        function updateSessionTimer() {
            const sessionStart = <?php echo $session_stats['login_time']; ?>;
            const lastActivity = <?php echo $session_stats['last_activity']; ?>;
            const now = Math.floor(Date.now() / 1000);
            
            const sessionDuration = now - sessionStart;
            const timeSinceActivity = now - lastActivity;
            
            // Update display if elements exist
            const sessionDurationElement = document.querySelector('.stat-item .value');
            if (sessionDurationElement) {
                sessionDurationElement.textContent = formatDuration(sessionDuration);
            }
        }

        function formatDuration(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            
            if (hours > 0) {
                return `${hours}h ${minutes}m ${secs}s`;
            } else if (minutes > 0) {
                return `${minutes}m ${secs}s`;
            } else {
                return `${secs}s`;
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Dashboard loaded by Kheni Urval (24CE055)');
            console.log('Session ID:', '<?php echo session_id(); ?>');
            console.log('Current theme:', '<?php echo $current_theme; ?>');
            
            // Update timer every second
            setInterval(updateSessionTimer, 1000);
            
            // Warn before session expires
            const sessionTimeout = <?php echo ini_get('session.gc_maxlifetime'); ?>;
            const warningTime = sessionTimeout - 300; // 5 minutes before expiry
            
            setTimeout(() => {
                if (confirm('Your session will expire in 5 minutes. Would you like to extend it?')) {
                    // Extend session by making a request
                    fetch('session_actions.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'action=extend_session'
                    });
                }
            }, warningTime * 1000);
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 't':
                        e.preventDefault();
                        toggleTheme();
                        break;
                    case 'l':
                        e.preventDefault();
                        if (confirm('Logout?')) {
                            window.location.href = '?logout=1';
                        }
                        break;
                }
            }
        });
    </script>
</body>
</html>
