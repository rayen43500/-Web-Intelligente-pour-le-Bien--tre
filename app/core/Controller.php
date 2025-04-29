<?php
/**
 * Classe de base pour tous les contrôleurs
 */
class Controller {
    /**
     * Charger un modèle
     * 
     * @param string $model Nom du modèle à charger
     * @return object Instance du modèle
     */
    protected function model($model) {
        // Vérifier si le fichier du modèle existe
        $modelFile = 'app/models/' . $model . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            // Retourner une nouvelle instance du modèle
            return new $model();
        } else {
            throw new Exception("Le modèle '$model' n'existe pas");
        }
    }
    
    /**
     * Charger une vue
     * 
     * @param string $view Nom de la vue à charger
     * @param array $data Données à passer à la vue
     * @return void
     */
    protected function view($view, $data = []) {
        // Vérifier si le fichier de vue existe
        $viewFile = 'app/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            // Extraire les données pour les rendre accessibles dans la vue
            extract($data);
            
            // Commencer la mise en mémoire tampon de sortie
            ob_start();
            
            // Inclure le fichier de vue
            include $viewFile;
            
            // Récupérer le contenu de la mémoire tampon et l'afficher
            echo ob_get_clean();
        } else {
            throw new Exception("La vue '$view' n'existe pas");
        }
    }
    
    /**
     * Rediriger vers une autre page
     * 
     * @param string $url URL de destination
     * @return void
     */
    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
    
    /**
     * Vérifier si une requête est de type POST
     * 
     * @return bool
     */
    protected function isPostRequest() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Obtenir les données POST filtrées
     * 
     * @return array Données POST filtrées
     */
    protected function getPostData() {
        return filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    }
} 