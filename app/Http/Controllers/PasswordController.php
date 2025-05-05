<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ren\Http\Services\PasswordService;

class PasswordController extends Controller
{
    private $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    /*
    * TODO Сделать свой Notification для отправки писем, и отправлять чистый токен
    * либо переделать ссылку под фронтенд
    */
    public function forgotPassword(Request $request)
    {
        $this->passwordService->sendResetPasswordEmail($request);
        return response(status: 204);
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request)
    {
        $this->passwordService->resetUserPassword($request);
        return response(status: 204);
    }
}
