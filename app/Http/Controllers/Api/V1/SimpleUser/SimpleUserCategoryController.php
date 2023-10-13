<?php

namespace App\Http\Controllers\Api\V1\SimpleUser;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\User\SimpleUserCategoryResource;
use App\Models\Category;
use App\Service\V1\Admin\CategoryService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class SimpleUserCategoryController extends Controller
{
    use ApiResponser;
     public function index(Request $request)
    {
        $result = CategoryService::indexCategories($request);
        $resourceResult = SimpleUserCategoryResource::collection($result->items());
        $resultData['result'] = $resourceResult;
        $resultData['all_count'] = $result->total();
        return $this->success($resultData,'Success' , 200);
    }
}
