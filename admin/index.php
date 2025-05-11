<?php
require_once __DIR__ . '/../app/bootstrap.php';

// Protection de la page
if (!isLoggedIn() || !isAdmin()) {
    redirect('login.php');
}

// Récupérer les statistiques pour le tableau de bord
$stats = getAdminStats();

function pourcentage($value, $total) {
    if ($total == 0) return 0;
    return round(($value / $total) * 100, 2);
}
$total_users = $stats['total_users'];
$total_books = $stats['total_books'];
$total_music = $stats['total_music'];
$total_videos = $stats['total_videos'];
$total_conversations = $stats['total_conversations'];

$total_global = $total_users + $total_books + $total_music + $total_videos + $total_conversations;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Plateforme de Bien-être Mental et Culturel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard">
       <!-- Sidebar modernisée -->
        <aside class="w-64 bg-blue-500 shadow-md text-white min-h-screen">
            <div class="p-6 border-b border-blue-400">
                <h2 class="text-2xl font-bold">Administration</h2>
            </div><br>
            <nav class="p-4 space-y-2">
                <a href="index.php" class="block py-2 px-4 rounded hover:bg-blue-600 text-white">
                    <b><i class="fas fa-home mr-2 text-white"></i> Tableau de bord</b>
                </a></br>
                <a href="books.php" class="block py-2 px-4 rounded hover:bg-blue-600 text-white">
                    <b><i class="fas fa-book mr-2 text-white"></i> Gestion des livres</b>
                </a><br>
                <a href="music.php" class="block py-2 px-4 rounded hover:bg-blue-600 text-white">
                    <b><i class="fas fa-music mr-2 text-white"></i> Gestion des musiques</b>
                </a><br>
                <a href="videos.php" class="block py-2 px-4 rounded hover:bg-blue-600 text-white">
                    <b><i class="fas fa-video mr-2 text-white"></i> Gestion des vidéos</b>
                </a><br>
                <a href="users.php" class="block py-2 px-4 rounded hover:bg-blue-600 text-white">
                    <b><i class="fas fa-users mr-2 text-white"></i> Gestion utilisateurs<b>
                </a><br>
                <a href="../logout.php" class="block py-2 px-4 rounded text-red-600 hover:bg-red-100 text-white">
                    <b> <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion</b>
                </a>
            </nav>
        </aside>

        
        <div class="content">
            <div class="page-header">
                <h1 style="font-size: larger;color:brown"> Tableau de bord administrateur</h1>
            </div>
            
            <!-- Statistiques générales -->
            <div class="feature-grid ">
                <div class="feature-card" >
                <h3><i class="fas fa-user"> Utilisateurs </i></h3>
                <div class="stat-value"><?php echo $total_users; ?> utilisateurs</div>
                <div class="progress-bar">
                    <div class="progress" style="width: <?php echo pourcentage($total_users, $total_global); ?>%;"></div>
                </div>
                <img src="../assets/img/stat.PNG" alt="pourcentage" style="width: 30px; height: 30px;" />
                <div class="percentage"><?php echo pourcentage($total_users, $total_global); ?>%</div>
                </div>

                <div class="feature-card">
                <h3><i class="fas fa-music"> Musiques  </i></h3>
                <div class="stat-value"><?php echo $total_music; ?> Musiques</div>
                <div class="progress-bar">
                    <div class="progress" style="width: <?php echo pourcentage($total_music, $total_global); ?>%;"></div>
                </div>
                <div >
                <img src="../assets/img/stat.PNG" alt="pourcentage" style="width: 30px; height: 30px;" />
                <div class="percentage"><?php echo pourcentage($total_music, $total_global); ?>%</div>
                </div>
                </div>

                <div class="feature-card">
                <h3><i class="fas fa-book"> Livres </i></h3>
                <div class="stat-value"><?php echo $total_books; ?> livres</div>
                <div class="progress-bar">
                    <div class="progress" style="width: <?php echo pourcentage($total_books, $total_global); ?>%;"></div>
                </div>
                <img src="../assets/img/stat.PNG" alt="pourcentage" style="width: 30px; height: 30px;" />
                <div class="percentage"><?php echo pourcentage($total_books, $total_global); ?>%</div>
                </div>

               <div class="feature-card">
                <h3><i class="fas fa-video"> Vedeo </i></h3>
                <div class="stat-value"><?php echo $total_videos; ?> Vedeo</div>
                <div class="progress-bar">
                    <div class="progress" style="width: <?php echo pourcentage($total_videos, $total_global); ?>%;"></div>
                </div>
                <img src="../assets/img/stat.PNG" alt="pourcentage" style="width: 30px; height: 30px;" />
                <div class="percentage"><?php echo pourcentage($total_videos, $total_global); ?>%</div>
                </div>

                <div class="feature-card">
                <h3><i class="fas fa-comments"> Conversations IA </i></h3>
                <div class="stat-value"><?php echo $total_conversations; ?> conversations</div>
                <div class="progress-bar">
                    <div class="progress" style="width: <?php echo pourcentage($total_conversations, $total_global); ?>%;"></div>
                </div>
                <img src="../assets/img/stat.PNG" alt="pourcentage" style="width: 30px; height: 30px;" />
                <div class="percentage"><?php echo pourcentage($total_conversations, $total_global); ?>%</div>
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
    
    <script src="../assets/js/main.js"></script>
</body>
</html> 