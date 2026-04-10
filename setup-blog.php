<?php
// Setup script untuk membuat database table blog_articles
require_once 'includes/config.php';

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Blog Setup</title>";
echo "<style>";
echo "body { font-family: Arial; margin: 20px; }";
echo ".success { color: green; background: #e8f5e9; padding: 15px; border-radius: 5px; margin: 15px 0; }";
echo ".error { color: red; background: #ffebee; padding: 15px; border-radius: 5px; margin: 15px 0; }";
echo ".info { color: blue; background: #e3f2fd; padding: 15px; border-radius: 5px; margin: 15px 0; }";
echo "table { border-collapse: collapse; margin: 20px 0; }";
echo "table, td, th { border: 1px solid #ddd; padding: 10px; }";
echo "th { background: #f5f5f5; }";
echo "</style>";
echo "</head>";
echo "<body>";

echo "<h1>📝 Blog Articles Database Setup</h1>";
echo "<hr>";

// Create table
$sql = "CREATE TABLE IF NOT EXISTS `blog_articles` (
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
  INDEX `idx_slug` (`slug`),
  INDEX `idx_status` (`status`),
  INDEX `idx_category` (`category`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql) === TRUE) {
    echo "<div class='success'><strong>✓ Table blog_articles berhasil dibuat!</strong></div>";
} else {
    echo "<div class='error'><strong>✗ Error creating table:</strong> " . htmlspecialchars($conn->error) . "</div>";
    exit;
}

// Check if table is empty
$check = $conn->query("SELECT COUNT(*) as count FROM blog_articles");
if ($check === FALSE) {
    echo "<div class='error'><strong>✗ Error checking table:</strong> " . htmlspecialchars($conn->error) . "</div>";
    exit;
}

$result = $check->fetch_assoc();
$article_count = $result['count'];

if ($article_count == 0) {
    echo "<div class='info'><strong>✓ Table kosong, siap untuk artikel baru!</strong></div>";
} else {
    echo "<div class='info'><strong>✓ Table sudah memiliki " . $article_count . " artikel.</strong></div>";
}

// Show table structure
echo "<h2>📊 Struktur Table:</h2>";
$structure = $conn->query("DESCRIBE blog_articles");
if ($structure === FALSE) {
    echo "<div class='error'>" . htmlspecialchars($conn->error) . "</div>";
} else {
    echo "<table>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($field = $structure->fetch_assoc()) {
        echo "<tr>";
        echo "<td><strong>" . htmlspecialchars($field['Field']) . "</strong></td>";
        echo "<td>" . htmlspecialchars($field['Type']) . "</td>";
        echo "<td>" . htmlspecialchars($field['Null']) . "</td>";
        echo "<td>" . htmlspecialchars($field['Key'] ?? '-') . "</td>";
        echo "<td>" . htmlspecialchars($field['Default'] ?? '-') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<hr>";
echo "<h2>✅ Setup Selesai!</h2>";
echo "<div class='success'>";
echo "<p><strong>Database sudah siap digunakan!</strong></p>";
echo "<p>Akses admin untuk membuat artikel:</p>";
echo "<ul>";
echo "<li><a href='admin/blog-articles.php'><strong>Kelola Blog</strong></a></li>";
echo "<li><a href='admin/blog-builder.php'><strong>Buat Artikel Baru</strong></a></li>";
echo "<li><a href='admin/dashboard.php'><strong>Admin Dashboard</strong></a></li>";
echo "</ul>";
echo "</div>";

echo "</body>";
echo "</html>";

