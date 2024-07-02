<?php

namespace App\Services\Auth;

use App\Services\Auth\Providers\Blacklist;
use Carbon\Carbon;
use DateTimeImmutable;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\JWT\Validation\ConstraintViolation;

class JWT
{
    public function __construct(private Blacklist $blacklist) {}

    /**
     * @param  array<non-empty-string, non-empty-string>  $claims
     */
    public function encode(array $claims): string
    {
        $key = InMemory::file(config('jwt.keys.private'));

        $token = (new JwtFacade())->issue(
            new Sha256(),
            $key,
            function (Builder $builder, DateTimeImmutable $issuedAt) use ($claims) {
                $builder = $builder->issuedBy(config('app.url'))
                    ->permittedFor(config('app.url'))
                    ->identifiedBy(bin2hex(random_bytes(16)))
                    ->expiresAt($issuedAt->modify('+1 hour'));

                foreach ($claims as $key => $claim) {
                    $builder = $builder->withClaim($key, $claim);
                }

                return $builder;
            });

        return $token->toString();

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
            if ($this->blacklist->has($claims['jti'])) {
                throw new ConstraintViolation('Token has been revoked');
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

        $expiresAt = isset($claims['exp']) ? Carbon::parse($claims['exp']) : null;

        $this->blacklist->add($claims['jti'], $expiresAt);

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
