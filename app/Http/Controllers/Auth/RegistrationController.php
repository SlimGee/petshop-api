<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class RegistrationController extends Controller
{
    public function store(StoreUserRequest $request): UserResource
    {
        $data = $request->validated();

        $user = User::create($data);

        event(new Registered($user));

        return new UserResource($user);
    }
}
