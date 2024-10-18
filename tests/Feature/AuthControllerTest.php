<?php

use App\Models\User;

it('admin user can successful login', function () {
    $password = fake()->password();
    $admin = User::factory()->admin()->create([
        'password' => $password,
    ]);
    $response = $this->postJson('api/login', [
        'email' => $admin->email,
        'password' => $password,
    ])
    ->assertOk();
    
    $this->isAuthenticated();
});

it('student cannot successful login', function () {
    $password = fake()->password();
    $user = User::factory()->student()->create([
        'password' => $password,
    ]);

    $response = $this->postJson('api/login', [
        'email' => $user->email,
        'password' => $password,
    ]);

    $response->assertUnauthorized();
    $this->assertGuest();
});

it('user cannot login with wrong credetials', function () {
    $password = fake()->password();
    $user = User::factory()->create([
        'password' => $password,
    ]);

    $response = $this->postJson('api/login', [
        'email' => $user->email,
        'password' => fake()->password(),

    ]);

    $response->assertUnauthorized();
    $this->assertGuest();
});

it('user can successful logout', function () {
    $user = login();

    $this->post('api/logout')->assertOk();

    $tokens = $user->tokens->toArray();
    expect($tokens)->toBeEmpty();
});