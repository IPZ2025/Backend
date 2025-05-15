<?php

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use Ren\Http\Services\Utils\AuthUtil;

test('create user and returns resource', function () {
    // Arrange
    $userData = [
        "name" => "Billy",
        "surname" => "Herrington",
        "password" => "qwertyuiop12345$",
        "phone" => "+380123456789",
        "email" => "sergeysolovyov2016@gmail.com",
    ];

    $request = $this->mock(StoreUserRequest::class);
    $request->shouldReceive('input')->with(Mockery::anyOf(
        "name",
        "surname",
        "email",
        "password",
        "phone",
        "image_url",
        "contacts",
        "addresses",
    ))->andReturnUsing(fn($key) => array_key_exists($key, $userData) ? $userData[$key] : null);

    $userService = new UserService($this->mock(AuthUtil::class));

    // Act
    $result = $userService->createUser($request);

    // Assert
    expect($result)->toBeInstanceOf(UserResource::class);
});
