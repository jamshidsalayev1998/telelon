<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\General\AreaResource;
use App\Models\Area;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    use ApiResponser;
    public function index(Request $request)
    {
        $areas = Area::query()->with('translates')->filter($request->filters)->get();
        $result['result'] = AreaResource::collection($areas);
        return $this->success($result,'Success');
    }
}
