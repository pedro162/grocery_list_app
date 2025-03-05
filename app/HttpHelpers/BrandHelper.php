<?php

namespace App\HttpHelpers;

use App\Application\Commands\CreateBrandCommand;
use App\Application\Handlers\CreateBrandHandler;
use App\Application\Handlers\InfoBrandHandler;
use App\Application\Services\BrandApplicationService;
use App\Domain\Brand\ValueObjects\BrandId;
use App\Infrastructure\Persistence\EloquentBrandRepository;
use App\Models\Brand as BrandModel;
use Illuminate\Support\Facades\DB;


class BrandHelper extends BaseHelper
{

    public function store(array $data)
    {
        $stCod = 201;
        try {
            DB::beginTransaction();

            $objRepo = new EloquentBrandRepository();
            $objHandler = new CreateBrandHandler($objRepo);
            $objBrandHandler = new InfoBrandHandler($objRepo);
            $objService = new BrandApplicationService($objHandler, $objBrandHandler);

            $command = (new CreateBrandCommand())
                ->brandId(0)
                ->brandName($data['name']);
            $domainBrandObject = $objService->createBrand($command);
            $response = BrandModel::where('id', '=', (string) $domainBrandObject->getId());

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

    public function index(array $data = [])
    {
        try {
            DB::beginTransaction();
            if (!empty($data['no_paginate'])) {
                $response = BrandModel::orderBy('id', 'DESC')->get();
            } else {
                $response = BrandModel::orderBy('id', 'DESC')->paginate(10);
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

            $objRepo = new EloquentBrandRepository();
            $domainBrandObject = $objRepo->findById(new BrandId($id));
            $response = BrandModel::where('id', '=', (string) $domainBrandObject->getId());

            DB::commit();

            if (!$response) {
                $stCod = 404;
                $response = [];
            }

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

    public function update(string $id, array $data)
    {
        $stCod = 201;
        try {
            DB::beginTransaction();

            $objRepo = new EloquentBrandRepository();
            $objHandler = new CreateBrandHandler($objRepo);
            $objBrandHandler = new InfoBrandHandler($objRepo);
            $objService = new BrandApplicationService($objHandler, $objBrandHandler);

            $command = (new CreateBrandCommand())
                ->brandId(0)
                ->brandName($data['name']);
            $domainBrandObject = $objService->createBrand($command);
            $response = BrandModel::where('id', '=', (string) $domainBrandObject->getId());

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

    public function destroy(string $id)
    {
        $response = null;
        $stCod = 200;

        try {
            DB::beginTransaction();

            $objRepo = new EloquentBrandRepository();
            $domainBrandObject = $objRepo->findById(new BrandId($id));
            //TODO
            //$response = BrandModel::where('id', '=', (string) $domainBrandObject->getId());

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
