<?php

namespace App\Domain\Product\ValueObjects;

class ProductBrandId
{
    private string $value;

    public function __construct(string $value)
    {
        if (((int) $value) < 0) {
            throw new \InvalidArgumentException("Brand ID cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
