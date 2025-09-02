<?php
$filename = "example_write.txt";

// Open file for appending ("a" = append)
$file = fopen($filename, "a") or die("Unable to open file!");

// Append new line
fwrite($file, "\nThis line is appended later.");

// Close file
fclose($file);

echo "Text appended successfully!";
?>
