<?php
// Improved PHP Example

// Greeting message
echo "<h2>Welcome to PHP Basics</h2>";

// Variables
$number = 8238496254;
$name = "PHP";

// Displaying variables
echo "Number is: <strong>$number</strong><br>";
echo "Language is: <strong>$name</strong><br><br>";

// Array example
$fruits = ["Apple", "Banana", "Mango"];

// Loop through array
echo "Some fruits:<br>";
foreach ($fruits as $fruit) {
    echo "- $fruit <br>";
}
echo "<br>";

// Function example
function square($n) {
    return $n * $n;
}

echo "The square of $number is: " . square($number) . "<br>";
?>
