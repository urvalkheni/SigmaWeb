<?php
// Quick database check
$conn = @new mysqli('localhost', 'root', '', 'student_management');

if ($conn->connect_error) {
    die("❌ Database 'student_management' doesn't exist!<br><br>
         <strong>Solution:</strong><br>
         1. Open <a href='http://localhost/phpmyadmin' target='_blank'>phpMyAdmin</a><br>
         2. Click 'SQL' tab<br>
         3. Copy content from <code>reset_database.sql</code><br>
         4. Paste and click 'Go'<br>
         5. Refresh this page");
}

$result = $conn->query("SELECT COUNT(*) as cnt FROM students");
$row = $result->fetch_assoc();

echo "✅ Database connected!<br>";
echo "✅ Found {$row['cnt']} students<br><br>";
echo "<a href='index.php'>Go to Application →</a>";
?>
