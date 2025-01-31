<?php 

return [
    'api_key' => env('DEEPSEEK_API_KEY'),
    'base_url' => env('DEEPSEEK_BASE_URL', 'https://api.deepseek.com'),
    'default_model' => env('DEEPSEEK_MODEL', 'deepseek-chat'),
    'default_temperature' => env('DEEPSEEK_TEMPERATURE', 1.0),
    'max_tokens' => env('DEEPSEEK_MAX_TOKENS', 4096),
    'cache' => [
        'enabled' => env('DEEPSEEK_CACHE_ENABLED', true),
        'ttl' => env('DEEPSEEK_CACHE_TTL', 3600),
    ],
];