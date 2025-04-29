<?php
/**
 * Contrôleur de base
 * 
 * Cette classe sert de contrôleur de base pour tous les autres contrôleurs
 * Charge les modèles et les vues
 */
class Controller {
    /**
     * Charge un modèle
     * 
     * @param string $model Nom du modèle à charger
     * @return object Instance du modèle
     */
    public function model($model) {
        // Vérifier si le fichier du modèle existe
        if(file_exists('../app/models/' . $model . '.php')) {
            // Charger le modèle
            require_once '../app/models/' . $model . '.php';
            
            // Instancier le modèle
            return new $model();
        } else {
            // Si le modèle n'existe pas, afficher une erreur
            die('Modèle ' . $model . ' introuvable');
        }
    }

    /**
     * Charge une vue
     * 
     * @param string $view Nom de la vue à charger
     * @param array $data Données à passer à la vue (optionnel)
     */
    public function view($view, $data = []) {
        // Vérifier si le fichier de vue existe
        if(file_exists('../app/views/' . $view . '.php')) {
            // Inclure le fichier de la vue
            require_once '../app/views/' . $view . '.php';
        } else {
            // Si la vue n'existe pas, afficher une erreur
            die('Vue ' . $view . ' introuvable');
        }
    }

    /**
     * Rediriger vers une autre page
     * 
     * @param string $url URL de redirection
     */
    public function redirect($url) {
        header('Location: ' . URLROOT . '/' . $url);
        exit;
    }
}
?> 