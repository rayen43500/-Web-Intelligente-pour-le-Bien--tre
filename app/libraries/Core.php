<?php
/**
 * Classe Core
 * 
 * Crée l'URL et charge le contrôleur central
 * Format URL: /contrôleur/méthode/paramètres
 */
class Core {
    // Propriétés par défaut
    protected $currentController = 'Pages'; // Contrôleur par défaut
    protected $currentMethod = 'index';     // Méthode par défaut
    protected $params = [];                 // Paramètres

    public function __construct() {
        $url = $this->getUrl();

        // Rechercher dans les contrôleurs le premier index/valeur
        if(isset($url[0]) && file_exists(CONTROLLERS_PATH . '/' . ucwords($url[0]) . '.php')) {
            // Si le contrôleur existe, le définir comme contrôleur courant
            $this->currentController = ucwords($url[0]);
            
            // Décharger le premier index
            unset($url[0]);
        }

        // Inclure le contrôleur
        require_once CONTROLLERS_PATH . '/' . $this->currentController . '.php';

        // Instancier le contrôleur
        $this->currentController = new $this->currentController;

        // Vérifier la deuxième partie de l'URL pour la méthode
        if(isset($url[1])) {
            // Vérifier si la méthode existe dans le contrôleur
            if(method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                
                // Décharger le deuxième index
                unset($url[1]);
            }
        }

        // Obtenir les paramètres
        $this->params = $url ? array_values($url) : [];

        // Appeler la méthode du contrôleur avec les paramètres
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    /**
     * Récupérer l'URL
     * 
     * @return array Segments de l'URL
     */
    public function getUrl() {
        if(isset($_GET['url'])) {
            // Supprimer le dernier slash
            $url = rtrim($_GET['url'], '/');
            
            // Filtrer les caractères spéciaux de l'URL
            $url = filter_var($url, FILTER_SANITIZE_URL);
            
            // Diviser l'URL en segments
            $url = explode('/', $url);
            
            return $url;
        }
        
        return [];
    }
}
?> 