<?php

echo "<h2>Indexed Array</h2>";
$fruits = array("Apple", "Banana", "Mango");

foreach ($fruits as $index => $fruit) 
{
    echo "Index $index : $fruit <br>";
}



echo "<h2>Associative Array</h2>";
$student = array(
    "name" => "Raj",
    "age" => 20,
    "course" => "B.Tech"
);

foreach ($student as $key => $value) {
    echo ucfirst($key) . " : $value <br>";
}


echo "<h2>Multidimensional Array</h2>";
$students = array(
    array("Raj", 20, "B.Tech"),
    array("Priya", 21, "MBA"),
    array("Amit", 22, "MCA")
);

foreach ($students as $row) {
    echo "Name: " . $row[0] . " | Age: " . $row[1] . " | Course: " . $row[2] . "<br>";
}
?>
