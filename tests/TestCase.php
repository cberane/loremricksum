<?php

namespace Cberane\LoremRicksum\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public $loadEnvironmentVariables = true;

    protected function getPackageProviders($app)
    {
        return [
            'Cberane\LoremRicksum\LoremRicksumServiceProvider',
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LoremRicksum' => 'Cberane\LoremRicksum\Facade',
        ];
    }
}
