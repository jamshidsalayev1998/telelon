<?php

namespace App\Traits;

use Carbon\Carbon;

trait ApiResponser
{
    /**
     * Return a success JSON response.
     *
     * @param array|string $data
     * @param string $message
     * @param int|null $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, string $message = null, int $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'error_code' => null
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param string $message
     * @param int $code
     * @param array|string|null $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(string $message = null, int $code, $data = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
            'error_code' => $code
        ], $code);
    }

}
