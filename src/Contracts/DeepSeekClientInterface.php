<?php 

namespace Johadtech\DeepSeekV3\Contracts;

interface DeepSeekClientInterface
{
    public function chat(array $messages, array $params = []);
    public function streamChat(array $messages, array $params = []);
    public function getUsage(): array;
    public function validateKey(): bool;
    public function countTokens(string $text): int;
}