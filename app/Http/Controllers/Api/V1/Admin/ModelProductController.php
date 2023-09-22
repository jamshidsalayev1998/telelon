<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModelProductRequest;
use App\Http\Requests\UpdateModelProductRequest;
use App\Http\Resources\Admin\ModelProductResource;
use App\Http\Resources\Admin\ModelProductShowResource;
use App\Models\ModelProduct;
use App\Service\V1\Admin\ModelProductService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ModelProductController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $result = ModelProductService::indexModelProduct($request);
//        return $result;
        $resourceResult = ModelProductResource::collection($result['result']);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreModelProductRequest $request)
    {
//        return $request->all();
        $result = ModelProductService::storeModelProduct($request->all());
        return $this->success($result, 'Ma`lumot qo`shildi', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ModelProduct $modelProduct)
    {
        $translates = $modelProduct->translates;
        $category = $modelProduct->category;
        $modelProductNew = ModelProduct::with('translates')->with('category.translates')->with('brand.translates')->find($modelProduct->id);
//        return $modelProduct->attributes;
//        return $modelProductNew;
        $result['result'] = new ModelProductResource($modelProductNew);
        return $this->success($result,'Success' , 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateModelProductRequest $request,ModelProduct $modelProduct)
    {
        $result = ModelProductService::updateModelProduct($modelProduct, $request->all());
        return $this->success($result, 'Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ModelProduct $modelProduct): \Illuminate\Http\JsonResponse
    {
        $result = ModelProductService::deleteModelPRoduct($modelProduct);
        return $this->success($result,'Deleted' , 200);
    }
}
