<?php

namespace App\Domain\Product\ValueObjects;

class ProductCategoryId
{
    private string $value;

    public function __construct(string $value)
    {
        if (((int) $value) < 0) {
            throw new \InvalidArgumentException("Categori ID cannot be empty");
        }
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
