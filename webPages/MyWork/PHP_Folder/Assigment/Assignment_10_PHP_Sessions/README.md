# Assignment 10: PHP Sessions and Cookies

**Student:** Kheni Urval (24CE055)  
**Course:** WDF: ITUE203  
**Assignment Type:** Medium-Level PHP Implementation  

## 📋 Assignment Overview

This assignment demonstrates comprehensive PHP session management and cookie handling through a complete authentication system. The implementation includes secure login/logout functionality, session timeout management, "remember me" cookies, user preferences storage, and advanced security features.

## 🎯 Learning Objectives

- Master PHP session management with security best practices
- Implement secure cookie handling and persistent storage
- Create robust user authentication systems
- Practice session timeout and security measures
- Develop user preference management systems
- Understand client-server state management

## 🛠️ Implementation Details

### Core Components

1. **SessionManager Class**
   - Comprehensive session lifecycle management
   - Security measures and timeout handling
   - User authentication and authorization
   - Activity logging and monitoring
   - Flash messaging system

2. **CookieManager Class**
   - Secure cookie creation and management
   - HttpOnly and secure flag configuration
   - User preference persistence
   - Theme and language storage

3. **Authentication System**
   - Password hashing with PHP's password_hash()
   - "Remember me" functionality with secure tokens
   - Session regeneration for security
   - IP address validation

4. **User Interface**
   - Responsive login and dashboard pages
   - Real-time session monitoring
   - Interactive preference management
   - Modern CSS with theme switching

### Technical Implementation

**Session Configuration:**
```php
session_start([
    'cookie_lifetime' => 3600,
    'cookie_httponly' => true,
    'cookie_secure' => false,
    'cookie_samesite' => 'Lax',
    'use_strict_mode' => true,
    'use_only_cookies' => true
]);
```

**Security Features:**
- Password hashing with bcrypt
- Session ID regeneration
- HttpOnly cookie flags
- Session timeout management
- IP address validation
- Activity logging

## 📁 File Structure

```
Assignment_10_PHP_Sessions/
├── index.php              # Main landing page
├── login.php              # User authentication
├── dashboard.php          # User dashboard
├── session_manager.php    # Core session management
├── session_actions.php    # AJAX action handler
└── README.md             # This documentation
```

## 🚀 Features Demonstrated

### 1. Session Management (`session_manager.php`)
- **Purpose:** Core session handling and security
- **Features:** Timeout detection, regeneration, cleanup, logging
- **Security:** IP validation, secure configuration, activity monitoring

### 2. User Authentication (`login.php`)
- **Purpose:** Secure user login interface
- **Features:** Demo accounts, auto-fill, remember me checkbox
- **Validation:** Input sanitization, error handling, rate limiting simulation

### 3. Dashboard Interface (`dashboard.php`)
- **Purpose:** Protected user area with session data
- **Features:** Real-time stats, preferences, theme switching
- **Interactivity:** AJAX updates, session monitoring, data management

### 4. AJAX Actions (`session_actions.php`)
- **Purpose:** Server-side action handling
- **Features:** Session extension, data clearing, preference updates
- **Security:** Authentication checks, input validation, JSON responses

### 5. Landing Page (`index.php`)
- **Purpose:** Public entry point and feature showcase
- **Features:** Status display, demo accounts, technical information
- **Design:** Responsive layout, interactive elements, accessibility

## 💡 Code Highlights

### Advanced Session Management
```php
class SessionManager {
    private static $sessionTimeout = 3600; // 1 hour
    
    public static function initialize() {
        if (self::isSessionExpired()) {
            self::destroySession();
            return false;
        }
        
        $_SESSION['last_activity'] = time();
        
        if (!isset($_SESSION['created'])) {
            $_SESSION['created'] = time();
        } elseif (time() - $_SESSION['created'] > 1800) {
            session_regenerate_id(true);
            $_SESSION['created'] = time();
        }
        
        return true;
    }
    
    public static function login($username, $password, $rememberMe = false) {
        global $users;
        
        if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_data'] = $users[$username];
            $_SESSION['login_time'] = time();
            $_SESSION['last_activity'] = time();
            $_SESSION['login_ip'] = $_SERVER['REMOTE_ADDR'];
            
            if ($rememberMe) {
                self::setRememberMeCookie($username);
            }
            
            self::logActivity($username, 'login', 'Successful login');
            return true;
        }
        
        self::logActivity($username, 'login_failed', 'Failed login attempt');
        return false;
    }
}
```

### Secure Cookie Management
```php
class CookieManager {
    public static function set($name, $value, $expiry = 3600, $httpOnly = true) {
        return setcookie($name, $value, time() + $expiry, '/', '', false, $httpOnly);
    }
    
    public static function setTheme($theme) {
        self::set('user_theme', $theme, 2592000); // 30 days
    }
    
    public static function getTheme() {
        return self::get('user_theme', 'light');
    }
}
```

### Remember Me Implementation
```php
private static function setRememberMeCookie($username) {
    $token = bin2hex(random_bytes(32));
    $cookieValue = $username . ':' . $token;
    $hashedCookie = hash('sha256', $cookieValue);
    
    setcookie('remember_me', $hashedCookie, 
             time() + self::$rememberMeTimeout, 
             '/', '', false, true);
    
    $_SESSION['remember_token'] = $token;
}
```

### Session Timeout Detection
```php
public static function isSessionExpired() {
    if (isset($_SESSION['last_activity'])) {
        return (time() - $_SESSION['last_activity']) > self::$sessionTimeout;
    }
    return false;
}
```

### AJAX Session Actions
```php
switch ($action) {
    case 'extend_session':
        $_SESSION['last_activity'] = time();
        session_regenerate_id(true);
        $_SESSION['created'] = time();
        
        echo json_encode([
            'success' => true,
            'message' => 'Session extended successfully',
            'new_session_id' => session_id()
        ]);
        break;
        
    case 'clear_session_data':
        unset($_SESSION['cart_items']);
        unset($_SESSION['recent_views']);
        unset($_SESSION['search_history']);
        
        echo json_encode([
            'success' => true,
            'message' => 'Session data cleared successfully'
        ]);
        break;
}
```

## 🎨 User Interface Features

### Responsive Design
- **Mobile-First Approach:** Optimized for all device sizes
- **CSS Grid/Flexbox:** Modern layout techniques
- **Theme Switching:** Light/dark mode with persistent storage
- **Interactive Elements:** Hover effects, animations, transitions

### Security Indicators
- **Session Status:** Visual indicators for login state
- **Security Badges:** Display of active security measures
- **Real-time Updates:** Live session monitoring and statistics
- **Timeout Warnings:** Proactive session expiration alerts

### User Experience
- **Auto-fill Demo:** Quick access to demo credentials
- **Keyboard Shortcuts:** Power user functionality
- **Loading States:** Visual feedback for async operations
- **Error Handling:** User-friendly error messages

## 🔧 Security Features

### Session Security
- **HttpOnly Cookies:** Prevent XSS access to session cookies
- **Secure Flags:** HTTPS-only transmission (configurable)
- **SameSite Protection:** CSRF protection with Lax policy
- **Session Regeneration:** Regular ID regeneration for security

### Authentication Security
- **Password Hashing:** Bcrypt with cost factor 10
- **Rate Limiting:** Simulated login attempt limiting
- **IP Validation:** Session IP address consistency checking
- **Activity Logging:** Comprehensive audit trail

### Data Protection
- **Input Sanitization:** All user inputs properly escaped
- **SQL Injection Prevention:** Prepared statements (where applicable)
- **XSS Protection:** Output encoding and CSP headers
- **CSRF Protection:** Token-based request validation

## 📊 Demo Accounts

The system includes four pre-configured demo accounts:

| Username | Password    | Role         | Purpose |
|----------|-------------|--------------|---------|
| admin    | admin123    | Administrator| Full access demonstration |
| kheni    | password123 | Student      | Student account (24CE055) |
| user     | user123     | User         | Standard user features |
| demo     | demo123     | Demo User    | General demonstration |

## 🚀 Usage Instructions

1. **Access Application:** Open `index.php` in web browser
2. **View Features:** Explore the landing page and feature overview
3. **Login:** Use any demo account or go to login page
4. **Dashboard:** Access session statistics and user preferences
5. **Preferences:** Modify theme, language, and notification settings
6. **Session Management:** Test timeout, extension, and logout features
7. **Security Testing:** Monitor session statistics and security features

## 🎓 Educational Value

This assignment demonstrates:
- **Session Lifecycle Management:** Complete session handling from creation to destruction
- **Security Best Practices:** Implementation of modern web security measures
- **State Management:** Persistent and temporary data storage strategies
- **User Experience Design:** Intuitive interfaces with responsive design
- **Error Handling:** Comprehensive error management and user feedback
- **Performance Optimization:** Efficient session and cookie operations

## 🏆 Assignment Completion

**Status:** ✅ Complete  
**Grade Level:** Medium-Level Implementation  
**Student:** Kheni Urval (24CE055)  
**Course:** WDF: ITUE203  

**Key Achievements:**
- ✅ Complete session management system with security measures
- ✅ Secure authentication with password hashing and remember me
- ✅ Advanced cookie handling with HttpOnly and secure flags
- ✅ Real-time session monitoring and timeout management
- ✅ User preference system with persistent storage
- ✅ Responsive UI with theme switching and accessibility
- ✅ AJAX-powered interactions and dynamic updates
- ✅ Comprehensive error handling and user feedback
- ✅ Activity logging and security audit trail
- ✅ Cross-browser compatibility and mobile responsiveness

## 🔍 Technical Specifications

### PHP Requirements
- PHP 7.4+ with session support
- Password hashing functions
- JSON encoding/decoding
- File system access for logging

### Security Configuration
- Session timeout: 3600 seconds (1 hour)
- Cookie lifetime: 3600 seconds (1 hour)
- Remember me: 2592000 seconds (30 days)
- HttpOnly cookies: Enabled
- Secure cookies: Configurable for HTTPS

### Browser Support
- Modern browsers with JavaScript enabled
- Cookie support required
- AJAX/Fetch API compatibility
- CSS3 and HTML5 features
