<?php
/**
 * Configuration principale de l'application
 */

// Informations sur l'application
define('APP_NAME', 'Plateforme de Bien-être Mental et Culturel');
define('APP_VERSION', '1.0.0');

// Chemins de l'application
define('ROOT_DIR', dirname(dirname(dirname(__FILE__))));
define('APP_DIR', ROOT_DIR . '/app');
define('URL_ROOT', 'http://localhost/webjs');

// Configuration d'affichage des erreurs
define('DISPLAY_ERRORS', true);
if (DISPLAY_ERRORS) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// Fuseau horaire
date_default_timezone_set('Europe/Paris');

// Ne pas démarrer une nouvelle session car déjà fait dans bootstrap.php

// Inclure le fichier de configuration de la base de données si les constantes ne sont pas définies
if (!defined('DB_HOST')) {
    require_once APP_DIR . '/config/database.php';
}

// URL de l'application
define('URLROOT', 'http://localhost/webjs');

// Nom de l'application
define('SITENAME', 'WebJS');

// Configuration du chemin d'accès de l'application
define('APPROOT', dirname(dirname(__FILE__)));
define('APPVERSION', '1.0.0');

// Chemins des dossiers principaux
define('CONTROLLERS_PATH', APPROOT . '/controllers');
define('MODELS_PATH', APPROOT . '/models');
define('VIEWS_PATH', APPROOT . '/views');
define('LIBRARIES_PATH', APPROOT . '/libraries');

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec("SET NAMES utf8mb4"); // Assurer le support UTF-8 complet
} catch (PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

// Inclure les helpers après avoir défini les constantes nécessaires
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
?> 