<?php

declare(strict_types=1);

namespace DrinkMachine\Application\Handler;

use DrinkMachine\Application\Query\DrinkMakerQuery;
use DrinkMachine\Domain\Entities\DrinkMaker;

class DrinkMakerHandler
{
    public function __invoke(DrinkMakerQuery $query): string
    {
        $drinkMaker = DrinkMaker::fromOrder($query->order());

        return $drinkMaker->getMessage();
    }
}
