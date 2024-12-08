<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Allow API and Sanctum CSRF routes
    'allowed_methods' => ['*'], // Allow all HTTP methods
    'allowed_origins' => ['http://localhost:3000','http://127.0.0.1:3000'], // Replace with your React app URL
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Allow all headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Enable cookies for Laravel Sanctum
];

