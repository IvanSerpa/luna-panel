<?php

namespace LunaPanel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LunaPanel\LunaPanel
 */
class LunaPanel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \LunaPanel\LunaPanel::class;
    }
}
