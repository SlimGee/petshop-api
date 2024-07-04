<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Auth\Models\Token;
use Carbon\Carbon;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\JWT\Validation\ConstraintViolation;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\JwtFacade;
use DateTimeImmutable;

class JWT
{
    /**
     * issue a token
     *
     * @param  array<string, string>  $options  options for the token including permissions and restrictions
     */
    public function encode(User $user, array $options = []): string
    {
        $key = InMemory::file(config('jwt.keys.private'));

        $claims = $this->makeClaims($user);

        $options = array_merge([
            'token_title' => 'Login token',
            'permissions' => [],
            'restrictions' => [],
        ], $options);

        $token = (new JwtFacade())->issue(
            new Sha256(),
            $key,
            function (Builder $builder, DateTimeImmutable $issuedAt) use ($claims) {
                $builder = $builder
                    ->issuedBy(config('app.url'))
                    ->permittedFor(config('app.url'))
                    ->identifiedBy(bin2hex(random_bytes(16)))
                    ->expiresAt($issuedAt->modify('+1 hour'));

                foreach ($claims as $key => $claim) {
                    $builder = $builder->withClaim($key, $claim);
                }

                return $builder;
            }
        );

        Token::create([
            ...$options,
            'user_id' => $user->id,
            'unique_id' => $token->claims()->get('jti'),
            'expires_at' => Carbon::parse($token->claims()->get('exp')),
        ]);

        return $token->toString();
    }

    /**
     * Make the default claims
     *
     * @return array<string, string>
     */
    public function makeClaims(User $user): array
    {
        return [
            'user_uuid' => $user->uuid,
        ];
    }

    /**
     * Prase the jwt token
     *
     * @param  non-empty-string  $token
     * @return array<non-empty-string, non-empty-string>
     */
    public function decode(string $token, bool $check = true): array
    {
        $key = InMemory::file(config('jwt.keys.public'));

        $token = (new JwtFacade())->parse(
            $token,
            new SignedWith(new Sha256, $key),
            new StrictValidAt(SystemClock::fromSystemTimezone()),
        );

        $claims = $token->claims()->all();

        if ($check) {
            if (!Token::where('unique_id', $claims['jti'])->exists()) {
                throw new ConstraintViolation('Bogus token or token has been revoked');
            }
        }

        return $claims;
    }

    /**
     * @param  non-empty-string  $token
     *
     * Revoke the token
     */
    public function invalidate(string $token): void
    {
        $claims = $this->decode($token);

        Token::where('unique_id', $claims['jti'])->first()->delete();
    }

    /**
     * @param  non-empty-string  $token
     */
    public function validate(string $token): bool
    {
        try {
            $this->decode($token);
        } catch (\Throwable $e) {
            return false;
        }

        return true;
    }

    public function refresh(string $token): string
    {
        // Refresh the jwt token
        return '';
    }
}
