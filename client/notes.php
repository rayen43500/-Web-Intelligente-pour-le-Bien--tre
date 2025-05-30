<!-- Dans <head> -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<?php
// Initialisation sécurisée
$errors = $errors ?? [];
$success = $success ?? '';
$currentNote = $currentNote ?? null;
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Musique - Plateforme de Bien-être Mental et Culturel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
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
        <!-- Content -->
        <main class="flex-1 p-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Bloc-notes personnel</h1>
                <a href="notes.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Nouvelle note</a>
            </div>

            <!-- Message unique -->
            <?php if (!empty($success)): ?>
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php elseif (!empty($errors)): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    <ul class="list-disc list-inside">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Liste des notes -->
                <div class="col-span-1 bg-white p-4 rounded shadow">
                    <h2 class="text-xl font-semibold mb-4">Mes notes</h2>
                    <?php if (empty($notes)): ?>
                        <p class="text-gray-500">Aucune note pour l'instant.</p>
                    <?php else: ?>
                        <ul class="space-y-2">
                            <?php foreach ($notes as $note): ?>
                                <li>
                                    <a href="notes.php?id=<?php echo $note['id']; ?>"
                                       class="block p-2 rounded hover:bg-blue-50 <?php echo ($currentNote && $currentNote['id'] == $note['id']) ? 'bg-blue-100 font-semibold' : ''; ?>">
                                        <h3 class="text-lg"><?php echo htmlspecialchars($note['title']); ?></h3>
                                        <small class="text-gray-500"><?php echo date('d/m/Y', strtotime($note['updated_at'])); ?></small>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Éditeur -->
                <div class="col-span-2 bg-white p-6 rounded shadow">
                    <form method="POST" action="">
                        <?php if ($currentNote): ?>
                            <input type="hidden" name="note_id" value="<?php echo $currentNote['id']; ?>">
                        <?php endif; ?>

                        <div class="mb-4">
                            <label class="block text-gray-650 font-semibold mb-2">Titre</label>
                            <input type="text" name="title" required
                                   value="<?php echo htmlspecialchars($currentNote['title'] ?? ''); ?>"
                                   placeholder="Titre de la note"
                                   class="w-full p-2 border border-gray-300 rounded">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-650 font-semibold mb-2">Contenu</label>
                            <textarea name="content" rows="10"
                                      placeholder="Contenu de la note"
                                      class="w-full p-2 border border-gray-300 rounded"><?php echo htmlspecialchars($currentNote['content'] ?? ''); ?></textarea>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                <?php echo $currentNote ? 'Mettre à jour' : 'Enregistrer'; ?>
                            </button>

                            <?php if ($currentNote): ?>
                                <a href="notes.php?action=delete&id=<?php echo $currentNote['id']; ?>"
                                   onclick="return confirm('Supprimer cette note ?')"
                                   class="text-red-600 hover:underline">Supprimer</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
