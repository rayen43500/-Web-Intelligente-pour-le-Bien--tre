<?php
require_once __DIR__ . '/../app/bootstrap.php';

// Protection de la page
if (!isLoggedIn() || !isAdmin()) {
    redirect('login.php');
}

// Récupérer les statistiques pour le tableau de bord
$stats = getAdminStats();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Plateforme de Bien-être Mental et Culturel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Administration</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="index.php" class="active">Tableau de bord</a></li>
                    <li><a href="books.php">Gestion des livres</a></li>
                    <li><a href="music.php">Gestion des musiques</a></li>
                    <li><a href="videos.php">Gestion des vidéos</a></li>
                    <li><a href="users.php">Gestion des utilisateurs</a></li>
                    <li><a href="../logout.php">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
        
        <div class="content">
            <div class="page-header">
                <h1>Tableau de bord administrateur</h1>
            </div>
            
            <!-- Statistiques générales -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Utilisateurs</h3>
                    <div class="stat-value"><?php echo $stats['total_users']; ?></div>
                </div>
                
                <div class="stat-card">
                    <h3>Livres</h3>
                    <div class="stat-value"><?php echo $stats['total_books']; ?></div>
                </div>
                
                <div class="stat-card">
                    <h3>Musiques</h3>
                    <div class="stat-value"><?php echo $stats['total_music']; ?></div>
                </div>
                
                <div class="stat-card">
                    <h3>Vidéos</h3>
                    <div class="stat-value"><?php echo $stats['total_videos']; ?></div>
                </div>
                
                <div class="stat-card">
                    <h3>Conversations IA</h3>
                    <div class="stat-value"><?php echo $stats['total_conversations']; ?></div>
                </div>
            </div>
            
            <!-- Gestion rapide -->
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h2>Actions rapides</h2>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <a href="books.php?action=add" class="btn primary">Ajouter un livre</a>
                            <a href="music.php?action=add" class="btn primary">Ajouter une musique</a>
                            <a href="videos.php?action=add" class="btn primary">Ajouter une vidéo</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Derniers contenus ajoutés -->
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h2>Derniers livres ajoutés</h2>
                        <a href="books.php" class="btn secondary">Voir tous</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Auteur</th>
                                        <th>Date d'ajout</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $books = getAllBooks();
                                    $books = array_slice($books, 0, 5);
                                    
                                    if (empty($books)) {
                                        echo "<tr><td colspan='4'>Aucun livre n'a été ajouté.</td></tr>";
                                    } else {
                                        foreach ($books as $book) {
                                            echo "<tr>
                                                <td>" . htmlspecialchars($book['title']) . "</td>
                                                <td>" . htmlspecialchars($book['author']) . "</td>
                                                <td>" . date('d/m/Y', strtotime($book['added_at'])) . "</td>
                                                <td>
                                                    <a href='books.php?action=edit&id=" . $book['id'] . "' class='btn-sm primary'>Modifier</a>
                                                    <a href='books.php?action=delete&id=" . $book['id'] . "' class='btn-sm danger' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce livre ?\")'>Supprimer</a>
                                                </td>
                                            </tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h2>Dernières musiques ajoutées</h2>
                        <a href="music.php" class="btn secondary">Voir toutes</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Artiste</th>
                                        <th>Date d'ajout</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $music = getAllMusic();
                                    $music = array_slice($music, 0, 5);
                                    
                                    if (empty($music)) {
                                        echo "<tr><td colspan='4'>Aucune musique n'a été ajoutée.</td></tr>";
                                    } else {
                                        foreach ($music as $track) {
                                            echo "<tr>
                                                <td>" . htmlspecialchars($track['title']) . "</td>
                                                <td>" . htmlspecialchars($track['artist']) . "</td>
                                                <td>" . date('d/m/Y', strtotime($track['added_at'])) . "</td>
                                                <td>
                                                    <a href='music.php?action=edit&id=" . $track['id'] . "' class='btn-sm primary'>Modifier</a>
                                                    <a href='music.php?action=delete&id=" . $track['id'] . "' class='btn-sm danger' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette musique ?\")'>Supprimer</a>
                                                </td>
                                            </tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/main.js"></script>
</body>
</html> 