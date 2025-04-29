<?php
/**
 * Point d'entrée de l'application
 * Toutes les requêtes passent par ici
 */

// Charger l'initialisation
require_once '../app/core/init.php';

// Créer une instance du routeur
$router = new Router();

// Définir les routes

// Routes pour la page d'accueil
$router->get('/', function() {
    $controller = new HomeController();
    $controller->index();
});

$router->get('/home', function() {
    $controller = new HomeController();
    $controller->index();
});

$router->get('/home/about', function() {
    $controller = new HomeController();
    $controller->about();
});

$router->get('/home/contact', function() {
    $controller = new HomeController();
    $controller->contact();
});

$router->post('/home/contact', function() {
    $controller = new HomeController();
    $controller->contact();
});

// Routes pour l'authentification
$router->get('/users/register', function() {
    $controller = new UsersController();
    $controller->register();
});

$router->post('/users/register', function() {
    $controller = new UsersController();
    $controller->register();
});

$router->get('/users/login', function() {
    $controller = new UsersController();
    $controller->login();
});

$router->post('/users/login', function() {
    $controller = new UsersController();
    $controller->login();
});

$router->get('/users/logout', function() {
    $controller = new UsersController();
    $controller->logout();
});

$router->get('/users/profile', function() {
    $controller = new UsersController();
    $controller->profile();
});

$router->post('/users/profile', function() {
    $controller = new UsersController();
    $controller->profile();
});

// Routes pour le tableau de bord
$router->get('/dashboard', function() {
    $controller = new DashboardController();
    $controller->index();
});

// Page 404 pour les routes non trouvées
$router->setNotFound(function() {
    header("HTTP/1.0 404 Not Found");
    echo '<h1>404 - Page non trouvée</h1>';
    echo '<p>La page que vous recherchez n\'existe pas.</p>';
    echo '<a href="' . URL_ROOT . '">Retour à l\'accueil</a>';
});

// Résoudre la route actuelle
$router->resolve(); 