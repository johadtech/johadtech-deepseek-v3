<?php 

namespace Johadtech\DeepSeekV3\Services;

use Johadtech\DeepSeekV3\Contracts\ResponseFormatterInterface;

class ResponseFormatter implements ResponseFormatterInterface
{
    public function format(array $response): array
    {
        return [
            'content' => $response['choices'][0]['message']['content'],
            'usage' => $response['usage'],
        ];
    }
}