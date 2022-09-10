<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        DB::table('roles')->insert([
            /** 1 */
            [
                'name' => 'Programador',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** 2 */
            [
                'name' => 'Administrador',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** 3 */
            [
                'name' => 'Usuário',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** 4 */
            [
                'name' => 'Leiturista',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** 5 */
            [
                'name' => 'Marketing',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
        ]);
    }
}
