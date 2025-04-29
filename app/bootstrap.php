<?php
/**
 * Fichier d'initialisation de l'application
 * Charge les configurations, les fonctions et initialise la session
 */

// Démarrer la session si elle n'est pas active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Charger les configurations depuis les fichiers de configuration
require_once __DIR__ . '/config/config.php';

// Charger les modèles
require_once __DIR__ . '/models/UserModel.php';

// Charger les fonctions utilitaires
require_once __DIR__ . '/helpers/functions.php';

// Autoloader pour les classes
spl_autoload_register(function($className) {
    if (file_exists(__DIR__ . '/libraries/' . $className . '.php')) {
        require_once __DIR__ . '/libraries/' . $className . '.php';
    }
});
?> 