<?php

namespace Cberane\LoremRicksum\Tests\Unit;

use Cberane\LoremRicksum\Faker\LoremRicksumFaker;
use Cberane\LoremRicksum\Tests\TestCase;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use InvalidArgumentException;

class LoremRicksumTest extends TestCase
{
    private LoremRicksumFaker $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = new LoremRicksumFaker();
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function fetch()
    {
        $result = $this->faker->fetch(1, 1);
        self::assertObjectHasAttribute('data', $result);
        self::assertIsArray($result->data);
        self::assertCount(1, $result->data);

        $result = $this->faker->fetch(4, 1);
        self::assertObjectHasAttribute('data', $result);
        self::assertIsArray($result->data);
        self::assertCount(4, $result->data);
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function invalid_paragraph_count()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->faker->fetch(-1);
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function invalid_quote_count()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->faker->fetch(1,-1);
    }


    /**
     * @test
     * @throws GuzzleException
     */
    public function getPlaintext()
    {
        // check for linebreaks
        $result = $this->faker->getPlaintext(1, 2);
        self::assertFalse(Str::contains($result, "\r\n"));

        $result = $this->faker->getPlaintext(2, 2);
        self::assertTrue(Str::contains($result, "\r\n"));
    }

    /**
     * @test
     * @throws GuzzleException
     */
    public function getHtml()
    {
        // check for expected count of paragraphs
        $result = $this->faker->getHtml(1, 2);
        self::assertMatchesRegularExpression('/^(<p>(.*)<\/p>)$/', $result);

        $result = $this->faker->getHtml(2, 2);
        self::assertMatchesRegularExpression('/^(<p>.*<\/p>){2}$/', $result);

        $result = $this->faker->getHtml(4, 1);
        self::assertMatchesRegularExpression('/^(<p>.*<\/p>){4}$/', $result);
    }


}