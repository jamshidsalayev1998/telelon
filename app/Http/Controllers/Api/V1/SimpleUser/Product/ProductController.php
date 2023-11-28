<?php

namespace App\Http\Controllers\Api\V1\SimpleUser\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpleUser\StoreProductRequest;
use App\Http\Resources\User\UserProductIndexResource;
use App\Models\Product;
use App\Models\ProductImage;
use App\Service\V1\SimpleUser\ProductAttributeService;
use App\Service\V1\SimpleUser\ProductImageService;
use App\Service\V1\SimpleUser\SimpleUserProductService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $resultH = SimpleUserProductService::indexProduct($request);
        $resourceResult = UserProductIndexResource::collection($resultH->items());
        $result['result'] = $resourceResult;
        $result['all_count'] = $resultH->total();
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
//        return $request->all();
        $user = auth()->user();
        $newProduct = SimpleUserProductService::storeProduct($request);
        ProductImageService::storeProductImage($request->images,$newProduct->id,$user->id);
        ProductAttributeService::storeProductAttributes($request->attribute , $newProduct->id);
        return $this->success($newProduct, 'Ma`lumot qo`shildi', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        $product->load(
            'region.translate' ,
            'area.translate' ,
            'category.translate' ,
            'product_status' ,
            'product_attributes.attribute.translate' ,
            'product_attributes.attribute_temporary_value.translate' ,
            'model_product.translate');
        $product->load('images.media_file');
        $resourceResult = new UserProductIndexResource($product);
        $result['result'] = $resourceResult;
        return $this->success($result, 'Success', 200);

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
    public function update(Request $request, $id)
    {
        //
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
