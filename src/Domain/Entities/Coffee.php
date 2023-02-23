<?php

declare(strict_types=1);

namespace DrinkMachine\Domain\Entities;

final class Coffee implements DrinkInterface
{
    public const NAME = 'coffee';
    private const PRICE = 0.6;

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
