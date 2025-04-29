<?php
/**
 * Fichier d'initialisation de l'application
 * Charge les configurations et les classes de base
 */

// Charger la configuration
require_once 'app/config/config.php';

// Fonctions utilitaires
require_once 'app/core/helpers.php';

// Charger les classes de base
require_once 'app/core/Controller.php';
require_once 'app/core/Model.php';
require_once 'app/core/Router.php';

// Fonction d'autoload pour charger automatiquement les classes
spl_autoload_register(function($className) {
    // Vérifier dans les dossiers de modèles et contrôleurs
    $paths = [
        'app/models/',
        'app/controllers/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
}); 