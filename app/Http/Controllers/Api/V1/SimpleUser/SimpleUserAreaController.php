<?php

namespace App\Http\Controllers\Api\V1\SimpleUser;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\SimpleUserAreaResource;
use App\Models\Area;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class SimpleUserAreaController extends Controller
{
    use ApiResponser;
    public function index(Request $request)
    {
        $areas = Area::query()->with('translate')->filter($request->filters)->get();
        $result['result'] = SimpleUserAreaResource::collection($areas);
        return $this->success($result,'Success');
    }
}
