<?php
require_once 'includes/config.php';

echo "=== STRUKTUR TABLE blog_posts ===\n";
$result = $conn->query('DESC blog_posts');
if ($result) {
    while($row = $result->fetch_assoc()) {
        echo $row['Field'] . ' | ' . $row['Type'] . ' | ' . $row['Null'] . ' | ' . $row['Key'] . "\n";
    }
} else {
    echo "Error: " . $conn->error . "\n";
}

echo "\n=== CURRENT BLOG POSTS DATA ===\n";
$result = $conn->query('SELECT * FROM blog_posts');
if ($result) {
    echo "Total rows: " . $result->num_rows . "\n";
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " | Title: " . $row['title'] . "\n";
    }
} else {
    echo "Error: " . $conn->error . "\n";
}

echo "\n=== TESTING INSERT ===\n";
$test_stmt = $conn->prepare("
    INSERT INTO blog_posts 
    (title, slug, excerpt, featured_image, content, category, tags, status, author_id, published_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$test_stmt) {
    echo "Prepare Error: " . $conn->error . "\n";
} else {
    $title = "Test Article";
    $slug = "test-article";
    $excerpt = "Test excerpt";
    $featured_image = "";
    $content = "[]";
    $category = "test";
    $tags = "test";
    $status = "draft";
    $author_id = 1;
    $published_at = null;
    
    $test_stmt->bind_param(
        "ssssssssss",
        $title,
        $slug,
        $excerpt,
        $featured_image,
        $content,
        $category,
        $tags,
        $status,
        $author_id,
        $published_at
    );
    
    if ($test_stmt->execute()) {
        echo "✓ Insert successful\n";
    } else {
        echo "Execute Error: " . $test_stmt->error . "\n";
    }
}
?>
