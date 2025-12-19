<?php

namespace App\Application\Security;

use Firebase\JWT\JWT;
use Firebase\JWT\KEY;

class JwtService
{
    private string $secret;
    private string $issuer;
    private int $ttl;

    public function __construct()
    {
        $this->secret = $_ENV['JWT_SECRET'];
        $this->issuer = $_ENV['JWT_ISSUER'];
        $this->ttl = (int) $_ENV['JWT_TTL'];
    }

    /**
     * 
     * @param array $payload
     * @return string
     */
    public function generate(array $payload): string
    {
        $now = time();
    
        $token = [
            'iss' => $this->issuer,
            'iat' => $now,
            'exp' => $now + $this->ttl,
            'data' => $payload,
        ];

        return JWT::encode($token, $this->secret, 'HS256');
    }

    /**
     * 
     * @param string $token
     * @return \stdClass
     */
    public function validate(string $token): object
    {
        return JWT::decode($token, new Key($this->secret, 'HS256'));
    }
}
