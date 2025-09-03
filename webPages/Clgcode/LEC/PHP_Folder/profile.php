<?php
    $uname = $_REQUEST["username"];
    $psd = $_REQUEST["password"];
    $dp = $_REQUEST["department"];
    echo "Welcome " . $uname . "<br>";
    echo "Your Password is :: " . $psd . "<br>";
    echo "Your Department is :: " . $dp;
?>