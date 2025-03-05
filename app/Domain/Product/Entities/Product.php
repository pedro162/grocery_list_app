<?php

namespace App\Domain\Product\Entities;

use App\Domain\Product\ValueObjects\ProductBrandId;
use App\Domain\Product\ValueObjects\ProductCategoryId;
use App\Domain\Product\ValueObjects\ProductId;
use App\Domain\Product\ValueObjects\ProductName;
use App\Models\Product as ModelsProduct;

class Product
{
    protected ProductId $id;
    protected ProductName $name;
    protected ProductCategoryId $categoryId;
    protected ProductBrandId $brandId;

    public function setId(ProductId $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?ProductId
    {
        return $this->id ?? null;
    }

    public function setCategoryId(ProductCategoryId $categoryId): self
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    public function getCategoryId(): ?ProductCategoryId
    {
        return $this->categoryId ?? null;
    }

    public function setBrandId(ProductBrandId $brandId): self
    {
        $this->brandId = $brandId;
        return $this;
    }

    public function getBrandId(): ?ProductBrandId
    {
        return $this->brandId ?? null;
    }

    public function setName(ProductName $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?ProductName
    {
        return $this->name;
    }

    public static function createProduct(array $data): self
    {
        $product = new self();
        $product->setId(new ProductId($data['id'] ?? ''));
        $product->setName(new ProductName($data['name'] ?? ''));
        $product->setCategoryId(new ProductCategoryId($data['category_id'] ?? ''));
        $product->setBrandId(new ProductBrandId($data['brand_id'] ?? ''));
        return $product;
    }

    public function getProductAray(): array
    {
        return [
            'id' => !empty($this->id) ? (string) $this->id : null,
            'name' => !empty($this->name) ? (string) $this->name : null,
            'category_id' => !empty($this->categoryId) ? (string) $this->categoryId : null,
            'brand_id' => !empty($this->brandId) ? (string) $this->brandId : null,
        ];
    }

    public function getProductModel(array $data = []): ModelsProduct
    {
        $data = $this->getProductAray();
        $data = array_filter($data, function ($item) {
            return !is_null($item);
        }, ARRAY_FILTER_USE_BOTH);

        return new ModelsProduct($data);
    }
}
