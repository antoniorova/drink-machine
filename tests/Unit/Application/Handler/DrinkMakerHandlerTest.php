<?php

declare(strict_types=1);

namespace DrinkMachine\Tests\Unit\Application\Handler;

use DrinkMachine\Application\Handler\DrinkMakerHandler;
use DrinkMachine\Application\Query\DrinkMakerQuery;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DrinkMakerHandlerTest extends TestCase
{
    /** @dataProvider getInputs */
    public function testShouldReturnDrinkResponseString(string $drink, int $sugar, bool $extraHot, float $price, string $expected): void
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
            'Drink maker makes 1 chocolate with 1 sugar and a stick'
        ];

        yield 'Get Chocolate with 2 sugar' => [
            'chocolate',
            2,
            false,
            0.5,
            'Drink maker makes 1 chocolate with 2 sugar and a stick'
        ];

        yield 'Get Chocolate with no sugar' => [
            'chocolate',
            0,
            false,
            0.5,
            'Drink maker makes 1 chocolate with no sugar - and therefore no stick'
        ];

        yield 'Get Coffee with 1 sugar' => [
            'coffee',
            1,
            false,
            0.6,
            'Drink maker makes 1 coffee with 1 sugar and a stick'
        ];

        yield 'Get Coffee with 2 sugar' => [
            'coffee',
            2,
            false,
            0.6,
            'Drink maker makes 1 coffee with 2 sugar and a stick'
        ];

        yield 'Get Coffee with no sugar' => [
            'coffee',
            0,
            false,
            0.6,
            'Drink maker makes 1 coffee with no sugar - and therefore no stick'
        ];

        yield 'Get Tea with 1 sugar' => [
            'tea',
            1,
            false,
            0.4,
            'Drink maker makes 1 tea with 1 sugar and a stick'
        ];

        yield 'Get Tea with 2 sugar' => [
            'tea',
            2,
            false,
            0.4,
            'Drink maker makes 1 tea with 2 sugar and a stick'
        ];

        yield 'Get Tea with no sugar' => [
            'tea',
            0,
            false,
            0.4,
            'Drink maker makes 1 tea with no sugar - and therefore no stick'
        ];

        yield 'Get Orange Juice' => [
            'orange juice',
            0,
            false,
            0.6,
            'Drink maker makes 1 orange juice'
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