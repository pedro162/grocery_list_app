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
            $result->updated([
                'name' => $product->getName(),
                //'users_create_id'
                //'users_update_id'   
            ]);
        } else {
            //create
            $result = ModelProduct::create([
                'name' => $product->getName(),
                //'users_create_id'
                //'users_update_id'   
            ]);
            $product->setId(new ProductId($result->id));
        }

        return $this->findById($product->getId());
    }

    public function findById(ProductId $id): ?array
    {
        $product = ModelProduct::with(['images'])->where('id', '=', (string)$id)->first();

        if ($product) {
            $objProduct = new Product();
            $objProduct->setId(new ProductId($product->id));
            $objProduct->setName(new ProductName($product->name));

            return ['objProduct' => $objProduct, 'product' => $product];
        }

        return null;
    }

    public function getAll(array $data = []): ?array
    {
        $products = ModelProduct::with(['images'])->orderBy('id', 'DESC')->paginate(10);
        $arrProducts = [];

        foreach ($products as $product) {
            $objProduct = new Product();
            $objProduct->setId(new ProductId($product->id));
            $objProduct->setName(new ProductName($product->name));
            $arrProducts[] = $objProduct;
        }

        return [
            'arrProducts' => $arrProducts,
            'collection' => $products
        ];
    }

    public function delete(ProductId $id): void
    {
        ModelProduct::with(['images'])->where('id', '=', (string)$id)->delete();
    }
}
