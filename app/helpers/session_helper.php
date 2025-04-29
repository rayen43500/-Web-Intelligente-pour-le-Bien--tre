<?php
/**
 * Helper de sessions
 * Fonctions pour gérer les sessions et les messages flash
 */

// Ne pas démarrer une session si elle est déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Flash message
 * Crée un message qui sera affiché une seule fois sur la prochaine page
 * @param string $name Nom du message flash
 * @param string $message Message à afficher
 * @param string $class Classe CSS optionnelle
 * @return void
 */
function flash($name = '', $message = '', $class = 'alert alert-success') {
    if(!empty($name)) {
        if(!empty($message) && empty($_SESSION[$name])) {
            if(!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            if(!empty($_SESSION[$name.'_class'])) {
                unset($_SESSION[$name.'_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $class;
        } elseif(empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name.'_class']) ? $_SESSION[$name.'_class'] : '';
            echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
        }
    }
}

/**
 * Vérifie si l'utilisateur est connecté
 * @return boolean
 */
// Ne pas redéclarer isLoggedIn() si elle existe déjà
if (!function_exists('isLoggedIn')) {
    function isLoggedIn() {
        if(isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
}
?> 