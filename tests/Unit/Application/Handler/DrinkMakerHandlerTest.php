<?php

declare(strict_types=1);

namespace DrinkMachine\Tests\Unit\Application\Handler;

use DrinkMachine\Application\Handler\DrinkMakerHandler;
use DrinkMachine\Application\Query\DrinkMakerQuery;
use DrinkMachine\Domain\ReadModel\Drink;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DrinkMakerHandlerTest extends TestCase
{
    /** @dataProvider getInputs */
    public function testShouldReturnDrinkResponseString(string $drink, int $sugar, bool $extraHot, float $price, Drink $expected): void
    {
        $sut = new DrinkMakerHandler();

        $this->assertEquals(
            $expected,
            $sut->__invoke(new DrinkMakerQuery($drink, $sugar, $extraHot, $price))
        );
    }

    public function getInputs(): Generator
    {
        yield 'Get Chocolate with 1 sugar' => [
            'chocolate',
            1,
            false,
            0.5,
            new Drink(
                'chocolate',
                1,
                true,
                false
            )
        ];

        yield 'Get Chocolate with 2 sugar' => [
            'chocolate',
            2,
            false,
            0.5,
            new Drink(
                'chocolate',
                2,
                true,
                false
            )
        ];

        yield 'Get Chocolate with no sugar' => [
            'chocolate',
            0,
            false,
            0.5,
            new Drink(
                'chocolate',
                0,
                true,
                false
            )
        ];

        yield 'Get Chocolate with no sugar extra hot' => [
            'chocolate',
            0,
            true,
            0.5,
            new Drink(
                'chocolate',
                0,
                true,
                true
            )
        ];

        yield 'Get Chocolate with 1 sugar extra hot' => [
            'chocolate',
            1,
            true,
            0.5,
            new Drink(
                'chocolate',
                1,
                true,
                true
            )
        ];

        yield 'Get Coffee with 1 sugar' => [
            'coffee',
            1,
            false,
            0.6,
            new Drink(
                'coffee',
                1,
                true,
                false
            )
        ];

        yield 'Get Coffee with 2 sugar' => [
            'coffee',
            2,
            false,
            0.6,
            new Drink(
                'coffee',
                2,
                true,
                false
            )
        ];

        yield 'Get Coffee with no sugar' => [
            'coffee',
            0,
            false,
            0.6,
            new Drink(
                'coffee',
                0,
                true,
                false
            )
        ];

        yield 'Get Coffee with no sugar extra hot' => [
            'coffee',
            0,
            true,
            0.6,
            new Drink(
                'coffee',
                0,
                true,
                true
            )
        ];

        yield 'Get Coffee with 1 sugar extra hot' => [
            'coffee',
            1,
            true,
            0.6,
            new Drink(
                'coffee',
                1,
                true,
                true
            )
        ];

        yield 'Get Tea with 1 sugar' => [
            'tea',
            1,
            false,
            0.4,
            new Drink(
                'tea',
                1,
                true,
                false
            )
        ];

        yield 'Get Tea with 2 sugar' => [
            'tea',
            2,
            false,
            0.4,
            new Drink(
                'tea',
                2,
                true,
                false
            )
        ];

        yield 'Get Tea with no sugar' => [
            'tea',
            0,
            false,
            0.4,
            new Drink(
                'tea',
                0,
                true,
                false
            )
        ];

        yield 'Get Tea without sugar and extra hot' => [
            'tea',
            0,
            true,
            0.4,
            new Drink(
                'tea',
                0,
                true,
                true
            )
        ];

        yield 'Get Tea with 1 sugar and extra hot' => [
            'tea',
            1,
            true,
            0.4,
            new Drink(
                'tea',
                1,
                true,
                true
            )
        ];

        yield 'Get Orange Juice' => [
            'orange juice',
            0,
            false,
            0.6,
            new Drink(
                'orange juice',
                0,
                false,
                false
            )
        ];
    }

    /** @dataProvider getErrorInputs */
    public function testShouldThrowExceptionOnWrongValues(string $drink, int $sugar, bool $extraHot, float $price): void
    {
        $this->expectException(InvalidArgumentException::class);
        $sut = new DrinkMakerHandler();

        $sut->__invoke(new DrinkMakerQuery($drink, $sugar, $extraHot, $price));
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
}