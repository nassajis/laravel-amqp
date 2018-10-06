<?php

namespace Nassajis\Amqp;

use Illuminate\Support\ServiceProvider;

/**
 * Lumen Service Provider
 *
 * @author Nassajis
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
        $this->app->bind('Nassajis\Amqp\Publisher', function ($app) {
            return new Publisher($app->config);
        });

        $this->app->bind('Nassajis\Amqp\Consumer', function ($app) {
            return new Consumer($app->config);
        });

        $this->app->bind('Amqp', 'Nassajis\Amqp\Amqp');

        if (!class_exists('Amqp')) {
            class_alias('Nassajis\Amqp\Facades\Amqp', 'Amqp');
        }
    }
}
