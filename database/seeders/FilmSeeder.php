<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primero insertamos directores
        $directors = [
            ['name' => 'Steven', 'surname' => 'Spielberg', 'birthdate' => '1946-12-18'],
            ['name' => 'Christopher', 'surname' => 'Nolan', 'birthdate' => '1970-07-30'],
            ['name' => 'Martin', 'surname' => 'Scorsese', 'birthdate' => '1942-11-17'],
            ['name' => 'Quentin', 'surname' => 'Tarantino', 'birthdate' => '1963-03-27'],
            ['name' => 'James', 'surname' => 'Cameron', 'birthdate' => '1954-08-16'],
        ];

        foreach ($directors as $director) {
            DB::table('directors')->insertOrIgnore(array_merge($director, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $spielberg = DB::table('directors')->where('surname', 'Spielberg')->value('id');
        $nolan = DB::table('directors')->where('surname', 'Nolan')->value('id');
        $scorsese = DB::table('directors')->where('surname', 'Scorsese')->value('id');
        $tarantino = DB::table('directors')->where('surname', 'Tarantino')->value('id');
        $cameron = DB::table('directors')->where('surname', 'Cameron')->value('id');

        $films = [
            // Spielberg
            ['title' => 'Schindler\'s List',      'release_date' => '1993-12-15', 'sinopsis' => 'La historia real de Oskar Schindler, quien salvó a más de mil judíos durante el Holocausto.',             'duration' => 195, 'gendre' => 'Drama',       'director_id' => $spielberg],
            ['title' => 'Jurassic Park',           'release_date' => '1993-06-11', 'sinopsis' => 'Un parque temático con dinosaurios reales se convierte en una pesadilla cuando los animales escapan.',     'duration' => 127, 'gendre' => 'Aventura',    'director_id' => $spielberg],
            ['title' => 'E.T. el extraterrestre',  'release_date' => '1982-06-11', 'sinopsis' => 'Un niño entabla amistad con un alienígena varado en la Tierra.',                                            'duration' => 115, 'gendre' => 'Ciencia ficción', 'director_id' => $spielberg],
            ['title' => 'Indiana Jones en busca del arca perdida', 'release_date' => '1981-06-12', 'sinopsis' => 'El arqueólogo Indiana Jones compite contra los nazis para encontrar el Arca de la Alianza.', 'duration' => 115, 'gendre' => 'Aventura',    'director_id' => $spielberg],

            // Nolan
            ['title' => 'Inception',               'release_date' => '2010-07-16', 'sinopsis' => 'Un ladrón que roba secretos a través de los sueños recibe la misión inversa: plantar una idea.',           'duration' => 148, 'gendre' => 'Ciencia ficción', 'director_id' => $nolan],
            ['title' => 'Interstellar',             'release_date' => '2014-11-07', 'sinopsis' => 'Un grupo de astronautas viaja a través de un agujero de gusano en busca de un nuevo hogar para la humanidad.', 'duration' => 169, 'gendre' => 'Ciencia ficción', 'director_id' => $nolan],
            ['title' => 'The Dark Knight',          'release_date' => '2008-07-18', 'sinopsis' => 'Batman se enfrenta al Joker, un criminal que busca sumir Gotham City en el caos.',                         'duration' => 152, 'gendre' => 'Acción',       'director_id' => $nolan],
            ['title' => 'Memento',                  'release_date' => '2000-10-11', 'sinopsis' => 'Un hombre con amnesia anterógrada investiga el asesinato de su esposa usando notas y tatuajes.',           'duration' => 113, 'gendre' => 'Thriller',     'director_id' => $nolan],

            // Scorsese
            ['title' => 'Goodfellas',              'release_date' => '1990-09-19', 'sinopsis' => 'La historia de Henry Hill y su vida en la mafia desde los años 50 hasta los 80.',                          'duration' => 146, 'gendre' => 'Crimen',       'director_id' => $scorsese],
            ['title' => 'The Departed',            'release_date' => '2006-10-06', 'sinopsis' => 'Un policía infiltrado y un topo de la mafia intentan descubrirse mutuamente en la policía de Boston.',     'duration' => 151, 'gendre' => 'Thriller',     'director_id' => $scorsese],
            ['title' => 'Taxi Driver',             'release_date' => '1976-02-08', 'sinopsis' => 'Un veterano de Vietnam trabaja como taxista nocturno en Nueva York y cae en la obsesión.',                 'duration' => 114, 'gendre' => 'Drama',        'director_id' => $scorsese],
            ['title' => 'The Wolf of Wall Street', 'release_date' => '2013-12-25', 'sinopsis' => 'Ascenso y caída del corredor de bolsa Jordan Belfort, conocido por su vida de excesos.',                   'duration' => 180, 'gendre' => 'Comedia',      'director_id' => $scorsese],

            // Tarantino
            ['title' => 'Pulp Fiction',            'release_date' => '1994-10-14', 'sinopsis' => 'Varias historias de crimen en Los Ángeles se entrelazan de forma no lineal.',                              'duration' => 154, 'gendre' => 'Crimen',       'director_id' => $tarantino],
            ['title' => 'Kill Bill: Volumen 1',    'release_date' => '2003-10-10', 'sinopsis' => 'Una asesina busca venganza contra su antiguo jefe y sus colegas que la dejaron por muerta.',               'duration' => 111, 'gendre' => 'Acción',       'director_id' => $tarantino],
            ['title' => 'Django Unchained',        'release_date' => '2012-12-25', 'sinopsis' => 'Un esclavo liberado se embarca en una misión para rescatar a su esposa de un brutal plantador.',           'duration' => 165, 'gendre' => 'Western',      'director_id' => $tarantino],
            ['title' => 'Inglourious Basterds',    'release_date' => '2009-08-21', 'sinopsis' => 'Durante la Segunda Guerra Mundial, dos planes para asesinar al liderazgo nazi convergen.',                 'duration' => 153, 'gendre' => 'Drama',        'director_id' => $tarantino],

            // Cameron
            ['title' => 'Titanic',                 'release_date' => '1997-12-19', 'sinopsis' => 'Una historia de amor entre personas de distinta clase social a bordo del fatídico Titanic.',              'duration' => 194, 'gendre' => 'Romance',      'director_id' => $cameron],
            ['title' => 'Avatar',                  'release_date' => '2009-12-18', 'sinopsis' => 'Un marine paralítico viaja a Pandora, donde debe elegir entre su misión y la protección del planeta.',     'duration' => 162, 'gendre' => 'Ciencia ficción', 'director_id' => $cameron],
            ['title' => 'Terminator 2',            'release_date' => '1991-07-03', 'sinopsis' => 'Un Terminator reprogramado protege a John Connor de un modelo más avanzado enviado para eliminarlo.',      'duration' => 137, 'gendre' => 'Acción',       'director_id' => $cameron],
            ['title' => 'Aliens',                  'release_date' => '1986-07-18', 'sinopsis' => 'Ripley regresa al planeta donde encontró los xenomorfos, esta vez acompañada de marines espaciales.',      'duration' => 137, 'gendre' => 'Ciencia ficción', 'director_id' => $cameron],
        ];

        foreach ($films as $film) {
            DB::table('films')->insert(array_merge($film, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
