<?php

declare(strict_types=1);

namespace DrinkMachine\Domain\Entities;

class Money
{
    public function __construct(
        public readonly float $value
    ) {
    }

    public static function fromFloat(float $value): self
    {
        return new self($value);
    }

    public function subtract(Money $other): self
    {
        $value = $this->value - $other->value;

        return new self($value);
    }
}
