<?php
require_once 'includes/config.php';

echo "<h2>Blog Posts Data</h2>";
$result = $conn->query("SELECT id, title, slug, status, content FROM blog_posts ORDER BY created_at DESC LIMIT 5");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "<hr>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "ID: " . $row['id'] . " | Status: " . $row['status'] . "<br>";
        echo "<h4>Content struktur:</h4>";
        echo "<pre>";
        $decoded = json_decode($row['content'], true);
        if (is_array($decoded)) {
            echo "✓ Valid JSON array dengan " . count($decoded) . " blok:\n";
            foreach ($decoded as $i => $block) {
                echo "  Block " . $i . ": " . $block['type'] . "\n";
            }
        } else {
            echo "✗ Bukan JSON array\n";
            echo "Raw content:\n";
            echo substr($row['content'], 0, 200) . "...\n";
        }
        echo "</pre>";
    }
} else {
    echo "Error: " . $conn->error;
}
?>
