<?php

namespace Ren\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PasswordService
{
    private $validator;

    public function __construct()
    {
        $this->validator = new class {
            private const EMAIL = "required|email";

            public function validateResetPassword(Request $request)
            {
                return $request->validate([
                    "token" => "required",
                    "email" => $this::EMAIL,
                    "password" => ["required", PasswordRule::default()],
                ]);
            }
        };
    }

    /**
     * Send email to user for reset password
     */
    public function sendResetPasswordEmail(Request $request)
    {
        $request->validate(["email" => "required|email"]);
        $status = Password::sendResetLink($request->only("email"));
        if ($status !== Password::ResetLinkSent) {
            throw new BadRequestHttpException($status);
        }
    }

    /**
     * Reset user password
     */
    public function resetUserPassword(Request $request)
    {
        $validated = $this->validator->validateResetPassword($request);
        $status = Password::reset(
            $request->only("email", "password", "token"),
            function (User $user, string $password) {
                $user->password = $password;
                $user->save();
            }
        );
        if ($status !== Password::PasswordReset) {
            throw new BadRequestHttpException($status);
        }
    }
}
