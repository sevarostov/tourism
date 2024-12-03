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
            [15000, "2013-11-11", "2027-01-15", "2026-08-30", 13950],
            [15000, "2013-12-11", "2027-05-15", "", 13500],
            [3000, "2013-12-11", "2027-05-15", "", 2700],
            [5000, "2013-12-11", "2027-05-15", "", 4500],
            [5000, "2012-11-11", "2027-05-15", "", 4500],
            [50000, "2014-12-11", "2027-05-15", "", 45500],
            [15000, "2011-11-11", "2027-01-15", "2027-01-02", 15000],
            [15000, "2011-11-11", "2027-12-15", "2027-12-02", 15000],
            [15000, "2011-11-11", "2027-05-15", "2027-01-02", 14550],
            [15000, "2011-11-11", "2026-05-15", "2025-08-02", 13950],
            [15000, "2022-12-11", "2027-05-15", "2026-11-02", 13950],
            [15000, "2011-11-11", "2027-05-15", "2026-12-02", 14250],
            [15000, "2022-12-11", "2027-05-15", "2026-12-02", 14250],
            [15000, "2022-12-11", "2027-05-15", "2027-01-02", 14550],
            [10000, "2023-12-11", "2027-05-15", "2026-01-02", 9300],
            [10000, "2023-12-11", "2027-05-15", '', 5500],
            [5000, "2023-12-11", "2027-05-15", '', 1000],
            [50000, "2014-12-11", "2027-05-15", '2026-05-15', 44000],
            [50000, "2014-12-11", "2027-05-15", '2026-12-15', 44000],
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