<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeTemporaryValueRequest;
use App\Http\Requests\UpdateAttributeTemporaryValueRequest;
use App\Http\Resources\Admin\AttributeTemporaryValueResource;
use App\Models\Attribute;
use App\Models\AttributeTemporaryValue;
use App\Service\V1\Admin\AttributeTemporaryValueService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class AttributeTemporaryValueController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAttributeTemporaryValueRequest $request,Attribute $attribute): \Illuminate\Http\JsonResponse
    {
        $result = AttributeTemporaryValueService::storeAttributeTemporaryValues($request->all(),$attribute);
         return $this->success($result, 'Ma`lumot qo`shildi', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAttributeTemporaryValueRequest $request, AttributeTemporaryValue $attributeTemporaryValue)
    {
         $result = AttributeTemporaryValueService::updateAttributeTemporaryValues($request->all(),$attributeTemporaryValue);
         return $this->success(new AttributeTemporaryValueResource($result), 'Ma`lumot o`zgartirildi', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AttributeTemporaryValue $attributeTemporaryValue)
    {
        $result = AttributeTemporaryValueService::deleteAttributeTemporaryValue($attributeTemporaryValue);
        return $this->success(new AttributeTemporaryValueResource($result),'Deleted' , 200);
    }
}
