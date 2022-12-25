<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Resources\UserPermissionsResource;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;

    public function username(): string
    {
        return 'login';
    }

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email']
        ]);

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    public function login(LoginRequest $loginRequest): \Illuminate\Http\JsonResponse
    {

        if (!Auth::attempt($loginRequest->all())) {
            return $this->error('Login yoki parol noto\'g\'ri', 401);
        }
        $user = auth()->user();
        $token = $user->createToken('API Token')->plainTextToken;
        $response['response'] = array(
            'token' => $token
        );
        return $this->success($response, 'Success');
    }

    public function me()
    {
        $user = auth()->user();
        $permission = $user->getAllPermissions();
        $response['result'] = array(
            'phone' => $user->login,
            'name' => $user->name,
            'permissions' => UserPermissionsResource::collection($permission)
        );
        return $this->success($response, 'Success');
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->tokens()->delete();
        return $this->success([], 'Success', 200);
    }
}
