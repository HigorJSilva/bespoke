<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserLoginService
{

  public function run(object $userCredentials)
  {

    $user = User::where('email', $userCredentials->email)->first();

    if(!$user || !Hash::check($userCredentials->password, $user->password)){
      throw ValidationException::withMessages(['email' => 'Wrong credentials']);
    }

    return $user;
  }
}
