<?php

namespace App\Traits;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use App\User;
use Laravel\Passport\Passport;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token;

trait PassportTokenTrait
{
    private $parseTokenKey;

    private function parseToken($token)
    {
        $key_path = Passport::keyPath('oauth-public.key');
        $this->parseTokenKey = file_get_contents($key_path);
        $token = (new Parser())->parse((string) $token);
        $signer = new Sha256();

        if ($token->verify($signer, $this->parseTokenKey)) {
            $user_id = $token->getClaim('sub');
            //$user = User::find($user_id);
            return $user_id;
        } else {
            return false;
        }
    }

}
