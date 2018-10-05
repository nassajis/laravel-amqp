<?php

namespace Nassaji\Amqp;

use Closure;
use Nassaji\Amqp\Request;
use Nassaji\Amqp\Message;

/**
 * @author Nassaji 
 */
class Amqp
{

    /**
     * @param string $routing
     * @param mixed  $message
     * @param array  $properties
     */
    public function publish($routing, $message, array $properties = [])
    {
        $properties['routing'] = $routing;

        /* @var Publisher $publisher */
        $publisher = app()->make('Nassaji\Amqp\Publisher');
        $publisher
            ->mergeProperties($properties)
            ->setup();

        if (is_string($message)) {
            $message = new Message($message, ['content_type' => 'text/plain', 'delivery_mode' => 2]);
        }

        $publisher->publish($routing, $message);
        Request::shutdown($publisher->getChannel(), $publisher->getConnection());
    }

    /**
     * @param string  $queue
     * @param Closure $callback
     * @param array   $properties
     * @throws Exception\Configuration
     */
    public function consume($queue, Closure $callback, $properties = [])
    {
        $properties['queue'] = $queue;

        /* @var Consumer $consumer */
        $consumer = app()->make('Nassaji\Amqp\Consumer');
        $consumer
            ->mergeProperties($properties)
            ->setup();

        $consumer->consume($queue, $callback);
        Request::shutdown($consumer->getChannel(), $consumer->getConnection());
    }

    /**
     * @param string $body
     * @param array  $properties
     * @return \Nassaji\Amqp\Message
     */
    public function message($body, $properties = [])
    {
        return new Message($body, $properties);
    }
}
