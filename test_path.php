<?php
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Path</title>
</head>
<body>
    <h2>Debug PATH INFO</h2>
    <pre>
SCRIPT_NAME: <?php echo $_SERVER['SCRIPT_NAME']; ?>

dirname(SCRIPT_NAME): <?php echo dirname($_SERVER['SCRIPT_NAME']); ?>

BASE_URL: <?php echo BASE_URL; ?>

ASSETS_URL: <?php echo ASSETS_URL; ?>

CSS Path: <?php echo ASSETS_URL . 'css/style.css'; ?>

HTTP_HOST: <?php echo $_SERVER['HTTP_HOST']; ?>
    </pre>
    
    <hr>
    <h3>CSS Link Test:</h3>
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css">
    <p style="color: red; font-size: 20px;">Jika text ini merah = CSS tidak terkoneksi</p>
    <p style="background: #333; color: #fff; padding: 10px;">Jika background gelap = CSS terkoneksi</p>
</body>
</html>
