<?php

namespace App\Tests;

use App\Model\Api\TripDto;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class IndexControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Hello there');
    }

    /**
     * @covers \App\Controller\Api\PriceController::calculateAction
     */
    public function testCalculate(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/price/calculate',
                                    ['basePrice' => '500001', 'birthday' => '2014-12-11', 'startAt'=>'2027-12-15']);

        $response = $client->getResponse();
        $this->assertSame(495501, json_decode($response->getContent(),true)['price']);
        $this->assertResponseIsSuccessful();

    }
}
