<?php

declare(strict_types=1);

namespace DrinkMachine\Application\Query;

use DrinkMachine\Domain\Entities\Money;
use DrinkMachine\Domain\Entities\Order;

class DrinkMakerQuery
{
    public function __construct(
        private readonly string $drink,
        private readonly int $sugar,
        private readonly bool $extraHot,
        private readonly float $money
    ) {
    }

    public function order(): Order
    {
        return new Order(
            $this->drink,
            $this->sugar,
            $this->extraHot,
            Money::fromFloat($this->money)
        );
    }
}
