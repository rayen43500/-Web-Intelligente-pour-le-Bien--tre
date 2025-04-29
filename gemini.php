<?php
/**
 * Google Gemini API Integration
 * Simple PHP wrapper for the Google Gemini API
 */

class GeminiAI {
    private $apiKey;
    private $apiEndpoint = 'https://generativelanguage.googleapis.com/v1beta/models/';
    private $model = 'gemini-pro';

    /**
     * Constructor
     * 
     * @param string $apiKey Your Google AI Studio API key
     * @param string $model Optional: Model name (default: gemini-pro)
     */
    public function __construct($apiKey, $model = null) {
        $this->apiKey = $apiKey;
        if ($model) {
            $this->model = $model;
        }
    }

    /**
     * Generate content using Google Gemini API
     * 
     * @param string $prompt The prompt text to send to Gemini
     * @param array $options Optional parameters (temperature, topK, topP, etc.)
     * @return array Response from Gemini API
     */
    public function generateContent($prompt, $options = []) {
        // Build request URL
        $url = $this->apiEndpoint . $this->model . ':generateContent?key=' . $this->apiKey;
        
        // Default parameters
        $params = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => $options['temperature'] ?? 0.7,
                'topK' => $options['topK'] ?? 40,
                'topP' => $options['topP'] ?? 0.95,
                'maxOutputTokens' => $options['maxOutputTokens'] ?? 1024,
            ]
        ];

        // Add safety settings if provided
        if (isset($options['safetySettings'])) {
            $params['safetySettings'] = $options['safetySettings'];
        }

        // Make the HTTP request
        $response = $this->makeRequest($url, $params);
        
        return $response;
    }

    /**
     * Generate chat content using Google Gemini API
     * 
     * @param array $messages Array of message objects with role and content
     * @param array $options Optional parameters
     * @return array Response from Gemini API
     */
    public function generateChatContent($messages, $options = []) {
        // Build request URL
        $url = $this->apiEndpoint . $this->model . ':generateContent?key=' . $this->apiKey;
        
        // Format messages for Gemini API
        $contents = [];
        foreach ($messages as $message) {
            $contents[] = [
                'role' => $message['role'],
                'parts' => [
                    ['text' => $message['content']]
                ]
            ];
        }

        // Default parameters
        $params = [
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => $options['temperature'] ?? 0.7,
                'topK' => $options['topK'] ?? 40,
                'topP' => $options['topP'] ?? 0.95,
                'maxOutputTokens' => $options['maxOutputTokens'] ?? 1024,
            ]
        ];

        // Add safety settings if provided
        if (isset($options['safetySettings'])) {
            $params['safetySettings'] = $options['safetySettings'];
        }

        // Make the HTTP request
        $response = $this->makeRequest($url, $params);
        
        return $response;
    }

    /**
     * Make HTTP request to the Gemini API
     * 
     * @param string $url API endpoint URL
     * @param array $data Request data
     * @return array|null Response data or null on error
     */
    private function makeRequest($url, $data) {
        // Initialize cURL
        $ch = curl_init($url);
        
        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        
        // Execute the request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Check for errors
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
            curl_close($ch);
            return null;
        }
        
        // Close cURL
        curl_close($ch);
        
        // Parse and return the response
        $responseData = json_decode($response, true);
        
        // Handle API errors
        if ($httpCode != 200) {
            return [
                'error' => true,
                'status' => $httpCode,
                'message' => $responseData['error']['message'] ?? 'Unknown error',
                'raw' => $responseData
            ];
        }
        
        return $responseData;
    }

    /**
     * Get the text from the API response
     * 
     * @param array $response The API response
     * @return string|null The generated text or null if unavailable
     */
    public function getTextFromResponse($response) {
        if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            return $response['candidates'][0]['content']['parts'][0]['text'];
        }
        return null;
    }
} 