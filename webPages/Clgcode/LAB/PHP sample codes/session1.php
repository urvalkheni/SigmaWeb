<?php
session_start();
$_SESSION["username"] = "Asif";
$_SESSION["email"] = "asif@example.com";

echo "Session created!<br>";
echo "Session ID: " . session_id();
?>
