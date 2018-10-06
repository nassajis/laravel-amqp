<?php

namespace Nassajis\Amqp;

use Nassajis\Amqp\Consumer;
use Nassajis\Amqp\Publisher;
use Illuminate\Support\ServiceProvider;

class AmqpServiceProvider extends ServiceProvider
{
    
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('Amqp', 'Nassajis\Amqp\Amqp');
        if (!class_exists('Amqp')) {
            class_alias('Nassajis\Amqp\Facades\Amqp', 'Amqp');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Nassajis\Amqp\Publisher', function ($app) {
            return new Publisher(config());
        });
        $this->app->singleton('Nassajis\Amqp\Consumer', function ($app) {
            return new Consumer(config());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Amqp', 'Nassajis\Amqp\Publisher', 'Nassajis\Amqp\Consumer'];
    }
}
