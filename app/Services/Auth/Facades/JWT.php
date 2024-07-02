<?php

namespace App\Services\Auth\Facades;

use App\Services\Auth\JWT as AppJWT;
use Illuminate\Support\Facades\Facade;

class JWT extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AppJWT::class;
    }
}
