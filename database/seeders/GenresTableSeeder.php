<?php

namespace Database\Seeders;

use App\Models\Genre;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert(
            [
                [
                    'name' => 'Cisgênero',
                    'acronym' => 'C',
                    'user_id' => 1,
                    'created_at' => new DateTime('now')
                ],
                [
                    'name' => 'Feminino',
                    'acronym' => 'F',
                    'user_id' => 1,
                    'created_at' => new DateTime('now')
                ],
                [
                    'name' => 'Masculino',
                    'acronym' => 'M',
                    'user_id' => 1,
                    'created_at' => new DateTime('now')
                ],
                [
                    'name' => 'Não-Binário',
                    'acronym' => 'NB',
                    'user_id' => 1,
                    'created_at' => new DateTime('now')
                ],
                [
                    'name' => 'Outros',
                    'acronym' => 'O',
                    'user_id' => 1,
                    'created_at' => new DateTime('now')
                ],
                [
                    'name' => 'Transgênero',
                    'acronym' => 'T',
                    'user_id' => 1,
                    'created_at' => new DateTime('now')
                ],
            ]
        );
    }
}
