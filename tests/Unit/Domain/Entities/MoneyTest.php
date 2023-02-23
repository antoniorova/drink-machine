<?php

declare(strict_types=1);

namespace DrinkMachine\Tests\Unit\Domain\Entities;

use DrinkMachine\Domain\Entities\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testShouldReturnSubtractBetweenTwoMoneys(): void
    {
        $moneyOne = Money::fromFloat(5.0);
        $moneyTwo = Money::fromFloat(4.0);

        $moneySut = $moneyOne->subtract($moneyTwo);

        $this->assertEquals(1.0, $moneySut->value);
    }
}