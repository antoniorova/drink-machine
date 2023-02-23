<?php

declare(strict_types=1);

namespace DrinkMachine\Domain\Entities;

class DrinkFactory
{
    public static function create(string $drinkName): DrinkInterface
    {
        switch ($drinkName) {
            case Chocolate::NAME:
                return new Chocolate();
            case Coffee::NAME:
                return new Coffee();
            case Tea::NAME:
                return new Tea();
            case OrangeJuice::NAME:
                return new OrangeJuice();
        }

        throw new \InvalidArgumentException();
    }
}
