<!-- Dans <head> -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<?php
require_once __DIR__ . '/../app/bootstrap.php';

// Protection de la page
if (!isLoggedIn()) {
    redirect('login.php');
}

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Plateforme de Bien-être Mental et Culturel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard">
    <aside class="w-64 bg-blue-500 shadow-md text-white">
            <div class="p-6 border-b">
                <h2 class="text-2xl font-bold">Menu</h2>
            </div>
            <nav class="p-4 space-y-2">
                <a href="dashboard.php" class="block py-2 px-4 rounded hover:bg-blue-600 text-white">
                    <i class="fas fa-home mr-2 text-white"></i> Accueil
                </a>
                <a href="ai-chat.php" class="block py-2 px-4 rounded hover:bg-blue-600 text-white">
                    <i class="fas fa-robot mr-2 text-white"></i> Consultation IA
                </a>
                 <a href="notes.php" class="block py-2 px-4 rounded hover:bg-blue-600 text-white">
                    <i class="fas fa-book mr-2 text-white"></i> Bloc-notes
                </a>
                <a href="books.php" class="block py-2 px-4 rounded hover:bg-blue-600 text-white">
                    <i class="fas fa-book mr-2 text-white"></i> Bibliothèque
                </a>
                <a href="music.php" class="block py-2 px-4 rounded hover:bg-blue-600 text-white">
                    <i class="fas fa-music mr-2 text-white"></i> Espace Musique
                </a>
                <a href="profile.php" class="block py-2 px-4 rounded hover:bg-blue-600 text-white">
                    <i class="fas fa-user mr-2 text-white"></i> Mon profil
                </a>
                <a href="../logout.php" class="block py-2 px-4 rounded text-red-600 hover:bg-red-100">
                    <i class="fas fa-sign-out-alt mr-2"></i><b> Déconnexion</b>
                </a>
            </nav>
        </aside>
        
        <div class="content">
            <div class="page-header">
                <h1>Bienvenue, <?php echo htmlspecialchars($userName); ?> !</h1>
            </div>
            
            <div class="dashboard-cards">
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <h2>Consultation IA</h2>
                        </div>
                        <div class="card-body">
                            <p>Discutez avec notre assistant virtuel pour des conseils personnalisés en matière de bien-être mental.</p>
                            <a href="ai-chat.php" class="btn primary">Commencer une conversation</a>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h2>Bloc-notes</h2>
                        </div>
                        <div class="card-body">
                            <p>Prenez des notes personnelles, organisez vos pensées et suivez vos objectifs.</p>
                            <a href="notes.php" class="btn primary">Accéder à mes notes</a>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <h2>Bibliothèque</h2>
                        </div>
                        <div class="card-body">
                            <p>Accédez à notre collection de livres numériques pour vous enrichir et vous détendre.</p>
                            <a href="books.php" class="btn primary">Explorer la bibliothèque</a>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h2>Espace Musique</h2>
                        </div>
                        <div class="card-body">
                            <p>Écoutez des musiques apaisantes et stimulantes pour améliorer votre humeur et votre concentration.</p>
                            <a href="music.php" class="btn primary">Écouter de la musique</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h2>Dernières activités</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        // Récupérer les 5 dernières notes
                        $notes = getUserNotes($userId);
                        $notes = array_slice($notes, 0, 5);
                        
                        // Récupérer les 5 dernières conversations IA
                        $conversations = getUserConversations($userId);
                        $conversations = array_slice($conversations, 0, 5);
                        
                        if (empty($notes) && empty($conversations)) {
                            echo "<p>Aucune activité récente. Commencez à utiliser nos services pour voir vos activités ici.</p>";
                        } else {
                            echo "<div class='activity-list'>";
                            
                            // Afficher les notes récentes
                            if (!empty($notes)) {
                                echo "<h3>Notes récentes</h3>";
                                echo "<ul>";
                                foreach ($notes as $note) {
                                    echo "<li>
                                        <a href='notes.php?id=" . $note['id'] . "'>
                                            " . htmlspecialchars($note['title']) . "
                                        </a>
                                        <span class='date'>" . date('d/m/Y', strtotime($note['updated_at'])) . "</span>
                                    </li>";
                                }
                                echo "</ul>";
                            }
                            
                            // Afficher les conversations récentes
                            if (!empty($conversations)) {
                                echo "<h3>Conversations récentes</h3>";
                                echo "<ul>";
                                foreach ($conversations as $conversation) {
                                    echo "<li>
                                        <a href='ai-chat.php?id=" . $conversation['id'] . "'>
                                            Conversation du " . date('d/m/Y à H:i', strtotime($conversation['conversation_date'])) . "
                                        </a>
                                    </li>";
                                }
                                echo "</ul>";
                            }
                            
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/main.js"></script>
</body>
</html>
