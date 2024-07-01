<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token\Builder;

class LoggedinUserController extends Controller
{
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $key = InMemory::file(config('jwt.keys.private'));

        $token = (new JwtFacade())->issue(
            new Sha256(),
            $key,
            fn (Builder $builder) => $builder->issuedBy(config('app.url'))
                ->permittedFor(config('app.url'))
                ->issuedAt(new \DateTimeImmutable())
                ->expiresAt(new \DateTimeImmutable('+1 hour'))
                ->withClaim('uuid', Auth::user()->uuid)
        );

        return response()->json([
            'success' => 1,
            'data' => [
                'token' => $token->toString(),
            ],
        ]);
    }
}
