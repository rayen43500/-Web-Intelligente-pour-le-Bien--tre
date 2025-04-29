<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../gemini.php';  // Inclure la classe Gemini API

// Protection de la page
if (!function_exists('isLoggedIn')) {
    die("Erreur: La fonction isLoggedIn() n'est pas définie. Vérifiez l'inclusion de functions.php.");
}

if (!isLoggedIn()) {
    redirect('../login.php');
}

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

// Clé API Gemini (en production, utilisez des variables d'environnement)
$apiKey = 'AIzaSyBBGnDYnsrrX5RwKCagz5d_rMg8Gesz6xA';

// Initialiser l'instance Gemini
$gemini = new GeminiAI($apiKey);

$errors = [];
$success = '';
$conversationId = null;
$messages = [];

// Charger une conversation existante
if (isset($_GET['id'])) {
    $conversationId = (int)$_GET['id'];
    
    // Vérifier si la conversation appartient à l'utilisateur
    $conversations = getUserConversations($userId);
    $conversationBelongsToUser = false;
    
    foreach ($conversations as $conversation) {
        if ($conversation['id'] == $conversationId) {
            $conversationBelongsToUser = true;
            break;
        }
    }
    
    if (!$conversationBelongsToUser) {
        $errors[] = "Conversation non trouvée ou vous n'êtes pas autorisé à y accéder.";
        $conversationId = null;
    } else {
        $messages = getConversationMessages($conversationId);
    }
} else {
    // Créer une nouvelle conversation
    $result = createAiConversation($userId);
    
    if ($result['success']) {
        $conversationId = $result['conversation_id'];
        
        // Message d'accueil de l'IA
        $welcomeMessage = "Bonjour ! Je suis votre assistant de bien-être mental. Comment puis-je vous aider aujourd'hui ? N'hésitez pas à me parler de ce qui vous préoccupe, je suis là pour vous écouter et vous conseiller.";
        saveAiMessage($conversationId, $welcomeMessage, false);
        
        $messages = getConversationMessages($conversationId);
    } else {
        $errors[] = $result['message'];
    }
}

// Traitement du formulaire d'envoi de message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && $conversationId) {
    $userMessage = trim($_POST['message']);
    
    if (!empty($userMessage)) {
        // Enregistrer le message de l'utilisateur
        $result = saveAiMessage($conversationId, $userMessage, true);
        
        if ($result['success']) {
            // Préparer les messages pour l'API Gemini
            $geminiMessages = [];
            
            // Ajouter un contexte à l'IA pour qu'elle agisse comme un assistant de bien-être mental
            $systemPrompt = [
                'role' => 'model',
                'content' => "Vous êtes un assistant de bien-être mental bienveillant et empathique. Votre objectif est d'aider l'utilisateur à améliorer son bien-être mental et émotionnel. Vous devez être compréhensif, offrir des conseils constructifs et des techniques pratiques pour gérer le stress, l'anxiété et améliorer la santé mentale. Vos réponses doivent être empathiques et encourageantes. Évitez les conseils médicaux spécifiques et suggérez de consulter un professionnel de la santé pour les problèmes graves. Répondez en français."
            ];
            
            $geminiMessages[] = $systemPrompt;
            
            // Ajouter les messages précédents (limités aux 10 derniers pour éviter de dépasser les limites de l'API)
            $recentMessages = array_slice($messages, -10);
            foreach ($recentMessages as $msg) {
                $geminiMessages[] = [
                    'role' => $msg['is_user'] ? 'user' : 'model',
                    'content' => $msg['message']
                ];
            }
            
            // Ajouter le message actuel de l'utilisateur
            $geminiMessages[] = [
                'role' => 'user',
                'content' => $userMessage
            ];
            
            try {
                // Générer une réponse avec l'API Gemini
                $options = [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 800
                ];
                
                $response = $gemini->generateChatContent($geminiMessages, $options);
                
                if (isset($response['error'])) {
                    throw new Exception("Erreur de l'API Gemini: " . ($response['message'] ?? "Erreur inconnue"));
                }
                
                // Extraire la réponse générée
                $aiResponse = $gemini->getTextFromResponse($response);
                
                // Si pas de réponse valide, utiliser une réponse de secours
                if (!$aiResponse) {
                    $backupResponses = [
                        "Je comprends ce que vous ressentez. Pouvez-vous m'en dire plus sur cette situation ?",
                        "C'est une préoccupation que beaucoup de personnes partagent. Comment vous sentez-vous par rapport à cela ?",
                        "Merci de partager cela avec moi. Avez-vous essayé de prendre un moment pour vous aujourd'hui ?",
                        "Je suis là pour vous écouter. Qu'est-ce qui vous aiderait à vous sentir mieux en ce moment ?",
                        "Parfois, prendre une pause et respirer profondément peut aider. Voulez-vous essayer un exercice de respiration ensemble ?"
                    ];
                    $aiResponse = $backupResponses[array_rand($backupResponses)];
                }
                
                // Sauvegarder la réponse de l'IA
                saveAiMessage($conversationId, $aiResponse, false);
                
                // Rafraîchir les messages
                $messages = getConversationMessages($conversationId);
                
            } catch (Exception $e) {
                $errors[] = "Erreur: " . $e->getMessage();
                
                // En cas d'erreur, utiliser une réponse de secours
                $backupResponse = "Je suis désolé, j'ai rencontré un problème technique. Pouvez-vous reformuler votre message ou essayer à nouveau plus tard ?";
                saveAiMessage($conversationId, $backupResponse, false);
                
                // Rafraîchir les messages
                $messages = getConversationMessages($conversationId);
            }
        } else {
            $errors[] = $result['message'];
        }
    }
}

// Récupérer les conversations passées pour le menu latéral
$conversations = getUserConversations($userId);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation IA - Plateforme de Bien-être Mental et Culturel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Menu</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php">Accueil</a></li>
                    <li><a href="ai-chat.php" class="active">Consultation IA</a></li>
                    <li><a href="notes.php">Bloc-notes</a></li>
                    <li><a href="books.php">Bibliothèque</a></li>
                    <li><a href="music.php">Espace Musique</a></li>
                    <li><a href="profile.php">Mon profil</a></li>
                    <li><a href="../logout.php">Déconnexion</a></li>
                </ul>
            </nav>
            
            <!-- Liste des conversations passées -->
            <div class="conversations-list">
                <h3>Mes conversations</h3>
                <?php if (count($conversations) > 1): // Plus d'une conversation (inclut la conversation actuelle) ?>
                <ul>
                    <?php foreach ($conversations as $conv): 
                        if ($conv['id'] != $conversationId): // Ne pas afficher la conversation actuelle ?>
                    <li>
                        <a href="ai-chat.php?id=<?php echo $conv['id']; ?>">
                            Conversation du <?php echo date('d/m/Y à H:i', strtotime($conv['conversation_date'])); ?>
                        </a>
                    </li>
                    <?php endif; endforeach; ?>
                </ul>
                <?php else: ?>
                <p>Vous n'avez pas d'autres conversations.</p>
                <?php endif; ?>
                <div class="new-conversation">
                    <a href="ai-chat.php" class="btn primary">Nouvelle conversation</a>
                </div>
            </div>
        </div>
        
        <div class="content">
            <div class="page-header">
                <h1>Consultation IA avec Google Gemini</h1>
            </div>
            
            <?php if (!empty($errors)): ?>
            <div class="alert error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <?php if ($conversationId): ?>
            <div class="chat-container">
                <div class="chat-messages" id="chatMessages">
                    <?php foreach ($messages as $message): ?>
                    <div class="message <?php echo $message['is_user'] ? 'user' : 'ai'; ?>">
                        <?php echo nl2br(htmlspecialchars($message['message'])); ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <form method="POST" action="" class="chat-input">
                    <input type="text" name="message" placeholder="Écrivez votre message ici..." required>
                    <button type="submit" class="btn primary">Envoyer</button>
                </form>
            </div>
            
            <div class="chat-info">
                <div class="card">
                    <div class="card-header">
                        <h2>À propos de cette consultation</h2>
                    </div>
                    <div class="card-body">
                        <p>Cette consultation IA est propulsée par Google Gemini et est conçue pour vous offrir un espace de dialogue et de réflexion sur votre bien-être mental.</p>
                        <p>Bien que notre assistant soit programmé pour vous fournir un soutien et des conseils, veuillez noter qu'il ne remplace pas une consultation avec un professionnel de la santé mentale.</p>
                        <p>Si vous vivez une situation d'urgence ou de détresse grave, veuillez contacter un service d'aide professionnelle ou consulter un médecin.</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
    // Faire défiler automatiquement vers le bas dans le chat
    document.addEventListener('DOMContentLoaded', function() {
        var chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    });
    </script>
    
    <script src="../assets/js/main.js"></script>
</body>
</html> 