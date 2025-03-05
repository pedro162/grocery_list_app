<?php

namespace Tests\Feature;

use App\Application\Commands\CreateProductCommand;
use App\Application\Handlers\CreateProductHandler;
use App\Application\Handlers\GetAllProductHandler;
use App\Application\Handlers\InfoProductHandler;
use App\Application\Services\ProductApplicationService;
use App\Domain\Product\Entities\Product;
use App\Infrastructure\Persistence\EloquentProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Domain\Product\ValueObjects\ProductType;
use App\Models\Product as ModelsProduct;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;

class ProductApplicationServiceTest extends TestCase
{
    protected string $url;

    protected ProductApplicationService $productApplicationService;
    //Test Documentatin: https://www.devmedia.com.br/teste-unitario-com-phpunit/41231#assertgreaterthan-
    protected function setUp(): void
    {
        parent::setUp();
        $this->testProductApplicationServiceBootstrap();
    }

    #[DataProvider('createValidProduct')]
    public function testCreateProductService(CreateProductCommand $command)
    {
        $response = $this->productApplicationService->createProduct($command);
        $response = $response['objProduct'] ?? null;
        $idProduct = (string) $response->getId();
        $idProduct = (int) $idProduct;
        $this->assertGreaterThan(0, $idProduct, "It was no possíble to create the product");
        $this->assertInstanceOf(Product::class, $response, "The instance type returned by the Service's createProduct method is not an instance of 'App\Domain\Product\Entities\Product'");
    }

    #[DataProvider('createInvalidProduct')]
    public function testCreateInvalidProduct(CreateProductCommand $product)
    {
        $this->expectException(\InvalidArgumentException::class);
        $response = $this->productApplicationService->createProduct($product);
        $response = $response['objProduct'] ?? null;
        $idProduct = (string) $response->getId();
        $idProduct = (int) $idProduct;
    }

    public static function createInvalidProduct(): array
    {
        $commandInvalidId = new CreateProductCommand(-1, 'Teste');
        $commandInvalidName = new CreateProductCommand(0, '');
        return [
            'ID inválido' => [$commandInvalidId],
            'Nome inválido' => [$commandInvalidName],
        ];
    }

    public static function createValidProduct(): array
    {
        $commandInvalid = new CreateProductCommand(0, 'Test product');
        return [
            'Nome válido' => [$commandInvalid],
        ];
    }

    public function testTryToCreateAndLoadASpecificProduct()
    {
        $command = new CreateProductCommand(0, 'Test product');
        $response = $this->productApplicationService->createProduct($command);
        $response = $response['objProduct'] ?? null;
        $idProduct = (string) $response->getId();
        $idProduct = (int) $idProduct;
        $entityProductObject = $this->productApplicationService->findProductById($idProduct);
        $entityProductObject = $entityProductObject['objProduct'] ?? null;
        $idProductEntityProductObject = (string) $entityProductObject->getId();
        $idProductEntityProductObject = (int) $idProductEntityProductObject;

        $this->assertGreaterThan(0, $idProductEntityProductObject, "It was no possible to load the product of code \"{$idProductEntityProductObject}\"");
    }

    #[DataProvider('createProductApi')]
    public function testCreateProductApi(ModelsProduct $product, $statusCode)
    {
        $response = $this->post($this->url, $product->toArray());
        $response->assertStatus($statusCode);
    }

    public static function createProductApi(): array
    {
        return [
            'Nome inválido' => [ModelsProduct::factory()->make(['name' => '']), 201],
            'Nome válido' => [ModelsProduct::factory()->make(['name' => 'Test product']), 201],
        ];
    }

    private function testProductApplicationServiceBootstrap()
    {
        $objRepo = new EloquentProductRepository();
        $objHendler = new CreateProductHandler($objRepo);
        $objProductHendler = new InfoProductHandler($objRepo);
        $objGetAllProductsHanlder = new GetAllProductHandler($objRepo);
        $objSerice = new ProductApplicationService($objHendler, $objProductHendler, $objGetAllProductsHanlder);

        $this->productApplicationService = $objSerice;
        $this->url = 'products';
    }
}
