<?php
// Test upload API response
$_SERVER['REQUEST_METHOD'] = 'POST';

// Create a test file
$test_file = '/tmp/test_image.jpg';
file_put_contents($test_file, "\xFF\xD8\xFF"); // Minimal JPEG header

$_FILES['profile_picture'] = [
    'name' => 'test.jpg',
    'type' => 'image/jpeg',
    'tmp_name' => $test_file,
    'error' => UPLOAD_ERR_OK,
    'size' => filesize($test_file)
];

// Simulate the upload API
echo "<pre>";
echo "Testing upload API...\n\n";

// Include the upload handler
ob_start();
include 'admin/api/upload-profile-picture.php';
$output = ob_get_clean();

echo "Raw Output:\n";
echo $output;
echo "\n\nParsed:\n";
var_dump(json_decode($output, true));
?>
