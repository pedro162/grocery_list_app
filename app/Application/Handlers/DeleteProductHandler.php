<?php

namespace App\Application\Handlers;

use App\Application\Commands\CreateProductCommand;
use App\Application\Commands\InfoProductCommand;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\ProductDocument;
use App\Domain\Product\ValueObjects\ProductId;
use App\Domain\Product\ValueObjects\ProductName;
use App\Domain\Product\ValueObjects\ProductType;

class DeleteProductHandler
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handler(InfoProductCommand $command): void
    {
        $product = new Product();
        $product->setId(new ProductId($command->getProductId()));

        return $this->repository->delete($product->getId());
    }
}
