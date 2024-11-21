<?php

namespace App\Model\Api;
use App\Common\CommonDefinition;
use OpenApi\Attributes\Property;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;
use JsonSerializable;
use OpenApi\Attributes as OA;
#[OA\Schema]
class TripDto implements JsonSerializable
{
    #[Assert\NotBlank]
    #[Property(property:'basePrice', type: 'float', example: 10000)]
    private float $basePrice;
    #[Assert\NotBlank]
    #[Property(property:'birthday', type: 'date', example: '2020-01-01')]
    #[Context([DateTimeNormalizer::FORMAT_KEY => CommonDefinition::API_DATE_FORMAT_FROM_DATETIME])]
    private \DateTimeInterface $birthday;
    #[Assert\NotBlank]
    #[Property(property:'startAt', type: 'date', example: '2024-01-01')]
    #[Context([DateTimeNormalizer::FORMAT_KEY => CommonDefinition::API_DATE_FORMAT_FROM_DATETIME])]
    private \DateTimeInterface $startAt;
    #[Property(property:'payedAt', type: 'date', example: '2024-01-02', nullable: true)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => CommonDefinition::API_DATE_FORMAT_FROM_DATETIME])]
    private \DateTimeInterface|null $payedAt = null;

    /**
     * @return float
     */
    public function getBasePrice(): float
    {
        return $this->basePrice;
    }

    /**
     * @param float $basePrice
     * @return $this
     */
    public function setBasePrice(float $basePrice)
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    /**
     * Get the value of birthday
     *
     * @return \DateTimeInterface Birthday
     */
    public function getBirthday(): \DateTimeInterface
    {
        return $this->birthday;
    }

    /**
     * Set the value of birthday
     *
     * @param \DateTimeInterface $birthday
     *
     * @return $this
     */
    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get the value of startAt
     *
     * @return \DateTimeInterface
     */
    public function getStartAt(): \DateTimeInterface
    {
        return $this->startAt;
    }

    /**
     * Set the value of startAt
     *
     * @param \DateTimeInterface $startAt
     *
     * @return $this
     */
    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get the value of payedAt
     *
     * @return \DateTimeInterface|null
     */
    public function getPayedAt(): \DateTimeInterface|null
    {
        return $this->payedAt;
    }

    /**
     * Set the value of payedAt
     *
     * @param \DateTimeInterface|null $payedAt
     *
     * @return $this
     */
    public function setPayedAt(\DateTimeInterface|null $payedAt): self
    {
        $this->payedAt = $payedAt;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}