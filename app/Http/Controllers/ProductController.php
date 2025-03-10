<?php

namespace App\Http\Controllers;

use App\Domain\Product\Entities\Product;
use App\Http\Requests\V1\Product\StoreProductRequest;
use App\HttpHelpers\ProductHelper;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductHelper $productHelper) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->productHelper->index();
        $httpResponseCode = $this->productHelper->getHttpResponseCode();
        return response()->json($response['collection'] ?? [], $httpResponseCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $response = $this->productHelper->store($request->validated());
        $httpResponseCode = $this->productHelper->getHttpResponseCode();
        return response()->json($response['product'], $httpResponseCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = $this->productHelper->show($id);
        $httpResponseCode = $this->productHelper->getHttpResponseCode();
        return response()->json($response['product'] ?? [], $httpResponseCode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = $this->productHelper->update($id, $request->all());
        $httpResponseCode = $this->productHelper->getHttpResponseCode();
        return response()->json($response['product'] ?? [], $httpResponseCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->productHelper->destroy($id);
        $httpResponseCode = $this->productHelper->getHttpResponseCode();
        return response()->json([], $httpResponseCode);
    }
}
