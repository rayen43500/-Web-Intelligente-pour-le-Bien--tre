
<?php
require_once __DIR__ . '/app/bootstrap.php';
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $file_path = $_POST['file_path'];
    $cover_path = $_POST['cover_path'];

    $sql = "INSERT INTO music (title, artist, file_path, cover_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$title, $artist, $file_path, $cover_path])) {
        $message = "✅ Morceau ajouté avec succès.";
    } else {
        $message = "❌ Erreur lors de l'ajout du morceau.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Musique - Plateforme de Bien-être Mental et Culturel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <form method="POST" action="" enctype="multipart/form-data">
    <label for="title">Titre :</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="artist">Artiste :</label><br>
    <input type="text" id="artist" name="artist"><br><br>

    <label for="file_path">Fichier audio (MP3) :</label><br>
    <input type="file" id="file_path" name="file_path" accept="audio/*" required><br><br>

    <label for="cover_path">Image de couverture (JPG/PNG) :</label><br>
    <input type="file" id="cover_path" name="cover_path" accept="image/*"><br><br>

    <button type="submit">Ajouter le morceau</button>
</form>

</body>