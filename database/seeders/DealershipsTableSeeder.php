<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DealershipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dealerships')->insert(
            [
                [
                    'name' => 'Cedae',
                    'service' => 'Água e Esgoto',
                    'editor' => 1,
                    'created_at' => new DateTime('now')
                ],
            ]
        );
    }
}
