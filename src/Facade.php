<?php

namespace Cberane\LoremRicksum;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade
{
    protected static function getFacadeAccessor()
    {
        return 'loremricksum';
    }
}
