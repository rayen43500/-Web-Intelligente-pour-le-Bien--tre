# Google Gemini API PHP Integration

This is a simple PHP implementation for integrating with the Google Gemini AI API. The implementation includes a PHP wrapper class for the API and example applications.

## Files Included

1. `gemini.php` - The core PHP wrapper class for the Google Gemini API
2. `gemini_example.php` - Example usage of the wrapper for text generation and chat
3. `gemini_chat.php` - A web-based chat interface using the Gemini API

## Getting Started

### Prerequisites

- PHP 7.4 or higher
- cURL extension enabled
- A Google AI Studio API key

### Get an API Key

1. Go to [Google AI Studio](https://ai.google.dev/)
2. Sign in with your Google account
3. Create a new API key in the API keys section
4. Copy your API key for use in the applications

### Setup

1. Download or clone these files to your web server
2. Replace `'YOUR_GEMINI_API_KEY'` in the example files with your actual API key
3. For production use, consider storing your API key in environment variables rather than hardcoding it

## Basic Usage

### Using the GeminiAI Class

```php
// Include the Gemini API class
require_once 'gemini.php';

// Initialize with your API key
$gemini = new GeminiAI('YOUR_API_KEY');

// Generate content with a prompt
$prompt = "What is artificial intelligence?";
$response = $gemini->generateContent($prompt);

// Extract the text from the response
$text = $gemini->getTextFromResponse($response);
echo $text;
```

### Chat Conversations

```php
// Create a conversation with multiple messages
$messages = [
    [
        'role' => 'user',
        'content' => 'Hello, how are you?'
    ],
    [
        'role' => 'model',
        'content' => 'I\'m doing well, thank you for asking! How can I help you today?'
    ],
    [
        'role' => 'user',
        'content' => 'Can you explain what machine learning is?'
    ]
];

// Generate a response to the conversation
$chatResponse = $gemini->generateChatContent($messages);
$chatText = $gemini->getTextFromResponse($chatResponse);
echo $chatText;
```

## Web Chat Interface

The `gemini_chat.php` file provides a simple web-based chat interface. To use it:

1. Upload all files to your web server
2. Set your API key in the `gemini_chat.php` file
3. Navigate to the file in your web browser
4. Start chatting with the Gemini AI model

## API Parameters

The GeminiAI class supports various parameters that can be passed to the Gemini API:

```php
$options = [
    'temperature' => 0.7,        // Controls randomness (0.0 to 1.0)
    'topK' => 40,                // Limits token selection to top K options
    'topP' => 0.95,              // Nucleus sampling threshold
    'maxOutputTokens' => 1024,   // Maximum length of generated content
    'safetySettings' => [        // Optional safety settings
        // Safety settings configuration
    ]
];

// Pass options when generating content
$response = $gemini->generateContent($prompt, $options);
```

## Error Handling

The API wrapper includes basic error handling:

```php
$response = $gemini->generateContent($prompt);

if (isset($response['error'])) {
    echo "Error: " . $response['message'];
} else {
    $text = $gemini->getTextFromResponse($response);
    echo $text;
}
```

## Security Considerations

- Always store API keys securely, preferably using environment variables
- Validate and sanitize user input before sending it to the API
- Consider implementing rate limiting to avoid excessive API usage

## License

This code is provided as-is for educational and development purposes.

## Resources

- [Google Gemini API Documentation](https://ai.google.dev/docs)
- [PHP cURL Documentation](https://www.php.net/manual/en/book.curl.php) 