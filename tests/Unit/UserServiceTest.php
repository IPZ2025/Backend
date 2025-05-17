<?php

namespace Tests\Unit;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Mockery\MockInterface;
use Ren\Http\Services\Utils\AuthUtil;

test("create user and returns resource(mock)", function () {
    $userData = [
        "name" => "Billy",
        "surname" => "Herrington",
        "password" => "qwertyuiop12345$",
        "phone" => "+380123456789",
        "email" => "qwertyuiop12345$@gmail.com",
    ];
    $request = $this->mock(StoreUserRequest::class);
    $request->shouldReceive("input")->with(Mockery::anyOf(
        "name",
        "surname",
        "email",
        "password",
        "phone",
        "image_base64",
        "contacts",
        "addresses",
    ))->andReturnUsing(fn($key) => array_key_exists($key, $userData) ? $userData[$key] : null);
    $userService = new UserService($this->mock(AuthUtil::class));
    $result = $userService->createUser($request);
    expect($result)->toBeInstanceOf(UserResource::class);
});

test("create user and returns resource(object)", function () {
    $userData = [
        "name" => "Billy",
        "surname" => "Herrington",
        "password" => "qwertyuiop12345$",
        "phone" => "+380123456789",
        "email" => "qwertyuiop12345$@gmail.com",
    ];
    $request = new StoreUserRequest(request: $userData, server: ["REQUEST_METHOD" => "POST"]);
    $userService = new UserService(new AuthUtil());
    $result = $userService->createUser($request);
    expect($result)->toBeInstanceOf(UserResource::class);
});

test("update user and returns resource(mock)", function () {
    $user = User::factory()->create();
    $userData = [
        "name" => "Billy",
        "surname" => "Herrington",
        "password" => "qwertyuiop12345$",
        "phone" => "+380123456789",
        "email" => "qwertyuiop12345$@gmail.com",
    ];
    $request = $this->mock(UpdateUserRequest::class);
    $request->shouldReceive("input")->with(Mockery::anyOf(
        "name",
        "surname",
        "email",
        "password",
        "phone",
        "image_base64",
        "contacts",
        "addresses",
    ))->andReturnUsing(fn($key) => array_key_exists($key, $userData) ? $userData[$key] : null);
    $request->shouldReceive("whenHas")->with(Mockery::anyOf(
        "name",
        "surname",
        "email",
        "password",
        "phone",
        "image_base64",
        "contacts",
        "addresses",
    ), Mockery::type("Closure"))->andReturnUsing(fn($key, $callable) => array_key_exists($key, $userData) ? $userData[$key] : $callable());
    $auth = $this->mock(AuthUtil::class);
    $auth->shouldReceive("checkUserAffiliation");
    $userService = new UserService($auth);
    $result = $userService->updateUser($request, $user);
    expect($result)->toBeInstanceOf(UserResource::class);
});

test("update user and returns resource(object)", function () {
    $user = User::factory()->create();
    $userData = [
        "name" => "Billy",
        "surname" => "Herrington",
        "password" => "qwertyuiop12345$",
        "phone" => "+380123456789",
        "email" => "qwertyuiop12345$@gmail.com",
    ];
    $request = new UpdateUserRequest(request: $userData, server: ["REQUEST_METHOD" => "POST"]);
    Auth::shouldReceive("user")->andReturn($user);
    $userService = new UserService(new AuthUtil());
    $result = $userService->updateUser($request, $user);
    expect($result)->toBeInstanceOf(UserResource::class);
});

// test("get list user as resource collection(mock)", #[RunInSeparateProcess, PreserveGlobalState(false)] function () {
//     $paginator = $this->mock(LengthAwarePaginator::class, function (MockInterface $mock) {
//         $mock->shouldReceive("toResourceCollection")->andReturn(ResourceCollection::class);
//     });
//     $user = $this->mock("alias:" . User::class);
//     $user->shouldReceive("paginate")->andReturn($paginator);
//     $userService = new UserService($this->mock(AuthUtil::class));
//     $result = $userService->listUserResources();
//     expect($result)->toBeInstanceOf(ResourceCollection::class);
// });

test("get list user as resource collection(object)", function () {
    User::factory()->count(5)->create();
    $userService = new UserService(new AuthUtil());
    $result = $userService->listUserResources();
    expect($result)->toBeInstanceOf(ResourceCollection::class);
});

test("get user as resource(mock)", function () {
    $user = $this->mock(User::class);
    $user->shouldReceive("toResource")->andReturn($this->mock(UserResource::class));
    $userService = new UserService($this->mock(AuthUtil::class));
    $result = $userService->getUserResource($user);
    expect($result)->toBeInstanceOf(UserResource::class);
});

test("get user as resource(object)", function () {
    $user = User::factory()->create();
    $userService = new UserService(new AuthUtil());
    $result = $userService->getUserResource($user);
    expect($result)->toBeInstanceOf(UserResource::class);
});

test("delete user and return resource(mock)", function () {
    $user = $this->mock(User::class);
    $user->shouldReceive("delete");
    $user->shouldReceive("toResource")->andReturn($this->mock(UserResource::class));
    $auth = $this->mock(AuthUtil::class);
    $auth->shouldReceive("checkUserAffiliation");
    $userService = new UserService($auth);
    $result = $userService->deleteUser($user);
    expect($result)->toBeInstanceOf(UserResource::class);
});

test("delete user and return resource(object)", function () {
    $user = User::factory()->create();
    Auth::shouldReceive("user")->andReturn($user);
    $userService = new UserService(new AuthUtil());
    $result = $userService->deleteUser($user);
    expect($result)->toBeInstanceOf(UserResource::class);
});

// class UserServiceTest extends TestCase
// {
//     #[RunInSeparateProcess]
//     public function get_list_user_as_resource_collection_mock()
//     {
//         $paginator = $this->mock(LengthAwarePaginator::class, function (MockInterface $mock) {
//             $mock->shouldReceive("toResourceCollection")->andReturn(ResourceCollection::class);
//         });
//         $user = $this->mock("alias:" . User::class);
//         $user->shouldReceive("paginate")->andReturn($paginator);
//         $userService = new UserService($this->mock(AuthUtil::class));
//         $result = $userService->listUserResources();
//         expect($result)->toBeInstanceOf(ResourceCollection::class);
//     }
// }
