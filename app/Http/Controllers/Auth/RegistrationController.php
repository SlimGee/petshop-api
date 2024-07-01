<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            ...$data,
            'password' => Hash::make($data['password']),
        ]);

        event(new Registered($user));

        return new UserResource($user);
    }
}
