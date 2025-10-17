<?php
/**
 * AJAX Operations Handler
 * Student: Kheni Urval (24CE055)
 * Assignment 13: MySQL CRUD Operations
 * Course: WDF: ITUE203
 */

// Start output buffering to prevent any accidental output
ob_start();

// Disable error display and send JSON errors instead
error_reporting(0);
ini_set('display_errors', 0);

// Clear any previous output
if (ob_get_length()) ob_clean();

// Set JSON header
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'student_management';

// Create connection
$conn = @new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        'success' => false, 
        'message' => 'Database connection failed. Please run reset_database.sql first!',
        'error' => $conn->connect_error
    ]);
    exit;
}

$conn->set_charset('utf8mb4');

// Get the action from POST request
$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'get_students':
            getStudents($conn);
            break;
        
        case 'get_statistics':
            getStatistics($conn);
            break;
        
        case 'get_courses':
            getCourses($conn);
            break;
        
        case 'add_student':
            addStudent($conn);
            break;
        
        case 'update_student':
            updateStudent($conn);
            break;
        
        case 'delete_student':
            deleteStudent($conn);
            break;
        
        case 'search_students':
            searchStudents($conn);
            break;
        
        case 'export_csv':
            exportCSV($conn);
            break;
        
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

/**
 * Get all students with optional filters
 */
function getStudents($conn) {
    $search = $_POST['search'] ?? '';
    $status = $_POST['status'] ?? '';
    $course = $_POST['course'] ?? '';
    
    $sql = "SELECT * FROM students WHERE 1=1";
    $params = [];
    
    if (!empty($search)) {
        $sql .= " AND (student_id LIKE ? OR name LIKE ? OR email LIKE ?)";
        $searchParam = "%$search%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
    }
    
    if (!empty($status)) {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    
    if (!empty($course)) {
        $sql .= " AND course = ?";
        $params[] = $course;
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    
    echo json_encode(['success' => true, 'students' => $students]);
}

/**
 * Get statistics for dashboard
 */
function getStatistics($conn) {
    $stats = [];
    
    // Total students
    $result = $conn->query("SELECT COUNT(*) as total FROM students");
    $stats['total'] = $result->fetch_assoc()['total'];
    
    // Active students
    $result = $conn->query("SELECT COUNT(*) as active FROM students WHERE status = 'Active'");
    $stats['active'] = $result->fetch_assoc()['active'];
    
    // Graduated students
    $result = $conn->query("SELECT COUNT(*) as graduated FROM students WHERE status = 'Graduated'");
    $stats['graduated'] = $result->fetch_assoc()['graduated'];
    
    // Inactive students
    $result = $conn->query("SELECT COUNT(*) as inactive FROM students WHERE status = 'Inactive'");
    $stats['inactive'] = $result->fetch_assoc()['inactive'];
    
    echo json_encode(['success' => true, 'statistics' => $stats]);
}

/**
 * Get unique courses for filter dropdown
 */
function getCourses($conn) {
    $result = $conn->query("SELECT DISTINCT course FROM students ORDER BY course");
    
    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row['course'];
    }
    
    echo json_encode(['success' => true, 'courses' => $courses]);
}

/**
 * Add new student
 */
function addStudent($conn) {
    $student_id = $_POST['student_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $course = $_POST['course'] ?? '';
    $semester = $_POST['semester'] ?? '';
    $gpa = $_POST['gpa'] ?? '';
    $status = $_POST['status'] ?? 'Active';
    
    // Validate required fields
    if (empty($student_id) || empty($name) || empty($email) || empty($course)) {
        echo json_encode(['success' => false, 'message' => 'All required fields must be filled']);
        return;
    }
    
    // Check if student ID or email already exists
    $stmt = $conn->prepare("SELECT id FROM students WHERE student_id = ? OR email = ?");
    $stmt->bind_param('ss', $student_id, $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Student ID or Email already exists']);
        return;
    }
    
    // Insert new student
    $stmt = $conn->prepare("INSERT INTO students (student_id, name, email, course, semester, gpa, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssds', $student_id, $name, $email, $course, $semester, $gpa, $status);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Student added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add student']);
    }
}

/**
 * Update existing student
 */
function updateStudent($conn) {
    $id = $_POST['id'] ?? '';
    $student_id = $_POST['student_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $course = $_POST['course'] ?? '';
    $semester = $_POST['semester'] ?? '';
    $gpa = $_POST['gpa'] ?? '';
    $status = $_POST['status'] ?? 'Active';
    
    // Validate required fields
    if (empty($id) || empty($student_id) || empty($name) || empty($email) || empty($course)) {
        echo json_encode(['success' => false, 'message' => 'All required fields must be filled']);
        return;
    }
    
    // Check if student ID or email already exists (excluding current student)
    $stmt = $conn->prepare("SELECT id FROM students WHERE (student_id = ? OR email = ?) AND id != ?");
    $stmt->bind_param('ssi', $student_id, $email, $id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Student ID or Email already exists']);
        return;
    }
    
    // Update student
    $stmt = $conn->prepare("UPDATE students SET student_id = ?, name = ?, email = ?, course = ?, semester = ?, gpa = ?, status = ? WHERE id = ?");
    $stmt->bind_param('sssssdi', $student_id, $name, $email, $course, $semester, $gpa, $status, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Student updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update student']);
    }
}

/**
 * Delete student
 */
function deleteStudent($conn) {
    $id = $_POST['id'] ?? '';
    
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'Student ID is required']);
        return;
    }
    
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param('i', $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Student deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete student']);
    }
}

/**
 * Search students
 */
function searchStudents($conn) {
    getStudents($conn);
}

/**
 * Export students to CSV
 */
function exportCSV($conn) {
    $result = $conn->query("SELECT * FROM students ORDER BY created_at DESC");
    
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    
    echo json_encode(['success' => true, 'students' => $students]);
}

// Flush output buffer
ob_end_flush();
