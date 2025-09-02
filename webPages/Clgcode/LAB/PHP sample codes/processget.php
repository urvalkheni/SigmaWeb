<?php
// Check if form is submitted via GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    // Collect data safely
    $name = htmlspecialchars($_GET['username']);
    $email = htmlspecialchars($_GET['email']);
    $age = (int) $_GET['age'];

    echo "<h2>Form Data Received (via GET):</h2>";
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
