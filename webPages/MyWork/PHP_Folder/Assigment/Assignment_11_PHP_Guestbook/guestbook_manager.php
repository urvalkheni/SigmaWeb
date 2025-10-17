<?php
/**
 * Assignment 11: PHP Guestbook System with File I/O Operations
 * Student: Kheni Urval (24CE055)
 * Course: WDF: ITUE203
 * 
 * This file contains the core guestbook management classes for handling
 * file operations, data validation, and CSV management with security features.
 */

class GuestbookManager {
    private $csvFile;
    private $lockFile;
    private $itemsPerPage;
    private $allowedTags;
    
    public function __construct($csvFile = 'guestbook_data.csv', $itemsPerPage = 10) {
        $this->csvFile = $csvFile;
        $this->lockFile = $csvFile . '.lock';
        $this->itemsPerPage = $itemsPerPage;
        $this->allowedTags = '<b><i><u><em><strong>';
        
        // Initialize CSV file with headers if it doesn't exist
        if (!file_exists($this->csvFile)) {
            $this->initializeCSV();
        }
    }
    
    /**
     * Initialize CSV file with headers
     */
    private function initializeCSV() {
        $headers = [
            'ID',
            'Name',
            'Email', 
            'Website',
            'Message',
            'Date',
            'IP_Address',
            'Status',
            'Moderated_By',
            'Moderated_Date'
        ];
        
        if ($handle = fopen($this->csvFile, 'w')) {
            fputcsv($handle, $headers);
            fclose($handle);
        }
    }
    
    /**
     * Add a new guestbook entry with validation
     */
    public function addEntry($data) {
        // Validate input data
        $validationResult = $this->validateEntry($data);
        if (!$validationResult['valid']) {
            return $validationResult;
        }
        
        // Sanitize data
        $sanitizedData = $this->sanitizeData($data);
        
        // Generate unique ID
        $id = $this->generateEntryId();
        
        // Prepare entry array
        $entry = [
            $id,
            $sanitizedData['name'],
            $sanitizedData['email'],
            $sanitizedData['website'],
            $sanitizedData['message'],
            date('Y-m-d H:i:s'),
            $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
            'pending', // pending, approved, rejected
            '',
            ''
        ];
        
        // Write to CSV with file locking
        if ($this->writeToCSV($entry)) {
            $this->logActivity('entry_added', $id, $sanitizedData['name']);
            return [
                'success' => true,
                'message' => 'Your message has been submitted and is pending moderation.',
                'entry_id' => $id
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to save your message. Please try again.'
            ];
        }
    }
    
    /**
     * Validate guestbook entry data
     */
    private function validateEntry($data) {
        $errors = [];
        
        // Name validation
        if (empty($data['name']) || strlen(trim($data['name'])) < 2) {
            $errors[] = 'Name must be at least 2 characters long.';
        } elseif (strlen($data['name']) > 50) {
            $errors[] = 'Name must not exceed 50 characters.';
        } elseif (!preg_match('/^[a-zA-Z\s\-\'\.]+$/', $data['name'])) {
            $errors[] = 'Name contains invalid characters.';
        }
        
        // Email validation
        if (empty($data['email'])) {
            $errors[] = 'Email address is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        } elseif (strlen($data['email']) > 100) {
            $errors[] = 'Email address is too long.';
        }
        
        // Website validation (optional)
        if (!empty($data['website'])) {
            if (!filter_var($data['website'], FILTER_VALIDATE_URL)) {
                $errors[] = 'Please enter a valid website URL.';
            } elseif (strlen($data['website']) > 200) {
                $errors[] = 'Website URL is too long.';
            }
        }
        
        // Message validation
        if (empty($data['message']) || strlen(trim($data['message'])) < 10) {
            $errors[] = 'Message must be at least 10 characters long.';
        } elseif (strlen($data['message']) > 1000) {
            $errors[] = 'Message must not exceed 1000 characters.';
        }
        
        // Check for spam patterns
        if ($this->isSpam($data['message'])) {
            $errors[] = 'Your message appears to contain spam content.';
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
    
    /**
     * Sanitize input data to prevent XSS and other attacks
     */
    private function sanitizeData($data) {
        return [
            'name' => htmlspecialchars(trim($data['name']), ENT_QUOTES, 'UTF-8'),
            'email' => filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL),
            'website' => filter_var(trim($data['website']), FILTER_SANITIZE_URL),
            'message' => strip_tags(trim($data['message']), $this->allowedTags)
        ];
    }
    
    /**
     * Generate unique entry ID
     */
    private function generateEntryId() {
        return 'GB' . date('Ymd') . '_' . uniqid();
    }
    
    /**
     * Write entry to CSV file with file locking
     */
    private function writeToCSV($entry) {
        $maxAttempts = 5;
        $attempt = 0;
        
        while ($attempt < $maxAttempts) {
            if ($this->acquireLock()) {
                $handle = fopen($this->csvFile, 'a');
                if ($handle) {
                    $result = fputcsv($handle, $entry);
                    fclose($handle);
                    $this->releaseLock();
                    return $result !== false;
                }
                $this->releaseLock();
            }
            
            $attempt++;
            usleep(100000); // Wait 0.1 second before retry
        }
        
        return false;
    }
    
    /**
     * Acquire file lock
     */
    private function acquireLock() {
        if (file_exists($this->lockFile)) {
            // Check if lock is stale (older than 30 seconds)
            if (time() - filemtime($this->lockFile) > 30) {
                unlink($this->lockFile);
            } else {
                return false;
            }
        }
        
        return file_put_contents($this->lockFile, getmypid()) !== false;
    }
    
    /**
     * Release file lock
     */
    private function releaseLock() {
        if (file_exists($this->lockFile)) {
            unlink($this->lockFile);
        }
    }
    
    /**
     * Get entries with pagination and filtering
     */
    public function getEntries($page = 1, $status = 'approved', $search = '') {
        if (!file_exists($this->csvFile)) {
            return [
                'entries' => [],
                'total' => 0,
                'pages' => 0,
                'current_page' => 1
            ];
        }
        
        $allEntries = [];
        
        if (($handle = fopen($this->csvFile, 'r')) !== false) {
            // Skip header row
            fgetcsv($handle);
            
            while (($data = fgetcsv($handle)) !== false) {
                if (count($data) >= 10) {
                    $entry = [
                        'id' => $data[0],
                        'name' => $data[1],
                        'email' => $data[2],
                        'website' => $data[3],
                        'message' => $data[4],
                        'date' => $data[5],
                        'ip_address' => $data[6],
                        'status' => $data[7],
                        'moderated_by' => $data[8],
                        'moderated_date' => $data[9]
                    ];
                    
                    // Filter by status
                    if ($status === 'all' || $entry['status'] === $status) {
                        // Filter by search term
                        if (empty($search) || $this->matchesSearch($entry, $search)) {
                            $allEntries[] = $entry;
                        }
                    }
                }
            }
            
            fclose($handle);
        }
        
        // Sort by date (newest first)
        usort($allEntries, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        // Calculate pagination
        $total = count($allEntries);
        $totalPages = ceil($total / $this->itemsPerPage);
        $offset = ($page - 1) * $this->itemsPerPage;
        $entries = array_slice($allEntries, $offset, $this->itemsPerPage);
        
        return [
            'entries' => $entries,
            'total' => $total,
            'pages' => $totalPages,
            'current_page' => $page
        ];
    }
    
    /**
     * Check if entry matches search criteria
     */
    private function matchesSearch($entry, $search) {
        $searchLower = strtolower($search);
        return strpos(strtolower($entry['name']), $searchLower) !== false ||
               strpos(strtolower($entry['message']), $searchLower) !== false ||
               strpos(strtolower($entry['email']), $searchLower) !== false;
    }
    
    /**
     * Moderate entry (approve/reject)
     */
    public function moderateEntry($entryId, $action, $moderatorName = 'Admin') {
        if (!in_array($action, ['approve', 'reject'])) {
            return ['success' => false, 'message' => 'Invalid action'];
        }
        
        $entries = $this->getAllEntriesArray();
        $updated = false;
        
        foreach ($entries as &$entry) {
            if ($entry[0] === $entryId) {
                $entry[7] = $action === 'approve' ? 'approved' : 'rejected';
                $entry[8] = $moderatorName;
                $entry[9] = date('Y-m-d H:i:s');
                $updated = true;
                break;
            }
        }
        
        if ($updated && $this->rewriteCSV($entries)) {
            $this->logActivity('entry_moderated', $entryId, $moderatorName, $action);
            return [
                'success' => true,
                'message' => "Entry {$action}d successfully."
            ];
        }
        
        return ['success' => false, 'message' => 'Failed to moderate entry'];
    }
    
    /**
     * Delete entry
     */
    public function deleteEntry($entryId) {
        $entries = $this->getAllEntriesArray();
        $found = false;
        
        foreach ($entries as $index => $entry) {
            if ($entry[0] === $entryId) {
                unset($entries[$index]);
                $found = true;
                break;
            }
        }
        
        if ($found && $this->rewriteCSV(array_values($entries))) {
            $this->logActivity('entry_deleted', $entryId);
            return ['success' => true, 'message' => 'Entry deleted successfully.'];
        }
        
        return ['success' => false, 'message' => 'Failed to delete entry'];
    }
    
    /**
     * Get all entries as array for manipulation
     */
    private function getAllEntriesArray() {
        $entries = [];
        
        if (($handle = fopen($this->csvFile, 'r')) !== false) {
            // Skip header
            fgetcsv($handle);
            
            while (($data = fgetcsv($handle)) !== false) {
                $entries[] = $data;
            }
            
            fclose($handle);
        }
        
        return $entries;
    }
    
    /**
     * Rewrite entire CSV file
     */
    private function rewriteCSV($entries) {
        if ($this->acquireLock()) {
            $handle = fopen($this->csvFile, 'w');
            if ($handle) {
                // Write header
                $headers = [
                    'ID', 'Name', 'Email', 'Website', 'Message',
                    'Date', 'IP_Address', 'Status', 'Moderated_By', 'Moderated_Date'
                ];
                fputcsv($handle, $headers);
                
                // Write entries
                foreach ($entries as $entry) {
                    fputcsv($handle, $entry);
                }
                
                fclose($handle);
                $this->releaseLock();
                return true;
            }
            $this->releaseLock();
        }
        
        return false;
    }
    
    /**
     * Basic spam detection
     */
    private function isSpam($message) {
        $spamKeywords = [
            'viagra', 'cialis', 'casino', 'poker', 'lottery',
            'make money fast', 'click here', 'free money',
            'work from home', 'business opportunity'
        ];
        
        $messageLower = strtolower($message);
        
        foreach ($spamKeywords as $keyword) {
            if (strpos($messageLower, $keyword) !== false) {
                return true;
            }
        }
        
        // Check for excessive links
        if (substr_count($messageLower, 'http') > 2) {
            return true;
        }
        
        // Check for excessive caps
        $capsCount = preg_match_all('/[A-Z]/', $message);
        if ($capsCount > strlen($message) * 0.5) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Get statistics
     */
    public function getStatistics() {
        $stats = [
            'total' => 0,
            'approved' => 0,
            'pending' => 0,
            'rejected' => 0,
            'today' => 0,
            'this_week' => 0,
            'this_month' => 0
        ];
        
        if (($handle = fopen($this->csvFile, 'r')) !== false) {
            fgetcsv($handle); // Skip header
            
            $today = date('Y-m-d');
            $weekStart = date('Y-m-d', strtotime('monday this week'));
            $monthStart = date('Y-m-01');
            
            while (($data = fgetcsv($handle)) !== false) {
                if (count($data) >= 8) {
                    $stats['total']++;
                    
                    $status = $data[7];
                    if (isset($stats[$status])) {
                        $stats[$status]++;
                    }
                    
                    $entryDate = substr($data[5], 0, 10);
                    if ($entryDate === $today) {
                        $stats['today']++;
                    }
                    if ($entryDate >= $weekStart) {
                        $stats['this_week']++;
                    }
                    if ($entryDate >= $monthStart) {
                        $stats['this_month']++;
                    }
                }
            }
            
            fclose($handle);
        }
        
        return $stats;
    }
    
    /**
     * Export entries to different formats
     */
    public function exportEntries($format = 'csv', $status = 'approved') {
        $entries = $this->getEntries(1, $status, '')['entries'];
        
        switch ($format) {
            case 'json':
                return json_encode($entries, JSON_PRETTY_PRINT);
                
            case 'xml':
                $xml = new SimpleXMLElement('<guestbook/>');
                foreach ($entries as $entry) {
                    $entryXml = $xml->addChild('entry');
                    foreach ($entry as $key => $value) {
                        $entryXml->addChild($key, htmlspecialchars($value));
                    }
                }
                return $xml->asXML();
                
            case 'html':
                $html = '<table border="1"><tr><th>Name</th><th>Email</th><th>Message</th><th>Date</th></tr>';
                foreach ($entries as $entry) {
                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($entry['name']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($entry['email']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($entry['message']) . '</td>';
                    $html .= '<td>' . htmlspecialchars($entry['date']) . '</td>';
                    $html .= '</tr>';
                }
                $html .= '</table>';
                return $html;
                
            default: // CSV
                $output = "Name,Email,Website,Message,Date\n";
                foreach ($entries as $entry) {
                    $output .= '"' . str_replace('"', '""', $entry['name']) . '",';
                    $output .= '"' . str_replace('"', '""', $entry['email']) . '",';
                    $output .= '"' . str_replace('"', '""', $entry['website']) . '",';
                    $output .= '"' . str_replace('"', '""', $entry['message']) . '",';
                    $output .= '"' . str_replace('"', '""', $entry['date']) . '"' . "\n";
                }
                return $output;
        }
    }
    
    /**
     * Log activities for audit trail
     */
    private function logActivity($action, $entryId, $user = 'System', $details = '') {
        $logFile = 'guestbook_activity.log';
        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        
        $logEntry = "[{$timestamp}] {$action} - Entry: {$entryId} - User: {$user} - IP: {$ip}";
        if ($details) {
            $logEntry .= " - Details: {$details}";
        }
        $logEntry .= "\n";
        
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Backup guestbook data
     */
    public function createBackup() {
        $backupDir = 'backups';
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
        
        $backupFile = $backupDir . '/guestbook_backup_' . date('Y-m-d_H-i-s') . '.csv';
        
        if (copy($this->csvFile, $backupFile)) {
            return [
                'success' => true,
                'message' => 'Backup created successfully.',
                'file' => $backupFile
            ];
        }
        
        return ['success' => false, 'message' => 'Failed to create backup.'];
    }
    
    /**
     * Clean old entries (older than specified days)
     */
    public function cleanOldEntries($days = 365) {
        $cutoffDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        $entries = $this->getAllEntriesArray();
        $originalCount = count($entries);
        
        $entries = array_filter($entries, function($entry) use ($cutoffDate) {
            return isset($entry[5]) && $entry[5] >= $cutoffDate;
        });
        
        $deletedCount = $originalCount - count($entries);
        
        if ($deletedCount > 0 && $this->rewriteCSV(array_values($entries))) {
            $this->logActivity('cleanup', 'multiple', 'System', "Deleted {$deletedCount} old entries");
            return [
                'success' => true,
                'message' => "Cleaned {$deletedCount} old entries.",
                'deleted_count' => $deletedCount
            ];
        }
        
        return [
            'success' => true,
            'message' => 'No old entries to clean.',
            'deleted_count' => 0
        ];
    }
}

/**
 * Configuration Manager for Guestbook Settings
 */
class GuestbookConfig {
    private $configFile = 'guestbook_config.json';
    private $defaultConfig = [
        'moderation_enabled' => true,
        'allow_html' => false,
        'max_message_length' => 1000,
        'max_name_length' => 50,
        'items_per_page' => 10,
        'spam_detection' => true,
        'require_email_verification' => false,
        'auto_approve_after_first' => false,
        'backup_frequency' => 'weekly',
        'cleanup_after_days' => 365,
        'admin_email' => 'admin@example.com',
        'site_name' => 'Kheni Urval\'s Guestbook (24CE055)'
    ];
    
    public function __construct() {
        if (!file_exists($this->configFile)) {
            $this->saveConfig($this->defaultConfig);
        }
    }
    
    public function getConfig() {
        if (file_exists($this->configFile)) {
            $config = json_decode(file_get_contents($this->configFile), true);
            return array_merge($this->defaultConfig, $config ?: []);
        }
        return $this->defaultConfig;
    }
    
    public function saveConfig($config) {
        return file_put_contents($this->configFile, json_encode($config, JSON_PRETTY_PRINT)) !== false;
    }
    
    public function updateSetting($key, $value) {
        $config = $this->getConfig();
        $config[$key] = $value;
        return $this->saveConfig($config);
    }
}

// Initialize session for admin functions
if (!session_id()) {
    session_start();
}

// Create global instances
$guestbook = new GuestbookManager();
$config = new GuestbookConfig();
?>
