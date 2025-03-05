<?php

namespace App\HttpHelpers;

use App\Application\Commands\CreateProductCommand;
use App\Application\Handlers\CreateProductHandler;
use App\Application\Handlers\InfoProductHandler;
use App\Application\Services\ProductApplicationService;
use App\Domain\Product\ValueObjects\ProductId;
use App\Infrastructure\Persistence\EloquentProductRepository;
use App\Models\Product as ProductModel;
use App\Models\SystemFile as SystemFileModel;
use Illuminate\Support\Facades\DB;
use App\Utils\ImageHandler;


class ProductHelper extends BaseHelper
{
    public function __construct(protected ProductApplicationService $productApplicationService) {}

    public function store(array $data, array $files = [])
    {
        $stCod = 201;
        try {
            DB::beginTransaction();
            $result = $this->productApplicationService->createProduct(CreateProductCommand::fromArray($data));
            DB::commit();
            $this->setHttpResponseData($result ?? []);
            $this->setHttpResponseState(true);
            $stCod = 201;
        } catch (\Exception $th) {
            DB::rollback();

            $msg  = $th->getMessage();
            $this->setHttpResponseData($msg);
            $this->setHttpResponseState(false);
            $stCod = 400;
        } catch (\Error $th) {
            DB::rollback();

            $msg  = $th->getMessage();
            $this->setHttpResponseData($msg);
            $this->setHttpResponseState(false);
            $stCod = 500;
        }
        $this->setHttpResponseCode($stCod);
        return $this->getHttpDataResponseRequest();
    }

    public function index(array $data = [])
    {
        try {
            DB::beginTransaction();
            $result = $this->productApplicationService->getAllProduct();
            $response = $result['collection'];

            if ($response) {
                foreach ($response as $item) {
                    $images = $item->images;
                    if ($images) {
                        foreach ($images as $image) {
                            $image->base64_content = ImageHandler::loadImageBase64Image($image->full_path);
                        }
                    }
                }
            }

            DB::commit();
            $this->setHttpResponseData($response);
            $this->setHttpResponseState(true);
            $stCod = 201;
        } catch (\Exception $th) {
            DB::rollback();

            $msg  = $th->getMessage();
            $this->setHttpResponseData($msg);
            $this->setHttpResponseState(false);
            $stCod = 400;
        } catch (\Error $th) {
            DB::rollback();

            $msg  = $th->getMessage();
            $this->setHttpResponseData($msg);
            $this->setHttpResponseState(false);
            $stCod = 500;
        }
        $this->setHttpResponseCode($stCod);
        return $this->getHttpDataResponseRequest();
    }

    public function show(string $id)
    {
        $response = null;
        $stCod = 200;

        try {
            DB::beginTransaction();
            $response = $this->productApplicationService->findProductById($id);
            DB::commit();

            if (!$response) {
                $stCod = 404;
                $response = [];
            }

            $this->setHttpResponseData($response);
            $this->setHttpResponseState(true);
        } catch (\Exception $th) {
            DB::rollback();

            $msg  = $th->getMessage();
            $this->setHttpResponseData($msg);
            $this->setHttpResponseState(false);
            $stCod = 400;
        } catch (\Error $th) {
            DB::rollback();

            $msg  = $th->getMessage();
            $this->setHttpResponseData($msg);
            $this->setHttpResponseState(false);
            $stCod = 500;
        }

        $this->setHttpResponseCode($stCod);
        return $this->getHttpDataResponseRequest();
    }

    public function update(string $id, array $data, array $files = [])
    {
        $stCod = 204;
        try {

            DB::beginTransaction();
            $data['id'] = $id;
            $command = CreateProductCommand::fromArray($data);
            $result = $this->productApplicationService->createProduct($command);

            $response = $result['product'] ?? null;
            $images = $response?->images;

            if ($images) {
                foreach ($images as $image) {
                    ImageHandler::deleteImage($image->full_path);
                    $image->delete();
                }
            }

            if (isset($data['photos']) && count($data['photos']) > 0) {
                foreach ($data['photos'] as $photo) {
                    if ($pathImage = ImageHandler::saveBase64Image($photo['url'])) {
                        SystemFileModel::create([
                            'full_path' => $pathImage,
                            'reference_id' => (string) $response?->id,
                            'reference' => 'products',
                        ]);
                    }
                }
            }

            DB::commit();
            $this->setHttpResponseData($result);
            $this->setHttpResponseState(true);
        } catch (\Exception $th) {
            DB::rollback();

            $msg  = $th->getMessage() . ' - ' . $th->getFile() . ' - ' . $th->getLine();
            $this->setHttpResponseData($msg);
            $this->setHttpResponseState(false);
            $stCod = 400;
        } catch (\Error $th) {
            DB::rollback();

            $msg  = $th->getMessage();
            $this->setHttpResponseData($msg);
            $this->setHttpResponseState(false);
            $stCod = 500;
        }
        $this->setHttpResponseCode($stCod);
        return $this->getHttpDataResponseRequest();
    }

    public function destroy(string $id)
    {
        $response = null;
        $stCod = 204;

        try {
            DB::beginTransaction();

            $result = $this->productApplicationService->destroy($id);

            DB::commit();
            $msg   = 'Bank transaction removed successfully';
            $this->setHttpResponseData($msg);
            $this->setHttpResponseState(true);
        } catch (\Exception $th) {
            DB::rollback();

            $msg  = $th->getMessage();
            $this->setHttpResponseData($msg);
            $this->setHttpResponseState(false);
            $stCod = 400;
        } catch (\Error $th) {
            DB::rollback();

            $msg  = $th->getMessage();
            $this->setHttpResponseData($msg);
            $this->setHttpResponseState(false);
            $stCod = 500;
        }

        $this->setHttpResponseCode($stCod);
        return $this->getHttpDataResponseRequest();
    }
}
