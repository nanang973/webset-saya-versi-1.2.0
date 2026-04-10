<?php
// Cek struktur blog_posts vs blog_articles
$conn = new mysqli('localhost', 'root', '', 'portofolio_db');

if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

echo "<h2>Comparing Tables</h2>";

// Check blog_posts
echo "<h3>✓ blog_posts columns:</h3>";
$result = $conn->query("DESCRIBE blog_posts");
$blog_posts_cols = [];
if ($result) {
    while($row = $result->fetch_assoc()) {
        $blog_posts_cols[] = $row['Field'];
        echo "- " . $row['Field'] . " (" . $row['Type'] . ")<br>";
    }
} else {
    echo "❌ Error: " . $conn->error . "<br>";
}

// Check blog_articles
echo "<h3>✓ blog_articles columns:</h3>";
$result = $conn->query("DESCRIBE blog_articles");
$blog_articles_cols = [];
if ($result) {
    while($row = $result->fetch_assoc()) {
        $blog_articles_cols[] = $row['Field'];
        echo "- " . $row['Field'] . " (" . $row['Type'] . ")<br>";
    }
} else {
    echo "❌ Error: " . $conn->error . "<br>";
}

// Compare
echo "<h3>Missing in blog_posts:</h3>";
$missing = array_diff($blog_articles_cols, $blog_posts_cols);
if (empty($missing)) {
    echo "✓ No missing columns";
} else {
    foreach ($missing as $col) {
        echo "- " . $col . "<br>";
    }
}

$conn->close();
?>
