<?php

namespace Tests\Feature;

use App\Application\Handlers\CreateProductHandler;
use App\Application\Handlers\InfoProductHandler;
use App\Application\Services\ProductApplicationService;
use App\Domain\Product\Entities\Product;
use App\Infrastructure\Persistence\EloquentProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Domain\Product\ValueObjects\ProductType;
use InvalidArgumentException;

class ProductApplicationServiceTest extends TestCase
{
    protected ProductApplicationService $productApplicationService;
    //Test Documentatin: https://www.devmedia.com.br/teste-unitario-com-phpunit/41231#assertgreaterthan-
    protected function setUp(): void
    {
        parent::setUp();
        $this->testProductApplicationServiceBootstrap();
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCreateProductService()
    {
        $response = $this->productApplicationService->createProduct(0, 'Test product');
        $idProduct = (string) $response->getId();
        $idProduct = (int) $idProduct;
        $this->assertGreaterThan(0, $idProduct, "It was no possíble to create the product");
    }

    public function testCreateProductWithInvalidNameService()
    {
        $this->expectException(\InvalidArgumentException::class);
        $response = $this->productApplicationService->createProduct(0, '');
        $idProduct = (string) $response->getId();
        $idProduct = (int) $idProduct;
    }

    public function testCreateroductWithInvalidNameService()
    {
        $this->expectException(\InvalidArgumentException::class);
        $response = $this->productApplicationService->createProduct(0, '');
        $idProduct = (string) $response->getId();
        $idProduct = (int) $idProduct;
    }

    public function testCheckTheInstanceTypeReturnedByCreateroductServiceMethod()
    {
        $response = $this->productApplicationService->createProduct(0, 'Test product');
        $this->assertInstanceOf(Product::class, $response, "The instance type returned by the Service's createProduct method is not an instance of 'App\Domain\Product\Entities\Product'");
    }

    public function testTryToCreateAndLoadASpecificProduct()
    {
        $response = $this->productApplicationService->createProduct(0, 'Test product');
        $idProduct = (string) $response->getId();
        $idProduct = (int) $idProduct;
        $entityProductObject = $this->productApplicationService->findProductById($idProduct);
        $idProductEntityProductObject = (string) $entityProductObject->getId();
        $idProductEntityProductObject = (int) $idProductEntityProductObject;

        $this->assertGreaterThan(0, $idProductEntityProductObject, "It was no possible to load the product of code \"{$idProductEntityProductObject}\"");
    }


    private function testProductApplicationServiceBootstrap()
    {
        $objRepo = new EloquentProductRepository();
        $objHendler = new CreateProductHandler($objRepo);
        $objProductHendler = new InfoProductHandler($objRepo);
        $objSerice = new ProductApplicationService($objHendler, $objProductHendler);

        $this->productApplicationService = $objSerice;
    }
}
