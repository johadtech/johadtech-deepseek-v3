<?php 

namespace Johadtech\DeepSeekV3\Contracts;

interface ResponseFormatterInterface
{
    public function format(array $response): array;
}