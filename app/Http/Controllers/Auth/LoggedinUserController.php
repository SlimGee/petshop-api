<?php

namespace App\Http\Controllers\Auth;

use App\Events\LoggedIn;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\Facades\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoggedinUserController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        event(new LoggedIn(Auth::user()));

        return response()->json([
            'success' => 1,
            'data' => [
                'token' => Auth::user()->createToken(),
            ],
        ]);
    }

    public function destroy(Request $request): Response
    {
        $token = $request->bearerToken();

        JWT::invalidate($token);

        return response()->noContent();
    }
}
