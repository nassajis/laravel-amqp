<?php

namespace Nassaji\Amqp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @author Nassaji
 * @see Nassaji\Amqp\Amqp
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
