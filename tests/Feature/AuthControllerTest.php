<?php

use App\Models\User;

it('admin user can successful login', function () {
    $password = fake()->password();
    $admin = User::factory()->admin()->create([
        'password' => $password,
    ]);
    $response = $this->post('api/login', [
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

    $response = $this->post('api/login', [
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

    $response = $this->post('api/login', [
        'email' => $user->email,
        'password' => fake()->password(),

    ]);

    $response->assertUnauthorized();
    $this->assertGuest();
});

it('user can successful logout', function () {
    login();

    $this->post('api/logout')->assertOk();
});