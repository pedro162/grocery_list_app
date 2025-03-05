<?php

namespace App\Domain\Product\Repositories;

use App\Domain\Product\Entities\Product;
use App\Domain\Product\ValueObjects\ProductId;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAll(array $data = []): ?array;
    public function save(Product $task): ?array;
    public function findById(ProductId $id): ?array;
    public function delete(ProductId $id): void;
}
