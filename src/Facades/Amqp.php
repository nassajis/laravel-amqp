<?php

namespace Nassajis\Amqp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @author Nassajis
 * @see Nassajis\Amqp\Amqp
 */
class Amqp extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Amqp';
    }
}
