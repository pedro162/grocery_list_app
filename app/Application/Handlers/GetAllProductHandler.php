<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreateProductCommand;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\ProductId;
use App\Domain\Product\ValueObjects\ProductName;

class GetAllProductHandler
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(CreateProductCommand $command = null): ?array
    {
        return $this->repository->getAll();
    }
}
