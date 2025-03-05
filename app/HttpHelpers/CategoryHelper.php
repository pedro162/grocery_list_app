<?php

namespace App\HttpHelpers;

use App\Application\Commands\CreateCategoryCommand;
use App\Application\Handlers\CreateCategoryHandler;
use App\Application\Handlers\InfoCategoryHandler;
use App\Application\Services\CategoryApplicationService;
use App\Domain\Category\ValueObjects\CategoryId;
use App\Infrastructure\Persistence\EloquentCategoryRepository;
use App\Models\Category as CategoryModel;
use Illuminate\Support\Facades\DB;


class CategoryHelper extends BaseHelper
{

    public function store(array $data)
    {
        $stCod = 201;
        try {
            DB::beginTransaction();

            $objRepo = new EloquentCategoryRepository();
            $objHandler = new CreateCategoryHandler($objRepo);
            $objCategoryHandler = new InfoCategoryHandler($objRepo);
            $objService = new CategoryApplicationService($objHandler, $objCategoryHandler);

            $command = (new CreateCategoryCommand())
                ->categoryId(0)
                ->categoryName($data['name']);
            $domainCategoryObject = $objService->createCategory($command);
            $response = CategoryModel::where('id', '=', (string) $domainCategoryObject->getId());

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
                $response = CategoryModel::orderBy('id', 'DESC')->get();
            } else {
                $response = CategoryModel::orderBy('id', 'DESC')->paginate(10);
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

            $objRepo = new EloquentCategoryRepository();
            $domainCategoryObject = $objRepo->findById(new CategoryId($id));
            $response = CategoryModel::where('id', '=', (string) $domainCategoryObject->getId());

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

            $objRepo = new EloquentCategoryRepository();
            $objHandler = new CreateCategoryHandler($objRepo);
            $objCategoryHandler = new InfoCategoryHandler($objRepo);
            $objService = new CategoryApplicationService($objHandler, $objCategoryHandler);

            $command = (new CreateCategoryCommand())
                ->categoryId(0)
                ->categoryName($data['name']);
            $domainCategoryObject = $objService->createCategory($command);
            $response = CategoryModel::where('id', '=', (string) $domainCategoryObject->getId());

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

            $objRepo = new EloquentCategoryRepository();
            $domainCategoryObject = $objRepo->findById(new CategoryId($id));
            //TODO
            //$response = CategoryModel::where('id', '=', (string) $domainCategoryObject->getId());

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
