<?php

declare(strict_types=1);

namespace DrinkMachine\Domain\Entities;

use Webmozart\Assert\Assert;

class DrinkMaker
{
    private function __construct(
        public readonly Order $order,
        public readonly DrinkInterface $drink
    ) {
    }

    public static function fromOrder(Order $order): self
    {
        $drink = DrinkFactory::create($order->drink);
        $drinkPrice = $drink->price();
        if (true === $order->hasSugar()) {
            Assert::true($drink->isSugarAvailable(), sprintf('Sugar not available for %s', $drink->name()));
        }
        if (true === $order->hasExtraHot()) {
            Assert::true($drink->isHotDrink(), sprintf('Extra hot not available for %s', $drink->name()));
        }
        Assert::greaterThanEq($order->sugar, 0);
        Assert::greaterThanEq(
            $order->money->value,
            $drinkPrice->value,
            sprintf('There are not enough money. %.2f need', $drinkPrice->subtract($order->money)->value)
        );

        return new self($order, $drink);
    }
}
