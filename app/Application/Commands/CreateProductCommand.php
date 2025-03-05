<?php

namespace App\Application\Commands;

use App\Application\Commands\BaseProductCommand;

class CreateProductCommand extends BaseProductCommand
{
    public function __construct(string $productId = '', string $productName = '')
    {
        $this->productId = $productId;
        $this->productName = $productName;
    }

    public static function fromArray(array $data): CreateProductCommand
    {
        return (new self())
            ->productId($data['id'] ?? '')
            ->productName($data['name'] ?? '')
            ->productBrandId($data['brand_id'] ?? '')
            ->productCategoryId($data['category_id'] ?? '');
    }
}
