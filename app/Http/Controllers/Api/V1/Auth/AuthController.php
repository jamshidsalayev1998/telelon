<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthNumberCheckRequest;
use App\Http\Requests\CheckCodeRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResendPasswordRequest;
use App\Http\Requests\SendSmsCodeRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Resources\UserPermissionsResource;
use App\Models\CaptchaImageKey;
use App\Models\User;
use App\Models\UserCode;
use App\Service\V1\Auth\GeneratePasswordService;
use App\Service\V1\Auth\SendPasswordToUserService;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponser;

    public function username(): string
    {
        return 'login';
    }

    public function register(RegisterRequest $registerRequest): \Illuminate\Http\JsonResponse
    {
        $temp_key = $registerRequest->captcha['temp_key'];
        $captchaImageKey = CaptchaImageKey::where('temp_key', $temp_key)->first();
        if (!$captchaImageKey) {
            return $this->success_with_code(false, [], 'Captcha key topilmadi yoki vaqti tugagan', 600);
        } else {
            $captchaImage = $captchaImageKey->captcha_image;
            if ($captchaImage->code != $registerRequest->captcha['code']) {
                return $this->success_with_code(false, [], 'Captcha key noto`g`ri', 601);
            }
        }
        CaptchaImageKey::where('temp_key', $temp_key)->delete();
        $attr = $registerRequest->all();
//        $password = GeneratePasswordService::generateUserPassword();
        $password = '11111';
        User::where('login' , $attr['login'])->delete();
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
                    if (!$user->register_code_status){
                        $user->register_code_status = 1;
                        $user->update();
                    }
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
        return $this->error($message, 200);

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
        if (User::where('login', $authNumberCheckRequest->login)->where('register_code_status' , 1)->exists()) {
            return $this->success_with_code(true, [], 'Raqam topildi', 602);
        } else {
            return $this->success_with_code(false, [], 'Raqam topilmadi', 603);

        }
    }

    public function resend(ResendPasswordRequest $resendPasswordRequest): \Illuminate\Http\JsonResponse
    {
        $temp_key = $resendPasswordRequest->captcha['temp_key'];
        $captchaImageKey = CaptchaImageKey::where('temp_key', $temp_key)->first();
        if (!$captchaImageKey) {
            return $this->success_with_code(false, [], 'Captcha key topilmadi yoki vaqti tugagan', 600);
        } else {
            $captchaImage = $captchaImageKey->captcha_image;
            if ($captchaImage->code != $resendPasswordRequest->captcha['code']) {
                return $this->success_with_code(false, [], 'Captcha key noto`g`ri', 601);
            }
        }
        CaptchaImageKey::where('temp_key', $temp_key)->delete();
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

    public function send_sms_code(SendSmsCodeRequest $request)
    {
        $temp_key = $request->captcha['temp_key'];
        $captchaImageKey = CaptchaImageKey::where('temp_key', $temp_key)->first();
        if (!$captchaImageKey) {
            return $this->success_with_code(false, [], 'Captcha key topilmadi yoki vaqti tugagan', 600);
        } else {
            $captchaImage = $captchaImageKey->captcha_image;
            if ($captchaImage->code != $request->captcha['code']) {
                return $this->success_with_code(false, [], 'Captcha key noto`g`ri', 601);
            }
        }
        CaptchaImageKey::where('temp_key', $temp_key)->delete();
        $attr = $request->all();
//        $password = GeneratePasswordService::generateUserPassword();
        $password = '11111';
        $user = User::where('login' , $request->login)->first();
        $user->password = Hash::make($password);
        $user->update();
        SendPasswordToUserService::sendPasswordToUser($password, $request->login, $user->id);
        $response['result'] = array(
            'sended' => true
        );
        return $this->success($response, 'Success');
    }
}
