<?php
// Drop existing blog_posts and recreate with correct structure
$conn = new mysqli('localhost', 'root', '', 'portofolio_db');

if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

echo "<h2>Fixing blog_posts table</h2>";

// First, backup data
$backup = $conn->query("SELECT * FROM blog_posts");
$backup_data = [];
if ($backup) {
    while ($row = $backup->fetch_assoc()) {
        $backup_data[] = $row;
    }
    echo "✓ Backed up " . count($backup_data) . " records<br>";
}

// Drop old table
if ($conn->query("DROP TABLE IF EXISTS blog_posts")) {
    echo "✓ Dropped old blog_posts<br>";
} else {
    echo "❌ Error dropping table: " . $conn->error . "<br>";
}

// Create new table with correct structure
$sql = "CREATE TABLE `blog_posts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `excerpt` TEXT,
  `featured_image` VARCHAR(500),
  `content` LONGTEXT NOT NULL COMMENT 'JSON format',
  `category` VARCHAR(100),
  `tags` VARCHAR(500),
  `status` ENUM('draft', 'published') DEFAULT 'draft',
  `view_count` INT DEFAULT 0,
  `author_id` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published_at` DATETIME,
  `description` TEXT,
  `html_file` VARCHAR(255),
  `image` VARCHAR(255),
  INDEX `idx_slug` (`slug`),
  INDEX `idx_status` (`status`),
  INDEX `idx_category` (`category`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql)) {
    echo "✓ Created new blog_posts table with correct structure<br>";
} else {
    echo "❌ Error creating table: " . $conn->error . "<br>";
}

// Restore data if any
if (!empty($backup_data)) {
    echo "<br><h3>Restoring data:</h3>";
    foreach ($backup_data as $row) {
        $title = $conn->real_escape_string($row['title']);
        $slug = $conn->real_escape_string($row['slug']);
        $excerpt = isset($row['excerpt']) ? $conn->real_escape_string($row['excerpt']) : '';
        $featured_image = isset($row['featured_image']) ? $conn->real_escape_string($row['featured_image']) : '';
        $content = isset($row['content']) ? $conn->real_escape_string($row['content']) : '{}';
        $category = isset($row['category']) ? $conn->real_escape_string($row['category']) : '';
        $tags = isset($row['tags']) ? $conn->real_escape_string($row['tags']) : '';
        $status = isset($row['status']) ? $row['status'] : 'draft';
        $author_id = isset($row['author_id']) ? $row['author_id'] : 1;
        
        $insert = "INSERT INTO blog_posts (title, slug, excerpt, featured_image, content, category, tags, status, author_id, created_at)
                   VALUES ('$title', '$slug', '$excerpt', '$featured_image', '$content', '$category', '$tags', '$status', $author_id, NOW())";
        
        if ($conn->query($insert)) {
            echo "✓ Restored: $title<br>";
        } else {
            echo "❌ Error restoring: " . $conn->error . "<br>";
        }
    }
}

echo "<br><h3>Final table structure:</h3>";
$result = $conn->query("DESCRIBE blog_posts");
if ($result) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . ($row['Key'] ? $row['Key'] : '-') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

$conn->close();
?>
