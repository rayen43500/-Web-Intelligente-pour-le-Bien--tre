<?php
require_once __DIR__ . '/app/bootstrap.php';

// Rediriger si déjà connecté
if (isLoggedIn()) {
    redirect('client/dashboard.php');
}

$errors = [];
$success = '';

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validation
    if (empty($email)) {
        $errors[] = "L'email est requis.";
    }
    
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    }
    
    // Si pas d'erreurs, procéder à la connexion
    if (empty($errors)) {
        $result = loginUser($email, $password);
        
        if ($result['success']) {
            // Redirection en fonction du rôle (admin ou utilisateur)
            if ($_SESSION['is_admin']) {
                redirect('admin/index.php');
            } else {
                redirect('client/dashboard.php');
            }
        } else {
            $errors[] = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Plateforme de Bien-être Mental et Culturel</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Plateforme de Bien-être Mental et Culturel</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="login.php" class="active">Connexion</a></li>
                    <li><a href="register.php">Inscription</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
        <section class="form-section">
            <div class="container">
                <h2>Connexion</h2>
                
                <?php if (!empty($errors)): ?>
                <div class="alert error">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn primary">Se connecter</button>
                    </div>
                </form>
                <div class="form-footer">
                    <p>Pas encore inscrit? <a href="register.php">Créer un compte</a></p>
                </div>
            </div>
        </section>
    </main>
    
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Plateforme de Bien-être Mental et Culturel</p>
        </div>
    </footer>
</body>
</html> 