<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRegistrationService
{
    public function createNewUserFromRequest(RegisterRequest $request)
    {
        $fields = $request->validated();
        $fields['password'] = Hash::make($fields['password']);
        return User::create($fields);
    }

}
