<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect("/", route("l5-swagger.default.api"));

Route::prefix("v1/auth")
    ->middleware(["api", "auth:api"])
    ->controller(AuthController::class)
    ->group(function () {
        Route::post("login", "login")->withoutMiddleware("auth:api")->name("login");
        Route::post("logout", "logout");
        Route::get("refresh", "refresh");
        Route::get("me", "me");
    });

Route::prefix("v1/user/password")
    ->controller(PasswordController::class)
    ->group(function () {
        Route::post("reset-password", "resetPassword")->name("password.reset");
        Route::post("forgot-password", "forgotPassword");
    });

Route::get("v1/user/advertisements", [AdvertisementController::class, "indexAll"])->name("user.advertisements.indexAll");
Route::apiResource("v1/user", UserController::class);
Route::apiResource("v1/user.advertisements", AdvertisementController::class)->scoped();
