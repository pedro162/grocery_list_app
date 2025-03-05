<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Product\Entities\Product;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\ProductId;
use App\Domain\Product\ValueObjects\ProductName;
use Illuminate\Support\Facades\DB;
use App\Models\Product as ModelProduct;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function save(Product $product): ?array
    {

        //Todo
        //Implement an object model instance and save or update within database, after that, return the object product implementation
        $productId = (string) $product->getId();
        $productId = (int) $productId;

        if ($productId > 0) {
            //update
            $result = ModelProduct::where('id', '=', $productId)->first();
            $result->updated($product->getProductAray());
        } else {

            //create
            $data = $product->getProductModel()->toArray();
            unset($data['id']);
            $result = ModelProduct::create($data);
            $product->setId(new ProductId($result->id));
        }

        return $this->findById($product->getId());
    }

    public function findById(ProductId $id): ?array
    {
        $product = ModelProduct::with(['images'])->where('id', '=', (string)$id)->first();

        if ($product) {
            $objProduct = Product::createProduct($product->toArray());
            return [
                'objProduct' => $objProduct,
                'product' => $product
            ];
        }

        return null;
    }

    public function getAll(array $data = []): ?array
    {
        $products = ModelProduct::with(['images'])->orderBy('id', 'DESC')->paginate(10);
        $arrProducts = [];

        foreach ($products as $product) {
            $arrProducts[] = Product::createProduct($product->toArray());
        }

        return [
            'arrProducts' => $arrProducts,
            'collection' => $products
        ];
    }

    public function delete(ProductId $id): void
    {
        ModelProduct::with(['images'])->where('id', '=', (string)$id)->first()->delete();
    }
}
