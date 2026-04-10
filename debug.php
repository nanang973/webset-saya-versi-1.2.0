<?php
// Diagnostic - Debug BASE_URL
echo "<h2>Debug Info:</h2>";
echo "<pre>";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "dirname(SCRIPT_NAME): " . dirname($_SERVER['SCRIPT_NAME']) . "\n";
echo "dirname(dirname(SCRIPT_NAME)): " . dirname(dirname($_SERVER['SCRIPT_NAME'])) . "\n";
echo "HTTP_HOST: " . $_SERVER['HTTP_HOST'] . "\n";
echo "PROTOCOL: " . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "\n";

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$script_path = dirname(dirname($_SERVER['SCRIPT_NAME']));

echo "\nCalculated BASE_URL: " . $protocol . '://' . $host . $script_path . '/' . "\n";
echo "Calculated ASSETS_URL: " . $protocol . '://' . $host . $script_path . '/assets/' . "\n";
echo "</pre>";

// Test CSS file
$css_url = $protocol . '://' . $host . $script_path . '/assets/css/style.css';
echo "<p><a href='" . $css_url . "' target='_blank'>Test CSS File</a></p>";
?>
