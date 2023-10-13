<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\General\RegionResource;
use App\Models\Region;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    use ApiResponser;
    public function index(Request $request)
    {
        $regions = Region::with('translates')->get();
        $result['result'] = RegionResource::collection($regions);
        return $this->success($result,'Success');
    }
}
