<?php

namespace Nassaji\Amqp;

use Nassaji\Amqp\Consumer;
use Nassaji\Amqp\Publisher;
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
        $this->app->bind('Amqp', 'Nassaji\Amqp\Amqp');
        if (!class_exists('Amqp')) {
            class_alias('Nassaji\Amqp\Facades\Amqp', 'Amqp');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Nassaji\Amqp\Publisher', function ($app) {
            return new Publisher(config());
        });
        $this->app->singleton('Nassaji\Amqp\Consumer', function ($app) {
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
        return ['Amqp', 'Nassaji\Amqp\Publisher', 'Nassaji\Amqp\Consumer'];
    }
}
