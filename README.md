# nassajis/laravel-amqp
AMQP wrapper for Laravel and Lumen to publish and consume messages especially from RabbitMQ

## Features
  - Advanced queue configuration
  - Add message to queues easily
  - Listen queues with useful options


## Installation

### Composer

Add the following to your require part within the composer.json: 

```js
"nassajis/laravel-amqp": "1.*" (Laravel >= 5.5)
```
```batch
$ php composer update
```

or

```
$ php composer require nassajis/laravel-amqp
```

## Integration

### Lumen

Create a **config** folder in the root directory of your Lumen application and copy the content
from **vendor/nassajis/laravel-amqp/config/amqp.php** to **config/amqp.php**.

Adjust the properties to your needs.

```php
return [

    'use' => 'production',

    'properties' => [

        'production' => [
            'host'                => 'localhost',
            'port'                => 5672,
            'username'            => 'username',
            'password'            => 'password',
            'vhost'               => '/',
            'exchange'            => 'amq.topic',
            'exchange_type'       => 'topic',
            'consumer_tag'        => 'consumer',
            'ssl_options'         => [], // See https://secure.php.net/manual/en/context.ssl.php
            'connect_options'     => [], // See https://github.com/php-amqplib/php-amqplib/blob/master/PhpAmqpLib/Connection/AMQPSSLConnection.php
            'queue_properties'    => ['x-ha-policy' => ['S', 'all']],
            'exchange_properties' => [],
            'timeout'             => 0
        ],

    ],

];
```

Register the Lumen Service Provider in **bootstrap/app.php**:

```php
/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
*/

//...

$app->configure('amqp');
$app->register(Nassajis\Amqp\LumenServiceProvider::class);

//...
```

Add Facade Support for Lumen 5.2+

```php
//...
$app->withFacades();
class_alias(\Illuminate\Support\Facades\App::class, 'App');
//...
```


### Laravel

Open **config/app.php** and add the service provider and alias:

```php
'Nassajis\Amqp\AmqpServiceProvider',
```

```php
'Amqp' => 'Nassajis\Amqp\Facades\Amqp',
```


## Publishing a message

### Push message with routing key

```php
    Amqp::publish('routing-key', 'message');
```

### Push message with routing key and create queue

```php	
    Amqp::publish('routing-key', 'message' , ['queue' => 'queue-name']);
```

### Push message with routing key and overwrite properties

```php	
    Amqp::publish('routing-key', 'message' , ['exchange' => 'amq.direct']);
```


## Consuming messages

### Consume messages, acknowledge and stop when no message is left

```php
Amqp::consume('queue-name', function ($message, $resolver) {
    		
   var_dump($message->body);

   $resolver->acknowledge($message);

   $resolver->stopWhenProcessed();
        
});
```

### Consume messages forever

```php
Amqp::consume('queue-name', function ($message, $resolver) {
    		
   var_dump($message->body);

   $resolver->acknowledge($message);
        
});
```

### Consume messages, with custom settings

```php
Amqp::consume('queue-name', function ($message, $resolver) {
    		
   var_dump($message->body);

   $resolver->acknowledge($message);
      
}, [
	'timeout' => 2,
	'vhost'   => 'vhost3'
]);
```

## Fanout example

### Publishing a message

```php
\Amqp::publish('', 'message' , [
    'exchange_type' => 'fanout',
    'exchange' => 'amq.fanout',
]);
```

### Consuming messages

```php
\Amqp::consume('', function ($message, $resolver) {
    var_dump($message->body);
    $resolver->acknowledge($message);
}, [
    'exchange' => 'amq.fanout',
    'exchange_type' => 'fanout',
    'queue_force_declare' => true,
    'queue_exclusive' => true,
    'persistent' => true// required if you want to listen forever
]);
```


### Consuming messages with Config QoS

```php
Amqp::consume('queue-name', function ($message, $resolver) {
    		
   var_dump($message->body);

   $resolver->acknowledge($message);
      
}, [] , [
    null,
    1 ,
    null
]);
```


## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Thanks From code@bjoern.io

