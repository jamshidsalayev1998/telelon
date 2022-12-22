<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
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
            return $this->error('Credentials not match', 401);
        }
        $user = auth()->user();
        $data['user'] = auth()->user();
        $data['token'] = $user->createToken('API Token')->plainTextToken;
        $permissions = $user->getPermissionsViaRoles();
        Arr::except($data['user'],['email' , 'email_verified_at' , 'updated_at' , 'created_at' , 'roles' , 'permissions']);
        $data['user']['permissions'] = $permissions;
        Arr::except($data['user']['permissions'],['guard_name']);
        return $this->success($data,'Success');
    }

    public function logout(): array
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
