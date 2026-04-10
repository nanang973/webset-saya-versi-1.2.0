<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "portfolio_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if image column exists
$result = $conn->query("SHOW COLUMNS FROM portfolios LIKE 'image'");

if ($result->num_rows === 0) {
    echo "Adding 'image' column to portfolios table...\n";
    
    if ($conn->query("ALTER TABLE portfolios ADD COLUMN image VARCHAR(255) DEFAULT NULL")) {
        echo "✓ Column 'image' added successfully!\n";
    } else {
        echo "✗ Error: " . $conn->error . "\n";
    }
} else {
    echo "✓ Column 'image' already exists!\n";
}

// Show current table structure
echo "\nCurrent portfolios table structure:\n";
$result = $conn->query("DESC portfolios");
while ($row = $result->fetch_assoc()) {
    echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
}

$conn->close();
?>
