<?php
// Désactiver l'affichage des erreurs pour la production
// error_reporting(0);

// Définir les variables de connexion à la base de données
$dbHost = 'localhost';
$dbUser = 'root'; 
$dbPass = '';
$dbName = 'bien_etre_db';

// Fonction pour afficher les messages
function displayMessage($type, $message) {
    echo "<div class='message $type'>$message</div>";
}

// Initialiser les variables
$success = true;
$errorMessages = [];
$infoMessages = [];

// Vérifier les prérequis
$phpVersion = phpversion();
if (version_compare($phpVersion, '7.4', '<')) {
    $success = false;
    $errorMessages[] = "Version PHP non compatible: $phpVersion (PHP 7.4 ou supérieur requis)";
} else {
    $infoMessages[] = "Version PHP: $phpVersion ✓";
}

// Vérifier les extensions PHP requises
$requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'json', 'session'];
foreach ($requiredExtensions as $ext) {
    if (!extension_loaded($ext)) {
        $success = false;
        $errorMessages[] = "Extension PHP manquante: $ext";
    } else {
        $infoMessages[] = "Extension $ext: Installée ✓";
    }
}

// Vérifier les permissions d'écriture dans le dossier uploads
$uploadDirs = ['uploads', 'uploads/books', 'uploads/music', 'uploads/videos', 'uploads/covers'];
foreach ($uploadDirs as $dir) {
    if (!file_exists($dir)) {
        if (!mkdir($dir, 0755, true)) {
            $success = false;
            $errorMessages[] = "Impossible de créer le dossier: $dir";
        } else {
            $infoMessages[] = "Dossier créé: $dir ✓";
        }
    } elseif (!is_writable($dir)) {
        $success = false;
        $errorMessages[] = "Le dossier $dir n'est pas accessible en écriture";
    } else {
        $infoMessages[] = "Permissions du dossier $dir: OK ✓";
    }
}

// Traiter le formulaire d'installation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['install'])) {
    try {
        // Tenter de se connecter au serveur MySQL
        $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Charger le fichier SQL
        $sql = file_get_contents('db.sql');
        
        // Exécuter le script SQL
        $pdo->exec($sql);
        
        displayMessage('success', "Base de données <strong>$dbName</strong> créée avec succès!");
        
        // Mettre à jour le fichier de configuration
        $configFile = 'includes/config.php';
        if (file_exists($configFile)) {
            $configContent = file_get_contents($configFile);
            
            // Mettre à jour les constantes de configuration
            $configContent = preg_replace("/define\('DB_HOST', '.*?'\);/", "define('DB_HOST', '$dbHost');", $configContent);
            $configContent = preg_replace("/define\('DB_NAME', '.*?'\);/", "define('DB_NAME', '$dbName');", $configContent);
            $configContent = preg_replace("/define\('DB_USER', '.*?'\);/", "define('DB_USER', '$dbUser');", $configContent);
            $configContent = preg_replace("/define\('DB_PASS', '.*?'\);/", "define('DB_PASS', '$dbPass');", $configContent);
            
            // Sauvegarder les modifications
            if (file_put_contents($configFile, $configContent)) {
                displayMessage('success', "Fichier de configuration mis à jour avec succès!");
            } else {
                displayMessage('error', "Impossible de mettre à jour le fichier de configuration. Veuillez le faire manuellement.");
            }
        }
        
        displayMessage('info', "<strong>Installation terminée!</strong> Vous pouvez <a href='index.php'>accéder à l'application</a> ou <a href='login.php'>vous connecter</a> avec les identifiants administrateur (admin@example.com / admin123)");
        
    } catch (PDOException $e) {
        displayMessage('error', "Erreur lors de l'installation: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - Plateforme de Bien-être Mental et Culturel</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #4e73df;
            margin-bottom: 20px;
        }
        .container {
            background-color: #f8f9fc;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .requirement-list {
            margin: 20px 0;
        }
        .requirement-item {
            padding: 10px;
            border-bottom: 1px solid #e3e6f0;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .btn {
            display: inline-block;
            font-weight: 500;
            color: #fff;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            background-color: #4e73df;
            border: 1px solid #4e73df;
            padding: 10px 20px;
            font-size: 16px;
            line-height: 1.5;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.15s;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        .btn:disabled {
            background-color: #6c757d;
            border-color: #6c757d;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Installation de la Plateforme de Bien-être Mental et Culturel</h1>
        
        <div class="requirement-list">
            <h2>Vérification des prérequis</h2>
            
            <?php foreach ($infoMessages as $message): ?>
                <div class="requirement-item"><?php echo $message; ?></div>
            <?php endforeach; ?>
            
            <?php foreach ($errorMessages as $message): ?>
                <div class="requirement-item" style="color: #721c24;"><?php echo $message; ?></div>
            <?php endforeach; ?>
        </div>
        
        <form method="POST" action="">
            <h2>Configuration de la base de données</h2>
            <p><strong>Note:</strong> Les paramètres par défaut sont configurés pour un environnement XAMPP local.</p>
            
            <div class="form-group">
                <label for="db_host">Hôte de la base de données</label>
                <input type="text" id="db_host" name="db_host" value="localhost" disabled>
            </div>
            
            <div class="form-group">
                <label for="db_name">Nom de la base de données</label>
                <input type="text" id="db_name" name="db_name" value="bien_etre_db" disabled>
            </div>
            
            <div class="form-group">
                <label for="db_user">Utilisateur de la base de données</label>
                <input type="text" id="db_user" name="db_user" value="root" disabled>
            </div>
            
            <div class="form-group">
                <label for="db_pass">Mot de passe de la base de données</label>
                <input type="password" id="db_pass" name="db_pass" value="" disabled>
            </div>
            
            <button type="submit" name="install" class="btn" <?php echo $success ? '' : 'disabled'; ?>>
                Installer la base de données
            </button>
            
            <?php if (!$success): ?>
                <p class="error">Veuillez corriger les erreurs ci-dessus avant de procéder à l'installation.</p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html> 