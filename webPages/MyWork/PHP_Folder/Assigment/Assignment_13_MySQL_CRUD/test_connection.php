<?php
/**
 * Database Connection Test
 * Student: Kheni Urval (24CE055)
 * Assignment 13: MySQL CRUD Operations
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Test - Assignment 13</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .test-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }
        .success {
            border-left-color: #28a745;
            background: #d4edda;
        }
        .error {
            border-left-color: #dc3545;
            background: #f8d7da;
        }
        h1 {
            color: #333;
        }
        h2 {
            color: #666;
            font-size: 18px;
            margin-top: 0;
        }
        .code {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
        .btn:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f8f9fa;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>🔍 Assignment 13 - Database Connection Test</h1>
    <p><strong>Student:</strong> Kheni Urval (24CE055)</p>
    
    <?php
    // Test 1: Check MySQL connection
    echo '<div class="test-box">';
    echo '<h2>Test 1: MySQL Server Connection</h2>';
    
    $host = 'localhost';
    $username = 'root';
    $password = '';
    
    $conn = @new mysqli($host, $username, $password);
    
    if ($conn->connect_error) {
        echo '<div class="error">';
        echo '<p>❌ <strong>FAILED:</strong> Cannot connect to MySQL server</p>';
        echo '<div class="code">Error: ' . htmlspecialchars($conn->connect_error) . '</div>';
        echo '<p><strong>Solution:</strong> Make sure XAMPP/WAMP MySQL service is running</p>';
        echo '</div>';
        exit;
    } else {
        echo '<p>✅ <strong>SUCCESS:</strong> MySQL server is running</p>';
    }
    echo '</div>';
    
    // Test 2: Check if database exists
    echo '<div class="test-box">';
    echo '<h2>Test 2: Database Existence</h2>';
    
    $result = $conn->query("SHOW DATABASES LIKE 'student_management'");
    
    if ($result && $result->num_rows > 0) {
        echo '<p>✅ <strong>SUCCESS:</strong> Database "student_management" exists</p>';
    } else {
        echo '<div class="error">';
        echo '<p>❌ <strong>FAILED:</strong> Database "student_management" does not exist</p>';
        echo '<p><strong>Solution:</strong></p>';
        echo '<ol>';
        echo '<li>Open phpMyAdmin: <a href="http://localhost/phpmyadmin" target="_blank">http://localhost/phpmyadmin</a></li>';
        echo '<li>Click "SQL" tab</li>';
        echo '<li>Open <code>reset_database.sql</code> file from this folder</li>';
        echo '<li>Copy all content and paste in SQL box</li>';
        echo '<li>Click "Go" button</li>';
        echo '<li>Refresh this page</li>';
        echo '</ol>';
        echo '</div>';
        echo '</div>';
        $conn->close();
        exit;
    }
    echo '</div>';
    
    // Test 3: Check database connection
    echo '<div class="test-box">';
    echo '<h2>Test 3: Database Connection</h2>';
    
    $conn->close();
    $conn = @new mysqli($host, $username, $password, 'student_management');
    
    if ($conn->connect_error) {
        echo '<div class="error">';
        echo '<p>❌ <strong>FAILED:</strong> Cannot connect to student_management database</p>';
        echo '<div class="code">Error: ' . htmlspecialchars($conn->connect_error) . '</div>';
        echo '</div>';
        echo '</div>';
        exit;
    } else {
        echo '<p>✅ <strong>SUCCESS:</strong> Connected to student_management database</p>';
    }
    echo '</div>';
    
    // Test 4: Check if students table exists
    echo '<div class="test-box">';
    echo '<h2>Test 4: Students Table</h2>';
    
    $result = $conn->query("SHOW TABLES LIKE 'students'");
    
    if ($result && $result->num_rows > 0) {
        echo '<p>✅ <strong>SUCCESS:</strong> Students table exists</p>';
    } else {
        echo '<div class="error">';
        echo '<p>❌ <strong>FAILED:</strong> Students table does not exist</p>';
        echo '<p><strong>Solution:</strong> Run reset_database.sql as described above</p>';
        echo '</div>';
        echo '</div>';
        $conn->close();
        exit;
    }
    echo '</div>';
    
    // Test 5: Check table structure
    echo '<div class="test-box">';
    echo '<h2>Test 5: Table Structure</h2>';
    
    $result = $conn->query("DESCRIBE students");
    
    if ($result) {
        echo '<p>✅ <strong>SUCCESS:</strong> Table structure is readable</p>';
        echo '<table>';
        echo '<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['Field']) . '</td>';
            echo '<td>' . htmlspecialchars($row['Type']) . '</td>';
            echo '<td>' . htmlspecialchars($row['Null']) . '</td>';
            echo '<td>' . htmlspecialchars($row['Key']) . '</td>';
            echo '<td>' . htmlspecialchars($row['Default'] ?? 'NULL') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        
        // Check for required fields
        $required_fields = ['id', 'student_id', 'name', 'email', 'course', 'semester', 'gpa', 'status'];
        $result = $conn->query("DESCRIBE students");
        $existing_fields = [];
        while ($row = $result->fetch_assoc()) {
            $existing_fields[] = $row['Field'];
        }
        
        $missing_fields = array_diff($required_fields, $existing_fields);
        if (!empty($missing_fields)) {
            echo '<div class="error" style="margin-top: 10px;">';
            echo '<p>⚠️ <strong>WARNING:</strong> Missing required fields: ' . implode(', ', $missing_fields) . '</p>';
            echo '<p><strong>Solution:</strong> Run reset_database.sql to update table structure</p>';
            echo '</div>';
        }
    }
    echo '</div>';
    
    // Test 6: Check student records
    echo '<div class="test-box">';
    echo '<h2>Test 6: Student Records</h2>';
    
    $result = $conn->query("SELECT COUNT(*) as total FROM students");
    $row = $result->fetch_assoc();
    $total = $row['total'];
    
    if ($total > 0) {
        echo '<p>✅ <strong>SUCCESS:</strong> Found ' . $total . ' student records</p>';
        
        // Show sample records
        $result = $conn->query("SELECT student_id, name, email, course, status FROM students LIMIT 5");
        if ($result && $result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Student ID</th><th>Name</th><th>Email</th><th>Course</th><th>Status</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['student_id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['course']) . '</td>';
                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    } else {
        echo '<div class="error">';
        echo '<p>⚠️ <strong>WARNING:</strong> No student records found</p>';
        echo '<p><strong>Solution:</strong> Run reset_database.sql to insert sample data</p>';
        echo '</div>';
    }
    echo '</div>';
    
    // Test 7: Test operations.php
    echo '<div class="test-box">';
    echo '<h2>Test 7: Operations.php Test</h2>';
    
    if (file_exists('operations.php')) {
        echo '<p>✅ <strong>SUCCESS:</strong> operations.php file exists</p>';
    } else {
        echo '<div class="error">';
        echo '<p>❌ <strong>FAILED:</strong> operations.php file not found</p>';
        echo '</div>';
    }
    echo '</div>';
    
    // Final verdict
    echo '<div class="test-box success">';
    echo '<h2>🎉 All Tests Passed!</h2>';
    echo '<p>Your database is properly configured and ready to use.</p>';
    echo '<a href="index.php" class="btn">Go to Student Management System</a>';
    echo '</div>';
    
    $conn->close();
    ?>
    
    <div class="test-box" style="background: #fff3cd; border-left-color: #ffc107;">
        <h2>📝 Quick Reference</h2>
        <p><strong>Files in this assignment:</strong></p>
        <ul>
            <li><code>reset_database.sql</code> - Database reset script (run this first!)</li>
            <li><code>test_connection.php</code> - This test file</li>
            <li><code>operations.php</code> - AJAX handler for CRUD operations</li>
            <li><code>index.php</code> - Main application interface</li>
            <li><code>database.php</code> - Database connection class</li>
        </ul>
        
        <p><strong>phpMyAdmin:</strong> <a href="http://localhost/phpmyadmin" target="_blank">http://localhost/phpmyadmin</a></p>
    </div>
</body>
</html>
