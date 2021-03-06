<?php

namespace App\Service;

use DateTimeZone;
use Monolog\DateTimeImmutable;



class JWTService
{
    // Generate token for

    /**
     * Generate JWT
     * @param array $base64Header
     * @param array $payload
     * @param string $secret
     * @param int $validity
     * @return string
     */

    public function generate(array $header, array $payload, string $secret, int $validity = 10800): string
    {
        if($validity > 0){
            $now = new DateTimeImmutable(false);// 128 Europe DateTime
            $exp = $now->getTimestamp() + $validity;
    
            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $exp;
    
        }

        //Encode in base64
        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        //"Clear" encode values(delete +, / and =)
        $base64Header = str_replace(['+','/','='], ['-','_', ''], $base64Header);
        $base64Payload = str_replace(['+','/','='], ['-','_', ''], $base64Payload);


        // Encode of "signature"
        $secret = base64_encode($secret);

        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true);

        $base64Signature = base64_encode($signature);

        $base64Signature = str_replace(['+','/','='], ['-','_', ''], $base64Signature);

        // Create Token
        $jwt = $base64Header . '.' . $base64Payload . '.' . $base64Signature;



        return $jwt;
    }

    //Verify if Token is valid
    public function isValid(string $token): bool
    {
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $token

        ) === 1;
    }
        // retrieve Payload
    public function getPayload(string $token): array
    {
        //dismantle the token
        $array = explode('.', $token);

        //decode the payload
        $payload = json_decode(base64_decode($array[1]), true);

        return $payload;
    }

    // retrieve Header
    public function getHeader(string $token): array
    {
        //dismantle the token
        $array = explode('.', $token);

        //decode the header
        $header = json_decode(base64_decode($array[0]), true);

        return $header;
    }

    // Verify if token expired
    
    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);

        $now = new DateTimeImmutable(false);

        return $payload['exp'] < $now->getTimestamp();
    }

    //Verify Token's signature
    public function check(string $token, string $secret)
    {
        //Retrieve header and Payload
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        // Regenerate token
        $verifToken = $this->generate($header, $payload, $secret, 0);

        return $token === $verifToken;
    }
}