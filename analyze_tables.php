<?php
require_once '../includes/config.php';

echo "<h2>Database Cleanup Report</h2>";
echo "<pre>";

// Table usage mapping
$table_usage = [
    'admin_users' => 'USED - Login authentication (/admin/login.php)',
    'profile' => 'USED - About page, Contact page, Home page (profile picture, name, title, bio)',
    'experience' => 'USED - About page (experience section)',
    'skills' => 'USED - Skills page, Home page (featured skills)',
    'portfolios' => 'USED - Portfolio page, Home page (featured projects)',
    'blog_posts' => 'USED - Blog page, Blog detail page, Home page (featured blogs)',
    'contact_messages' => 'USED - Contact form submissions (messages page in admin)',
    'education' => '❌ NOT USED - Removed from about.php',
    'organizations' => '❌ NOT USED - Removed from about.php',
    'blog_articles' => '❌ DELETED - Already dropped',
];

echo "=== TABLE USAGE STATUS ===\n\n";

// Get all current tables
$result = $conn->query("SHOW TABLES");
$all_tables = [];
while ($row = $result->fetch_row()) {
    $all_tables[] = $row[0];
}

foreach ($all_tables as $table) {
    $status = $table_usage[$table] ?? 'UNKNOWN';
    $count = $conn->query("SELECT COUNT(*) as count FROM `$table`")->fetch_assoc()['count'];
    echo $table . " [$count records]\n";
    echo "  → " . $status . "\n\n";
}

echo "\n=== REKOMENDASI ===\n";
echo "✓ Pertahankan table yang USED\n";
echo "✓ Hapus table: education, organizations\n";
echo "\n</pre>";

// Suggest drop commands
echo "<h3>Drop Commands:</h3>";
echo "<pre>";
echo "DROP TABLE IF EXISTS education;\n";
echo "DROP TABLE IF EXISTS organizations;\n";
echo "</pre>";

echo "<p><strong>Note:</strong> Hanya table yang kosong dan tidak digunakan. Jika ingin eksekusi, jalankan kode di bawah ini.</p>";

// Check if user wants to execute
if (isset($_GET['execute']) && $_GET['execute'] == 'yes') {
    echo "<h3>Executing cleanup...</h3>";
    echo "<pre>";
    
    if ($conn->query("DROP TABLE IF EXISTS education")) {
        echo "✓ Table education berhasil dihapus\n";
    } else {
        echo "❌ Error dropping education: " . $conn->error . "\n";
    }
    
    if ($conn->query("DROP TABLE IF EXISTS organizations")) {
        echo "✓ Table organizations berhasil dihapus\n";
    } else {
        echo "❌ Error dropping organizations: " . $conn->error . "\n";
    }
    
    echo "</pre>";
    echo "<p><a href='analyze_tables.php'>Kembali ke analisis</a></p>";
} else {
    echo "<p><a href='analyze_tables.php?execute=yes' onclick=\"return confirm('Yakin ingin hapus table education dan organizations?')\">HAPUS UNUSED TABLES</a></p>";
}
?>
