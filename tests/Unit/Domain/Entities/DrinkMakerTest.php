<?php

declare(strict_types=1);

namespace DrinkMachine\Tests\Unit\Domain\Entities;

use DrinkMachine\Domain\Entities\Chocolate;
use DrinkMachine\Domain\Entities\DrinkMaker;
use DrinkMachine\Domain\Entities\Money;
use DrinkMachine\Domain\Entities\Order;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DrinkMakerTest extends TestCase
{
    public function testShouldCreateDrinkMakerFromOrder(): void
    {
        $order = new Order(
            'chocolate',
            1,
            true,
            Money::fromFloat(0.5)
        );
        $drinkMaker = DrinkMaker::fromOrder($order);

        $this->assertEquals(
            $order,
            $drinkMaker->order
        );

        $this->assertEquals(
            new Chocolate(),
            $drinkMaker->drink
        );
    }

    /** @dataProvider getErrorInputs */
    public function testShouldThrowExceptionOnWrongValues(string $drink, int $sugar, bool $extraHot, float $price): void
    {
        $this->expectException(InvalidArgumentException::class);
        $order = new Order(
            $drink,
            $sugar,
            $extraHot,
            Money::fromFloat($price)
        );
        DrinkMaker::fromOrder($order);
    }

    public function getErrorInputs(): Generator
    {
        yield 'Wrong drink value' => [
            'foo',
            1,
            false,
            0.1
        ];

        yield 'Wrong sugar value' => [
            'tea',
            -1,
            false,
            0.4
        ];
    }

    /** @dataProvider getWrongPriceValues */
    public function testShouldThrowExceptionCreateDrinkMakerInsufficientMoney(string $drink, float $price): void
    {
        $this->expectException(InvalidArgumentException::class);
        $order = new Order(
            $drink,
            1,
            false,
            Money::fromFloat($price)
        );
        DrinkMaker::fromOrder($order);
    }

    public function getWrongPriceValues(): Generator
    {
        yield 'Chocolate wrong price' => [
            'chocolate',
            0.1
        ];

        yield 'Coffee wrong price' => [
            'coffee',
            0.1
        ];

        yield 'Tea wrong price' => [
            'tea',
            0.1
        ];

        yield 'Orange juice wrong price' => [
            'orange juice',
            0.1
        ];
    }
}