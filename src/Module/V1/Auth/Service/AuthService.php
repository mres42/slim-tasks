<?php

namespace App\Module\V1\Auth\Service;

use App\Module\V1\Auth\Repository\AuthRepository;
use App\Application\Security\JwtService;
use App\Exception\AuthException;

class AuthService
{
    public function __construct(
        private AuthRepository $authRepository,
        private JwtService $jwtService
    ) {}

    public function authenticate(array $data): array
    {

        $user = $this->authRepository->getUserByEmail($data["email"]);

        if (!$user->getId()) {
            // return exception
            throw new AuthException("No user with that email was found.");
        };

        // generate auth token
        $token = $this->jwtService->generate([
            'sub' => $user->getId(),
            'email' => $user->getEmail()
        ]);

        return [
            "token_type" => 'Bearer',
            'token' => $token
        ];
    }
}
