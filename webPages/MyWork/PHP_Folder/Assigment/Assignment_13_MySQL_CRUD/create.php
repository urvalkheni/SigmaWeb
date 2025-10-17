<?php
/**
 * Assignment 13: MySQL CRUD - Create Student
 * Student: Kheni Urval (24CE055)
 * Course: WDF: ITUE203
 */

require_once 'config.php';

$error = '';
$success = '';

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
            $db = DatabaseConnection::getInstance()->getConnection();
            $stmt = $db->prepare("INSERT INTO students (name, email, branch) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $branch]);
            
            $success = 'Student created successfully!';
            header('refresh:2;url=list.php');
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = 'Email already exists';
            } else {
                $error = 'Error creating student: ' . $e->getMessage();
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
    <title>Create Student - Assignment 13</title>
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
        <h1>Create New Student</h1>
        <p><strong>Student:</strong> Kheni Urval (24CE055) | <strong>Course:</strong> WDF: ITUE203</p>
    </div>
    
    <a href="list.php" class="btn btn-secondary">← Back to List</a>
    
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="branch">Branch *</label>
            <select id="branch" name="branch" required>
                <option value="">Select Branch</option>
                <option value="Computer Engineering" <?php echo (($_POST['branch'] ?? '') === 'Computer Engineering') ? 'selected' : ''; ?>>Computer Engineering</option>
                <option value="Information Technology" <?php echo (($_POST['branch'] ?? '') === 'Information Technology') ? 'selected' : ''; ?>>Information Technology</option>
                <option value="Electronics Engineering" <?php echo (($_POST['branch'] ?? '') === 'Electronics Engineering') ? 'selected' : ''; ?>>Electronics Engineering</option>
                <option value="Mechanical Engineering" <?php echo (($_POST['branch'] ?? '') === 'Mechanical Engineering') ? 'selected' : ''; ?>>Mechanical Engineering</option>
                <option value="Civil Engineering" <?php echo (($_POST['branch'] ?? '') === 'Civil Engineering') ? 'selected' : ''; ?>>Civil Engineering</option>
            </select>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Create Student</button>
            <a href="list.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</body>
</html>
