<?php

namespace Cberane\LoremRicksum\Tests\Feature;

use Cberane\LoremRicksum\Faker\LoremRicksumFaker;
use Cberane\LoremRicksum\Tests\TestCase;
use LoremRicksum;

class FacadeTest extends TestCase
{
    /**
     * @test
     */
    public function resolve_facade_through_accessor()
    {
        $facade = app('loremricksum');

        self::assertInstanceOf(LoremRicksumFaker::class, $facade, 'app should resolve the facade correctly');
    }

    /**
     * @test
     */
    public function resolve_facade_through_classname()
    {
        $result = LoremRicksum::getPlaintext(1, 1);

        self::assertIsString($result);
    }
}
