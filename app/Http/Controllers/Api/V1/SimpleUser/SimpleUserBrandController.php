<?php

namespace App\Http\Controllers\Api\V1\SimpleUser;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BrandResource;
use App\Service\V1\Admin\BrandService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class SimpleUserBrandController extends Controller
{
    use ApiResponser;
    public function index(Request $request)
    {
        $resultH = BrandService::indexBrands($request);
        $resourceResult = BrandResource::collection($resultH->items());
        $resultData['result'] = $resourceResult;
        $resultData['all_count'] = $resultH->total();
        return $this->success($resultData, 'Success', 200);
    }
}
