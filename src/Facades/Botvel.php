<?php

namespace Thettler\Botvel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Thettler\Botvel\Botvel
 */
class Botvel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Thettler\Botvel\Botvel::class;
    }
}
