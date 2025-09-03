
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="data:,">
</head>
<body>
    <h1>Server Side Scripting</h1>
    
    <?php
    function add($a, $b) {
        return $a + $b;
    }
    
    $str1 = "URVAL";
    $str2 = 777;
    ?>
    
    <span>
        <?php 
        echo "Welcome " . "Admin" . "<br>";
        echo "The Addition is = " . add(6,9) . "<br>";
        echo "Welcome " . $str1 . $str2 . "<br>";
        echo "Hello, World!<br>";
        ?>
    </span>

</body>
</html>