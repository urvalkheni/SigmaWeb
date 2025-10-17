<?php
/**
 * Index Page - PHP Sessions and Cookies Demo
 * Student: Kheni Urval (24CE055)
 * Assignment 10: PHP Sessions and Cookies
 * Course: WDF: ITUE203
 * Medium-Level Implementation
 */

require_once 'session_manager.php';

// Check if user is already logged in
$is_logged_in = SessionManager::isLoggedIn();

// Get some basic information
$client_info = getClientInfo();
$demo_users = getDemoUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Sessions & Cookies Demo - Assignment 10</title>
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

        .main-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            min-height: 600px;
        }

        .header {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .student-info {
            background: rgba(255, 255, 255, 0.2);
            padding: 15px 30px;
            border-radius: 25px;
            display: inline-block;
            margin: 15px 0;
            font-weight: 600;
            font-size: 1.1em;
        }

        .assignment-info {
            font-size: 1em;
            opacity: 0.9;
            margin-top: 10px;
        }

        .content {
            padding: 40px;
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .welcome-section h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 2em;
        }

        .welcome-section p {
            color: #7f8c8d;
            font-size: 1.1em;
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto 30px;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
        }

        .btn-success {
            background: linear-gradient(45deg, #27ae60, #229954);
            color: white;
        }

        .btn-info {
            background: linear-gradient(45deg, #17a2b8, #138496);
            color: white;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .feature-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .feature-card .icon {
            font-size: 3em;
            margin-bottom: 15px;
        }

        .feature-card h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.3em;
        }

        .feature-card p {
            color: #7f8c8d;
            line-height: 1.5;
        }

        .demo-accounts {
            background: linear-gradient(45deg, #9b59b6, #8e44ad);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .demo-accounts h3 {
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.5em;
        }

        .accounts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .account-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .account-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.02);
        }

        .account-item .username {
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .account-item .details {
            font-size: 0.9em;
            opacity: 0.9;
        }

        .technical-info {
            background: #2c3e50;
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
        }

        .technical-info h3 {
            margin-bottom: 20px;
            text-align: center;
            color: #3498db;
        }

        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .tech-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 8px;
        }

        .tech-item .label {
            font-weight: bold;
            color: #3498db;
            margin-bottom: 5px;
        }

        .tech-item .value {
            opacity: 0.9;
            word-break: break-all;
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
            margin: 10px 0;
        }

        .status-logged-in {
            background: #d4edda;
            color: #155724;
        }

        .status-logged-out {
            background: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 2em;
                flex-direction: column;
                gap: 10px;
            }

            .content {
                padding: 30px 20px;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .accounts-grid {
                grid-template-columns: 1fr;
            }

            .tech-grid {
                grid-template-columns: 1fr;
            }
        }

        .footer {
            background: #34495e;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="header">
            <h1>
                🔐 PHP Sessions & Cookies Demo
            </h1>
            <div class="student-info">
                👨‍💻 Student: Kheni Urval (24CE055)
            </div>
            <div class="assignment-info">
                Assignment 10: PHP Sessions and Cookies | Course: WDF: ITUE203 | Medium-Level Implementation
            </div>
        </div>

        <div class="content">
            <div class="welcome-section">
                <h2>Welcome to the Session Management Demo</h2>
                <p>
                    This comprehensive demonstration showcases advanced PHP session management, 
                    secure cookie handling, user authentication, and session security features. 
                    Explore the features below to see how modern web applications handle user sessions and persistent data.
                </p>

                <div class="status-indicator <?php echo $is_logged_in ? 'status-logged-in' : 'status-logged-out'; ?>">
                    <span><?php echo $is_logged_in ? '✅' : '❌'; ?></span>
                    <span>Status: <?php echo $is_logged_in ? 'Logged In' : 'Not Logged In'; ?></span>
                </div>
            </div>

            <div class="action-buttons">
                <?php if ($is_logged_in): ?>
                    <a href="dashboard.php" class="btn btn-success">
                        🏠 Go to Dashboard
                    </a>
                    <a href="login.php?logout=1" class="btn btn-info">
                        🚪 Logout
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary">
                        🔐 Login
                    </a>
                    <a href="#demo-accounts" class="btn btn-info" onclick="scrollToSection('#demo-accounts')">
                        🎭 View Demo Accounts
                    </a>
                <?php endif; ?>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="icon">🛡️</div>
                    <h3>Secure Session Management</h3>
                    <p>Advanced session configuration with security measures including session timeout, IP validation, and secure cookie settings.</p>
                </div>

                <div class="feature-card">
                    <div class="icon">🍪</div>
                    <h3>Cookie Management</h3>
                    <p>Comprehensive cookie handling with HttpOnly flags, secure settings, and persistent user preferences storage.</p>
                </div>

                <div class="feature-card">
                    <div class="icon">🔑</div>
                    <h3>User Authentication</h3>
                    <p>Robust login system with password hashing, "remember me" functionality, and activity logging.</p>
                </div>

                <div class="feature-card">
                    <div class="icon">⏰</div>
                    <h3>Session Timeout</h3>
                    <p>Automatic session expiration with configurable timeouts and grace period warnings for active users.</p>
                </div>

                <div class="feature-card">
                    <div class="icon">📊</div>
                    <h3>Activity Monitoring</h3>
                    <p>Real-time session statistics, user activity tracking, and comprehensive logging for security analysis.</p>
                </div>

                <div class="feature-card">
                    <div class="icon">⚙️</div>
                    <h3>User Preferences</h3>
                    <p>Persistent user settings stored in both sessions and cookies, including theme, language, and notification preferences.</p>
                </div>
            </div>

            <div class="demo-accounts" id="demo-accounts">
                <h3>🎭 Demo User Accounts</h3>
                <p style="text-align: center; margin-bottom: 20px; opacity: 0.9;">
                    Try logging in with any of these pre-configured demo accounts:
                </p>
                <div class="accounts-grid">
                    <?php foreach ($demo_users as $username => $info): ?>
                        <div class="account-item">
                            <div class="username">👤 <?php echo ucfirst($username); ?></div>
                            <div class="details"><?php echo htmlspecialchars($info); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="technical-info">
                <h3>🔧 Technical Information</h3>
                <div class="tech-grid">
                    <div class="tech-item">
                        <div class="label">Session Status:</div>
                        <div class="value"><?php echo session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Inactive'; ?></div>
                    </div>
                    <div class="tech-item">
                        <div class="label">Session ID:</div>
                        <div class="value"><?php echo $is_logged_in ? substr(session_id(), 0, 16) . '...' : 'Not started'; ?></div>
                    </div>
                    <div class="tech-item">
                        <div class="label">PHP Version:</div>
                        <div class="value"><?php echo phpversion(); ?></div>
                    </div>
                    <div class="tech-item">
                        <div class="label">Client IP:</div>
                        <div class="value"><?php echo htmlspecialchars($client_info['ip_address']); ?></div>
                    </div>
                    <div class="tech-item">
                        <div class="label">User Agent:</div>
                        <div class="value"><?php echo htmlspecialchars(substr($client_info['user_agent'], 0, 50)) . '...'; ?></div>
                    </div>
                    <div class="tech-item">
                        <div class="label">Request Time:</div>
                        <div class="value"><?php echo htmlspecialchars($client_info['request_time']); ?></div>
                    </div>
                    <div class="tech-item">
                        <div class="label">Session Timeout:</div>
                        <div class="value"><?php echo ini_get('session.gc_maxlifetime'); ?> seconds</div>
                    </div>
                    <div class="tech-item">
                        <div class="label">Cookie Lifetime:</div>
                        <div class="value"><?php echo ini_get('session.cookie_lifetime'); ?> seconds</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🎓 Assignment 10: PHP Sessions and Cookies - Implementation by Kheni Urval (24CE055)</p>
            <p>📚 Course: WDF: ITUE203 | Medium-Level PHP Session Management Demo</p>
        </div>
    </div>

    <script>
        function scrollToSection(selector) {
            document.querySelector(selector).scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('PHP Sessions & Cookies Demo loaded by Kheni Urval (24CE055)');
            console.log('Login status:', <?php echo $is_logged_in ? 'true' : 'false'; ?>);
            
            // Add some interactive features
            const featureCards = document.querySelectorAll('.feature-card');
            featureCards.forEach(card => {
                card.addEventListener('click', function() {
                    card.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        card.style.transform = '';
                    }, 200);
                });
            });

            // Add click handlers to demo accounts
            const accountItems = document.querySelectorAll('.account-item');
            accountItems.forEach(item => {
                item.addEventListener('click', function() {
                    const username = this.querySelector('.username').textContent.replace('👤 ', '').toLowerCase();
                    if (confirm(`Would you like to go to the login page and auto-fill credentials for ${username}?`)) {
                        window.location.href = `login.php?demo=${username}`;
                    }
                });
                
                // Add hover effect
                item.style.cursor = 'pointer';
            });

            // Check session status periodically if logged in
            <?php if ($is_logged_in): ?>
            setInterval(function() {
                fetch('session_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=check_session_status'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.is_expired) {
                        alert('Your session has expired. You will be redirected to the login page.');
                        window.location.href = 'login.php';
                    }
                })
                .catch(error => {
                    console.error('Session check error:', error);
                });
            }, 60000); // Check every minute
            <?php endif; ?>

            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch(e.key) {
                        case 'l':
                            e.preventDefault();
                            window.location.href = 'login.php';
                            break;
                        case 'd':
                            e.preventDefault();
                            <?php if ($is_logged_in): ?>
                            window.location.href = 'dashboard.php';
                            <?php else: ?>
                            alert('Please login first to access the dashboard.');
                            <?php endif; ?>
                            break;
                    }
                }
            });
        });

        // Add some visual feedback
        function addVisualFeedback() {
            const actionButtons = document.querySelectorAll('.btn');
            actionButtons.forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px) scale(1.02)';
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                });
            });
        }

        // Call visual feedback function
        addVisualFeedback();
    </script>
</body>
</html>
