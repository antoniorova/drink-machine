<?php

declare(strict_types=1);

namespace DrinkMachine\Application\Handler;

use DrinkMachine\Application\Query\DrinkMakerQuery;
use DrinkMachine\Domain\Entities\DrinkMaker;
use DrinkMachine\Domain\ReadModel\Drink;

class DrinkMakerHandler
{
    public function __invoke(DrinkMakerQuery $query): Drink
    {
        $drinkMaker = DrinkMaker::fromOrder($query->order());

        return new Drink(
            $drinkMaker->drink->name(),
            $drinkMaker->order->sugar,
            $drinkMaker->drink->isHotDrink(),
            $drinkMaker->order->extraHot
        );
    }
}
