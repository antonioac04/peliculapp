<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('test_login_con_credenciales_validas_devuelve_token', function () {
    User::factory()->create([
        'email' => 'antonio@test.com',
        'password' => bcrypt('12345678'),
    ]);

    $response = $this->postJson('/api/auth/login', [
        'email' => 'antonio@test.com',
        'password' => '12345678',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
});

test('test_login_con_credenciales_invalidas_devuelve_401', function () {
    User::factory()->create([
        'email' => 'antonio@test.com',
        'password' => bcrypt('12345678'),
    ]);

    $response = $this->postJson('/api/auth/login', [
        'email' => 'antonio@test.com',
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(401)
        ->assertJsonMissing(['exception'])
        ->assertJsonMissing(['trace']);
});

test('test_login_con_campos_faltantes_devuelve_422', function () {
    $response = $this->postJson('/api/auth/login', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email', 'password']);
});

test('test_logout_invalida_el_token', function () {
    User::factory()->create([
        'email' => 'antonio@test.com',
        'password' => bcrypt('12345678'),
    ]);

    $login = $this->postJson('/api/auth/login', [
        'email' => 'antonio@test.com',
        'password' => '12345678',
    ]);

    $token = $login->json('access_token');

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/auth/logout')
        ->assertStatus(200);

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->getJson('/api/auth/me')
        ->assertStatus(401);
});

test('test_refresh_devuelve_nuevo_token_valido', function () {
    User::factory()->create([
        'email' => 'antonio@test.com',
        'password' => bcrypt('12345678'),
    ]);

    $login = $this->postJson('/api/auth/login', [
        'email' => 'antonio@test.com',
        'password' => '12345678',
    ]);

    $token = $login->json('access_token');

    $refresh = $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/auth/refresh');

    $refresh->assertStatus(200)
        ->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);

    $newToken = $refresh->json('access_token');

    $this->withHeader('Authorization', 'Bearer '.$newToken)
        ->getJson('/api/auth/me')
        ->assertStatus(200);
});

test('test_me_devuelve_datos_del_usuario_autenticado', function () {
    User::factory()->create([
        'name' => 'Antonio',
        'email' => 'antonio@test.com',
        'password' => bcrypt('12345678'),
    ]);

    $login = $this->postJson('/api/auth/login', [
        'email' => 'antonio@test.com',
        'password' => '12345678',
    ]);

    $token = $login->json('access_token');

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->getJson('/api/auth/me')
        ->assertStatus(200)
        ->assertJsonFragment([
            'name' => 'Antonio',
            'email' => 'antonio@test.com',
        ])
        ->assertJsonMissingPath('password');
});

test('test_acceso_sin_token_devuelve_401', function () {
    $this->getJson('/api/directors')
        ->assertStatus(401)
        ->assertJson([
            'message' => 'Unauthenticated.',
        ]);
});

test('test_acceso_con_token_malformado_devuelve_401', function () {
    $this->withHeader('Authorization', 'Bearer token_inventado')
        ->getJson('/api/directors')
        ->assertStatus(401);
});