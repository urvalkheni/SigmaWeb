<?php
/**
 * Assignment 13: MySQL CRUD Operations
 * Student: Kheni Urval (24CE055)
 * Course: WDF: ITUE203
 * 
 * Database Configuration and Connection Management
 */

class DatabaseConnection {
    private static $instance = null;
    private $connection;
    private $host = 'localhost';
    private $database = 'student_management';
    private $username = 'root';
    private $password = '';
    
    private function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                ]
            );
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed. Please check configuration.");
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function testConnection() {
        try {
            $stmt = $this->connection->query("SELECT 1");
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function setupDatabase() {
        try {
            // Create database if not exists
            $createDB = "CREATE DATABASE IF NOT EXISTS {$this->database} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            $this->connection->exec($createDB);
            
            // Use the database
            $this->connection->exec("USE {$this->database}");
            
            // Create students table
            $createTable = "
                CREATE TABLE IF NOT EXISTS students (
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
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ";
            
            $this->connection->exec($createTable);
            
            // Insert sample data if table is empty
            $checkData = $this->connection->query("SELECT COUNT(*) as count FROM students")->fetch();
            
            if ($checkData['count'] == 0) {
                $this->insertSampleData();
            }
            
            return true;
            
        } catch (PDOException $e) {
            error_log("Database setup failed: " . $e->getMessage());
            throw new Exception("Database setup failed: " . $e->getMessage());
        }
    }
    
    private function insertSampleData() {
        $sampleStudents = [
            [
                'student_id' => '24CE055',
                'first_name' => 'Kheni',
                'last_name' => 'Urval',
                'email' => 'kheni.urval@student.edu',
                'phone' => '+91 98765 43210',
                'date_of_birth' => '2003-05-15',
                'course' => 'WDF: ITUE203',
                'semester' => 4,
                'gpa' => 3.85,
                'status' => 'active'
            ],
            [
                'student_id' => '24CE01',
                'first_name' => 'Raj',
                'last_name' => 'Patel',
                'email' => 'raj.patel@student.edu',
                'phone' => '+91 98765 43211',
                'date_of_birth' => '2003-03-20',
                'course' => 'Computer Engineering',
                'semester' => 4,
                'gpa' => 3.92,
                'status' => 'active'
            ],
            [
                'student_id' => '24CE02',
                'first_name' => 'Priya',
                'last_name' => 'Shah',
                'email' => 'priya.shah@student.edu',
                'phone' => '+91 98765 43212',
                'date_of_birth' => '2003-07-10',
                'course' => 'Information Technology',
                'semester' => 4,
                'gpa' => 3.78,
                'status' => 'active'
            ],
            [
                'student_id' => '24CE03',
                'first_name' => 'Arjun',
                'last_name' => 'Mehta',
                'email' => 'arjun.mehta@student.edu',
                'phone' => '+91 98765 43213',
                'date_of_birth' => '2002-12-05',
                'course' => 'Electronics Engineering',
                'semester' => 6,
                'gpa' => 3.65,
                'status' => 'active'
            ],
            [
                'student_id' => '24CE04',
                'first_name' => 'Sneha',
                'last_name' => 'Gupta',
                'email' => 'sneha.gupta@student.edu',
                'phone' => '+91 98765 43214',
                'date_of_birth' => '2003-01-25',
                'course' => 'Computer Science',
                'semester' => 4,
                'gpa' => 3.95,
                'status' => 'active'
            ],
            [
                'student_id' => '23CE15',
                'first_name' => 'Vikram',
                'last_name' => 'Singh',
                'email' => 'vikram.singh@student.edu',
                'phone' => '+91 98765 43215',
                'date_of_birth' => '2002-09-18',
                'course' => 'Mechanical Engineering',
                'semester' => 6,
                'gpa' => 3.72,
                'status' => 'active'
            ],
            [
                'student_id' => '22CE30',
                'first_name' => 'Kavya',
                'last_name' => 'Sharma',
                'email' => 'kavya.sharma@student.edu',
                'phone' => '+91 98765 43216',
                'date_of_birth' => '2001-11-12',
                'course' => 'Civil Engineering',
                'semester' => 8,
                'gpa' => 3.88,
                'status' => 'graduated'
            ],
            [
                'student_id' => '24CE05',
                'first_name' => 'Rohit',
                'last_name' => 'Kumar',
                'email' => 'rohit.kumar@student.edu',
                'phone' => '+91 98765 43217',
                'date_of_birth' => '2003-04-08',
                'course' => 'Software Engineering',
                'semester' => 4,
                'gpa' => 3.82,
                'status' => 'active'
            ],
            [
                'student_id' => '24CE06',
                'first_name' => 'Anita',
                'last_name' => 'Joshi',
                'email' => 'anita.joshi@student.edu',
                'phone' => '+91 98765 43218',
                'date_of_birth' => '2003-06-22',
                'course' => 'Computer Engineering',
                'semester' => 4,
                'gpa' => 3.90,
                'status' => 'active'
            ],
            [
                'student_id' => '23CE20',
                'first_name' => 'Amit',
                'last_name' => 'Verma',
                'email' => 'amit.verma@student.edu',
                'phone' => '+91 98765 43219',
                'date_of_birth' => '2002-08-14',
                'course' => 'Information Technology',
                'semester' => 6,
                'gpa' => 3.67,
                'status' => 'inactive'
            ]
        ];
        
        $sql = "INSERT INTO students (student_id, first_name, last_name, email, phone, date_of_birth, course, semester, gpa, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        
        foreach ($sampleStudents as $student) {
            $stmt->execute([
                $student['student_id'],
                $student['first_name'],
                $student['last_name'],
                $student['email'],
                $student['phone'],
                $student['date_of_birth'],
                $student['course'],
                $student['semester'],
                $student['gpa'],
                $student['status']
            ]);
        }
    }
    
    // Prevent cloning and unserialization
    private function __clone() {}
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}

/**
 * Student CRUD Operations Class
 */
class StudentCRUD {
    private $db;
    private $connection;
    
    public function __construct() {
        $this->db = DatabaseConnection::getInstance();
        $this->connection = $this->db->getConnection();
    }
    
    /**
     * Create a new student record
     */
    public function createStudent($data) {
        try {
            // Validate required fields
            $requiredFields = ['student_id', 'first_name', 'last_name', 'email', 'course'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    throw new Exception("Field '{$field}' is required");
                }
            }
            
            // Validate email format
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format");
            }
            
            // Validate GPA range
            if (isset($data['gpa']) && ($data['gpa'] < 0 || $data['gpa'] > 4.0)) {
                throw new Exception("GPA must be between 0.0 and 4.0");
            }
            
            // Check for duplicate student_id and email
            $checkSql = "SELECT COUNT(*) FROM students WHERE student_id = ? OR email = ?";
            $checkStmt = $this->connection->prepare($checkSql);
            $checkStmt->execute([$data['student_id'], $data['email']]);
            
            if ($checkStmt->fetchColumn() > 0) {
                throw new Exception("Student ID or email already exists");
            }
            
            $sql = "INSERT INTO students (student_id, first_name, last_name, email, phone, date_of_birth, course, semester, gpa, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->connection->prepare($sql);
            $result = $stmt->execute([
                $data['student_id'],
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['phone'] ?? null,
                $data['date_of_birth'] ?? null,
                $data['course'],
                $data['semester'] ?? 1,
                $data['gpa'] ?? null,
                $data['status'] ?? 'active'
            ]);
            
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Student created successfully',
                    'student_id' => $this->connection->lastInsertId()
                ];
            } else {
                throw new Exception("Failed to create student");
            }
            
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return [
                    'success' => false,
                    'message' => 'Student ID or email already exists'
                ];
            }
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Read student records with pagination and search
     */
    public function getStudents($page = 1, $limit = 10, $search = '', $status = '', $course = '') {
        try {
            $offset = ($page - 1) * $limit;
            
            // Build WHERE clause
            $whereConditions = [];
            $params = [];
            
            if (!empty($search)) {
                $whereConditions[] = "(first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR student_id LIKE ?)";
                $searchTerm = "%{$search}%";
                $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
            }
            
            if (!empty($status)) {
                $whereConditions[] = "status = ?";
                $params[] = $status;
            }
            
            if (!empty($course)) {
                $whereConditions[] = "course LIKE ?";
                $params[] = "%{$course}%";
            }
            
            $whereClause = empty($whereConditions) ? '' : 'WHERE ' . implode(' AND ', $whereConditions);
            
            // Get total count
            $countSql = "SELECT COUNT(*) as total FROM students {$whereClause}";
            $countStmt = $this->connection->prepare($countSql);
            $countStmt->execute($params);
            $totalRecords = $countStmt->fetch()['total'];
            
            // Get paginated results
            $sql = "SELECT * FROM students {$whereClause} ORDER BY created_at DESC LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            $students = $stmt->fetchAll();
            
            // Calculate pagination info
            $totalPages = ceil($totalRecords / $limit);
            
            return [
                'success' => true,
                'data' => $students,
                'pagination' => [
                    'current_page' => $page,
                    'total_pages' => $totalPages,
                    'total_records' => $totalRecords,
                    'per_page' => $limit,
                    'has_next' => $page < $totalPages,
                    'has_prev' => $page > 1
                ]
            ];
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Read a single student by ID
     */
    public function getStudent($id) {
        try {
            $sql = "SELECT * FROM students WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);
            
            $student = $stmt->fetch();
            
            if ($student) {
                return [
                    'success' => true,
                    'data' => $student
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Student not found'
                ];
            }
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Update student record
     */
    public function updateStudent($id, $data) {
        try {
            // Check if student exists
            $existingStudent = $this->getStudent($id);
            if (!$existingStudent['success']) {
                return $existingStudent;
            }
            
            // Validate email format if provided
            if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format");
            }
            
            // Validate GPA range if provided
            if (isset($data['gpa']) && ($data['gpa'] < 0 || $data['gpa'] > 4.0)) {
                throw new Exception("GPA must be between 0.0 and 4.0");
            }
            
            // Check for duplicate email/student_id (excluding current record)
            if (isset($data['email']) || isset($data['student_id'])) {
                $checkSql = "SELECT COUNT(*) FROM students WHERE (email = ? OR student_id = ?) AND id != ?";
                $checkStmt = $this->connection->prepare($checkSql);
                $checkStmt->execute([
                    $data['email'] ?? $existingStudent['data']['email'],
                    $data['student_id'] ?? $existingStudent['data']['student_id'],
                    $id
                ]);
                
                if ($checkStmt->fetchColumn() > 0) {
                    throw new Exception("Student ID or email already exists");
                }
            }
            
            // Build UPDATE query dynamically
            $allowedFields = [
                'student_id', 'first_name', 'last_name', 'email', 'phone',
                'date_of_birth', 'course', 'semester', 'gpa', 'status'
            ];
            
            $updateFields = [];
            $params = [];
            
            foreach ($allowedFields as $field) {
                if (isset($data[$field])) {
                    $updateFields[] = "{$field} = ?";
                    $params[] = $data[$field];
                }
            }
            
            if (empty($updateFields)) {
                return [
                    'success' => false,
                    'message' => 'No valid fields to update'
                ];
            }
            
            $sql = "UPDATE students SET " . implode(', ', $updateFields) . " WHERE id = ?";
            $params[] = $id;
            
            $stmt = $this->connection->prepare($sql);
            $result = $stmt->execute($params);
            
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Student updated successfully',
                    'affected_rows' => $stmt->rowCount()
                ];
            } else {
                throw new Exception("Failed to update student");
            }
            
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return [
                    'success' => false,
                    'message' => 'Student ID or email already exists'
                ];
            }
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Delete student record
     */
    public function deleteStudent($id) {
        try {
            // Check if student exists
            $existingStudent = $this->getStudent($id);
            if (!$existingStudent['success']) {
                return $existingStudent;
            }
            
            $sql = "DELETE FROM students WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            $result = $stmt->execute([$id]);
            
            if ($result && $stmt->rowCount() > 0) {
                return [
                    'success' => true,
                    'message' => 'Student deleted successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to delete student'
                ];
            }
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Get statistics
     */
    public function getStatistics() {
        try {
            $stats = [];
            
            // Total students
            $totalStmt = $this->connection->query("SELECT COUNT(*) as total FROM students");
            $stats['total_students'] = $totalStmt->fetch()['total'];
            
            // Students by status
            $statusStmt = $this->connection->query("SELECT status, COUNT(*) as count FROM students GROUP BY status");
            $stats['by_status'] = $statusStmt->fetchAll();
            
            // Students by course
            $courseStmt = $this->connection->query("SELECT course, COUNT(*) as count FROM students GROUP BY course ORDER BY count DESC LIMIT 5");
            $stats['by_course'] = $courseStmt->fetchAll();
            
            // Average GPA
            $gpaStmt = $this->connection->query("SELECT AVG(gpa) as avg_gpa FROM students WHERE gpa IS NOT NULL");
            $stats['average_gpa'] = round($gpaStmt->fetch()['avg_gpa'], 2);
            
            // Students by semester
            $semesterStmt = $this->connection->query("SELECT semester, COUNT(*) as count FROM students GROUP BY semester ORDER BY semester");
            $stats['by_semester'] = $semesterStmt->fetchAll();
            
            return [
                'success' => true,
                'data' => $stats
            ];
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Get distinct courses
     */
    public function getCourses() {
        try {
            $sql = "SELECT DISTINCT course FROM students WHERE course IS NOT NULL ORDER BY course";
            $stmt = $this->connection->query($sql);
            $courses = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            return [
                'success' => true,
                'data' => $courses
            ];
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Bulk delete students
     */
    public function bulkDelete($ids) {
        try {
            if (empty($ids) || !is_array($ids)) {
                return [
                    'success' => false,
                    'message' => 'No valid IDs provided'
                ];
            }
            
            $placeholders = str_repeat('?,', count($ids) - 1) . '?';
            $sql = "DELETE FROM students WHERE id IN ({$placeholders})";
            
            $stmt = $this->connection->prepare($sql);
            $result = $stmt->execute($ids);
            
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Students deleted successfully',
                    'deleted_count' => $stmt->rowCount()
                ];
            } else {
                throw new Exception("Failed to delete students");
            }
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Export students to CSV
     */
    public function exportToCSV($search = '', $status = '', $course = '') {
        try {
            // Get all students based on filters
            $result = $this->getStudents(1, 10000, $search, $status, $course);
            
            if (!$result['success']) {
                return $result;
            }
            
            $students = $result['data'];
            
            // Generate CSV content
            $csvContent = "ID,Student ID,First Name,Last Name,Email,Phone,Date of Birth,Course,Semester,GPA,Status,Enrollment Date\n";
            
            foreach ($students as $student) {
                $csvContent .= sprintf(
                    "%d,%s,%s,%s,%s,%s,%s,%s,%d,%.2f,%s,%s\n",
                    $student['id'],
                    $student['student_id'],
                    $student['first_name'],
                    $student['last_name'],
                    $student['email'],
                    $student['phone'] ?? '',
                    $student['date_of_birth'] ?? '',
                    $student['course'],
                    $student['semester'],
                    $student['gpa'] ?? 0.0,
                    $student['status'],
                    $student['enrollment_date']
                );
            }
            
            return [
                'success' => true,
                'data' => $csvContent,
                'count' => count($students)
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}

?>
