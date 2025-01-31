# Johadtech DeepSeek V3 Package

A robust Laravel package for integrating the DeepSeek V3 API.

## Installation

### Step 1: Install via Composer
Run the following command in your terminal:
```bash
composer require johadtech/deepseek-v3
```

### Step 2: Publish the Configuration File
Once installed, publish the package configuration file using:
```bash
php artisan vendor:publish --provider="Johadtech\DeepSeekV3\Providers\DeepSeekServiceProvider" --tag="deepseek-config"
```

### Step 3: Set Up Your API Key
Open your `.env` file and add the following entry:
```ini
DEEPSEEK_API_KEY=your_api_key_here
```
Replace `your_api_key_here` with your actual DeepSeek API key.

---

## Usage

### Basic Chat Completion
To send a simple chat message to DeepSeek:
```php
use Johadtech\DeepSeekV3\Facades\DeepSeek;

$response = DeepSeek::chat([
    ['role' => 'user', 'content' => 'Hello']
]);

echo $response['content'];
```

### Advanced Chat Completion with Parameters
You can also specify additional parameters for more control:
```php
$response = DeepSeek::chat(
    messages: [
        ['role' => 'user', 'content' => 'Explain quantum computing']
    ],
    params: [
        'model' => 'deepseek-reasoner',
        'temperature' => 0.7,
        'max_tokens' => 1000
    ]
);
```

### Handling Errors
Ensure you catch exceptions when making API calls:
```php
try {
    $response = DeepSeek::chat([['role' => 'user', 'content' => 'Tell me a joke']]);
    echo $response['content'];
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

---

## Testing

To run tests, use:
```bash
composer test
```

Ensure you have PHPUnit installed in your development environment.

---

## Documentation

For full documentation, visit [DeepSeek API Docs](https://api-docs.deepseek.com/).

---

## Contributing

We welcome contributions! To contribute:

1. Fork the repository.
2. Create a new branch (`feature-name`).
3. Commit your changes.
4. Submit a pull request.

---

## License

This package is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
