<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function loginSecurityToken()
{

    $response = test()->postJson('/api/auth/login', [
        'email' => 'antonio@test.com',
        'password' => '12345678',
    ]);

    return $response->json('access_token');
}

test('test_respuestas_de_error_no_exponen_stack_trace', function () {

    config([
        'app.debug' => false,
    ]);

    $response = $this->getJson('/api/directors');

    $response->assertStatus(401);

    $response->assertJsonMissingPath('exception');
    $response->assertJsonMissingPath('file');
    $response->assertJsonMissingPath('line');
});

test('test_password_no_aparece_en_respuesta_me', function () {

    User::factory()->create([
        'name' => 'Antonio',
        'email' => 'antonio@test.com',
        'password' => bcrypt('12345678'),
    ]);

    $token = loginSecurityToken();

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->getJson('/api/auth/me')
        ->assertStatus(200)
        ->assertJsonMissingPath('password');
});