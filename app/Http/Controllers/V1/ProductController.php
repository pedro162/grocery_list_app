<?php

namespace App\Http\Controllers\V1;

use App\Domain\Product\Entities\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Product\GetAllProductRequest;
use App\Http\Requests\V1\Product\StoreProductRequest;
use App\Http\Requests\V1\Product\UpdateProductRequest;
use App\Http\Resources\V1\Product\DeleteProductResource;
use App\Http\Resources\V1\Product\GetAllProductResource;
use App\Http\Resources\V1\Product\GetByIdProductResource;
use App\Http\Resources\V1\Product\StoreProductResource;
use App\HttpHelpers\ProductHelper;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductHelper $productHelper) {}
    /**
     * Display a listing of the resource.
     */
    public function index(GetAllProductRequest $request)
    {
        $response = $this->productHelper->index($request->validated());
        $httpResponseCode = $this->productHelper->getHttpResponseCode();
        return response()->json(new GetAllProductResource($response['collection'] ?? []), $httpResponseCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $response = $this->productHelper->store($request->validated());
        $httpResponseCode = $this->productHelper->getHttpResponseCode();
        return response()->json(new StoreProductResource($response['product'] ?? []), $httpResponseCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = $this->productHelper->show($id);
        $httpResponseCode = $this->productHelper->getHttpResponseCode();
        return response()->json(new GetByIdProductResource($response['product'] ?? []), $httpResponseCode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $response = $this->productHelper->update($id, $request->validated());
        $httpResponseCode = $this->productHelper->getHttpResponseCode();
        return response()->json(new GetByIdProductResource($response['product'] ?? []), $httpResponseCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->productHelper->destroy($id);
        $httpResponseCode = $this->productHelper->getHttpResponseCode();
        return response()->json(new DeleteProductResource($response['product'] ?? []), $httpResponseCode);
    }
}
