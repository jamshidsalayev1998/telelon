<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\Admin\BrandResource;
use App\Http\Resources\Admin\CategoryResource;
use App\Models\Brand;
use App\Service\V1\Admin\BrandService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $resultH = BrandService::indexBrands($request);
        $resourceResult = BrandResource::collection($resultH['result']);
        $result['result'] = $resourceResult;
        return $this->success($result, 'Success', 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreBrandRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBrandRequest $request): \Illuminate\Http\JsonResponse
    {
        $result = BrandService::storeBrand($request->all());
        return $this->success($result, 'Ma`lumot qo`shildi', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateBrandRequest $request
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBrandRequest $request, Brand $brand): \Illuminate\Http\JsonResponse
    {
        $result = BrandService::updateBrand($brand, $request->all());
        return $this->success($result, 'Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Brand $brand): \Illuminate\Http\JsonResponse
    {
        $result = BrandService::deleteBrand($brand);
        return $this->success($result, "Ma`lumot o'chirildi");
    }
}
