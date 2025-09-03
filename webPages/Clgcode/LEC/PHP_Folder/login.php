<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Log in Pannel</h2>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Enter Username" ><br><br>
        <input type="password" name="password" placeholder="Enter Password" ><br><br>
        <input type="text" name="department" placeholder="Enter Department" ><br><br>
        <input type="submit" value="Login"><br><br>
    <?php

    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["department"])) {
    $uname = $_REQUEST["username"];
    $psd = $_REQUEST["password"];
    $dp = $_REQUEST["department"];
    echo "Welcome " . $uname . "<br>";
        echo "Your Password is :: " . $psd . "<br>";
        echo "Your Department is :: " . $dp;
    }
        
?>
    </form>
   
</body>
</html>