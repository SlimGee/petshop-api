<?php

namespace App\Http\Controllers\Auth;

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

        return response()->json([
            'success' => 1,
            'data' => [
                'token' => JWT::encode(['user_uuid' => Auth::user()->uuid]),
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
