<?php

use App\Models\User;
use App\Models\Film;
use App\Models\Director;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function loginFilmToken()
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

test('test_listar_peliculas_autenticado_devuelve_coleccion', function () {
    Film::factory()->count(2)->create();

    $token = loginFilmToken();

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->getJson('/api/films')
        ->assertStatus(200)
        ->assertJsonCount(2);
});

test('test_crear_pelicula_asociada_a_director_existente', function () {
    $director = Director::factory()->create();

    $token = loginFilmToken();

    $data = [
        'title' => 'Interstellar',
        'release_date' => '2014-11-07',
        'sinopsis' => 'Pelicula de ciencia ficcion',
        'duration' => 169,
        'gendre' => 'Ciencia Ficcion',
        'director_id' => $director->id,
    ];

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/films', $data)
        ->assertStatus(201);

    $this->assertDatabaseHas('films', $data);
});

test('test_crear_pelicula_con_director_inexistente_devuelve_422', function () {
    $token = loginFilmToken();

    $data = [
        'title' => 'Pelicula prueba',
        'release_date' => '2020-01-01',
        'sinopsis' => 'Sinopsis de prueba',
        'duration' => 120,
        'gendre' => 'Drama',
        'director_id' => 99999,
    ];

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/films', $data)
        ->assertStatus(422);
});

test('test_actualizar_pelicula', function () {
    $film = Film::factory()->create();

    $director = Director::factory()->create();

    $token = loginFilmToken();

    $data = [
        'title' => 'Titulo actualizado',
        'release_date' => '2022-05-10',
        'sinopsis' => 'Sinopsis actualizada',
        'duration' => 140,
        'gendre' => 'Drama',
        'director_id' => $director->id,
    ];

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->putJson("/api/films/{$film->id}", $data)
        ->assertStatus(200);

    $this->assertDatabaseHas('films', [
        'id' => $film->id,
        'title' => 'Titulo actualizado',
    ]);
});

test('test_eliminar_pelicula', function () {
    $film = Film::factory()->create();

    $token = loginFilmToken();

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->deleteJson("/api/films/{$film->id}")
        ->assertStatus(204);

    $this->assertDatabaseMissing('films', [
        'id' => $film->id,
    ]);
});

test('test_mostrar_pelicula_incluye_datos_del_director', function () {
    $director = Director::factory()->create([
        'name' => 'Christopher',
        'surname' => 'Nolan',
    ]);

    $film = Film::factory()->create([
        'director_id' => $director->id,
    ]);

    $token = loginFilmToken();

    $this->withHeader('Authorization', 'Bearer '.$token)
        ->getJson("/api/films/{$film->id}")
        ->assertStatus(200)
        ->assertJsonPath('director.id', $director->id)
        ->assertJsonPath('director.name', 'Christopher');
});