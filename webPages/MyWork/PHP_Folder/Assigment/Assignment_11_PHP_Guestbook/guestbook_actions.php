<?php
/**
 * Assignment 11: PHP Guestbook AJAX Actions Handler
 * Student: Kheni Urval (24CE055)
 * Course: WDF: ITUE203
 * 
 * This file handles all AJAX requests for the guestbook system,
 * including entry management, moderation, and data operations.
 */

// Include the main guestbook manager
require_once 'guestbook_manager.php';

// Set content type for JSON responses
header('Content-Type: application/json');

// Initialize response array
$response = [
    'success' => false,
    'message' => 'Invalid request',
    'data' => null
];

try {
    // Get action from POST or GET
    $action = $_POST['action'] ?? $_GET['action'] ?? '';
    
    switch ($action) {
        case 'add_entry':
            $response = handleAddEntry();
            break;
            
        case 'get_entries':
            $response = handleGetEntries();
            break;
            
        case 'get_statistics':
            $response = handleGetStatistics();
            break;
            
        case 'moderate_entry':
            $response = handleModerateEntry();
            break;
            
        case 'delete_entry':
            $response = handleDeleteEntry();
            break;
            
        case 'create_backup':
            $response = handleCreateBackup();
            break;
            
        case 'clean_old_entries':
            $response = handleCleanOldEntries();
            break;
            
        case 'export_data':
            handleExportData();
            return; // Exit early for file download
            
        case 'update_config':
            $response = handleUpdateConfig();
            break;
            
        default:
            $response = [
                'success' => false,
                'message' => 'Unknown action: ' . $action
            ];
    }
    
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ];
    
    // Log the error
    error_log("Guestbook Error [{$action}]: " . $e->getMessage());
}

// Send JSON response
echo json_encode($response);

/**
 * Handle adding a new guestbook entry
 */
function handleAddEntry() {
    global $guestbook;
    
    // Validate required fields
    $requiredFields = ['name', 'email', 'message'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            return [
                'success' => false,
                'message' => 'Missing required field: ' . $field
            ];
        }
    }
    
    // Prepare entry data
    $entryData = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'website' => $_POST['website'] ?? '',
        'message' => $_POST['message']
    ];
    
    // Add entry using the guestbook manager
    $result = $guestbook->addEntry($entryData);
    
    return $result;
}

/**
 * Handle getting guestbook entries with pagination and filtering
 */
function handleGetEntries() {
    global $guestbook;
    
    $page = (int)($_POST['page'] ?? $_GET['page'] ?? 1);
    $status = $_POST['status'] ?? $_GET['status'] ?? 'approved';
    $search = $_POST['search'] ?? $_GET['search'] ?? '';
    $isAdmin = isset($_POST['admin']) || isset($_GET['admin']);
    
    // If not admin, only show approved entries
    if (!$isAdmin && $status !== 'approved') {
        $status = 'approved';
    }
    
    try {
        $data = $guestbook->getEntries($page, $status, $search);
        
        return [
            'success' => true,
            'message' => 'Entries retrieved successfully',
            'data' => $data
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error retrieving entries: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle getting guestbook statistics
 */
function handleGetStatistics() {
    global $guestbook;
    
    try {
        $stats = $guestbook->getStatistics();
        
        return [
            'success' => true,
            'message' => 'Statistics retrieved successfully',
            'data' => $stats
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error retrieving statistics: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle entry moderation (approve/reject)
 */
function handleModerateEntry() {
    global $guestbook;
    
    $entryId = $_POST['entry_id'] ?? '';
    $action = $_POST['moderate_action'] ?? '';
    
    if (empty($entryId) || empty($action)) {
        return [
            'success' => false,
            'message' => 'Missing entry ID or moderation action'
        ];
    }
    
    if (!in_array($action, ['approve', 'reject'])) {
        return [
            'success' => false,
            'message' => 'Invalid moderation action'
        ];
    }
    
    try {
        $result = $guestbook->moderateEntry($entryId, $action, 'Admin');
        return $result;
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error moderating entry: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle entry deletion
 */
function handleDeleteEntry() {
    global $guestbook;
    
    $entryId = $_POST['entry_id'] ?? '';
    
    if (empty($entryId)) {
        return [
            'success' => false,
            'message' => 'Missing entry ID'
        ];
    }
    
    try {
        $result = $guestbook->deleteEntry($entryId);
        return $result;
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error deleting entry: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle backup creation
 */
function handleCreateBackup() {
    global $guestbook;
    
    try {
        $result = $guestbook->createBackup();
        return $result;
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error creating backup: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle cleaning old entries
 */
function handleCleanOldEntries() {
    global $guestbook;
    
    $days = (int)($_POST['days'] ?? 365);
    
    try {
        $result = $guestbook->cleanOldEntries($days);
        return $result;
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error cleaning old entries: ' . $e->getMessage()
        ];
    }
}

/**
 * Handle data export (returns file for download)
 */
function handleExportData() {
    global $guestbook;
    
    $format = $_GET['format'] ?? 'csv';
    $status = $_GET['status'] ?? 'approved';
    
    try {
        $data = $guestbook->exportEntries($format, $status);
        
        // Set appropriate headers for file download
        switch ($format) {
            case 'json':
                header('Content-Type: application/json');
                header('Content-Disposition: attachment; filename="guestbook_export.json"');
                break;
                
            case 'xml':
                header('Content-Type: application/xml');
                header('Content-Disposition: attachment; filename="guestbook_export.xml"');
                break;
                
            case 'html':
                header('Content-Type: text/html');
                header('Content-Disposition: attachment; filename="guestbook_export.html"');
                break;
                
            default: // CSV
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="guestbook_export.csv"');
        }
        
        echo $data;
        
    } catch (Exception $e) {
        // If export fails, return to main page with error
        header('Location: index.php?error=' . urlencode('Export failed: ' . $e->getMessage()));
    }
}

/**
 * Handle configuration updates
 */
function handleUpdateConfig() {
    global $config;
    
    $setting = $_POST['setting'] ?? '';
    $value = $_POST['value'] ?? '';
    
    if (empty($setting)) {
        return [
            'success' => false,
            'message' => 'Missing setting name'
        ];
    }
    
    try {
        $result = $config->updateSetting($setting, $value);
        
        if ($result) {
            return [
                'success' => true,
                'message' => 'Configuration updated successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to update configuration'
            ];
        }
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error updating configuration: ' . $e->getMessage()
        ];
    }
}

/**
 * Validate admin access (simplified for demo)
 */
function validateAdminAccess() {
    // In a real application, this would check session authentication
    // For demo purposes, we'll use a simple password check
    $adminPassword = $_POST['admin_password'] ?? $_SESSION['admin_authenticated'] ?? '';
    return $adminPassword === 'admin123' || $_SESSION['admin_authenticated'] === true;
}

/**
 * Get client IP address
 */
function getClientIpAddress() {
    $ipKeys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
    
    foreach ($ipKeys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, 
                    FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
    
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

/**
 * Rate limiting function (basic implementation)
 */
function checkRateLimit($action, $maxAttempts = 10, $timeWindow = 300) {
    $ip = getClientIpAddress();
    $cacheFile = "rate_limit_{$action}_{$ip}.tmp";
    
    $attempts = 0;
    if (file_exists($cacheFile)) {
        $data = json_decode(file_get_contents($cacheFile), true);
        if ($data && $data['timestamp'] > time() - $timeWindow) {
            $attempts = $data['attempts'];
        }
    }
    
    if ($attempts >= $maxAttempts) {
        return false;
    }
    
    // Update attempt counter
    $data = [
        'attempts' => $attempts + 1,
        'timestamp' => time()
    ];
    file_put_contents($cacheFile, json_encode($data));
    
    return true;
}

/**
 * Log security events
 */
function logSecurityEvent($event, $details = '') {
    $logFile = 'security.log';
    $timestamp = date('Y-m-d H:i:s');
    $ip = getClientIpAddress();
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    
    $logEntry = "[{$timestamp}] SECURITY: {$event} - IP: {$ip} - UA: {$userAgent}";
    if ($details) {
        $logEntry .= " - Details: {$details}";
    }
    $logEntry .= "\n";
    
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

/**
 * Sanitize input for logging
 */
function sanitizeForLog($input) {
    return preg_replace('/[^\w\s\-\.@]/', '', $input);
}
?>
