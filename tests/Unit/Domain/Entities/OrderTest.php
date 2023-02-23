<?php

declare(strict_types=1);

namespace DrinkMachine\Tests\Unit\Domain\Entities;

use DrinkMachine\Domain\Entities\Money;
use DrinkMachine\Domain\Entities\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testShouldCreateOrderCorrectly(): void
    {
        $sut = new Order(
            'chocolate',
            1,
            true,
            Money::fromFloat(0.5)
        );

        $this->assertEquals('chocolate', $sut->drink);
        $this->assertEquals(1, $sut->sugar);
        $this->assertTrue($sut->extraHot);
        $this->assertEquals(Money::fromFloat(0.5), $sut->money);
    }
}