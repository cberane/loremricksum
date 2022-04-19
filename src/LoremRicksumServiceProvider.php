<?php

namespace Cberane\LoremRicksum;

use Cberane\LoremRicksum\Faker\LoremRicksumFaker;
use Illuminate\Support\ServiceProvider;

class LoremRicksumServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('loremricksum', function () {
            return new LoremRicksumFaker();
        });
    }
}
