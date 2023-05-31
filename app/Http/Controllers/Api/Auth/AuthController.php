<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Services\Auth\UserRegisterService;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $user = (new UserRegisterService)->store((object) $request->validated());

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('apiToken')->plainTextToken
        ]);
    }
}
