# Assignment 13: MySQL CRUD Operations

**Student:** Kheni Urval (24CE055)  
**Course:** WDF: ITUE203  
**Assignment:** Complete MySQL Database CRUD Operations  

## Overview

This assignment demonstrates comprehensive MySQL database operations using PHP with Object-Oriented Programming (OOP) principles. The project implements a complete Student Management System with full CRUD (Create, Read, Update, Delete) functionality, advanced features like pagination, search, filtering, and data export capabilities.

## Features Implemented

### 🗄️ Database Operations

1. **Create Operations**
   - Add new student records with validation
   - Prepared statements for security
   - Duplicate prevention (student ID and email)
   - Data integrity enforcement

2. **Read Operations**
   - Paginated student listing
   - Advanced search functionality
   - Multiple filter options (status, course)
   - Real-time search with debouncing

3. **Update Operations**
   - Edit existing student records
   - Partial updates (only modified fields)
   - Data validation and integrity checks
   - Conflict detection for unique fields

4. **Delete Operations**
   - Individual student deletion
   - Bulk delete functionality
   - Confirmation prompts for safety
   - Soft delete option (status-based)

### 🛡️ Security Features

1. **SQL Injection Prevention**
   - Prepared statements throughout
   - Parameter binding for all queries
   - Input sanitization and validation

2. **Data Validation**
   - Server-side validation for all inputs
   - Email format validation
   - GPA range validation (0.0 - 4.0)
   - Required field enforcement

3. **Error Handling**
   - Comprehensive exception handling
   - User-friendly error messages
   - Logging for debugging and auditing

### 📊 Advanced Features

1. **Pagination System**
   - Configurable page sizes
   - Navigation controls
   - Record count information
   - Efficient database queries

2. **Search and Filtering**
   - Full-text search across multiple fields
   - Status-based filtering
   - Course-based filtering
   - Combined filter support

3. **Data Export**
   - CSV export functionality
   - Filtered export options
   - Proper CSV formatting
   - Download trigger

4. **Statistics Dashboard**
   - Total student count
   - Status-based statistics
   - Course distribution
   - Average GPA calculation

### 🎨 User Interface

1. **Responsive Design**
   - Bootstrap 5 framework
   - Mobile-friendly interface
   - Modern card-based layout
   - Professional styling

2. **Interactive Elements**
   - Modal forms for add/edit operations
   - AJAX-powered operations
   - Real-time feedback
   - Loading states and animations

3. **User Experience**
   - Intuitive navigation
   - Clear action buttons
   - Status indicators
   - Confirmation dialogs

## File Structure

```
Assignment_13_MySQL_CRUD/
├── README.md                   # This documentation file
├── index.php                   # Main application interface
├── database.php               # Database connection and CRUD classes
├── operations.php             # AJAX request handler
└── SQL/
    ├── schema.sql             # Database schema
    └── sample_data.sql        # Sample data insertion
```

## Database Schema

### Students Table
```sql
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    date_of_birth DATE,
    course VARCHAR(100),
    semester INT,
    gpa DECIMAL(3,2),
    status ENUM('active', 'inactive', 'graduated', 'suspended') DEFAULT 'active',
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_student_id (student_id),
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_course (course)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## Core Classes

### Database Connection (Singleton Pattern)
- **`DatabaseConnection`** - Manages database connectivity
- **Features:** Connection pooling, error handling, automatic setup
- **Security:** Prepared statements, parameter binding

### CRUD Operations
- **`StudentCRUD`** - Complete CRUD operations for students
- **Methods:** Create, read, update, delete, bulk operations
- **Features:** Validation, pagination, search, statistics

## Setup Instructions

### 1. Database Configuration
```php
// Update database credentials in database.php
private $host = 'localhost';
private $database = 'student_management';
private $username = 'root';
private $password = '';
```

### 2. MySQL Database Setup
```sql
-- Create database
CREATE DATABASE student_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE student_management;

-- Run the schema from database.php or create manually
```

### 3. Web Server Setup
```bash
# Using PHP built-in server
php -S localhost:8000

# Or using XAMPP/WAMP
# Place files in htdocs/www directory
```

### 4. Access Application
- Open browser to `http://localhost:8000`
- Navigate to the assignment folder
- Open `index.php`

## Usage Examples

### Creating a New Student
```php
$data = [
    'student_id' => '24CE055',
    'first_name' => 'Kheni',
    'last_name' => 'Urval',
    'email' => 'kheni.urval@student.edu',
    'phone' => '+91 98765 43210',
    'course' => 'WDF: ITUE203',
    'semester' => 4,
    'gpa' => 3.85,
    'status' => 'active'
];

$result = $studentCRUD->createStudent($data);
```

### Reading Students with Pagination
```php
// Get page 1, 10 students per page, search for "kheni"
$result = $studentCRUD->getStudents(1, 10, 'kheni', 'active', 'WDF');
```

### Updating Student Record
```php
$data = [
    'gpa' => 3.90,
    'semester' => 5,
    'status' => 'active'
];

$result = $studentCRUD->updateStudent(1, $data);
```

### Advanced Search and Filtering
```javascript
// Frontend search with debouncing
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        currentPage = 1;
        loadStudents();
    }, 500);
});
```

## API Endpoints

### POST `/operations.php`

#### Create Student
```
action=create
student_id=24CE055
first_name=Kheni
last_name=Urval
email=kheni@example.com
course=WDF
...
```

#### Read Students
```
action=read
page=1
limit=10
search=kheni
status=active
course=WDF
```

#### Update Student
```
action=update
id=1
gpa=3.90
semester=5
```

#### Delete Student
```
action=delete
id=1
```

#### Bulk Delete
```
action=bulk_delete
ids=1,2,3,4
```

#### Get Statistics
```
action=statistics
```

#### Export CSV
```
action=export
search=
status=active
course=
```

## Security Measures

### 1. SQL Injection Prevention
```php
// Using prepared statements
$sql = "SELECT * FROM students WHERE email = ?";
$stmt = $this->connection->prepare($sql);
$stmt->execute([$email]);
```

### 2. Input Validation
```php
function validateStudentData($data) {
    $errors = [];
    
    // Email validation
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
    
    // GPA validation
    if ($data['gpa'] < 0 || $data['gpa'] > 4.0) {
        $errors[] = 'GPA must be between 0.0 and 4.0';
    }
    
    return $errors;
}
```

### 3. Data Sanitization
```php
function sanitizeInput($input) {
    return trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
}
```

## Performance Optimizations

### 1. Database Indexing
```sql
-- Indexes for fast queries
INDEX idx_student_id (student_id),
INDEX idx_email (email),
INDEX idx_status (status),
INDEX idx_course (course)
```

### 2. Efficient Pagination
```php
// Count query separate from data query
$countSql = "SELECT COUNT(*) as total FROM students WHERE ...";
$dataSql = "SELECT * FROM students WHERE ... LIMIT ? OFFSET ?";
```

### 3. AJAX Loading
```javascript
// Asynchronous data loading
async function loadStudents() {
    try {
        const response = await fetch('operations.php', { ... });
        const data = await response.json();
        displayStudents(data.data);
    } catch (error) {
        showAlert('error', 'Failed to load students');
    }
}
```

## Error Handling

### 1. Database Errors
```php
try {
    $stmt->execute($params);
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        return ['success' => false, 'message' => 'Duplicate entry'];
    }
    return ['success' => false, 'message' => 'Database error'];
}
```

### 2. Validation Errors
```php
// Server-side validation
if (empty($data['email'])) {
    throw new Exception('Email is required');
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    throw new Exception('Invalid email format');
}
```

### 3. Frontend Error Display
```javascript
function showAlert(type, message) {
    const alertHTML = `
        <div class="alert alert-${type} alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.getElementById('alertContainer').innerHTML = alertHTML;
}
```

## Testing Features

### 1. Database Connection Test
```php
public function testConnection() {
    try {
        $stmt = $this->connection->query("SELECT 1");
        return true;
    } catch (PDOException $e) {
        return false;
    }
}
```

### 2. Data Validation Tests
```php
// Test invalid email
$invalidData = ['email' => 'invalid-email'];
$errors = validateStudentData($invalidData);
assert(!empty($errors));

// Test valid data
$validData = ['email' => 'test@example.com', 'gpa' => 3.5];
$errors = validateStudentData($validData);
assert(empty($errors));
```

### 3. CRUD Operation Tests
```javascript
// Test create operation
async function testCreateStudent() {
    const testData = {
        action: 'create',
        student_id: 'TEST001',
        first_name: 'Test',
        last_name: 'Student',
        email: 'test@example.com',
        course: 'Test Course'
    };
    
    const response = await fetch('operations.php', {
        method: 'POST',
        body: new URLSearchParams(testData)
    });
    
    const result = await response.json();
    console.log('Create test:', result.success ? 'PASSED' : 'FAILED');
}
```

## Browser Compatibility

- **Modern Browsers:** Chrome 90+, Firefox 88+, Safari 14+, Edge 90+
- **JavaScript:** ES6+ features used
- **CSS:** CSS3 with Flexbox and Grid
- **Bootstrap:** Version 5.3+ required

## Assignment Requirements Met

✅ **MySQL Database Integration** - Complete database setup and operations  
✅ **CRUD Operations** - Create, Read, Update, Delete functionality  
✅ **Prepared Statements** - SQL injection prevention  
✅ **Data Validation** - Server-side and client-side validation  
✅ **Pagination** - Efficient data pagination system  
✅ **Search Functionality** - Advanced search and filtering  
✅ **Error Handling** - Comprehensive error management  
✅ **Security Measures** - Input sanitization and validation  
✅ **Responsive Design** - Mobile-friendly interface  
✅ **OOP Implementation** - Object-oriented PHP code  
✅ **AJAX Integration** - Asynchronous operations  
✅ **Data Export** - CSV export functionality  
✅ **Statistics Dashboard** - Data analytics and reporting  

## Technical Specifications

- **PHP Version:** 7.4+ (Recommended: 8.0+)
- **MySQL Version:** 5.7+ (Recommended: 8.0+)
- **Web Server:** Apache/Nginx with PHP support
- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Framework:** Bootstrap 5.3
- **Icons:** Font Awesome 6.0
- **Architecture:** Model-View-Controller inspired

## Future Enhancements

1. **Advanced Features**
   - User authentication and authorization
   - Role-based access control
   - Audit logging and history tracking
   - Advanced reporting and analytics

2. **Performance Improvements**
   - Database query optimization
   - Caching implementation
   - CDN integration for static assets
   - API rate limiting

3. **Additional Functionality**
   - File upload for student documents
   - Email notification system
   - Bulk import from CSV/Excel
   - RESTful API endpoints

4. **Security Enhancements**
   - CSRF protection
   - XSS prevention
   - Session management
   - Password encryption

## Troubleshooting

### Common Issues

1. **Database Connection Failed**
   - Check MySQL server is running
   - Verify database credentials
   - Ensure database exists

2. **AJAX Requests Failing**
   - Check browser console for errors
   - Verify operations.php is accessible
   - Check PHP error logs

3. **Pagination Not Working**
   - Verify JavaScript is enabled
   - Check for console errors
   - Ensure proper data format

### Debug Mode
```php
// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Add debug output
error_log("Debug: " . print_r($data, true));
```

---

**© 2024 Kheni Urval (24CE055) - WDF: ITUE203 Assignment**

*This assignment demonstrates comprehensive MySQL database operations with modern web development practices, security measures, and user-friendly interface design.*
