<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Services\Auth\UserLoginService;
use App\Http\Services\Auth\UserLogoutService;
use App\Http\Services\Auth\UserRegisterService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $user = (new UserRegisterService)->run((object) $request->validated());

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('apiToken')->plainTextToken
        ]);
    }

    public function login(LoginUserRequest $request)
    {
        $user = (new UserLoginService)->run((object) $request->validated());

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('apiToken')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        (new UserLogoutService)->run($request);

        return response()->noContent();
    }
}
