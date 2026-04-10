<?php
// Check and add profile_picture column
require_once 'includes/config.php';

// Check if column exists
$result = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='profile' AND COLUMN_NAME='profile_picture'");

if ($result->num_rows === 0) {
    // Column doesn't exist, add it
    $sql = "ALTER TABLE profile ADD COLUMN profile_picture VARCHAR(255) DEFAULT NULL";
    
    if ($conn->query($sql)) {
        echo "✅ Column profile_picture berhasil ditambahkan ke tabel profile!";
    } else {
        echo "❌ Error: " . $conn->error;
    }
} else {
    echo "✅ Column profile_picture sudah ada di tabel profile";
}

// Show table structure
echo "\n\n=== Struktur Tabel Profile ===\n";
$result = $conn->query("DESCRIBE profile");
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}

$conn->close();
?>
