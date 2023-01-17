<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthNumberCheckRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResendPasswordRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Resources\UserPermissionsResource;
use App\Models\User;
use App\Models\UserCode;
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
            'password' => bcrypt($password),
        ]);
        $user->assignRole(['simple-user']);
        SendPasswordToUserService::sendPasswordToUser($password, $registerRequest->login, $user->id);
        $response['result'] = array(
            'created' => true
        );
        return $this->success($response, 'Success');
    }

    public function login(UserLoginRequest $userLoginRequest)
    {
        $tmpUser = User::where('login', $userLoginRequest->login)->first();
        $lastCode = UserCode::orderBy('id', 'DESC')->where('user_id', $tmpUser->id)->first();
//        return $lastCode;
        $message = '';
        if ($lastCode) {
            $limited = date('Y-m-d H:i:s', strtotime("+3 minutes", strtotime($lastCode->created_at)));
            if ($lastCode->code == $userLoginRequest->code) {
                if (date('Y-m-d H:i:s') <= $limited) {
                    $attr = $userLoginRequest->all();
                    $newAttr = array(
                        'login' => $attr['login'],
                        'password' => $userLoginRequest->code
                    );
                    if (!Auth::attempt($newAttr)) {
                        return $this->error('Login yoki parol noto\'g\'ri', 401);
                    }
                    $user = auth()->user();
                    $token = $user->createToken('API Token')->plainTextToken;
                    $response['result'] = array(
                        'token' => $token
                    );
                    UserCode::where('user_id', $user->id)->delete();
                    return $this->success($response, 'Success');
                } else {
                    $message = 'Srogi otgan';
                }
            } else {
                $message = 'Code notogri';
            }
        } else {
            $message = 'Code notogri';

        }
        $response['result'] = array(
            'token' => 'Togri kelmadi'
        );
        return $this->error($message, 401);

    }

    public function loginAdmin(LoginRequest $loginRequest): \Illuminate\Http\JsonResponse
    {
        if (!Auth::attempt($loginRequest->all())) {
            return $this->error('Login yoki parol noto\'g\'ri', 401);
        }
        $user = auth()->user();
        $token = $user->createToken('API Token')->plainTextToken;
        $response['result'] = array(
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

    public function check(AuthNumberCheckRequest $authNumberCheckRequest): \Illuminate\Http\JsonResponse
    {
        if (User::where('login', $authNumberCheckRequest->login)->exists()) {
            $finUser = User::where('login', $authNumberCheckRequest->login)->first();
            $password = GeneratePasswordService::generateUserPassword();
            $finUser->password = bcrypt($password);
            SendPasswordToUserService::sendPasswordToUser($password, $finUser->login, $finUser->id);
            $finUser->update();
        }
        $response['result'] = array(
            'code' => User::where('login', $authNumberCheckRequest->login)->exists() ? 200 : 404
        );
        return $this->success($response, 'Success');
    }

    public function resend(ResendPasswordRequest $resendPasswordRequest): \Illuminate\Http\JsonResponse
    {
        $tmpUser = User::where('login', $resendPasswordRequest->login)->first();
        $lastCode = UserCode::orderBy('id', 'DESC')->where('user_id', $tmpUser->id)->first();
        $limited = '';
        if ($lastCode)
        $limited = date('Y-m-d H:i:s', strtotime("+3 minutes", strtotime($lastCode->created_at)));
        if (!$lastCode || date('Y-m-d H:i:s') >= $limited) {
            $password = GeneratePasswordService::generateUserPassword();
            SendPasswordToUserService::sendPasswordToUser($password, $resendPasswordRequest->login, $tmpUser->id);
            $tmpUser->password = bcrypt($password);
            $tmpUser->update();
            return $this->success([
                'result' => [
                    'sent' => true
                ]
            ], 'Code sent');
        } else {
            return $this->error('Srogi otmagan', 422);
        }
    }
}
