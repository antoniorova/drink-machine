<?php

declare(strict_types=1);

namespace DrinkMachine\Tests\Unit\Domain\Entities;

use DrinkMachine\Domain\Entities\DrinkMaker;
use DrinkMachine\Domain\Entities\Money;
use DrinkMachine\Domain\Entities\Order;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DrinkMakerTest extends TestCase
{
    /** @dataProvider getChocolateInputs */
    public function testShouldCreateDrinkMakerFromChocolateOrder(int $sugar, bool $extraHot, string $message): void
    {
        $order = new Order(
            'chocolate',
            $sugar,
            $extraHot,
            Money::fromFloat(0.5)
        );
        $drinkMaker = DrinkMaker::fromOrder($order);

        $this->assertEquals(
            $message,
            $drinkMaker->getMessage()
        );
    }

    public function getChocolateInputs(): Generator
    {
        yield 'Get Chocolate with 1 sugar' => [
            1,
            false,
            'Drink maker makes 1 chocolate with 1 sugar and a stick'
        ];

        yield 'Get Chocolate with 2 sugar' => [
            2,
            false,
            'Drink maker makes 1 chocolate with 2 sugar and a stick'
        ];

        yield 'Get Chocolate with no sugar' => [
            0,
            false,
            'Drink maker makes 1 chocolate with no sugar - and therefore no stick'
        ];

        yield 'Get Chocolate with 1 sugar and extra hot' => [
            1,
            true,
            'Drink maker makes an extra hot chocolate with 1 sugar and a stick'
        ];

        yield 'Get Chocolate with no sugar and extra hot' => [
            0,
            true,
            'Drink maker makes an extra hot chocolate with no sugar - and therefore no stick'
        ];
    }

    /** @dataProvider getCoffeeInputs */
    public function testShouldCreateDrinkMakerFromCoffeeOrder(int $sugar, bool $extraHot, string $message): void
    {
        $order = new Order(
            'coffee',
            $sugar,
            $extraHot,
            Money::fromFloat(0.6)
        );
        $drinkMaker = DrinkMaker::fromOrder($order);

        $this->assertEquals(
            $message,
            $drinkMaker->getMessage()
        );
    }

    public function getCoffeeInputs(): Generator
    {
        yield 'Get Coffee with 1 sugar' => [
            1,
            false,
            'Drink maker makes 1 coffee with 1 sugar and a stick'
        ];

        yield 'Get Coffee with 2 sugar' => [
            2,
            false,
            'Drink maker makes 1 coffee with 2 sugar and a stick'
        ];

        yield 'Get Coffee with no sugar' => [
            0,
            false,
            'Drink maker makes 1 coffee with no sugar - and therefore no stick'
        ];

        yield 'Get Coffee with 1 sugar and extra hot' => [
            1,
            true,
            'Drink maker makes an extra hot coffee with 1 sugar and a stick'
        ];

        yield 'Get Coffee with no sugar and extra hot' => [
            0,
            true,
            'Drink maker makes an extra hot coffee with no sugar - and therefore no stick'
        ];
    }

    /** @dataProvider getTeaInputs */
    public function testShouldCreateDrinkMakerFromTeaOrder(int $sugar, bool $extraHot, string $message): void
    {
        $order = new Order(
            'tea',
            $sugar,
            $extraHot,
            Money::fromFloat(0.4)
        );
        $drinkMaker = DrinkMaker::fromOrder($order);

        $this->assertEquals(
            $message,
            $drinkMaker->getMessage()
        );
    }

    public function getTeaInputs(): Generator
    {
        yield 'Get Tea with 1 sugar' => [
            1,
            false,
            'Drink maker makes 1 tea with 1 sugar and a stick'
        ];

        yield 'Get Tea with 2 sugar' => [
            2,
            false,
            'Drink maker makes 1 tea with 2 sugar and a stick'
        ];

        yield 'Get Tea with no sugar' => [
            0,
            false,
            'Drink maker makes 1 tea with no sugar - and therefore no stick'
        ];

        yield 'Get Tea with 1 sugar and extra hot ' => [
            1,
            true,
            'Drink maker makes an extra hot tea with 1 sugar and a stick'
        ];

        yield 'Get Tea with no sugar and extra hot ' => [
            0,
            true,
            'Drink maker makes an extra hot tea with no sugar - and therefore no stick'
        ];
    }

    public function testShouldCreateDrinkMakerFromOrangeJuiceOrder(): void
    {
        $order = new Order(
            'orange juice',
            0,
            false,
            Money::fromFloat(0.6)
        );
        $drinkMaker = DrinkMaker::fromOrder($order);

        $this->assertEquals(
            'Drink maker makes 1 orange juice',
            $drinkMaker->getMessage()
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