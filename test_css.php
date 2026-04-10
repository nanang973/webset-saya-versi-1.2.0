<?php
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test CSS Connection</title>
</head>
<body>
    <h1>Test CSS Connection</h1>
    
    <h2>Debug Info:</h2>
    <pre>
BASE_URL: <?php echo BASE_URL; ?>
ASSETS_URL: <?php echo ASSETS_URL; ?>
CSS URL: <?php echo ASSETS_URL . 'css/style.css'; ?>

HTTP_HOST: <?php echo $_SERVER['HTTP_HOST']; ?>
SCRIPT_NAME: <?php echo $_SERVER['SCRIPT_NAME']; ?>
PROTOCOL: <?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http'); ?>
    </pre>
    
    <h2>CSS Link Test:</h2>
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css">
    
    <div style="background: #333; color: #fff; padding: 20px; margin-top: 20px;">
        <h3>Jika div ini gelap dengan text putih = CSS berhasil!</h3>
        <p>Jika tetap polos = CSS tidak terkoneksi</p>
    </div>
    
    <h2>Check CSS File Exist:</h2>
    <pre>
<?php
$css_file = 'assets/css/style.css';
if (file_exists($css_file)) {
    echo "✅ File CSS ada: " . realpath($css_file);
    echo "\nFile size: " . filesize($css_file) . " bytes";
    echo "\nFirst 200 chars:\n";
    echo substr(file_get_contents($css_file), 0, 200);
} else {
    echo "❌ File CSS tidak ditemukan: " . $css_file;
}
?>
    </pre>
</body>
</html>
