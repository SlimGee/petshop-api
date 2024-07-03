<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Models\Brand;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $brands = Brand::paginate();

        return BrandResource::collection($brands);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request): JsonResource
    {
        $brand = Brand::create($request->validated());

        return new BrandResource($brand);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand): JsonResource
    {
        return new BrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand): JsonResource
    {
        $brand->update($request->validated());

        return new CategoryResource($brand->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand): Response
    {
        $brand->delete();

        return response()->noContent();
    }
}
