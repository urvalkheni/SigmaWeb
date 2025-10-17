<?php
/**
 * Assignment 11: PHP File I/O - Guestbook List
 * Student: Kheni Urval (24CE055)
 * Course: WDF: ITUE203
 * 
 * Simple script to read and display guestbook entries
 */

// Define storage file
$storage_file = 'guestbook_entries.txt';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestbook Entries - Kheni Urval (24CE055)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .entry { border: 1px solid #ccc; margin: 10px 0; padding: 15px; border-radius: 5px; }
        .entry-header { font-weight: bold; color: #333; }
        .entry-content { margin-top: 10px; }
        .back-link { display: inline-block; margin: 20px 0; padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Guestbook Entries</h1>
    <p><strong>Student:</strong> Kheni Urval (24CE055) | <strong>Course:</strong> WDF: ITUE203</p>
    
    <a href="guestbook.php" class="back-link">← Back to Guestbook</a>
    
    <div id="entries">
        <?php
        if (file_exists($storage_file)) {
            $entries = file($storage_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            if (empty($entries)) {
                echo '<p>No guestbook entries yet. <a href="guestbook.php">Be the first to sign!</a></p>';
            } else {
                foreach (array_reverse($entries) as $entry) {
                    $parts = explode('|', $entry);
                    if (count($parts) >= 4) {
                        $name = htmlspecialchars($parts[0]);
                        $email = htmlspecialchars($parts[1]);
                        $message = htmlspecialchars($parts[2]);
                        $timestamp = htmlspecialchars($parts[3]);
                        
                        echo '<div class="entry">';
                        echo '<div class="entry-header">' . $name . ' (' . $email . ') - ' . $timestamp . '</div>';
                        echo '<div class="entry-content">' . nl2br($message) . '</div>';
                        echo '</div>';
                    }
                }
            }
        } else {
            echo '<p>No guestbook entries yet. <a href="guestbook.php">Be the first to sign!</a></p>';
        }
        ?>
    </div>
    
    <a href="guestbook.php" class="back-link">← Back to Guestbook</a>
    
    <footer style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #ccc; color: #666;">
        <p>&copy; 2025 Assignment 11: PHP File I/O Guestbook | Student: Kheni Urval (24CE055) | Course: WDF: ITUE203</p>
    </footer>
</body>
</html>
