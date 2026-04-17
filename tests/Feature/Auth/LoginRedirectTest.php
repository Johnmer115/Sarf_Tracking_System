<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin users are redirected to the admin dashboard after login', function () {
    $admin = User::factory()->create([
        'name' => 'admin.account',
        'email' => 'admin@example.com',
        'password' => bcrypt('secret123'),
        'usertype' => 'admin',
    ]);

    $response = $this->post(route('login.attempt'), [
        'account' => $admin->email,
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('admin.index'));
    $this->assertAuthenticatedAs($admin);
});

test('regular users are redirected to the welcome page after login', function () {
    $user = User::factory()->create([
        'name' => 'user.account',
        'email' => 'user@example.com',
        'password' => bcrypt('secret123'),
        'usertype' => 'user',
    ]);

    $response = $this->post(route('login.attempt'), [
        'account' => $user->name,
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('welcome'));
    $this->assertAuthenticatedAs($user);
});

test('login is rejected when the usertype is not admin or user', function () {
    User::factory()->create([
        'email' => 'staff@example.com',
        'password' => bcrypt('secret123'),
        'usertype' => 'staff',
    ]);

    $response = $this->from(route('login'))->post(route('login.attempt'), [
        'account' => 'staff@example.com',
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('account');
    $this->assertGuest();
});
