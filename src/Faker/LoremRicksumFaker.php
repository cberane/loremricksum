<?php

namespace Cberane\LoremRicksum\Faker;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;

class LoremRicksumFaker
{
    /**
     * the api url to use to fetch lorem ricksum quotes.
     *
     * @var string
     */
    const API_URL = 'http://loremricksum.com/api/';

    /**
     * @var Client|null the client to use for the requests
     */
    private ?Client $apiClient;

    /**
     * @param Client|null $client
     */
    public function __construct(?Client $client = null)
    {
        $this->apiClient = $client ?? new Client();
    }

    /**
     * method to fetch the quotes from the api.
     *
     * @param int $paragraphs
     * @param int $quotes
     *
     * @throws GuzzleException
     *
     * @return mixed Object with attribute 'data'
     */
    public function fetch(int $paragraphs = 1, int $quotes = 3)
    {
        // simple check of the parameters
        if ($paragraphs < 1) {
            throw new InvalidArgumentException('invalid number of paragraphs');
        }
        if ($quotes < 1) {
            throw new InvalidArgumentException('invalid number of quotes');
        }

        // create request url
        $url = self::API_URL."?paragraphs=$paragraphs&quotes=$quotes";

        // fetch quotes from server
        $response = $this->apiClient->get($url);
        assert($response->getStatusCode() === 200);

        // get content
        $body = $response->getBody()->getContents();
        assert($body != null);

        // decode json to object
        $json = json_decode($body);
        assert($json != null);
        assert($json->data != null);

        // return object for further handling
        return $json;
    }

    /**
     * returns the quotes as a simple combined text. uses double linebreak between each paragraph.
     *
     * @param int $paragraphs number of paragraphs to load from api
     * @param int $quotes     number of quotes to load from api
     *
     * @throws GuzzleException
     *
     * @return string plain text of quotes
     */
    public function getPlaintext(int $paragraphs = 1, int $quotes = 3): string
    {
        $result = $this->fetch($paragraphs, $quotes);

        // return combined string
        return implode("\r\n\r\n", $result->data);
    }

    /**
     * returns the quotes as html paragraphs (<p>). each paragraph is inserted in a p-tag.
     *
     * @param int $paragraphs number of paragraphs to load from api
     * @param int $quotes     number of quotes to load from api
     *
     * @throws GuzzleException
     * @throws InvalidArgumentException
     *
     * @return string HTML text of quotes
     */
    public function getHtml(int $paragraphs = 1, int $quotes = 3): string
    {
        $temp = $this->fetch($paragraphs, $quotes);
        $result = '<p>';
        $result .= implode('</p><p>', $temp->data);
        $result .= '</p>';
        // return combined string as paragraphs
        return $result;
    }
}
