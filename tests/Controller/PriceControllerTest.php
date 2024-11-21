<?php

namespace App\Tests\Controller;

use App\Controller\Api\PriceController;
use App\Model\Api\TripDto;
use PHPUnit\Framework\TestCase;

class PriceControllerTest  extends TestCase
{
    private $data = [
            [14999, "2018-11-11", "2027-01-15", "2026-08-30", 13949.07],
            [15000, "2018-11-11", "2027-01-15", "2026-08-30", 13950],
        ];

    public function testCalculateActionWithTripDto(): void
    {
        $priceController = new PriceController();

        foreach ($this->data as $item) {
            $tripDto = new TripDto();
            $tripDto->setBasePrice($item[0]);
            $tripDto->setBirthday(new \DateTimeImmutable( $item[1]));
            $tripDto->setStartAt(new \DateTimeImmutable( $item[2]));
            $tripDto->setPayedAt(new \DateTimeImmutable( $item[3]));
            $response = $priceController->calculateAction($tripDto);

            $this->assertSame($item[4], json_decode($response->getContent(),true)['price']);
        }

    }
}