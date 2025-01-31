<?php 

if (!function_exists('deepseek_cache_key')) {
    function deepseek_cache_key(array $messages, array $params): string
    {
        return 'deepseek_' . md5(json_encode([$messages, $params]));
    }
}