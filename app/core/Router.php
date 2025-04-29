<?php
class Router {
    private $routes = [];
    private $notFoundCallback;

    /**
     * Ajouter une route au routeur
     * 
     * @param string $method Méthode HTTP (GET, POST, etc.)
     * @param string $path Chemin URL
     * @param callable $callback Fonction à exécuter
     */
    public function addRoute($method, $path, $callback) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    /**
     * Définir la fonction à appeler en cas de route non trouvée
     * 
     * @param callable $callback
     */
    public function setNotFound($callback) {
        $this->notFoundCallback = $callback;
    }

    /**
     * Méthode simplifiée pour ajouter une route GET
     */
    public function get($path, $callback) {
        $this->addRoute('GET', $path, $callback);
    }

    /**
     * Méthode simplifiée pour ajouter une route POST
     */
    public function post($path, $callback) {
        $this->addRoute('POST', $path, $callback);
    }

    /**
     * Résoudre la route actuelle en fonction de l'URL
     */
    public function resolve() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Supprimer le dossier de base du chemin (si nécessaire)
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/' && $basePath !== '\\') {
            $requestUri = substr($requestUri, strlen($basePath));
        }
        
        // S'assurer que le chemin commence par /
        if (empty($requestUri)) {
            $requestUri = '/';
        }
        
        // Parcourir toutes les routes enregistrées
        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }
            
            // Convertir le chemin de route en expression régulière
            $pattern = $this->convertRouteToRegex($route['path']);
            
            if (preg_match($pattern, $requestUri, $matches)) {
                // Supprimer le premier match (la correspondance complète)
                array_shift($matches);
                
                // Exécuter le callback avec les paramètres extraits
                return call_user_func_array($route['callback'], $matches);
            }
        }
        
        // Route non trouvée
        if ($this->notFoundCallback) {
            return call_user_func($this->notFoundCallback);
        }
        
        // Réponse par défaut si aucune route et aucun gestionnaire 404
        header("HTTP/1.0 404 Not Found");
        echo '404 - Page non trouvée';
    }
    
    /**
     * Convertir une route en expression régulière
     */
    private function convertRouteToRegex($route) {
        // Échapper les caractères spéciaux de regex
        $route = preg_quote($route, '/');
        
        // Remplacer les paramètres de route {:param} par des capteurs regex
        $route = preg_replace('/\\\{([a-zA-Z0-9_]+)\\\}/', '([^\/]+)', $route);
        
        // Ajouter les délimiteurs et ancres
        return '/^' . $route . '$/';
    }
} 