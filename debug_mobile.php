<?php
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Debug Mobile CSS</title>
</head>
<body>
    <h1>DEBUG INFO</h1>
    <pre>
HTTP_HOST: <?php echo $_SERVER['HTTP_HOST']; ?>
SCRIPT_NAME: <?php echo $_SERVER['SCRIPT_NAME']; ?>
REQUEST_URI: <?php echo $_SERVER['REQUEST_URI']; ?>
PROTOCOL: <?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http'); ?>
__DIR__: <?php echo __DIR__; ?>

BASE_URL: <?php echo BASE_URL; ?>
ASSETS_URL: <?php echo ASSETS_URL; ?>
CSS URL: <?php echo ASSETS_URL . 'css/style.css'; ?>
    </pre>

    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css">
    
    <div style="background: #333; color: #fff; padding: 20px;">
        <h2>Test CSS</h2>
        <p>Jika background gelap = CSS loading ✅</p>
        <p>Jika polos = CSS gagal ❌</p>
    </div>
</body>
</html>
