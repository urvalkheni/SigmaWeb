<?php
/**
 * Login Page - PHP Sessions and Cookies
 * Student: Kheni Urval (24CE055)
 * Assignment 10: PHP Sessions and Cookies
 * Course: WDF: ITUE203
 * Medium-Level Implementation
 */

require_once 'session_manager.php';

// Redirect if already logged in
if (SessionManager::isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error_message = '';
$success_message = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember_me = isset($_POST['remember_me']);
    
    if (empty($username) || empty($password)) {
        $error_message = 'Please enter both username and password.';
    } else {
        if (SessionManager::login($username, $password, $remember_me)) {
            SessionManager::setFlashMessage('success', 'Login successful! Welcome back.');
            header('Location: dashboard.php');
            exit;
        } else {
            $error_message = 'Invalid username or password. Please try again.';
        }
    }
}

// Get demo users for display
$demo_users = getDemoUsers();
$client_info = getClientInfo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PHP Sessions & Cookies Demo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 600px;
        }

        .login-form {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-info {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 2em;
        }

        .student-info {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
            color: white;
            padding: 10px 20px;
            border-radius: 15px;
            display: inline-block;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .assignment-info {
            color: #7f8c8d;
            font-size: 0.9em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin: 0;
        }

        .login-btn {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert.error {
            background: #fdf2f2;
            color: #c0392b;
            border: 1px solid #e74c3c;
        }

        .alert.success {
            background: #f0f9f0;
            color: #229954;
            border: 1px solid #27ae60;
        }

        .demo-users {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .demo-users h3 {
            margin-bottom: 15px;
            color: white;
        }

        .user-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 8px;
            font-size: 0.9em;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-item:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .features {
            margin-top: 20px;
        }

        .features h3 {
            margin-bottom: 15px;
            color: white;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            color: rgba(255, 255, 255, 0.9);
        }

        .feature-item i {
            font-size: 1.2em;
        }

        .client-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
        }

        .client-info h4 {
            margin-bottom: 10px;
            color: white;
        }

        .client-info p {
            margin-bottom: 5px;
            font-size: 0.85em;
            color: rgba(255, 255, 255, 0.8);
        }

        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .login-form, .login-info {
                padding: 30px;
            }

            .header h1 {
                font-size: 1.5em;
            }
        }

        .forgot-password {
            text-align: center;
            margin-top: 15px;
        }

        .forgot-password a {
            color: #3498db;
            text-decoration: none;
            font-size: 0.9em;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .auto-fill {
            background: #ecf0f1;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            padding: 8px;
            margin-top: 10px;
            font-size: 0.85em;
            color: #7f8c8d;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .auto-fill:hover {
            background: #d5dbdb;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <div class="header">
                <h1>🔐 Login</h1>
                <div class="student-info">
                    👨‍💻 Kheni Urval (24CE055)
                </div>
                <div class="assignment-info">
                    Assignment 10: PHP Sessions & Cookies | Course: WDF: ITUE203
                </div>
            </div>

            <?php if ($error_message): ?>
                <div class="alert error">
                    ❌ <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="alert success">
                    ✅ <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="username">👤 Username:</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                        required
                        placeholder="Enter your username"
                    >
                    <div class="auto-fill" onclick="document.getElementById('username').value='admin'; document.getElementById('password').value='admin123';">
                        🚀 Quick fill: admin / admin123
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">🔒 Password:</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        placeholder="Enter your password"
                    >
                </div>

                <div class="checkbox-group">
                    <input 
                        type="checkbox" 
                        id="remember_me" 
                        name="remember_me"
                        <?php echo isset($_POST['remember_me']) ? 'checked' : ''; ?>
                    >
                    <label for="remember_me">🍪 Remember me for 30 days</label>
                </div>

                <button type="submit" class="login-btn">
                    🚀 Login
                </button>
            </form>

            <div class="forgot-password">
                <a href="#" onclick="alert('Demo: Password reset not implemented in this demo')">
                    Forgot your password?
                </a>
            </div>
        </div>

        <div class="login-info">
            <div class="demo-users">
                <h3>🎭 Demo Accounts</h3>
                <?php foreach ($demo_users as $username => $info): ?>
                    <div class="user-item" onclick="fillCredentials('<?php echo $username; ?>')">
                        <strong><?php echo ucfirst($username); ?></strong><br>
                        <small><?php echo htmlspecialchars($info); ?></small>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="features">
                <h3>✨ Features</h3>
                <div class="feature-item">
                    <span>🔐</span> Secure session management
                </div>
                <div class="feature-item">
                    <span>🍪</span> Remember me functionality
                </div>
                <div class="feature-item">
                    <span>⏰</span> Session timeout protection
                </div>
                <div class="feature-item">
                    <span>📊</span> Activity logging
                </div>
                <div class="feature-item">
                    <span>🛡️</span> Security measures
                </div>
                <div class="feature-item">
                    <span>💾</span> User preferences storage
                </div>
            </div>

            <div class="client-info">
                <h4>📱 Client Information</h4>
                <p><strong>IP:</strong> <?php echo htmlspecialchars($client_info['ip_address']); ?></p>
                <p><strong>Browser:</strong> <?php echo htmlspecialchars(substr($client_info['user_agent'], 0, 50)) . '...'; ?></p>
                <p><strong>Time:</strong> <?php echo htmlspecialchars($client_info['request_time']); ?></p>
            </div>
        </div>
    </div>

    <script>
        // Auto-fill credentials for demo
        function fillCredentials(username) {
            const passwords = {
                'admin': 'admin123',
                'kheni': 'password123',
                'user': 'user123',
                'demo': 'demo123'
            };
            
            document.getElementById('username').value = username;
            document.getElementById('password').value = passwords[username] || '';
            
            // Add visual feedback
            const userItems = document.querySelectorAll('.user-item');
            userItems.forEach(item => item.style.background = 'rgba(255, 255, 255, 0.1)');
            event.target.closest('.user-item').style.background = 'rgba(255, 255, 255, 0.3)';
        }

        // Show/hide password toggle
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            
            // Add show/hide password functionality
            const toggleBtn = document.createElement('button');
            toggleBtn.type = 'button';
            toggleBtn.innerHTML = '👁️';
            toggleBtn.style.cssText = 'position:absolute;right:10px;top:50%;transform:translateY(-50%);border:none;background:none;cursor:pointer;';
            
            passwordField.parentNode.style.position = 'relative';
            passwordField.parentNode.appendChild(toggleBtn);
            
            toggleBtn.addEventListener('click', function() {
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    toggleBtn.innerHTML = '🙈';
                } else {
                    passwordField.type = 'password';
                    toggleBtn.innerHTML = '👁️';
                }
            });

            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl+Enter to submit form
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    document.querySelector('form').submit();
                }
                
                // Quick demo login with F1
                if (e.key === 'F1') {
                    e.preventDefault();
                    fillCredentials('admin');
                }
            });

            console.log('Login page loaded by Kheni Urval (24CE055)');
            console.log('Available demo accounts:', <?php echo json_encode(array_keys($demo_users)); ?>);
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            if (!username || !password) {
                e.preventDefault();
                alert('Please enter both username and password.');
                return false;
            }
            
            if (password.length < 3) {
                e.preventDefault();
                alert('Password must be at least 3 characters long.');
                return false;
            }
            
            // Show loading state
            const submitBtn = document.querySelector('.login-btn');
            submitBtn.innerHTML = '⏳ Logging in...';
            submitBtn.disabled = true;
        });

        // Auto-focus username field
        document.getElementById('username').focus();
    </script>
</body>
</html>
