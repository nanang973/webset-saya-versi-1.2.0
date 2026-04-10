<?php
require_once '../includes/config.php';

echo "<h2>Database Cleanup</h2>";
echo "<pre>";

// 1. Drop blog_articles table (tidak lagi digunakan)
echo "\n=== MENGHAPUS TABLE YANG TIDAK DIGUNAKAN ===\n";
if ($conn->query("DROP TABLE IF EXISTS blog_articles")) {
    echo "✓ Table blog_articles berhasil dihapus\n";
} else {
    echo "❌ Error dropping blog_articles: " . $conn->error . "\n";
}

// 2. Check education table
echo "\n=== CEK TABLE education ===\n";
$edu_check = $conn->query("SELECT COUNT(*) as count FROM education");
if ($edu_check) {
    $edu_count = $edu_check->fetch_assoc()['count'];
    echo "Total education records: $edu_count\n";
    if ($edu_count == 0) {
        echo "⚠️  Table education kosong (data tidak ada)\n";
    }
} else {
    echo "❌ Table education tidak ada atau error\n";
}

// 3. Check organizations table
echo "\n=== CEK TABLE organizations ===\n";
$org_check = $conn->query("SELECT COUNT(*) as count FROM organizations");
if ($org_check) {
    $org_count = $org_check->fetch_assoc()['count'];
    echo "Total organizations records: $org_count\n";
    if ($org_count == 0) {
        echo "⚠️  Table organizations kosong (data tidak ada)\n";
    }
} else {
    echo "❌ Table organizations tidak ada atau error\n";
}

// 4. Check experience table
echo "\n=== CEK TABLE experience ===\n";
$exp_check = $conn->query("SELECT COUNT(*) as count FROM experience");
if ($exp_check) {
    $exp_count = $exp_check->fetch_assoc()['count'];
    echo "Total experience records: $exp_count\n";
    if ($exp_count == 0) {
        echo "⚠️  Table experience kosong (data tidak ada)\n";
    }
} else {
    echo "❌ Table experience tidak ada atau error\n";
}

// 5. List all tables
echo "\n=== DAFTAR SEMUA TABLE ===\n";
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_row()) {
    echo "- " . $row[0] . "\n";
}

echo "\n</pre>";
echo "<p><strong>Catatan:</strong> Table education dan organizations masih ada tapi kosong. Jika tidak akan digunakan, bisa dihapus juga dari kode di pages/about.php</p>";
?>
