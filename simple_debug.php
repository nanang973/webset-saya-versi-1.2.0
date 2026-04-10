<?php
// Simplified debug without full config
$conn = new mysqli('localhost', 'root', '', 'portofolio_db');

if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

echo "=== STRUKTUR TABLE blog_posts ===\n\n";
$result = $conn->query('DESC blog_posts');
if ($result) {
    while($row = $result->fetch_assoc()) {
        echo sprintf("%-20s | %-20s | %-10s | %-10s\n", 
            $row['Field'], $row['Type'], $row['Null'], $row['Key']);
    }
} else {
    echo "Error: " . $conn->error . "\n";
}

echo "\n=== COBA INSERT TEST ===\n\n";
// Coba dengan field yang pasti ada
$test = $conn->prepare("
    INSERT INTO blog_posts 
    (title, slug, excerpt, featured_image, content, category, tags, status, author_id, published_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$test) {
    echo "❌ Prepare Error: " . $conn->error . "\n";
} else {
    $title = "Test";
    $slug = "test-" . time();
    $excerpt = "Test";
    $featured_image = "";
    $content = "{}";
    $category = "test";
    $tags = "test";
    $status = "draft";
    $author_id = 1;
    $published_at = null;
    
    $test->bind_param("ssssssssss", $title, $slug, $excerpt, $featured_image, $content, $category, $tags, $status, $author_id, $published_at);
    
    if ($test->execute()) {
        echo "✓ Insert berhasil!\n";
        echo "  New ID: " . $test->insert_id . "\n";
    } else {
        echo "❌ Execute Error: " . $test->error . "\n";
    }
}

$conn->close();
?>
