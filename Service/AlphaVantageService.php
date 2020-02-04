<?php

declare(strict_types=1);

namespace cHeeSaW\AlphaVantageBundle\Service;

use cHeeSaW\AlphaVantageBundle\Endpoints\Endpoint;
use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Uri;

class AlphaVantageService implements AlphaVantage
{
    private $client;
    private $alphaVantageApiUrl;
    private $alphaVantageApiKey;

    public function __construct(ClientInterface $client, string $alphaVantageApiUrl, string $alphaVantageApiKey)
    {
        $this->client = $client;
        $this->alphaVantageApiUrl = $alphaVantageApiUrl;
        $this->alphaVantageApiKey = $alphaVantageApiKey;
    }

    public function get(Endpoint $endpoint): string
    {
        $uri = new Uri(
            $this->alphaVantageApiUrl . $endpoint->getQueryString() . '&apikey=' . $this->alphaVantageApiKey
        );

        try {
            $response = $this->client->request('GET', $uri);
            if ($response->getStatusCode() === 200) {
                return $response->getBody()->getContents();
            }
            throw new Exception('Invalid statuscode returned: ' . $response->getStatusCode());
        } catch (GuzzleException $exception) {
            throw new Exception('Invalid request made: ' . $exception->getMessage());
        }
    }
}
