<?php
require_once 'includes/config.php';

// Check image table
echo "<h2>Checking Database Tables</h2>";
echo "<pre>";

$result = $conn->query("SHOW TABLES");
echo "All tables:\n";
while ($row = $result->fetch_row()) {
    echo "- " . $row[0] . "\n";
}

echo "\n\nImage table structure:\n";
$check = $conn->query("DESCRIBE image");
if ($check) {
    while ($row = $check->fetch_assoc()) {
        echo $row['Field'] . " (" . $row['Type'] . ")\n";
    }
} else {
    echo "Image table does not exist\n";
}

// Check blog_posts table
echo "\n\nBlog posts table structure:\n";
$check = $conn->query("DESCRIBE blog_posts");
if ($check) {
    while ($row = $check->fetch_assoc()) {
        echo $row['Field'] . " (" . $row['Type'] . ")\n";
    }
}

echo "</pre>";
?>
