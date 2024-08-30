<?php

namespace App\Tests\Context;

use Behat\Gherkin\Node\PyStringNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Mink\Driver\GoutteDriver;

class ClientContext extends MinkContext
{
    private const BASE_URL = 'http://localhost:8000';

    private function getDriver(): GoutteDriver
    {
        $driver = $this->getSession()->getDriver();
        if (!$driver instanceof GoutteDriver) {
            throw new \Exception('Unsupported driver. Only GoutteDriver is supported.');
        }

        return $driver;
    }

    /**
     * @When I send a :method request to :url with body:
     * @When I send a :method request to :url
     * @throws \Exception
     */
    public function iSendARequestTo($method, $url, PyStringNode $body = null): void
    {
        $driver = $this->getDriver();
        $client = $driver->getClient();
        $content = $body?->getRaw();
        $fullUrl = self::BASE_URL . $url;
        $client->request($method, $fullUrl, [], [], ['CONTENT_TYPE' => 'application/json'], $content);

        $statusCode = $client->getResponse()->getStatusCode();
        if ($statusCode >= 400) {
            throw new \Exception('Request failed with status code ' . $statusCode);
        }
    }
}