<?php
// 1. Function without parameters
function greet() 
{
    echo "Hello, Welcome to PHP Functions!<br>";
}

// 2. Function with parameters
function addNumbers($a, $b)
 {
    return $a + $b;
}

// 3. Function with default parameter
function sayHello($name = "Guest") 
{
    echo "Hello, $name!<br>";
}

// 4. Function returning multiple values (using array)
function calculate($x, $y)
 {
    $sum = $x + $y;
    $diff = $x - $y;
    $product = $x * $y;
    return array($sum, $diff, $product);
}

// ------------------- Calling functions -------------------

// Call function without parameters
greet();  

// Call function with parameters
echo "Sum of 10 and 20 is: " . addNumbers(10, 20) . "<br>";

// Call function with default parameter
sayHello();           // uses default "Guest"
sayHello("Mayuri");   // passes value

// Call function returning multiple values
$results = calculate(8, 4);
echo "Sum: " . $results[0] . "<br>";
echo "Difference: " . $results[1] . "<br>";
echo "Product: " . $results[2] . "<br>";
?>
