<?php

namespace Nelsius\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Nelsius\Managers\CheckoutManager checkout()
 * @method static \Nelsius\Managers\ChargeManager charges()
 *
 * @see \Nelsius\NelsiusClient
 */
class Nelsius extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'nelsius';
    }
}
