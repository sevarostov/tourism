<?php

namespace App\Controller\Api;

use App\Model\Api\TripDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/price')]
class PriceController extends AbstractController
{
    #[Route('/calculate', name: 'api_price_calculate', methods: [Request::METHOD_POST])]
    public function calculateAction(#[MapRequestPayload] TripDto $tripDto)
    : JsonResponse
    {
        $childDiscount      = $this->childDiscount($tripDto);
        $childDiscountPrice = match ($childDiscount) {
            4500, 0    => $tripDto->getBasePrice() - $childDiscount,
            default => intval($tripDto->getBasePrice()) - intval($tripDto->getBasePrice()) * $childDiscount / 100,
        };

        $reservationDiscount      = $this->reservationDiscount($tripDto, $childDiscountPrice);
        $reservationDiscountPrice = match ($reservationDiscount) {
            1500, 0 => $childDiscountPrice - $reservationDiscount,
            default => intval($tripDto->getBasePrice()) - intval($tripDto->getBasePrice()) * $reservationDiscount / 100,
        };

        return new JsonResponse([
                                    'price'  => $reservationDiscountPrice,
                                    'status' => Response::HTTP_OK,
                                ]);
    }

    /**
     * @param TripDto $tripDto
     * @return int
     */
    public function childDiscount(TripDto $tripDto)
    {
        $age = date_diff($tripDto->getBirthday(), new \DateTimeImmutable())->y;

        return match (true) {
            $age <= 2  => 80,
            $age <= 6  => $tripDto->getBasePrice() * 0.3 < 4500 ? 30 : 4500,
            $age <= 12 => 10,
            default    => 0
        };
    }

    public function reservationDiscount(TripDto $tripDto, $childDiscountPrice)
    {
        $startAt  = ($tripDto->getStartAt() ?? new \DateTimeImmutable());
        $startAt->setTime(0, 0, 0);

        $month    = $tripDto->getPayedAt()?->format('m');
        $thisYear = intval($tripDto->getPayedAt()?->format('y')) === $startAt->format('y') - 1;
        $nextYear = intval($tripDto->getPayedAt()?->format('y')) === intval($startAt->format('y'));

        return match (true) {
            $startAt >= (new \DateTimeImmutable())->setDate(intval($startAt->format('Y')), '04', '01')->setTime(0, 0, 0)
            && $startAt <= (new \DateTimeImmutable())->setDate(intval($startAt->format('Y')), '09', '30')->setTime(0, 0, 0)
            && $month => match (true) {
                $month <= 11 && $thisYear => $childDiscountPrice * 0.07 < 1500 ? 7 : 1500,
                $month == 12 && $thisYear => $childDiscountPrice * 0.05 < 1500 ? 5 : 1500,
                $month == 1 && $nextYear  => $childDiscountPrice * 0.03 < 1500 ? 3 : 1500,
                default                   => 0,
            },
            $startAt >= (new \DateTimeImmutable())->setDate(intval($startAt->format('Y')), '10', '01')->setTime(0, 0, 0)
            && $startAt <= (new \DateTimeImmutable())->setDate(intval($startAt->format('Y')), '01', '14')->setTime(0, 0, 0)
            && $month => match (true) {
                $month <= 3 && $thisYear => $childDiscountPrice * 0.07 < 1500 ? 7 : 1500,
                $month == 4 && $thisYear => $childDiscountPrice * 0.05 < 1500 ? 5 : 1500,
                $month == 5 && $thisYear => $childDiscountPrice * 0.03 < 1500 ? 3 : 1500,
                default                  => 0,
            },
            $startAt >= (new \DateTimeImmutable())->setDate(intval($startAt->format('Y')), '01', '15')->setTime(0, 0, 0)
            && $month => match (true) {
                $month <= 8 && $thisYear  => $childDiscountPrice * 0.07 < 1500 ? 7 : 1500,
                $month == 9 && $thisYear  => $childDiscountPrice * 0.05 < 1500 ? 5 : 1500,
                $month == 10 && $thisYear => $childDiscountPrice * 0.03 < 1500 ? 3 : 1500,
                default                   => 0,
            },
            default   => 0
        };
    }
}