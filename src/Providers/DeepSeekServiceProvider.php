<?php 

namespace Johadtech\DeepSeekV3\Providers;

use Illuminate\Support\ServiceProvider;
use Johadtech\DeepSeekV3\Services\DeepSeekClient;
use Johadtech\DeepSeekV3\Contracts\DeepSeekClientInterface;

class DeepSeekServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(DeepSeekClientInterface::class, DeepSeekClient::class);

        $this->mergeConfigFrom(
            __DIR__.'/../config/deepseek.php', 'deepseek'
        );
    }

    public function boot()
    {
        if($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/deepseek.php' => config_path('deepseek.php'),
            ], 'deepseek-config');
        }
    }
}
