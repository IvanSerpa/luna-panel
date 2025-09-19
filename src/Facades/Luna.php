<?php

namespace Luna\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Luna\Luna
 */
class Luna extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Luna\Luna::class;
    }
}
