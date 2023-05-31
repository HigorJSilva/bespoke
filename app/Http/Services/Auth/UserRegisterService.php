<?php

namespace App\Http\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRegisterService
{

  public function store(object $userData)
  {
    $userData->password = Hash::make($userData->password);
    return User::create((array) $userData);
  }
}
