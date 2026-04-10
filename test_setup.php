<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Test - Portfolio Website</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 10px;
            padding: 40px;
            max-width: 700px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        h1 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }
        
        .check-item {
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #667eea;
            background: #f8f9ff;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }
        
        .check-item.success {
            border-left-color: #10b981;
            background: #f0fdf4;
        }
        
        .check-item.error {
            border-left-color: #ef4444;
            background: #fef2f2;
        }
        
        .check-item.warning {
            border-left-color: #f59e0b;
            background: #fffbf0;
        }
        
        .icon {
            font-size: 20px;
            margin-right: 15px;
            width: 30px;
            text-align: center;
        }
        
        .text h3 {
            color: #333;
            margin-bottom: 5px;
            font-size: 1rem;
        }
        
        .text p {
            color: #666;
            font-size: 0.9rem;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .button {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            text-align: center;
            flex: 1;
            min-width: 150px;
        }
        
        .button-primary {
            background: #667eea;
            color: white;
        }
        
        .button-primary:hover {
            background: #5568d3;
        }
        
        .button-secondary {
            background: #e5e7eb;
            color: #333;
        }
        
        .button-secondary:hover {
            background: #d1d5db;
        }
        
        .note {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .note strong {
            color: #d97706;
        }
        
        .success-message {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            color: #065f46;
            text-align: center;
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎯 Portfolio Setup Test</h1>
        <p class="subtitle">Verifikasi instalasi website Anda</p>
        
        <?php
        // Enable error display
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        
        // Test results
        $tests = [];
        
        // 1. PHP Version
        $phpVersion = phpversion();
        $tests['php'] = [
            'title' => 'PHP Version',
            'status' => version_compare($phpVersion, '7.4', '>=') ? 'success' : 'warning',
            'message' => "PHP $phpVersion " . (version_compare($phpVersion, '7.4', '>=') ? '✓' : '(minimal 7.4 recommended)'),
        ];
        
        // 2. File Structure
        $requiredFiles = [
            'includes/config.php',
            'includes/header.php',
            'includes/footer.php',
            'pages/about.php',
            'admin/login.php',
            'assets/css/style.css',
            'assets/js/main.js',
        ];
        
        $filesOk = true;
        foreach ($requiredFiles as $file) {
            if (!file_exists($file)) {
                $filesOk = false;
                break;
            }
        }
        
        $tests['files'] = [
            'title' => 'Required Files',
            'status' => $filesOk ? 'success' : 'error',
            'message' => $filesOk ? 'All required files present ✓' : 'Some files missing ✗',
        ];
        
        // 3. Database Connection
        $dbOk = false;
        $dbMessage = '';
        
        if (file_exists('includes/config.php')) {
            require_once 'includes/config.php';
            
            $tempConn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($tempConn->connect_error) {
                $dbMessage = "Connection failed: " . $tempConn->connect_error;
            } else {
                $dbOk = true;
                $dbMessage = 'Connected to ' . DB_NAME . ' ✓';
                $tempConn->close();
            }
        } else {
            $dbMessage = 'config.php not found';
        }
        
        $tests['database'] = [
            'title' => 'Database Connection',
            'status' => $dbOk ? 'success' : 'error',
            'message' => $dbMessage,
        ];
        
        // 4. Folder Permissions
        $writableOk = true;
        $writableDirs = ['assets/', 'includes/'];
        
        foreach ($writableDirs as $dir) {
            if (is_dir($dir) && !is_writable($dir)) {
                $writableOk = false;
                break;
            }
        }
        
        $tests['writable'] = [
            'title' => 'Folder Permissions',
            'status' => $writableOk ? 'success' : 'warning',
            'message' => $writableOk ? 'Directories writable ✓' : 'Some directories not writable (might cause issues)',
        ];
        
        // 5. Extensions
        $extensions = ['mysqli', 'json', 'gd'];
        $extOk = true;
        $missingExt = [];
        
        foreach ($extensions as $ext) {
            if (!extension_loaded($ext)) {
                $extOk = false;
                $missingExt[] = $ext;
            }
        }
        
        $tests['extensions'] = [
            'title' => 'PHP Extensions',
            'status' => $extOk ? 'success' : 'warning',
            'message' => $extOk ? 'All extensions loaded ✓' : 'Missing: ' . implode(', ', $missingExt),
        ];
        
        // Overall status
        $allOk = $dbOk && $filesOk && $extOk;
        ?>
        
        <!-- Test Results -->
        <?php foreach ($tests as $test): ?>
            <div class="check-item <?php echo $test['status']; ?>">
                <div class="icon">
                    <?php 
                    switch ($test['status']) {
                        case 'success': echo '✓'; break;
                        case 'error': echo '✗'; break;
                        case 'warning': echo '⚠'; break;
                    }
                    ?>
                </div>
                <div class="text">
                    <h3><?php echo $test['title']; ?></h3>
                    <p><?php echo $test['message']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        
        <!-- Status Message -->
        <?php if ($allOk): ?>
            <div class="success-message">
                <strong>✓ Setup Berhasil!</strong><br>
                Website Anda siap digunakan. Lanjut ke langkah berikutnya.
            </div>
        <?php else: ?>
            <div class="note">
                <strong>⚠ Ada Masalah:</strong><br>
                Silahkan fix masalah di atas sebelum melanjutkan. Baca README.md untuk troubleshooting.
            </div>
        <?php endif; ?>
        
        <!-- Quick Start Info -->
        <div class="note">
            <strong>📝 Next Steps:</strong><br>
            1. Perbarui data profil Anda<br>
            2. Tambahkan artikel & proyek<br>
            3. Test semua halaman<br>
            4. Deploy ke hosting
        </div>
        
        <!-- Navigation Buttons -->
        <div class="button-group">
            <a href="<?php echo defined('BASE_URL') ? BASE_URL : '/webset01/portfolio/'; ?>" class="button button-primary">
                → Ke Website
            </a>
            <a href="<?php echo defined('BASE_URL') ? BASE_URL . 'admin/' : '/webset01/portfolio/admin/'; ?>" class="button button-secondary">
                → Admin Panel
            </a>
        </div>
        
        <div style="margin-top: 30px; padding: 20px; background: #f3f4f6; border-radius: 5px; font-size: 0.9rem; color: #666;">
            <strong>💡 Info:</strong><br>
            File test ini: test_setup.php<br>
            Bisa didelete setelah setup selesai.
        </div>
    </div>
</body>
</html>
