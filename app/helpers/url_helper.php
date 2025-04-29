<?php
/**
 * Helper d'URL
 * Fonctions pour gérer les redirections et les manipulations d'URL
 */

/**
 * Redirige vers la page spécifiée
 * @param string $page Chemin relatif de la page
 * @return void
 */
if (!function_exists('redirect')) {
    function redirect($page) {
        header('location: ' . URLROOT . '/' . $page);
        exit;
    }
}
?> 