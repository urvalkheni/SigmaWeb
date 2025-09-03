<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="icon" href="data:,">
</head>
<body>
    <h2>Log in Panel</h2>
    <form action="" method="request">
        <input type="text" name="username" placeholder="Enter Username" required><br><br>
        <input type="password" name="password" placeholder="Enter Password" required><br><br>
        <input type="submit" name="login" value="Login"><br><br>
        
        <?php
        define("USER","AdminUrval");
        define("PASSWORD","12345");
        
        if(isset($_REQUEST['login'])) {
            $uname = $_REQUEST['username'];
            $psd = $_REQUEST['password'];
            setcookie("username", $uname);
            setcookie("password", $psd);
            if($uname == USER && $psd == PASSWORD) {
                header("Location: profile.php?username=$uname");
            }
            else{
                echo "Invalid Username or Password!";
            }
        }
        ?>
    </form>
   
</body>
</html>