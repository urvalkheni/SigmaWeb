/*<?php
// Start the session
session_start();

// Set session variable
$_SESSION["username"] = "Asif";

// Display session variable
echo "Welcome, " . $_SESSION["username"];
?> */


<?php
// Set a cookie (name, value, time to expire)
setcookie("username", "Asif", time() + 3600, "/"); // expires in 1 hour

// Check if cookie is set
if(isset($_COOKIE["username"])) {
    echo "Welcome back, " . $_COOKIE["username"];
} else {
    echo "Hello, new user!";
}
?>   