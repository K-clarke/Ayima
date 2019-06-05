<?php

declare(strict_types=1);

namespace App\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;

class AyimaClient
{
    public const API_URL = 'https://tools.ayima.com/techtest/api/marketintel';

    private $client;

    public function __construct()
    {
        $this->client = $client = new Client();
    }

    public function getScores(): ?string
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];

        try {
            $response = $this->client->request('GET', self::API_URL, $headers);
        } catch (RequestException $exception) { // Guzzle throws Request Exception if status code is 503
            return null;
        }

        if (Response::HTTP_OK == $response->getStatusCode()) {
            $contents = $response->getBody()->getContents();

            return $contents;
        }
    }
}
