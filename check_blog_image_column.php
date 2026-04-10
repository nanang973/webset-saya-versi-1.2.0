<?php
require_once 'includes/config.php';

// Check and add image column to blog_posts if not exists
echo "<h2>Checking blog_posts table</h2>";
echo "<pre>";

$result = $conn->query("SHOW COLUMNS FROM blog_posts");
$has_image = false;
echo "Current columns:\n";
while ($row = $result->fetch_assoc()) {
    echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
    if ($row['Field'] === 'image') {
        $has_image = true;
    }
}

if (!$has_image) {
    echo "\n\nAdding 'image' column to blog_posts...\n";
    if ($conn->query("ALTER TABLE blog_posts ADD COLUMN image VARCHAR(255) DEFAULT NULL")) {
        echo "✅ Column 'image' berhasil ditambahkan!\n";
    } else {
        echo "❌ Error: " . $conn->error . "\n";
    }
} else {
    echo "\n✅ Column 'image' sudah ada!\n";
}

echo "</pre>";
?>
