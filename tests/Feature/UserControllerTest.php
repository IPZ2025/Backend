<?php

use App\Models\User;

test('get all user as json', function () {
    User::factory()->count(5)->create();
    $response = $this->get("api/v1/user");
    $response->assertStatus(200)->assertJsonCount(5, "data");;
});

test('get user as json', function () {
    $user = User::factory()->create();
    $response = $this->get("api/v1/user/$user->id");
    $response->assertStatus(200)->assertJson(["id" => $user->id, "name" => $user->name]);
});

test('create user and response json', function () {
    $userData = [
        "name" => "Billy",
        "surname" => "Herrington",
        "password" => "qwertyuiop12345$",
        "phone" => "+380123456789",
        "email" => "qwertyuiop12345$@gmail.com",
    ];
    $response = $this->post("api/v1/user", $userData);
    $response->assertStatus(201)->assertJson([
        "name" => "Billy",
        "surname" => "Herrington",
        "phone" => "+380123456789",
        "email" => "qwertyuiop12345$@gmail.com",
    ]);
});

test('update user and response json', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $userData = [
        "name" => "Billy",
        "surname" => "Herrington",
        "phone" => "+380123456789",
    ];
    $response = $this->patch("api/v1/user/$user->id", $userData);
    $response->assertStatus(200)->assertJson($userData);
});

test('delete user and response json', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->delete("api/v1/user/$user->id");
    $response->assertStatus(200)->assertJson(["id" => $user->id, "name" => $user->name]);
});
