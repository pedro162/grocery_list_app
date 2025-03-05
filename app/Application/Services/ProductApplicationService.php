<?php

namespace App\Application\Services;

use App\Application\Commands\CreateProductCommand;
use App\Application\Commands\InfoProductCommand;
use App\Application\Handlers\CreateProductHandler;
use App\Application\Handlers\GetAllProductHandler;
use App\Application\Handlers\InfoProductHandler;
use App\Domain\Product\Entities\Product;

class ProductApplicationService
{
    public function __construct(
        private CreateProductHandler $createProductHandler,
        private InfoProductHandler $infoProductHandler,
        private GetAllProductHandler $getAllProductHandler
    ) {}

    public function setInfoProductHandler(InfoProductHandler $infoProductHandler): void
    {
        $this->infoProductHandler = $infoProductHandler;
    }

    public function createProduct(CreateProductCommand $command): ?array
    {
        return $this->createProductHandler->handler($command);
    }

    public function findProductById(string $productId)
    {
        $command = new InfoProductCommand($productId);
        return $this->infoProductHandler->handler($command);
    }

    public function getAllProduct(array $data = []): ?array
    {
        return $this->getAllProductHandler->handler();
    }

    public function destroy(string $productId)
    {
        $command = new InfoProductCommand($productId);
        return $this->infoProductHandler->handler($command);
    }
}
