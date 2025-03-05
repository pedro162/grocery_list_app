<?php

namespace App\Application\Commands;

abstract class BaseProductCommand
{
    protected string $productId;
    protected string $productCategoryId;
    protected string $productBrandId;
    protected string $productName;

    public function productId(string $productId): BaseProductCommand
    {
        $this->productId = $productId;
        return $this;
    }

    public function productName(string $productName): BaseProductCommand
    {
        $this->productName = $productName;
        return $this;
    }

    public function productCategoryId(string $productCategoryId): BaseProductCommand
    {
        $this->productCategoryId = $productCategoryId;
        return $this;
    }

    public function productBrandId(string $productBrandId): BaseProductCommand
    {
        $this->productBrandId = $productBrandId;
        return $this;
    }

    public function getProductId(): ?string
    {
        return $this->productId ?? '';
    }

    public function getProductName(): ?string
    {
        return $this->productName ?? '';
    }

    public function getProductBrandId(): ?string
    {
        return $this->productBrandId ?? '';
    }

    public function getProductCategoryId(): ?string
    {
        return $this->productCategoryId ?? '';
    }
}
