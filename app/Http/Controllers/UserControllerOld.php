<?php

namespace App\Http\Controllers;

use App\Exceptions\ExistUserException;
use App\Models\User;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class UserControllerOld extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register new user
     */
    public function register(Request $request)
    {
        return response()->json($this->userService->createUser($request), 201);
    }
}
