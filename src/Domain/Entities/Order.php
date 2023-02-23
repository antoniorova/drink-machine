<?php

declare(strict_types=1);

namespace DrinkMachine\Domain\Entities;

class Order
{
    public function __construct(
        public readonly string $drink,
        public readonly int $sugar,
        public readonly bool $extraHot,
        public readonly Money $money
    ) {
    }

    public function hasSugar(): bool
    {
        return 0 < $this->sugar;
    }

    public function hasExtraHot(): bool
    {
        return $this->extraHot;
    }
}
