<?php
// Simple debug - just check if we can access the upload API
echo "<h1>API Debug Test</h1>";
echo "<pre>";

// Test 1: Check file exists
echo "File exists: " . (file_exists('admin/api/upload-profile-picture.php') ? 'YES' : 'NO') . "\n";

// Test 2: Try to check what happens when we access it
echo "\nTesting what auth_check.php does...\n";

// Start session
session_start();

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    echo "❌ NOT LOGGED IN - auth_check.php would redirect or show error\n";
    echo "This is likely the issue!\n";
} else {
    echo "✅ LOGGED IN - Session user_id: " . $_SESSION['user_id'] . "\n";
}

echo "\n";
?>
