<?php

declare(strict_types=1);

namespace DrinkMachine\Domain\ReadModel;

class Drink
{
    public function __construct(
        public readonly string $name,
        public readonly int $sugar,
        public readonly bool $isHotDrink,
        public readonly bool $extraHot
    ) {
    }
}
