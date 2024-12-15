<?php

namespace App\Tests\Model\Api;

use App\Model\Api\TripDto;
use PHPUnit\Framework\TestCase;

class TripDtoTest extends TestCase
{
    private $data = [
        [14999, "2018-11-11", "2027-01-15", "2026-08-30", 10499.3],
        [500000, "2014-12-11", "2027-01-10", '', 495500],
    ];

    public function testSettersAndGetters(): void
    {
        $tripDto = new TripDto();

        foreach ($this->data as $item) {
            $tripDto = new TripDto();
            $tripDto->setBasePrice($item[0]);
            $tripDto->setBirthday(new \DateTimeImmutable($item[1]));
            $tripDto->setStartAt(new \DateTimeImmutable($item[2]));
            $tripDto->setPayedAt(new \DateTimeImmutable($item[3] ?? ''));

            $this->assertSame(intval($item[0]), intval($tripDto->getBasePrice()));
            $this->assertSame((new \DateTimeImmutable($item[1]))
                                  ->format('Y-m-d H:i:s'), $tripDto->getBirthday()
                                                                   ->format('Y-m-d H:i:s'));
            $this->assertSame((new \DateTimeImmutable($item[2]))
                                  ->format('Y-m-d H:i:s'), $tripDto->getStartAt()
                                                                   ->format('Y-m-d H:i:s'));
            $this->assertSame(($item[3] ? new \DateTimeImmutable($item[3]) : new \DateTimeImmutable())
                                  ->format('Y-m-d H:i:s'), $tripDto->getPayedAt()
                                                                   ->format('Y-m-d H:i:s'));

            $this->assertSame(is_array([]), is_array($tripDto->jsonSerialize()));
        }

    }

}