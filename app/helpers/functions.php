<?php
/**
 * Fonctions utilitaires pour l'application
 */

// Inscription d'un utilisateur
function registerUser($name, $email, $password) {
    global $pdo;
    
    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        return [
            'success' => false,
            'message' => "Cet email est déjà utilisé."
        ];
    }
    
    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    // Insertion de l'utilisateur
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    
    try {
        $stmt->execute([$name, $email, $hashedPassword]);
        return [
            'success' => true,
            'message' => "Inscription réussie. Vous pouvez maintenant vous connecter.",
            'user_id' => $pdo->lastInsertId()
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => "Erreur lors de l'inscription: " . $e->getMessage()
        ];
    }
}

// Connexion d'un utilisateur
function loginUser($email, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT id, name, email, password, is_admin FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() == 0) {
        return [
            'success' => false,
            'message' => "Email ou mot de passe incorrect."
        ];
    }
    
    $user = $stmt->fetch();
    
    // Vérifier le mot de passe
    if (password_verify($password, $user['password'])) {
        // Créer la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['is_admin'] = (bool)$user['is_admin'];
        
        return [
            'success' => true,
            'message' => "Connexion réussie.",
            'user' => $user
        ];
    } else {
        // Pour le débogage, ajoutons des informations supplémentaires
        error_log("Échec de connexion pour $email - Mot de passe incorrect");
        error_log("Hash stocké: " . $user['password']);
        
        return [
            'success' => false,
            'message' => "Email ou mot de passe incorrect."
        ];
    }
}

// Déconnexion d'un utilisateur
function logoutUser() {
    // Détruire toutes les variables de session
    $_SESSION = [];
    
    // Détruire la session
    session_destroy();
    
    return [
        'success' => true,
        'message' => "Déconnexion réussie."
    ];
}

// Fonction pour vérifier si l'utilisateur est admin
if (!function_exists('isAdmin')) {
    function isAdmin() {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
    }
}

// Fonction pour récupérer des statistiques pour le tableau de bord admin
function getAdminStats() {
    global $pdo;
    
    $stats = [];
    
    // Nombre total d'utilisateurs
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM users WHERE is_admin = 0");
    $stmt->execute();
    $stats['total_users'] = $stmt->fetch()['total'];
    
    // Nombre total de livres
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM books");
    $stmt->execute();
    $stats['total_books'] = $stmt->fetch()['total'];
    
    // Nombre total de musiques
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM music");
    $stmt->execute();
    $stats['total_music'] = $stmt->fetch()['total'];
    
    // Nombre total de vidéos
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM videos");
    $stmt->execute();
    $stats['total_videos'] = $stmt->fetch()['total'];
    
    // Nombre total de conversations IA
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM ai_conversations");
    $stmt->execute();
    $stats['total_conversations'] = $stmt->fetch()['total'];
    
    return $stats;
}

// Fonctions pour récupérer tous les livres
function getAllBooks() {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM books ORDER BY added_at DESC");
    $stmt->execute();
    
    return $stmt->fetchAll();
}

// Fonctions pour récupérer tous les morceaux de musique
function getAllMusic() {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM music ORDER BY added_at DESC");
    $stmt->execute();
    
    return $stmt->fetchAll();
} 