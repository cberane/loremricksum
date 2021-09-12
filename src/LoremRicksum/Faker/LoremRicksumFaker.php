<?php

namespace LoremRicksum\Faker;

use GuzzleHttp\Client;
use InvalidArgumentException;

class LoremRicksumFaker
{
    /**
     * the api url to use to fetch lorem ricksum quotes.
     */
    const API_URL = 'http://loremricksum.com/api/';

    /**
     * save singleton instance of LoremRicksumFaker.
     *
     * @var
     */
    private static $instance = null;

    /**
     * @var Client http client of the instance
     */
    private $apiClient;

    /**
     * @return LoremRicksumFaker singleton instance
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new LoremRicksumFaker();
        }

        return self::$instance;
    }

    /**
     * LoremRicksumFaker constructor.
     */
    private function __construct()
    {
        $this->apiClient = new Client();
    }

    /**
     * method to fetch the quotes from the api.
     *
     * @param int $paragraphs
     * @param int $quotes
     *
     * @throws InvalidArgumentException
     *
     * @return mixed Object with attribute 'data'
     */
    private function fetch($paragraphs = 1, $quotes = 3)
    {
        // simple check of the parameters
        if ($paragraphs == null || !is_numeric($paragraphs) || $paragraphs < 1) {
            throw new InvalidArgumentException('invalid number of paragraphs');
        }
        if ($quotes == null || !is_numeric($quotes) || $quotes < 1) {
            throw new InvalidArgumentException('invalid number of quotes');
        }

        // create request url
        $url = self::API_URL.'?paragraphs='.$paragraphs.'&quotes='.$quotes;

        // fetch quotes from server
        $response = $this->apiClient->get($url);
        assert($response != null);
        assert($response->getStatusCode() == 200);

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
     * @throws InvalidArgumentException
     *
     * @return string plain text of quotes
     */
    public function getPlaintext($paragraphs = 1, $quotes = 3)
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
     * @throws InvalidArgumentException
     *
     * @return string HTML text of quotes
     */
    public function getHtml($paragraphs = 1, $quotes = 3)
    {
        $temp = $this->fetch($paragraphs, $quotes);
        $result = '<p>';
        $result .= implode('</p><p>', $temp->data);
        $result .= '</p>';
        // return combined string as paragraphs
        return $result;
    }
}
