<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : APP_NAME; ?></title>
    <meta name="description" content="<?php echo isset($description) ? $description : 'Plateforme de bien-être mental et culturel'; ?>">
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><?php echo APP_NAME; ?></h1>
            <nav>
                <ul>
                    <li><a href="<?php echo URL_ROOT; ?>">Accueil</a></li>
                    <li><a href="<?php echo URL_ROOT; ?>/home/about">À propos</a></li>
                    <li><a href="<?php echo URL_ROOT; ?>/home/contact">Contact</a></li>
                    <?php if (isLoggedIn()) : ?>
                        <li><a href="<?php echo URL_ROOT; ?>/dashboard">Tableau de bord</a></li>
                        <li><a href="<?php echo URL_ROOT; ?>/users/logout">Déconnexion</a></li>
                    <?php else : ?>
                        <li><a href="<?php echo URL_ROOT; ?>/users/login">Connexion</a></li>
                        <li><a href="<?php echo URL_ROOT; ?>/users/register">Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
        <?php if (isset($_SESSION['flash_message'])) : 
            $flash = getFlashMessage(); ?>
            <div class="flash-message <?php echo $flash['type']; ?>">
                <?php echo $flash['message']; ?>
            </div>
        <?php endif; ?> 