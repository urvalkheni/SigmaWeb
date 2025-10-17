<?php
/**
 * Assignment 13: MySQL CRUD - Delete Student
 * Student: Kheni Urval (24CE055)
 * Course: WDF: ITUE203
 */

require_once 'config.php';

$error = '';
$success = '';

// Get student ID
$id = $_GET['id'] ?? $_POST['id'] ?? '';

if (empty($id) || !is_numeric($id)) {
    header('Location: list.php');
    exit();
}

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    try {
        $db = DatabaseConnection::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$id]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['message'] = 'Student deleted successfully!';
        } else {
            $_SESSION['error'] = 'Student not found!';
        }
        
        header('Location: list.php');
        exit();
    } catch (PDOException $e) {
        $error = 'Error deleting student: ' . $e->getMessage();
    }
}

// Fetch student data for confirmation
try {
    $db = DatabaseConnection::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch();
    
    if (!$student) {
        header('Location: list.php');
        exit();
    }
} catch (PDOException $e) {
    $error = 'Error fetching student: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student - Assignment 13</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .btn { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #545b62; }
        .error { color: red; margin: 10px 0; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 4px; margin: 20px 0; }
        .student-details { background: #f8f9fa; padding: 15px; border-radius: 4px; margin: 20px 0; }
        .header { margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Delete Student</h1>
        <p><strong>Student:</strong> Kheni Urval (24CE055) | <strong>Course:</strong> WDF: ITUE203</p>
    </div>
    
    <a href="list.php" class="btn btn-secondary">← Back to List</a>
    
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if (isset($student)): ?>
        <div class="warning">
            <strong>⚠ Warning:</strong> You are about to delete the following student. This action cannot be undone.
        </div>
        
        <div class="student-details">
            <h3>Student Details</h3>
            <p><strong>ID:</strong> <?php echo $student['id']; ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($student['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
            <p><strong>Branch:</strong> <?php echo htmlspecialchars($student['branch']); ?></p>
            <p><strong>Created:</strong> <?php echo $student['created_at']; ?></p>
        </div>
        
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this student? This action cannot be undone.');">
            <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
            <button type="submit" name="confirm_delete" class="btn btn-danger">Yes, Delete Student</button>
            <a href="list.php" class="btn btn-secondary">Cancel</a>
        </form>
    <?php endif; ?>
</body>
</html>
