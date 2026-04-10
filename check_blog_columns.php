<?php
require_once 'includes/config.php';

echo "<h2>Checking blog_posts table columns</h2>";
echo "<pre>";

$result = $conn->query("DESCRIBE blog_posts");
$columns = [];
echo "Current columns:\n";
while ($row = $result->fetch_assoc()) {
    echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
    $columns[] = $row['Field'];
}

echo "\n\nAdding missing columns...\n";

// Add description column if not exists
if (!in_array('description', $columns)) {
    if ($conn->query("ALTER TABLE blog_posts ADD COLUMN description TEXT")) {
        echo "✅ Column 'description' berhasil ditambahkan!\n";
    } else {
        echo "❌ Error adding description: " . $conn->error . "\n";
    }
}

// Add html_file column if not exists
if (!in_array('html_file', $columns)) {
    if ($conn->query("ALTER TABLE blog_posts ADD COLUMN html_file VARCHAR(255)")) {
        echo "✅ Column 'html_file' berhasil ditambahkan!\n";
    } else {
        echo "❌ Error adding html_file: " . $conn->error . "\n";
    }
}

// Drop content column if exists (optional - only if you want to fully migrate)
// if (in_array('content', $columns)) {
//     if ($conn->query("ALTER TABLE blog_posts DROP COLUMN content")) {
//         echo "✅ Column 'content' berhasil dihapus!\n";
//     } else {
//         echo "⚠️ Could not drop content column: " . $conn->error . "\n";
//     }
// }

echo "\nDone!\n";
echo "</pre>";
?>
