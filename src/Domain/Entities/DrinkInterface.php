<?php

declare(strict_types=1);

namespace DrinkMachine\Domain\Entities;

interface DrinkInterface
{
    public function name(): string;
    public function price(): Money;
    public function isSugarAvailable(): bool;
    public function isHotDrink(): bool;
}
