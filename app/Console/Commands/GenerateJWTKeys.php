<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SoulDoit\SetEnv\Env;

class GenerateJWTKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jwt:keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate JWT keys.';

    /**
     * Execute the console command.
     */
    public function handle(Env $envService)
    {
        $pair = openssl_pkey_new([
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ]);

        $publicKey = openssl_pkey_get_details($pair)['key'];

        openssl_pkey_export($pair, $privateKey);

        file_put_contents(storage_path('jwt-public.key'), $publicKey);
        file_put_contents(storage_path('jwt-private.key'), $privateKey);

        $envService->set('JWT_PUBLIC_KEY', 'jwt-public.key');
        $envService->set('JWT_PRIVATE_KEY', 'jwt-private.key');

        $this->info('JWT keys generated.');
    }
}
