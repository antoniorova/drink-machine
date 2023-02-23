<?php

declare(strict_types=1);

namespace DrinkMachine\Domain\Entities;

use Webmozart\Assert\Assert;

class DrinkMaker
{
    private function __construct(
        private readonly Order $order,
        private readonly DrinkInterface $drink
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

    public function getMessage(): string
    {
        $output = sprintf(
            'Drink maker makes %s %s',
            true === $this->order->extraHot ? 'an extra hot' : '1',
            $this->drink->name()
        );

        if (false === $this->drink->isHotDrink()) {
            return $output;
        }

        if ($this->order->sugar > 0) {
            return sprintf(
                '%s with %d sugar and a stick',
                $output,
                $this->order->sugar
            );
        }

        return sprintf(
            '%s with no sugar - and therefore no stick',
            $output
        );
    }
}
