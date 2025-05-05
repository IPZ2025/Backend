<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "auth",
    description: "user authentication"
)]
class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $userService)
    {
        $this->authService = $userService;
    }

    /**
     * Get a JWT via given credentials.
     */
    #[OA\Post(
        path: "/v1/auth/login",
        requestBody: new OA\RequestBody(),
        responses: [
            new OA\Response(
                response: 200,
                description: "return jwt token",
                content: new OA\JsonContent(ref: UserResource::class)
            ),
        ],
        tags: ["auth"],
    )]
    public function login(Request $request)
    {
        return response()->json($this->authService->loginUser($request));
    }

    /**
     * Get the authenticated User.
     */
    public function me()
    {
        return response()->json($this->authService->getAuthUser());
    }

    /**
     * Log the user out (Invalidate the token).
     */
    public function logout()
    {
        $this->authService->logout();
        return response(status: 204);
    }

    /**
     * Refresh a token.
     */
    public function refresh()
    {
        return response()->json($this->authService->refreshUserToken());
    }
}
