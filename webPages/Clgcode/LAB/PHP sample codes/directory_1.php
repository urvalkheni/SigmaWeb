<?php
$dirname = "myfolder";

// Create directory if not exists
if (!is_dir($dirname)) {
    mkdir($dirname);
    echo "Directory created: $dirname <br>";
} else {
    echo "Directory already exists! <br>";
}

// List files in current directory
$files = scandir(".");
echo "Files and directories in current folder: <br>";
foreach ($files as $file) {
    echo $file . "<br>";
}
?>
