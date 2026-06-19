<?php

namespace Database\Seeders;

use App\Models\Director;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DirectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // DB::table('directors')->insert([
        //    'name' => 'David',
        //    'surname' => 'Lynch',
        //    'birthdate' => now(),
        //    'updated_at' => now(),
        //    'created_at' => now(),
        // ]);
        // DB::table('directors')->insert([
        //    'name' => 'Antonio',
        //    'surname' => 'Banderas',
        //    'birthdate' => now(),
        //    'updated_at' => now(),
        //    'created_at' => now(),
        // ]);

        Director::create(['name' => 'Stanley', 'surname' => 'Kubrick', 'birthdate' => '1928-07-26']);
        Director::create(['name' => 'Martin', 'surname' => 'Scorsese', 'birthdate' => '1942-11-17']);
        Director::create(['name' => 'Christopher', 'surname' => 'Nolan', 'birthdate' => '1970-07-30']);
        Director::create(['name' => 'Steven', 'surname' => 'Spielberg', 'birthdate' => '1946-12-18']);
        Director::create(['name' => 'Francis Ford', 'surname' => 'Coppola', 'birthdate' => '1939-04-07']);
        Director::create(['name' => 'Quentin', 'surname' => 'Tarantino', 'birthdate' => '1963-03-27']);
        Director::create(['name' => 'Ridley', 'surname' => 'Scott', 'birthdate' => '1937-11-30']);
        Director::create(['name' => 'Pedro', 'surname' => 'Almodóvar', 'birthdate' => '1949-09-25']);
        Director::create(['name' => 'Akira', 'surname' => 'Kurosawa', 'birthdate' => '1910-03-23']);
        Director::create(['name' => 'Alfred', 'surname' => 'Hitchcock', 'birthdate' => '1899-08-13']);
        Director::create(['name' => 'James', 'surname' => 'Cameron', 'birthdate' => '1954-08-16']);
        Director::create(['name' => 'Tim', 'surname' => 'Burton', 'birthdate' => '1958-08-25']);
        Director::create(['name' => 'Wes', 'surname' => 'Anderson', 'birthdate' => '1969-05-01']);
        Director::create(['name' => 'Denis', 'surname' => 'Villeneuve', 'birthdate' => '1967-10-03']);
        Director::create(['name' => 'Guillermo', 'surname' => 'del Toro', 'birthdate' => '1964-10-09']);
        Director::create(['name' => 'Joel', 'surname' => 'Coen', 'birthdate' => '1954-11-29']);
        Director::create(['name' => 'Woody', 'surname' => 'Allen', 'birthdate' => '1935-12-01']);
        Director::create(['name' => 'Roman', 'surname' => 'Polanski', 'birthdate' => '1933-08-18']);
        Director::create(['name' => 'Jean-Luc', 'surname' => 'Godard', 'birthdate' => '1930-12-03']);
        Director::create(['name' => 'Alejandro González', 'surname' => 'Iñárritu', 'birthdate' => '1963-08-15']);

    }
}
