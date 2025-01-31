<?php

namespace Johadtech\DeepSeekV3\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Johadtech\DeepSeekV3\Providers\DeepSeekServiceProvider;

abstract class TestCase extends BaseTestCase
{
    /**
     * Load package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            DeepSeekServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Production
        //$this->app->configure('deepseek');

        // Testing
        $app['config']->set('deepseek', include __DIR__.'/../src/config/deepseek.php');
    }
}
