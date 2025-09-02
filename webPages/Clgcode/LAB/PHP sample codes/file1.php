
<?php
$filename = "example.txt";

// Open file for reading
$file = fopen($filename, "r") or die("Unable to open file!");

// Read entire file
echo fread($file, filesize($filename));

// Close file
fclose($file);
?>
