<?php 

namespace Johadtech\DeepSeekV3\Tests\Unit;

use Johadtech\DeepSeekV3\Tests\TestCase;
use Johadtech\DeepSeekV3\Services\DeepSeekClient;

class ClientTest extends TestCase
{
    public function test_client_initialization()
    {
        $client = new DeepSeekClient();
        $this->assertInstanceOf(DeepSeekClient::class, $client);
    }
}