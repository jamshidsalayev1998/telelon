<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Http\Resources\Admin\AttributeResource;
use App\Service\V1\Admin\AttributeService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

/**
 * @method success($result, string $string, int $int)
 */
class AttributeController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $resultH = AttributeService::indexAttributes($request);
        $resourceResult = AttributeResource::collection($resultH['result']);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttributeRequest $request)
    {
//        return $request->all();
        $result = AttributeService::storeAttribute($request->all());
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributeRequest $request, $attribute)
    {
        $result = AttributeService::updateAttribute($attribute,$request->all());
        return $this->success($result,'Updated' , 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
