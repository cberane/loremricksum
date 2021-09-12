<?php

namespace LoremRicksum;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use LoremRicksum\Faker\LoremRicksumFaker;

class LoremRicksumServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // code...
    }

    public function register()
    {
//        $this->app->singleton('LoremRicksumFaker', function ($app) {
//            return LoremRicksumFaker::getInstance();
//        });
        App::bind('loremricksum', function () {
            return LoremRicksumFaker::getInstance();
        });
    }
}
