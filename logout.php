<?php
require_once __DIR__ . '/app/bootstrap.php';

// Déconnecter l'utilisateur
$result = logoutUser();

// Rediriger vers la page d'accueil
redirect('index.php');
?> 