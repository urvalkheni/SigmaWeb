<?php
$filename = "example_write.txt";

// Open file for writing ("w" = write, will create if not exists)
$file = fopen($filename, "w") or die("Unable to open file!");

// Write some text
fwrite($file, "Hello, this is a file handling example in PHP.\n");
fwrite($file, "Second line of text.");

// Close file
fclose($file);

echo "File created and written successfully!";
?>