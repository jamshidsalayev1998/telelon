<?php

namespace App\Http\Controllers\Api\V1\SimpleUser;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\SimpleUserRegionResource;
use App\Models\Region;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class SimpleUserRegionController extends Controller
{
     use ApiResponser;
    public function index(Request $request)
    {
        $regions = Region::with('translate')->with('areas.translate')->get();
//        return $regions;
        $result['result'] = SimpleUserRegionResource::collection($regions);
        return $this->success($result,'Success');
    }
}
