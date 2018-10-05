<?php

namespace Nassaji\Amqp;

use Illuminate\Support\ServiceProvider;

/**
 * Lumen Service Provider
 *
 * @author Nassaji
 */
class LumenServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Nassaji\Amqp\Publisher', function ($app) {
            return new Publisher($app->config);
        });

        $this->app->bind('Nassaji\Amqp\Consumer', function ($app) {
            return new Consumer($app->config);
        });

        $this->app->bind('Amqp', 'Nassaji\Amqp\Amqp');

        if (!class_exists('Amqp')) {
            class_alias('Nassaji\Amqp\Facades\Amqp', 'Amqp');
        }
    }
}
