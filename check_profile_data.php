<?php
require_once 'includes/config.php';

echo "<h2>Profile Data dari Database</h2>";
echo "<pre>";

$profile = $conn->query("SELECT * FROM profile LIMIT 1")->fetch_assoc();
var_dump($profile);

echo "\n\n=== Checking File ===\n";
if (!empty($profile['profile_picture'])) {
    $file_path = $profile['profile_picture'];
    echo "Stored path: " . htmlspecialchars($file_path) . "\n";
    echo "Full path: " . htmlspecialchars(dirname(__FILE__) . '/' . $file_path) . "\n";
    echo "File exists: " . (file_exists($file_path) ? 'YES' : 'NO') . "\n";
    echo "File size: " . (file_exists($file_path) ? filesize($file_path) . ' bytes' : 'N/A') . "\n";
}

echo "</pre>";
?>
