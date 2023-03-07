<?php

declare(strict_types=1);

namespace DrinkMachine\Infrastructure\Ui\Console;

use DrinkMachine\Domain\ReadModel\Drink;

class StringTransformer
{
    public static function apply(Drink $drink): string
    {
        $output = sprintf(
            'Drink maker makes %s %s',
            true === $drink->extraHot ? 'an extra hot' : '1',
            $drink->name
        );

        if (false === $drink->isHotDrink) {
            return $output;
        }

        if ($drink->sugar > 0) {
            return sprintf(
                '%s with %d sugar and a stick',
                $output,
                $drink->sugar
            );
        }

        return sprintf(
            '%s with no sugar - and therefore no stick',
            $output
        );
    }
}
