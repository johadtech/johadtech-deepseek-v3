<?php 

namespace Johadtech\DeepSeekV3\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;
use Johadtech\DeepSeekV3\Contracts\DeepSeekClientInterface;
use Johadtech\DeepSeekV3\Exceptions\{
    AuthenticationException,
    InvalidParameterException,
    RateLimitException
};

class DeepSeekClient implements DeepSeekClientInterface
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;
    protected $defaultModel;
    protected $defaultTemperature;
    protected $maxTokens;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => config('deepseek.timeout'),
        ]);

        $this->apiKey = config('deepseek.api_key');
        $this->baseUrl = config('deepseek.base_url');
        $this->defaultModel = config('deepseek.default_model');
        $this->defaultTemperature = config('deepseek.default_temperature');
        $this->maxTokens = config('deepseek.max_tokens');

        $this->validateConfig();
    }

    public function chat(array $messages, array $params = [])
    {
        $this->validateRequest($messages, $params);

        $cacheKey = $this->generateCacheKey($messages, $params);

        return Cache::remember($cacheKey, config('deepseek.cache.ttl'), function() use ($messages, $params) {
            return $this->makeApiRequest($messages, $params);
        });
    }

    public function streamChat(array $messages, array $params = [])
    {
        $this->validateRequest($messages, $params);

        $response = $this->client->post("{$this->baseUrl}/chat/completions", [
            'headers' => $this->buildHeaders(),
            'json' => $this->buildPayload($messages, $params),
            'stream' => true,
        ]);

        return $response->getBody();
    }

    public function getUsage(): array
    {
        $response = $this->client->get("{$this->baseUrl}/usage", [
            'headers' => $this->buildHeaders(),
        ]);

        return json_decode($response->getBody(), true);
    }

    public function validateKey(): bool
    {
        try {
            $this->client->get("{$this->baseUrl}/validate", [
                'headers' => $this->buildHeaders(),
            ]);

            return true;
        } catch (ClientException $e) {
            return false;
        }
    }

    public function countTokens(string $text): int
    {
        $response = $this->client->post("{$this->baseUrl}/count-tokens", [
            'headers' => $this->buildHeaders(),
            'json' => ['text' => $text],
        ]);

        return json_decode($response->getBody(), true)['tokens'];
    }

    protected function validateConfig(): void
    {
        if (empty($this->apiKey)) {
            throw new AuthenticationException('DeepSeek API key not configured');
        }

        if (!in_array($this->defaultModel, config('deepseek.allowed_models'))) {
            throw new InvalidParameterException("Invalid model: {$this->defaultModel}");
        }
    }

    protected function validateRequest(array $messages, array $params): void
    {
        if (empty($messages)) {
            throw new InvalidParameterException('Messages array cannot be empty');
        }

        if (isset($params['temperature']) && ($params['temperature'] < 0 || $params['temperature'] > 2)) {
            throw new InvalidParameterException('Temperature must be between 0 and 2');
        }
    }

    protected function buildHeaders(): array
    {
        return [
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ];
    }

    protected function buildPayload(array $messages, array $params): array
    {
        return [
            'model' => $params['model'] ?? $this->defaultModel,
            'messages' => $messages,
            'temperature' => $params['temperature'] ?? $this->defaultTemperature,
            'max_tokens' => $params['max_tokens'] ?? $this->maxTokens,
            'stream' => $params['stream'] ?? false,
        ];
    }

    protected function generateCacheKey(array $messages, array $params): string
    {
        return 'deepseek_' . md5(json_encode([$messages, $params]));
    }

    protected function makeApiRequest(array $messages, array $params)
    {
        try {
            $response = $this->client->post("{$this->baseUrl}/chat/completions", [
                'headers' => $this->buildHeaders(),
                'json' => $this->buildPayload($messages, $params),
            ]);

            return json_decode($response->getBody(), true);

        } catch (ClientException $e) {
            $this->handleClientError($e);
        }
    }

    protected function handleClientError(ClientException $e): void
    {
        match ($e->getResponse()->getStatusCode()) {
            401 => throw new AuthenticationException('Invalid API key'),
            429 => throw new RateLimitException('API rate limit exceeded'),
            422 => throw new InvalidParameterException(json_decode($e->getResponse()->getBody(), true)['error']),
            default => throw new \RuntimeException("API Error: {$e->getMessage()}"),
        };
    }
}