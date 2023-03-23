<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;

class SMSNotificationTest extends WebTestCase
{

    private KernelBrowser $client;

    public function setUp() : void
    {
        $this->client = static::createClient([], [
            'HTTP_HOST' => 'localhost:8080'
        ]);

        parent::setUp();
    }

    private function checkJsonRequest(string $method, string $uri, int $code, array $data): void
    {
        $this->client->jsonRequest($method, $uri, $data);
        $response = $this->client->getResponse();
        $this->assertSame($code, $response->getStatusCode());
    }


    public function testNotificationValidation() : void
    {
        $this->checkJsonRequest('POST', '/v1/api/notification/sms', Response::HTTP_BAD_REQUEST, [
            'recipient' => '123123123',
            'messageText' => 'example',
            'userId' => 'test'
        ]);

        $this->checkJsonRequest('POST', '/v1/api/notification/sms', Response::HTTP_BAD_REQUEST, [
            'recipient' => '+48000000000',
            'messageText' => 'example',
            'userId' => ''
        ]);

        $this->checkJsonRequest('POST', '/v1/api/notification/sms', Response::HTTP_BAD_REQUEST, [
            'recipient' => '+48000000000',
            'messageText' => '',
            'userId' => 'test'
        ]);
    }

    public function testNotificationSuccess() : void
    {
        $this->checkJsonRequest('POST', '/v1/api/notification/sms', Response::HTTP_CREATED, [
            'recipient' => '+48000000000',
            'messageText' => 'test',
            'userId' => 'test'
        ]);
    }

    public function testUserThrottle() : void
    {
        $this->checkJsonRequest('POST', '/v1/api/notification/sms', Response::HTTP_TOO_MANY_REQUESTS, [
            'recipient' => '+48000000000',
            'messageText' => 'test',
            'userId' => 'test'
        ]);
    }
}
