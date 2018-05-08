<?php

use App\Esquema;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        #factory(App\Esquema::class)->times(3)->create();
        #factory(App\Competencia::class)->times(5)->create();
        #factory(App\Pregunta::class)->times(13)->create();
        factory(App\Respuesta::class)->times(1)->create();
    }
}
