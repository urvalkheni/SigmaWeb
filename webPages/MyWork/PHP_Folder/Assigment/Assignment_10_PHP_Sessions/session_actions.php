<?php
/**
 * Session Actions Handler
 * Student: Kheni Urval (24CE055)
 * Assignment 10: PHP Sessions and Cookies
 * Course: WDF: ITUE203
 * Medium-Level Implementation
 */

require_once 'session_manager.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!SessionManager::isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

// Handle POST requests only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'clear_session_data':
        try {
            // Clear specific session data but keep authentication
            unset($_SESSION['cart_items']);
            unset($_SESSION['recent_views']);
            unset($_SESSION['search_history']);
            unset($_SESSION['user_preferences']);
            
            SessionManager::setFlashMessage('success', 'Session data cleared successfully!');
            
            echo json_encode([
                'success' => true,
                'message' => 'Session data cleared successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error clearing session data: ' . $e->getMessage()
            ]);
        }
        break;
        
    case 'clear_cookies':
        try {
            // Clear all non-essential cookies
            $cookies_to_clear = ['user_theme', 'user_language', 'notifications', 'remember_me'];
            
            foreach ($cookies_to_clear as $cookie) {
                if (CookieManager::exists($cookie)) {
                    CookieManager::delete($cookie);
                }
            }
            
            SessionManager::setFlashMessage('success', 'Cookies cleared successfully!');
            
            echo json_encode([
                'success' => true,
                'message' => 'Cookies cleared successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error clearing cookies: ' . $e->getMessage()
            ]);
        }
        break;
        
    case 'extend_session':
        try {
            // Update last activity time to extend session
            $_SESSION['last_activity'] = time();
            
            // Regenerate session ID for security
            session_regenerate_id(true);
            $_SESSION['created'] = time();
            
            echo json_encode([
                'success' => true,
                'message' => 'Session extended successfully',
                'new_session_id' => session_id()
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error extending session: ' . $e->getMessage()
            ]);
        }
        break;
        
    case 'add_cart_item':
        try {
            $item_name = trim($_POST['item_name'] ?? '');
            $item_price = floatval($_POST['item_price'] ?? 0);
            
            if (empty($item_name) || $item_price <= 0) {
                throw new Exception('Invalid item data');
            }
            
            if (!isset($_SESSION['cart_items'])) {
                $_SESSION['cart_items'] = [];
            }
            
            $_SESSION['cart_items'][] = [
                'id' => count($_SESSION['cart_items']) + 1,
                'name' => $item_name,
                'price' => $item_price,
                'added_at' => time()
            ];
            
            echo json_encode([
                'success' => true,
                'message' => 'Item added to cart',
                'cart_count' => count($_SESSION['cart_items'])
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error adding item: ' . $e->getMessage()
            ]);
        }
        break;
        
    case 'remove_cart_item':
        try {
            $item_id = intval($_POST['item_id'] ?? 0);
            
            if (!isset($_SESSION['cart_items']) || $item_id <= 0) {
                throw new Exception('Invalid item ID');
            }
            
            // Remove item by ID
            $_SESSION['cart_items'] = array_filter($_SESSION['cart_items'], function($item) use ($item_id) {
                return $item['id'] !== $item_id;
            });
            
            // Re-index array
            $_SESSION['cart_items'] = array_values($_SESSION['cart_items']);
            
            echo json_encode([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => count($_SESSION['cart_items'])
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error removing item: ' . $e->getMessage()
            ]);
        }
        break;
        
    case 'add_recent_view':
        try {
            $page_title = trim($_POST['page_title'] ?? '');
            
            if (empty($page_title)) {
                throw new Exception('Invalid page title');
            }
            
            if (!isset($_SESSION['recent_views'])) {
                $_SESSION['recent_views'] = [];
            }
            
            // Remove if already exists to avoid duplicates
            $_SESSION['recent_views'] = array_filter($_SESSION['recent_views'], function($view) use ($page_title) {
                return $view !== $page_title;
            });
            
            // Add to beginning of array
            array_unshift($_SESSION['recent_views'], $page_title);
            
            // Keep only last 10 items
            $_SESSION['recent_views'] = array_slice($_SESSION['recent_views'], 0, 10);
            
            echo json_encode([
                'success' => true,
                'message' => 'Recent view added',
                'recent_count' => count($_SESSION['recent_views'])
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error adding recent view: ' . $e->getMessage()
            ]);
        }
        break;
        
    case 'add_search_term':
        try {
            $search_term = trim($_POST['search_term'] ?? '');
            
            if (empty($search_term)) {
                throw new Exception('Invalid search term');
            }
            
            if (!isset($_SESSION['search_history'])) {
                $_SESSION['search_history'] = [];
            }
            
            // Remove if already exists to avoid duplicates
            $_SESSION['search_history'] = array_filter($_SESSION['search_history'], function($term) use ($search_term) {
                return $term !== $search_term;
            });
            
            // Add to beginning of array
            array_unshift($_SESSION['search_history'], $search_term);
            
            // Keep only last 20 items
            $_SESSION['search_history'] = array_slice($_SESSION['search_history'], 0, 20);
            
            echo json_encode([
                'success' => true,
                'message' => 'Search term added',
                'search_count' => count($_SESSION['search_history'])
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error adding search term: ' . $e->getMessage()
            ]);
        }
        break;
        
    case 'get_session_info':
        try {
            $session_stats = SessionManager::getSessionStats();
            $current_user = SessionManager::getCurrentUser();
            
            echo json_encode([
                'success' => true,
                'data' => [
                    'session_stats' => $session_stats,
                    'user_info' => $current_user,
                    'session_data' => [
                        'cart_items' => $_SESSION['cart_items'] ?? [],
                        'recent_views' => $_SESSION['recent_views'] ?? [],
                        'search_history' => $_SESSION['search_history'] ?? [],
                        'user_preferences' => $_SESSION['user_preferences'] ?? []
                    ]
                ]
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error getting session info: ' . $e->getMessage()
            ]);
        }
        break;
        
    case 'update_preference':
        try {
            $key = trim($_POST['key'] ?? '');
            $value = $_POST['value'] ?? '';
            
            if (empty($key)) {
                throw new Exception('Invalid preference key');
            }
            
            SessionManager::setUserPreference($key, $value);
            
            // Also store in cookies for persistence
            if (in_array($key, ['theme', 'language'])) {
                CookieManager::set('user_' . $key, $value, 2592000); // 30 days
            }
            
            echo json_encode([
                'success' => true,
                'message' => 'Preference updated',
                'key' => $key,
                'value' => $value
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error updating preference: ' . $e->getMessage()
            ]);
        }
        break;
        
    case 'check_session_status':
        try {
            $is_expired = SessionManager::isSessionExpired();
            $session_stats = SessionManager::getSessionStats();
            
            echo json_encode([
                'success' => true,
                'data' => [
                    'is_expired' => $is_expired,
                    'is_logged_in' => SessionManager::isLoggedIn(),
                    'time_remaining' => 3600 - $session_stats['time_since_activity'], // Assuming 1 hour timeout
                    'session_id' => session_id()
                ]
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error checking session status: ' . $e->getMessage()
            ]);
        }
        break;
        
    case 'regenerate_session':
        try {
            // Regenerate session ID for security
            $old_session_id = session_id();
            session_regenerate_id(true);
            $new_session_id = session_id();
            
            $_SESSION['created'] = time();
            $_SESSION['last_activity'] = time();
            
            echo json_encode([
                'success' => true,
                'message' => 'Session ID regenerated',
                'old_session_id' => $old_session_id,
                'new_session_id' => $new_session_id
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error regenerating session: ' . $e->getMessage()
            ]);
        }
        break;
        
    default:
        echo json_encode([
            'success' => false,
            'message' => 'Unknown action: ' . $action
        ]);
        break;
}

// Log the action for debugging
SessionManager::setUserPreference('last_action', [
    'action' => $action,
    'timestamp' => time(),
    'ip' => $_SERVER['REMOTE_ADDR']
]);

exit;
?>
