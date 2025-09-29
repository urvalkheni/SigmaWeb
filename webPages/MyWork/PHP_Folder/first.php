<!-- Modified by GitHub Copilot on 2025-09-22 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Basics</title>
    <!-- Disable favicon to prevent default "loveable" favicon -->
    <link rel="icon" href="data:,">
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; color: #222; margin: 40px; }
        h2 { color: #007bff; }
        .section { margin-bottom: 24px; }
        ul { padding-left: 20px; }
        .result { background: #e9ecef; padding: 10px; border-radius: 5px; display: inline-block; }
    </style>
</head>
<body>

<?php
// Improved PHP Example

// Greeting message
echo "<h2>Welcome to PHP Basics</h2>";

// Variables
$number = 9999999999;
$name = "PHP";
$urval = 12;
// Displaying variables
echo "<div class='section'>";
echo "<div class='result'>Number is: <strong>$number</strong></div><br>";
echo "<div class='result'>Language is: <strong>$name</strong></div>";
echo "</div>";

// Array example
$fruits = ["Apple", "Banana", "Mango", "Orange"];

// Loop through array
echo "<div class='section'>";
echo "Some fruits:";
echo "<ul>";
foreach ($fruits as $fruit) {
    echo "<li>$fruit</li>";
}
echo "</ul>";
echo "</div>";

// Function example
function square($n) {
    return $n * $n;
}

// New: Function to check if a number is even or odd
function isEven($n) {
    return $n % 2 === 0 ? "Even" : "Odd";
}

echo "<div class='section'>";
echo "The square of <strong>$urval</strong> is: <span class='result'>" . square($urval) . "</span><br>";
echo "The number <strong>$urval</strong> is: <span class='result'>" . isEven($urval) . "</span>";
echo "</div>";
?>

</body>
</html>
