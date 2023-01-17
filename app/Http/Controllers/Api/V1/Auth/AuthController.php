<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthNumberCheckRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Resources\UserPermissionsResource;
use App\Models\User;
use App\Service\V1\Auth\GeneratePasswordService;
use App\Service\V1\Auth\SendPasswordToUserService;
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

    public function register(RegisterRequest $registerRequest): \Illuminate\Http\JsonResponse
    {
        $attr = $registerRequest->all();
        $password = GeneratePasswordService::generateUserPassword();
        $user = User::create([
            'name' => $attr['name'],
            'login' => $attr['login'],
        ]);
        SendPasswordToUserService::sendPasswordToUser($password, $registerRequest->login, $user->id);
        $response['result'] = array(
            'created' => true
        );
        return $this->success($response, 'Success');
    }

    public function login(LoginRequest $loginRequest): \Illuminate\Http\JsonResponse
    {

        if (!Auth::attempt($loginRequest->all())) {
            return $this->error('Login yoki parol noto\'g\'ri', 401);
        }
        $user = auth()->user();
        $token = $user->createToken('API Token')->plainTextToken;
        $response['result'] = array(
            'created' => $token
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

    public function check(AuthNumberCheckRequest $authNumberCheckRequest)
    {
        $response['result'] = array(
            'code' => User::where('login', $authNumberCheckRequest->login)->exists() ? 200 : 404
        );
        return $this->success($response, 'Success');
    }
}
