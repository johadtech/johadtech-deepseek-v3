<?php 

namespace Johadtech\DeepSeekV3\Tests\Feature;

use Johadtech\DeepSeekV3\Tests\TestCase;
use Johadtech\DeepSeekV3\Facades\DeepSeek;

class DeepSeekApiTest extends TestCase
{
    public function test_chat_completion()
    {
        $response = DeepSeek::chat([
            ['role' => 'user', 'content' => 'Hello']
        ]);

        $this->assertArrayHasKey('content', $response);
    }
}