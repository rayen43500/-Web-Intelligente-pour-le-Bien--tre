<?php
/**
 * Google Gemini Chat Interface
 * A simple web-based chat interface for Google Gemini AI
 */

// Start session to maintain chat history
session_start();

// Include the Gemini API wrapper
require_once 'gemini.php';

// Initialize chat history if it doesn't exist
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}

// Set your API key (in production, use environment variables)
$apiKey = 'AIzaSyBBGnDYnsrrX5RwKCagz5d_rMg8Gesz6xA';

// Function to process chat messages
function processChat($message, $apiKey) {
    // Create Gemini instance
    $gemini = new GeminiAI($apiKey);
    
    // Add user message to history
    $_SESSION['chat_history'][] = [
        'role' => 'user',
        'content' => $message
    ];
    
    // Generate response from Gemini
    $response = $gemini->generateChatContent($_SESSION['chat_history']);
    
    // Extract text from response
    $generatedText = $gemini->getTextFromResponse($response);
    
    // If we got a valid response, add it to history
    if ($generatedText) {
        $_SESSION['chat_history'][] = [
            'role' => 'model',
            'content' => $generatedText
        ];
    }
    
    return $generatedText;
}

// Process form submission
$responseText = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && !empty($_POST['message'])) {
    $userMessage = trim($_POST['message']);
    
    try {
        $responseText = processChat($userMessage, $apiKey);
        if (!$responseText) {
            $error = "Failed to get a response from Gemini. Please try again.";
        }
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Clear chat history if requested
if (isset($_POST['clear_chat'])) {
    $_SESSION['chat_history'] = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gemini AI Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .chat-container {
            height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        .user-message {
            background-color: #e3f2fd;
            margin-left: 20px;
            margin-right: 5px;
            text-align: right;
        }
        .bot-message {
            background-color: #f0f0f0;
            margin-right: 20px;
            margin-left: 5px;
        }
        .input-container {
            display: flex;
            margin-top: 10px;
        }
        #message-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            margin-left: 10px;
            background-color: #4285f4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #2a75f3;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .clear-btn {
            background-color: #f44336;
        }
        .clear-btn:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gemini AI Chat</h1>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="chat-container" id="chat-container">
            <?php foreach ($_SESSION['chat_history'] as $message): ?>
                <div class="message <?php echo $message['role'] === 'user' ? 'user-message' : 'bot-message'; ?>">
                    <strong><?php echo $message['role'] === 'user' ? 'You' : 'Gemini'; ?>:</strong>
                    <?php echo nl2br(htmlspecialchars($message['content'])); ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <form method="post" action="">
            <div class="input-container">
                <input type="text" id="message-input" name="message" placeholder="Type your message here..." required>
                <button type="submit">Send</button>
            </div>
            <div style="text-align: center; margin-top: 10px;">
                <button type="submit" name="clear_chat" class="clear-btn">Clear Chat</button>
            </div>
        </form>
    </div>
    
    <script>
        // Scroll to bottom of chat container
        document.addEventListener('DOMContentLoaded', function() {
            const chatContainer = document.getElementById('chat-container');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        });
    </script>
</body>
</html> 