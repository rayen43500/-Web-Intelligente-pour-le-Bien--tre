<?php
/**
 * Fonctions utilitaires pour l'application
 */

/**
 * Rediriger vers une page
 * 
 * @param string $url URL de destination
 * @return void
 */
function redirect($url) {
    header('Location: ' . $url);
    exit;
}

/**
 * Vérifier si l'utilisateur est connecté
 * 
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Nettoyer les données entrées par l'utilisateur
 * 
 * @param string $data Données à nettoyer
 * @return string Données nettoyées
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Générer un jeton CSRF
 * 
 * @return string
 */
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Vérifier le jeton CSRF
 * 
 * @param string $token Jeton à vérifier
 * @return bool
 */
function verifyCsrfToken($token) {
    if (!isset($_SESSION['csrf_token']) || !$token) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Afficher un message flash
 * 
 * @param string $message Message à afficher
 * @param string $type Type de message (success, error, info, warning)
 * @return void
 */
function setFlashMessage($message, $type = 'info') {
    $_SESSION['flash_message'] = [
        'message' => $message,
        'type' => $type
    ];
}

/**
 * Récupérer et supprimer le message flash
 * 
 * @return array|null
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $flashMessage = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $flashMessage;
    }
    return null;
} 