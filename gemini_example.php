<?php
/**
 * Example usage of the Google Gemini API wrapper
 */

// Require the Gemini API class
require_once 'gemini.php';

// Set your API key here (get one from https://ai.google.dev/)
$apiKey = 'AIzaSyBBGnDYnsrrX5RwKCagz5d_rMg8Gesz6xA';

// Initialize the Gemini client
$gemini = new GeminiAI($apiKey);

// Example 1: Simple text generation
$prompt = "Explain quantum computing in simple terms.";
$response = $gemini->generateContent($prompt);

// Check for errors
if (isset($response['error'])) {
    echo "Error: " . $response['message'] . "\n";
} else {
    // Extract and display the generated text
    $text = $gemini->getTextFromResponse($response);
    echo "Generated Text:\n" . $text . "\n\n";
}

// Example 2: Chat conversation
$messages = [
    [
        'role' => 'user',
        'content' => 'Hello, can you help me with a programming question?'
    ],
    [
        'role' => 'model',
        'content' => 'Of course! I\'d be happy to help with your programming question. What would you like to know?'
    ],
    [
        'role' => 'user',
        'content' => 'How do I connect to a MySQL database using PHP?'
    ]
];

// Optional parameters
$options = [
    'temperature' => 0.2,  // Lower temperature for more focused, deterministic responses
    'maxOutputTokens' => 500
];

$chatResponse = $gemini->generateChatContent($messages, $options);

// Check for errors
if (isset($chatResponse['error'])) {
    echo "Chat Error: " . $chatResponse['message'] . "\n";
} else {
    // Extract and display the generated text
    $chatText = $gemini->getTextFromResponse($chatResponse);
    echo "Chat Response:\n" . $chatText . "\n";
}
?> 