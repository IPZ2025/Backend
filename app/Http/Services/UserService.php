<?php

namespace App\Http\Services;

use App\Exceptions\ExistUserException;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserService
{
    public function listUserResources(){
        return User::paginate()->toResourceCollection();
    }

    public function createUser(StoreUserRequest $request)
    {
        $user = User::firstOrNew(["email" => $request->input("email")]);
        if ($user->exists) {
            throw new ExistUserException("User with email " . $request->input("email") . " already exist");
        } else {
            $user = User::create([
                "name" => $request->input("name"),
                "surname" => $request->input("surname"),
                "email" => $request->input("email"),
                "password" => $request->input("password"),
                "phone" => $request->input("phone"),
                "addresses" => $request->input("addresses"),
            ]);
            return $user->toResource();
        }
    }

    /**
     * Get user as recource
     */
    public function getUserResource(User $user)
    {
        return $user->toResource();
    }

    public function updateUser(UpdateUserRequest $request, User $user)
    {
        if (auth()->user()->id != $user->id) {
            throw new AccessDeniedHttpException("Try to update unauthenticated user");
        }
        $request->whenHas("name", fn() => $user->name = $request->input("name"));
        $request->whenHas("surname", fn() => $user->surname = $request->input("surname"));
        $request->whenHas("password", fn() => $user->password = $request->input("password"));
        $request->whenHas("phone", fn() => $user->phone = $request->input("phone"));
        $request->whenHas("email", fn() => $user->email = $request->input("email"));
        $request->whenHas("address", fn() => $user->address = $request->input("address"));
        $user->save();
        return $user->toResource();
    }

    public function deleteUser(User $user)
    {
        if (auth()->user()->id != $user->id) {
            throw new AccessDeniedHttpException("Try to delete unauthenticated user");
        }
        $user->delete();
        return $user->toResource();
    }
}
