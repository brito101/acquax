<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeMetersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_meters')->insert(
            [
                [
                    'name' => 'Água',
                    'acronym' => 'A',
                    'user_id' => 1,
                    'created_at' => new DateTime('now')
                ],
                [
                    'name' => 'Gás',
                    'acronym' => 'G',
                    'user_id' => 1,
                    'created_at' => new DateTime('now')
                ]
            ]
        );
    }
}
