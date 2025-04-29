<?php
// Script de test pour diagnostiquer les problèmes de connexion
require_once __DIR__ . '/app/bootstrap.php';

echo "<h1>Test de connexion</h1>";

// Définir les informations de connexion
$email = 'admin@example.com';
$password = 'admin123';

echo "<p>Tentative de connexion avec email: $email</p>";

// Vérifier si l'utilisateur existe
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    echo "<p>Erreur: Cet utilisateur n'existe pas dans la base de données.</p>";
    exit;
}

echo "<p>Utilisateur trouvé: ID={$user['id']}, Nom={$user['name']}</p>";
echo "<p>Hash du mot de passe stocké: " . $user['password'] . "</p>";

// Tester le mot de passe avec password_verify
$verification = password_verify($password, $user['password']);
echo "<p>Résultat de password_verify: " . ($verification ? "SUCCÈS" : "ÉCHEC") . "</p>";

// Créer un nouveau hash pour comparaison
$newHash = password_hash($password, PASSWORD_BCRYPT);
echo "<p>Nouveau hash généré pour le même mot de passe: $newHash</p>";

// Suggestion pour résoudre le problème
echo "<h2>Résolution potentielle</h2>";
echo "<p>Si la vérification a échoué, vous pouvez mettre à jour le mot de passe dans la base de données:</p>";
echo "<pre>
UPDATE users SET password = '$newHash' WHERE email = '$email';
</pre>";

echo "<p><a href='login.php'>Retour à la page de connexion</a></p>";
?> 