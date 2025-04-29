<?php
require_once __DIR__ . '/app/bootstrap.php';

// Rediriger si déjà connecté
if (isLoggedIn()) {
    redirect('client/dashboard.php');
}

$errors = [];
$success = '';
$name = '';
$email = '';

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($name)) {
        $errors[] = "Le nom est requis.";
    }
    
    if (empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide.";
    }
    
    if (strlen($password) < 6) {
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }
    
    // Si pas d'erreurs, procéder à l'inscription
    if (empty($errors)) {
        $result = registerUser($name, $email, $password);
        
        if ($result['success']) {
            $success = $result['message'];
            // Réinitialiser les valeurs du formulaire
            $name = '';
            $email = '';
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
    <title>Inscription - Plateforme de Bien-être Mental et Culturel</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Plateforme de Bien-être Mental et Culturel</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="login.php">Connexion</a></li>
                    <li><a href="register.php" class="active">Inscription</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
        <section class="form-section">
            <div class="container">
                <h2>Créer un compte</h2>
                
                <?php if (!empty($errors)): ?>
                <div class="alert error">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                <div class="alert success">
                    <?php echo $success; ?>
                    <p><a href="login.php">Se connecter maintenant</a></p>
                </div>
                <?php else: ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                        <small>Le mot de passe doit contenir au moins 6 caractères.</small>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmer le mot de passe</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn primary">S'inscrire</button>
                    </div>
                </form>
                <div class="form-footer">
                    <p>Déjà inscrit? <a href="login.php">Se connecter</a></p>
                </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
    
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Plateforme de Bien-être Mental et Culturel</p>
        </div>
    </footer>
    
    <script src="assets/js/main.js"></script>
</body>
</html> 