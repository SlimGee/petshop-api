<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'success' => 1,
            'data' => [
                'user' => $request->user(),
            ],
        ]);
    }
}
