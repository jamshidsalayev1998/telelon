<?php

namespace App\Http\Controllers\Api\V1\SimpleUser;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ModelProductResource;
use App\Http\Resources\User\SimpleUserModelProductResource;
use App\Models\ModelProduct;
use App\Service\V1\Admin\ModelProductService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class SimpleUserModelProductController extends Controller
{
    use ApiResponser;
    public function index(Request $request)
    {
        $result = ModelProductService::indexModelProduct($request);
        $resourceResult = SimpleUserModelProductResource::collection($result->items());
        $resultData['result'] = $resourceResult;
        $resultData['all_count'] = $result->total();
        return $this->success($resultData, 'Success', 200);
    }

    public function show(ModelProduct $modelProduct)
    {
        $modelProductNew = ModelProduct::with('translate')->with('attributes.translate')->with('category.translates')->with('brand.translates')->find($modelProduct->id);
        $result['result'] = new SimpleUserModelProductResource($modelProductNew);
        return $this->success($result,'Success' , 200);
    }
}

