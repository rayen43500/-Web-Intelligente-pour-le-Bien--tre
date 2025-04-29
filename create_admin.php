<?php
// Script pour créer un compte administrateur
require_once __DIR__ . '/app/bootstrap.php';

// Informations de l'administrateur
$name = 'Administrateur';
$email = 'admin@example.com';
$password = 'admin123';
$isAdmin = 1;

echo "<h1>Création d'un compte administrateur</h1>";

// Vérifier si l'email existe déjà
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    $userId = $stmt->fetch()['id'];
    echo "<p>Un utilisateur avec cet email existe déjà (ID: $userId).</p>";
    
    // Mettre à jour le mot de passe et les droits admin
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET password = ?, is_admin = ? WHERE email = ?");
    
    if ($stmt->execute([$hashedPassword, $isAdmin, $email])) {
        echo "<p>Le compte a été mis à jour avec succès.</p>";
        echo "<p>Nouveau mot de passe: $password</p>";
        echo "<p>Droits administrateur: " . ($isAdmin ? "OUI" : "NON") . "</p>";
        echo "<p>Hash du mot de passe: $hashedPassword</p>";
    } else {
        echo "<p>Erreur lors de la mise à jour du compte.</p>";
    }
} else {
    // Créer un nouvel utilisateur administrateur
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, ?)");
    
    if ($stmt->execute([$name, $email, $hashedPassword, $isAdmin])) {
        $userId = $pdo->lastInsertId();
        echo "<p>Un compte administrateur a été créé avec succès.</p>";
        echo "<p>ID: $userId</p>";
        echo "<p>Nom: $name</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Mot de passe: $password</p>";
        echo "<p>Hash du mot de passe: $hashedPassword</p>";
    } else {
        echo "<p>Erreur lors de la création du compte administrateur.</p>";
    }
}

echo "<p><a href='login.php'>Aller à la page de connexion</a></p>";
?> 