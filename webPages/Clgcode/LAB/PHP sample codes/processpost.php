<?php
// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Collect data safely
    $name = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $age = (int) $_POST['age'];

    echo "<h2>Form Data Received (via POST):</h2>";
    echo "Name: " . $name . "<br>";
    echo "Email: " . $email . "<br>";
    echo "Age: " . $age . "<br>";

    // Example: Adding simple logic
    if ($age >= 18) {
        echo "<p style='color:green;'>You are eligible to register.</p>";
    } else {
        echo "<p style='color:red;'>Sorry, you must be 18 or older to register.</p>";
    }
}
?>
