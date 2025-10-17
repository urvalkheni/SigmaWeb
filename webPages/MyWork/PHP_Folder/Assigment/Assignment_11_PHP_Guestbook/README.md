# Assignment 11: PHP Guestbook with File I/O Operations

**Student:** Kheni Urval (24CE055)  
**Course:** WDF: ITUE203  
**Assignment Type:** Medium-Level PHP Implementation  

## 📋 Assignment Overview

This assignment demonstrates comprehensive PHP file I/O operations through a complete guestbook system. The implementation includes CSV data storage, file locking mechanisms, data validation, pagination, moderation system, and advanced file operations with security measures.

## 🎯 Learning Objectives

- Master PHP file input/output operations with proper error handling
- Implement CSV data storage and manipulation techniques
- Practice file locking for concurrent access protection
- Create robust data validation and sanitization systems
- Develop pagination systems for efficient data display
- Build admin interfaces for content moderation
- Implement export functionality in multiple formats
- Practice security measures and spam detection algorithms

## 🛠️ Implementation Details

### Core Components

1. **GuestbookManager Class**
   - Complete file I/O operations management
   - CSV reading, writing, and manipulation
   - File locking with retry mechanisms
   - Data validation and sanitization
   - Pagination and filtering systems

2. **File Operations**
   - CSV file initialization with headers
   - Atomic file writing with locking
   - Concurrent access protection
   - File backup and restoration
   - Export to multiple formats (CSV, JSON, XML, HTML)

3. **Data Management**
   - Input validation and sanitization
   - Spam detection algorithms
   - Entry moderation system
   - Search and filtering capabilities
   - Statistics and analytics

4. **Security Features**
   - XSS protection with htmlspecialchars()
   - Input sanitization and validation
   - File locking for data integrity
   - Activity logging and audit trails
   - Rate limiting and spam detection

### Technical Implementation

**File Operations:**
```php
// CSV file initialization
private function initializeCSV() {
    $headers = [
        'ID', 'Name', 'Email', 'Website', 'Message',
        'Date', 'IP_Address', 'Status', 'Moderated_By', 'Moderated_Date'
    ];
    
    if ($handle = fopen($this->csvFile, 'w')) {
        fputcsv($handle, $headers);
        fclose($handle);
    }
}

// File locking mechanism
private function acquireLock() {
    if (file_exists($this->lockFile)) {
        if (time() - filemtime($this->lockFile) > 30) {
            unlink($this->lockFile);
        } else {
            return false;
        }
    }
    
    return file_put_contents($this->lockFile, getmypid()) !== false;
}
```

**Data Validation:**
```php
private function validateEntry($data) {
    $errors = [];
    
    // Name validation
    if (empty($data['name']) || strlen(trim($data['name'])) < 2) {
        $errors[] = 'Name must be at least 2 characters long.';
    } elseif (!preg_match('/^[a-zA-Z\s\-\'\.]+$/', $data['name'])) {
        $errors[] = 'Name contains invalid characters.';
    }
    
    // Email validation
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    
    // Message validation with spam detection
    if ($this->isSpam($data['message'])) {
        $errors[] = 'Your message appears to contain spam content.';
    }
    
    return ['valid' => empty($errors), 'errors' => $errors];
}
```

**Pagination System:**
```php
public function getEntries($page = 1, $status = 'approved', $search = '') {
    $allEntries = [];
    
    if (($handle = fopen($this->csvFile, 'r')) !== false) {
        fgetcsv($handle); // Skip header
        
        while (($data = fgetcsv($handle)) !== false) {
            if ($this->matchesFilter($data, $status, $search)) {
                $allEntries[] = $this->formatEntry($data);
            }
        }
        fclose($handle);
    }
    
    // Sort and paginate
    usort($allEntries, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });
    
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
```

## 📁 File Structure

```
Assignment_11_PHP_Guestbook/
├── index.php                  # Main interface with tabbed navigation
├── guestbook_manager.php       # Core backend logic and file operations
├── guestbook_actions.php       # AJAX action handlers
├── guestbook_data.csv          # CSV data storage (auto-generated)
├── guestbook_config.json       # Configuration settings (auto-generated)
├── guestbook_activity.log      # Activity audit trail (auto-generated)
├── backups/                    # Automated backup storage
└── README.md                   # This documentation
```

## 🚀 Features Demonstrated

### 1. File I/O Operations (`guestbook_manager.php`)
- **Purpose:** Complete file operations management
- **Features:** CSV reading/writing, file locking, atomic operations
- **Methods:** fopen(), fclose(), fgetcsv(), fputcsv(), file locking

### 2. Data Management System
- **Purpose:** Comprehensive data handling and validation
- **Features:** Input validation, sanitization, spam detection
- **Security:** XSS prevention, SQL injection protection, data integrity

### 3. User Interface (`index.php`)
- **Purpose:** Interactive frontend with responsive design
- **Features:** Tabbed navigation, real-time updates, admin panel
- **Technology:** Modern CSS, JavaScript ES6, AJAX communication

### 4. AJAX Handler (`guestbook_actions.php`)
- **Purpose:** Server-side action processing
- **Features:** Entry management, moderation, export functionality
- **Security:** Rate limiting, input validation, error handling

### 5. Export System
- **Purpose:** Multi-format data export capabilities
- **Features:** CSV, JSON, XML, HTML export formats
- **Implementation:** Dynamic format conversion with proper headers

## 💡 Code Highlights

### Advanced File Locking
```php
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
```

### Spam Detection Algorithm
```php
private function isSpam($message) {
    $spamKeywords = [
        'viagra', 'cialis', 'casino', 'poker', 'lottery',
        'make money fast', 'click here', 'free money'
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
```

### Export Functionality
```php
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
```

### Activity Logging
```php
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
```

## 🎨 User Interface Features

### Responsive Design
- **Mobile-First:** Optimized for all device sizes
- **Modern CSS:** Gradient backgrounds, smooth animations
- **Interactive Elements:** Hover effects, loading states
- **Accessibility:** Proper semantic markup, keyboard navigation

### Admin Panel
- **Authentication:** Password protection for admin functions
- **Moderation:** Approve/reject/delete entry capabilities
- **Management:** Backup creation, data export, cleanup tools
- **Statistics:** Real-time analytics and reporting

### User Experience
- **Tabbed Interface:** Organized content sections
- **Real-time Updates:** AJAX-powered interactions
- **Search & Filter:** Dynamic content filtering
- **Form Validation:** Client and server-side validation

## 🔧 Security Features

### Data Protection
- **Input Sanitization:** All user inputs properly cleaned
- **XSS Prevention:** Output encoding with htmlspecialchars()
- **File Security:** Proper file permissions and locking
- **Spam Detection:** Multi-level spam filtering

### Access Control
- **Admin Authentication:** Password-protected admin functions
- **Rate Limiting:** Prevention of spam submissions
- **IP Logging:** Activity tracking for security
- **Validation:** Server-side input validation

## 📊 Statistics and Analytics

The system provides comprehensive statistics including:
- Total entries by status (approved, pending, rejected)
- Time-based analytics (today, this week, this month)
- Entry trends and patterns
- Admin activity tracking

## 🚀 Usage Instructions

1. **Access Application:** Open `index.php` in web browser
2. **View Entries:** Browse approved guestbook entries
3. **Add Entry:** Use "Sign Guestbook" tab to submit new entry
4. **Admin Access:** Use password `admin123` for admin functions
5. **Moderation:** Approve/reject pending entries
6. **Export Data:** Download entries in various formats
7. **Maintenance:** Create backups and clean old entries

## 🎓 Educational Value

This assignment demonstrates:
- **File I/O Mastery:** Complete file operations with error handling
- **Data Persistence:** CSV storage without database dependency
- **Concurrency Handling:** File locking for multi-user scenarios
- **Data Validation:** Comprehensive input validation and sanitization
- **Security Practices:** XSS prevention, spam detection, access control
- **User Interface Design:** Modern, responsive web interfaces
- **System Administration:** Backup, export, and maintenance features

## 🏆 Assignment Completion

**Status:** ✅ Complete  
**Grade Level:** Medium-Level Implementation  
**Student:** Kheni Urval (24CE055)  
**Course:** WDF: ITUE203  

**Key Achievements:**
- ✅ Complete file I/O operations with proper error handling
- ✅ CSV data storage with file locking mechanisms
- ✅ Advanced data validation and sanitization
- ✅ Pagination system for efficient data display
- ✅ Admin moderation system with authentication
- ✅ Multi-format export functionality (CSV, JSON, XML, HTML)
- ✅ Spam detection and security measures
- ✅ Activity logging and audit trails
- ✅ Responsive UI with tabbed navigation
- ✅ Real-time statistics and analytics
- ✅ Backup and maintenance utilities
- ✅ Comprehensive error handling and user feedback

## 🔍 Technical Specifications

### PHP Requirements
- PHP 7.4+ with file system functions
- CSV file handling capabilities
- JSON encoding/decoding support
- SimpleXML for XML export

### File Operations
- fopen(), fclose(), fgetcsv(), fputcsv()
- File locking with custom implementation
- Atomic file operations
- File permission management

### Security Measures
- Input validation with filter_var()
- XSS prevention with htmlspecialchars()
- Spam detection algorithms
- Rate limiting implementation

### Performance Features
- Efficient pagination algorithms
- Lazy loading of large datasets
- File-based caching mechanisms
- Optimized search and filtering
