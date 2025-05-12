<?php

namespace App\Http\Services;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthService
{
    private $authValidator;

    public function __construct()
    {
        $this->authValidator = new class {
            private const EMAIL = "required|email";

            public function validateLoginUser(Request $request)
            {
                return $request->validate([
                    "email" => $this::EMAIL,
                    "password" => "required",
                ]);
            }
        };
    }

    public function loginUser(Request $request)
    {
        $validated = $this->authValidator->validateLoginUser($request);
        $credentials = request()->only(["email", "password"]);
        if (!$token = auth()->attempt($credentials)) {
            throw new AuthenticationException();
        }
        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     */
    public function logout()
    {
        auth()->logout();
    }

    /**
     * Get the authenticated User.
     */
    public function getAuthUser()
    {
        return auth()->user()->toResource();
    }

    /**
     * Refresh a token.
     */
    public function refreshUserToken()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return [
            "access_token" => $token,
            "token_type" => "bearer",
            "expires_in" => auth()->factory()->getTTL(),
        ];
    }
}
