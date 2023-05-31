<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserLogoutService
{

  public function run(Request $request)
  {
    $request->user()->currentAccessToken()->delete();
    return null;
  }
}
