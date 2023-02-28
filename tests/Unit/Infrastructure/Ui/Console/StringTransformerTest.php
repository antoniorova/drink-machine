<?php

declare(strict_types=1);

namespace DrinkMachine\Tests\Unit\Infrastructure\Ui\Console;

use DrinkMachine\Domain\ReadModel\Drink;
use DrinkMachine\Infrastructure\Ui\Console\StringTransformer;
use Generator;
use PHPUnit\Framework\TestCase;

class StringTransformerTest extends TestCase
{
    /** @dataProvider getValues */
    public function testShouldReturnExpectedString(Drink $sut, $expected): void
    {
        $this->assertEquals(
            $expected,
            StringTransformer::apply($sut)
        );
    }

    public function getValues(): Generator
    {
        yield 'Hot drink with 1 sugar' => [
            new Drink(
                'foo',
                1,
                true,
                false
            ),
            'Drink maker makes 1 foo with 1 sugar and a stick'
        ];

        yield 'Hot drink with 1 sugar and extra hot' => [
            new Drink(
                'foo',
                1,
                true,
                true
            ),
            'Drink maker makes an extra hot foo with 1 sugar and a stick'
        ];

        yield 'Hot drink without sugar and extra hot' => [
            new Drink(
                'foo',
                0,
                true,
                true
            ),
            'Drink maker makes an extra hot foo with no sugar - and therefore no stick'
        ];

        yield 'Not Hot Drink' => [
            new Drink(
                'boo',
                0,
                false,
                false
            ),
            'Drink maker makes 1 boo'
        ];
    }
}
