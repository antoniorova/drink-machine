<?php

declare(strict_types=1);

namespace DrinkMachine\Domain\Entities;

final class Chocolate implements DrinkInterface
{
    public const NAME = 'chocolate';
    private const PRICE = 0.5;

    public function name(): string
    {
        return self::NAME;
    }

    public function price(): Money
    {
        return Money::fromFloat(self::PRICE);
    }

    public function isSugarAvailable(): bool
    {
        return true;
    }

    public function isHotDrink(): bool
    {
        return true;
    }
}
