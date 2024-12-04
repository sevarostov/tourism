<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Hello there');
    }

    public function testCalculate(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/price/calculate',
                                    ['basePrice' => '500001', 'birthday' => '2014-12-11', 'startAt'=>'2027-12-15']);

        $this->assertResponseIsSuccessful();
    }
}
