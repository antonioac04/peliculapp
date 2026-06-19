<?php

use App\Models\User;
use App\Models\Director;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function loginAndGetToken()
{
    User::factory()->create([
        'email' => 'antonio@test.com',
        'password' => bcrypt('12345678'),
    ]);

    $response = test()->postJson('/api/auth/login', [
        'email' => 'antonio@test.com',
        'password' => '12345678',
    ]);

    return $response->json('access_token');
}

test('test_listar_directores_requiere_autenticacion', function () {
    $this->getJson('/api/directors')
        ->assertStatus(401);
});

test('test_listar_directores_autenticado_devuelve_coleccion', function () {
    Director::factory()->count(3)->create();

    $token = loginAndGetToken();

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->getJson('/api/directors')
        ->assertStatus(200)
        ->assertJsonCount(3);
});

test('test_crear_director_con_datos_validos', function () {

    $token = loginAndGetToken();

    $data = [
        'name' => 'Steven',
        'surname' => 'Spielberg',
        'birthdate' => '1946-12-18',
    ];

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/directors', $data)
        ->assertStatus(201);

    $this->assertDatabaseHas('directors', $data);
});

test('test_crear_director_con_datos_invalidos_devuelve_422', function () {

    $token = loginAndGetToken();

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/directors', [])
        ->assertStatus(422);
});

test('test_actualizar_director_existente', function () {

    $director = Director::factory()->create();

    $token = loginAndGetToken();

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->putJson("/api/directors/{$director->id}", [
            'name' => 'Nuevo',
            'surname' => 'Apellido',
            'birthdate' => '1980-01-01',
        ])
        ->assertStatus(200);

    $this->assertDatabaseHas('directors', [
        'id' => $director->id,
        'name' => 'Nuevo',
    ]);
});

test('test_actualizar_director_inexistente_devuelve_404', function () {

    $token = loginAndGetToken();

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->putJson('/api/directors/99999', [
            'name' => 'Test',
            'surname' => 'Test',
            'birthdate' => '2000-01-01',
        ])
        ->assertStatus(404);
});

test('test_eliminar_director_existente', function () {

    $director = Director::factory()->create();

    $token = loginAndGetToken();

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->deleteJson("/api/directors/{$director->id}")
        ->assertStatus(204);

    $this->assertDatabaseMissing('directors', [
        'id' => $director->id,
    ]);
});

test('test_eliminar_director_con_peliculas_asociadas', function () {

    $director = Director::factory()->create();

    \App\Models\Film::create([
       'title' => 'Interstellar',
       'sinopsis' => 'Pelicula de ciencia ficcion',
       'duration' => 169,
       'release_date' => '2014-11-07',
       'gendre' => 'Ciencia ficcion',
       'director_id' => $director->id,
    ]);

    $token = loginAndGetToken();

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->deleteJson("/api/directors/{$director->id}")
        ->assertStatus(500);

    $this->assertDatabaseHas('directors', [
        'id' => $director->id,
    ]);
});
