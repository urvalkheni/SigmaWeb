<?php
/**
 * Assignment 13: MySQL CRUD - Edit Student
 * Student: Kheni Urval (24CE055)
 * Course: WDF: ITUE203
 */

require_once 'config.php';

$error = '';
$success = '';
$student = null;

// Get student ID
$id = $_GET['id'] ?? $_POST['id'] ?? '';

if (empty($id) || !is_numeric($id)) {
    header('Location: list.php');
    exit();
}

// Fetch student data
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $branch = trim($_POST['branch'] ?? '');
    
    // Server-side validation
    if (empty($name)) {
        $error = 'Name is required';
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Valid email is required';
    } elseif (empty($branch)) {
        $error = 'Branch is required';
    } else {
        try {
            $stmt = $db->prepare("UPDATE students SET name = ?, email = ?, branch = ? WHERE id = ?");
            $stmt->execute([$name, $email, $branch, $id]);
            
            $success = 'Student updated successfully!';
            // Refresh student data
            $stmt = $db->prepare("SELECT * FROM students WHERE id = ?");
            $stmt->execute([$id]);
            $student = $stmt->fetch();
            
            header('refresh:2;url=list.php');
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = 'Email already exists';
            } else {
                $error = 'Error updating student: ' . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - Assignment 13</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin: 15px 0; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 300px; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #545b62; }
        .error { color: red; margin: 10px 0; }
        .success { color: green; margin: 10px 0; }
        .header { margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Edit Student</h1>
        <p><strong>Student:</strong> Kheni Urval (24CE055) | <strong>Course:</strong> WDF: ITUE203</p>
    </div>
    
    <a href="list.php" class="btn btn-secondary">← Back to List</a>
    
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <?php if ($student): ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
        
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? $student['name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? $student['email']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="branch">Branch *</label>
            <select id="branch" name="branch" required>
                <option value="">Select Branch</option>
                <?php
                $branches = ['Computer Engineering', 'Information Technology', 'Electronics Engineering', 'Mechanical Engineering', 'Civil Engineering'];
                $selectedBranch = $_POST['branch'] ?? $student['branch'];
                foreach ($branches as $branch) {
                    $selected = ($selectedBranch === $branch) ? 'selected' : '';
                    echo "<option value=\"$branch\" $selected>$branch</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Update Student</button>
            <a href="list.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    <?php endif; ?>
</body>
</html>
