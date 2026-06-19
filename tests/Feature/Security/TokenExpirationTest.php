<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('test_token_expirado_devuelve_401', function () {

    config(['jwt.ttl' => 0]);

    User::factory()->create([
        'email' => 'antonio@test.com',
        'password' => bcrypt('12345678'),
    ]);

    $login = $this->postJson('/api/auth/login', [
        'email' => 'antonio@test.com',
        'password' => '12345678',
    ]);

    $token = $login->json('access_token');

    sleep(1);

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->getJson('/api/auth/me')
        ->assertStatus(401);
});
