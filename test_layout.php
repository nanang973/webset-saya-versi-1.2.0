<?php
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Layout</title>
</head>
<body>
    <h1>DEBUG LAYOUT TEST</h1>
    
    <pre>
BASE_URL: <?php echo BASE_URL; ?>
ASSETS_URL: <?php echo ASSETS_URL; ?>

Window Width: <script>document.write(window.innerWidth)</script>
Screen Width: <script>document.write(screen.width)</script>
    </pre>
    
    <h2>Halaman untuk ditest:</h2>
    <ul>
        <li><a href="pages/about.php">About</a></li>
        <li><a href="pages/skills.php">Skills</a></li>
        <li><a href="pages/blog.php">Blog</a></li>
        <li><a href="pages/portfolio.php">Portfolio</a></li>
        <li><a href="pages/contact.php">Contact</a></li>
    </ul>
    
    <h2>Test CSS Container:</h2>
    <div style="border: 2px solid red; max-width: 1200px; margin: 0 auto; padding: 20px;">
        <p>Container max-width: 1200px</p>
        <p>Width: <script>document.write(document.querySelector('div').offsetWidth)</script>px</p>
    </div>
</body>
</html>
