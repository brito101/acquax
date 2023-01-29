<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesHasPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        DB::table('role_has_permissions')->insert([
            /** ACL 1 to  11 */
            [
                'permission_id' => 1,
                'role_id' => 1
            ],
            [
                'permission_id' => 2,
                'role_id' => 1
            ],
            [
                'permission_id' => 3,
                'role_id' => 1
            ],
            [
                'permission_id' => 4,
                'role_id' => 1
            ],
            [
                'permission_id' => 5,
                'role_id' => 1
            ],
            [
                'permission_id' => 6,
                'role_id' => 1
            ],
            [
                'permission_id' => 7,
                'role_id' => 1
            ],
            [
                'permission_id' => 8,
                'role_id' => 1
            ],
            [
                'permission_id' => 9,
                'role_id' => 1
            ],
            [
                'permission_id' => 10,
                'role_id' => 1
            ],
            [
                'permission_id' => 11,
                'role_id' => 1
            ],
            /* Profile assignment by administrator type user */
            [
                'permission_id' => 11,
                'role_id' => 2
            ],
            /** Access Settings by programmer */
            [
                'permission_id' => 12,
                'role_id' => 1
            ],
            /** Genres (programmer) 13 to 17 */
            [
                'permission_id' => 13,
                'role_id' => 1
            ],
            [
                'permission_id' => 14,
                'role_id' => 1
            ],
            [
                'permission_id' => 15,
                'role_id' => 1
            ],
            [
                'permission_id' => 16,
                'role_id' => 1
            ],
            [
                'permission_id' => 17,
                'role_id' => 1
            ],
            /** Users  de 18 to 22 (progremmer and administrator) */
            [
                'permission_id' => 18,
                'role_id' => 1
            ],
            [
                'permission_id' => 18,
                'role_id' => 2
            ],
            [
                'permission_id' => 19,
                'role_id' => 1
            ],
            [
                'permission_id' => 19,
                'role_id' => 2
            ],
            [
                'permission_id' => 20,
                'role_id' => 1
            ],
            [
                'permission_id' => 20,
                'role_id' => 2
            ],
            [
                'permission_id' => 21,
                'role_id' => 1
            ],
            [
                'permission_id' => 21,
                'role_id' => 2
            ],
            [
                'permission_id' => 22,
                'role_id' => 1
            ],
            [
                'permission_id' => 22,
                'role_id' => 2
            ],
            /** Complexes 23 to 27 (programmer and administrator) */
            [
                'permission_id' => 23,
                'role_id' => 1
            ],
            [
                'permission_id' => 23,
                'role_id' => 2
            ],
            [
                'permission_id' => 24,
                'role_id' => 1
            ],
            [
                'permission_id' => 24,
                'role_id' => 2
            ],
            [
                'permission_id' => 25,
                'role_id' => 1
            ],
            [
                'permission_id' => 25,
                'role_id' => 2
            ],
            [
                'permission_id' => 26,
                'role_id' => 1
            ],
            [
                'permission_id' => 26,
                'role_id' => 2
            ],
            [
                'permission_id' => 27,
                'role_id' => 1
            ],
            [
                'permission_id' => 27,
                'role_id' => 2
            ],
            /** Block 28 to 32 (programmer and administrator) */
            [
                'permission_id' => 28,
                'role_id' => 1
            ],
            [
                'permission_id' => 28,
                'role_id' => 2
            ],
            [
                'permission_id' => 29,
                'role_id' => 1
            ],
            [
                'permission_id' => 29,
                'role_id' => 2
            ],
            [
                'permission_id' => 30,
                'role_id' => 1
            ],
            [
                'permission_id' => 30,
                'role_id' => 2
            ],
            [
                'permission_id' => 31,
                'role_id' => 1
            ],
            [
                'permission_id' => 31,
                'role_id' => 2
            ],
            [
                'permission_id' => 32,
                'role_id' => 1
            ],
            [
                'permission_id' => 32,
                'role_id' => 2
            ],
            /** Apartments 33 to 36 (Programmer and Administrator)*/
            [
                'permission_id' => 33,
                'role_id' => 1
            ],
            [
                'permission_id' => 33,
                'role_id' => 2
            ],
            [
                'permission_id' => 34,
                'role_id' => 1
            ],
            [
                'permission_id' => 34,
                'role_id' => 2
            ],
            [
                'permission_id' => 35,
                'role_id' => 1
            ],
            [
                'permission_id' => 35,
                'role_id' => 2
            ],
            [
                'permission_id' => 36,
                'role_id' => 1
            ],
            [
                'permission_id' => 36,
                'role_id' => 2
            ],
            [
                'permission_id' => 37,
                'role_id' => 1
            ],
            [
                'permission_id' => 37,
                'role_id' => 2
            ],
            /** Type Meters 38 to 42 (Programmer and Administrator) */
            [
                'permission_id' => 38,
                'role_id' => 1
            ],
            [
                'permission_id' => 38,
                'role_id' => 2
            ],
            [
                'permission_id' => 39,
                'role_id' => 1
            ],
            [
                'permission_id' => 39,
                'role_id' => 2
            ],
            [
                'permission_id' => 40,
                'role_id' => 1
            ],
            [
                'permission_id' => 40,
                'role_id' => 2
            ],
            [
                'permission_id' => 41,
                'role_id' => 1
            ],
            [
                'permission_id' => 41,
                'role_id' => 2
            ],
            [
                'permission_id' => 42,
                'role_id' => 1
            ],
            [
                'permission_id' => 42,
                'role_id' => 2
            ],
            /** Meters */
            [
                'permission_id' => 43,
                'role_id' => 1
            ],
            [
                'permission_id' => 43,
                'role_id' => 2
            ],
            [
                'permission_id' => 44,
                'role_id' => 1
            ],
            [
                'permission_id' => 44,
                'role_id' => 2
            ],
            [
                'permission_id' => 45,
                'role_id' => 1
            ],
            [
                'permission_id' => 45,
                'role_id' => 2
            ],
            [
                'permission_id' => 46,
                'role_id' => 1
            ],
            [
                'permission_id' => 46,
                'role_id' => 2
            ],
            [
                'permission_id' => 47,
                'role_id' => 1
            ],
            [
                'permission_id' => 47,
                'role_id' => 2
            ],
            /** Residents */
            [
                'permission_id' => 48,
                'role_id' => 1
            ],
            [
                'permission_id' => 48,
                'role_id' => 2
            ],
            [
                'permission_id' => 49,
                'role_id' => 1
            ],
            [
                'permission_id' => 49,
                'role_id' => 2
            ],
            [
                'permission_id' => 50,
                'role_id' => 1
            ],
            [
                'permission_id' => 50,
                'role_id' => 2
            ],
            [
                'permission_id' => 51,
                'role_id' => 1
            ],
            [
                'permission_id' => 51,
                'role_id' => 2
            ],
            [
                'permission_id' => 52,
                'role_id' => 1
            ],
            [
                'permission_id' => 52,
                'role_id' => 2
            ],
            /** Syndics 53 to 57 */
            [
                'permission_id' => 53,
                'role_id' => 1
            ],
            [
                'permission_id' => 53,
                'role_id' => 2
            ],
            [
                'permission_id' => 54,
                'role_id' => 1
            ],
            [
                'permission_id' => 54,
                'role_id' => 2
            ],
            [
                'permission_id' => 55,
                'role_id' => 1
            ],
            [
                'permission_id' => 55,
                'role_id' => 2
            ],
            [
                'permission_id' => 56,
                'role_id' => 1
            ],
            [
                'permission_id' => 56,
                'role_id' => 2
            ],
            [
                'permission_id' => 57,
                'role_id' => 1
            ],
            [
                'permission_id' => 57,
                'role_id' => 2
            ],
            /** Readings 58 to 62 */
            [
                'permission_id' => 58,
                'role_id' => 1
            ],
            [
                'permission_id' => 58,
                'role_id' => 2
            ],
            [
                'permission_id' => 59,
                'role_id' => 1
            ],
            [
                'permission_id' => 59,
                'role_id' => 2
            ],
            [
                'permission_id' => 60,
                'role_id' => 1
            ],
            [
                'permission_id' => 60,
                'role_id' => 2
            ],
            [
                'permission_id' => 61,
                'role_id' => 1
            ],
            [
                'permission_id' => 61,
                'role_id' => 2
            ],
            [
                'permission_id' => 62,
                'role_id' => 1
            ],
            [
                'permission_id' => 62,
                'role_id' => 2
            ],
            /** Dealerships 63 to 67 */
            [
                'permission_id' => 63,
                'role_id' => 1
            ],
            [
                'permission_id' => 63,
                'role_id' => 2
            ],
            [
                'permission_id' => 64,
                'role_id' => 1
            ],
            [
                'permission_id' => 64,
                'role_id' => 2
            ],
            [
                'permission_id' => 65,
                'role_id' => 1
            ],
            [
                'permission_id' => 65,
                'role_id' => 2
            ],
            [
                'permission_id' => 66,
                'role_id' => 1
            ],
            [
                'permission_id' => 66,
                'role_id' => 2
            ],
            [
                'permission_id' => 67,
                'role_id' => 1
            ],
            [
                'permission_id' => 67,
                'role_id' => 2
            ],
            /** Dealerships Readings 68 to 72 */
            [
                'permission_id' => 68,
                'role_id' => 1
            ],
            [
                'permission_id' => 68,
                'role_id' => 2
            ],
            [
                'permission_id' => 69,
                'role_id' => 1
            ],
            [
                'permission_id' => 69,
                'role_id' => 2
            ],
            [
                'permission_id' => 70,
                'role_id' => 1
            ],
            [
                'permission_id' => 70,
                'role_id' => 2
            ],
            [
                'permission_id' => 71,
                'role_id' => 1
            ],
            [
                'permission_id' => 71,
                'role_id' => 2
            ],
            [
                'permission_id' => 72,
                'role_id' => 1
            ],
            [
                'permission_id' => 72,
                'role_id' => 2
            ],
            /** Edit profile */
            [
                'permission_id' => 73,
                'role_id' => 4
            ],
            [
                'permission_id' => 73,
                'role_id' => 5
            ],
            /** Apartment Readings */
            [
                'permission_id' => 74,
                'role_id' => 3
            ],
            /** Edit Perfil Application */
            [
                'permission_id' => 75,
                'role_id' => 3
            ],
            /** Access Meter Reading by Apartment  */
            [
                'permission_id' => 76,
                'role_id' => 3
            ],
            /** Support */
            [
                'permission_id' => 77,
                'role_id' => 3
            ],
            [
                'permission_id' => 78,
                'role_id' => 3
            ],
            /** Advertisements */
            [
                'permission_id' => 79,
                'role_id' => 1
            ],
            [
                'permission_id' => 79,
                'role_id' => 2
            ],
            [
                'permission_id' => 79,
                'role_id' => 5
            ],
            [
                'permission_id' => 80,
                'role_id' => 1
            ],
            [
                'permission_id' => 80,
                'role_id' => 2
            ],
            [
                'permission_id' => 80,
                'role_id' => 5
            ],
            [
                'permission_id' => 81,
                'role_id' => 1
            ],
            [
                'permission_id' => 81,
                'role_id' => 2
            ],
            [
                'permission_id' => 81,
                'role_id' => 5
            ],
            [
                'permission_id' => 82,
                'role_id' => 1
            ],
            [
                'permission_id' => 82,
                'role_id' => 2
            ],
            [
                'permission_id' => 82,
                'role_id' => 5
            ],
            [
                'permission_id' => 83,
                'role_id' => 1
            ],
            [
                'permission_id' => 83,
                'role_id' => 2
            ],
            [
                'permission_id' => 83,
                'role_id' => 5
            ],
            /** Posts */
            [
                'permission_id' => 84,
                'role_id' => 1
            ],
            [
                'permission_id' => 84,
                'role_id' => 2
            ],
            [
                'permission_id' => 84,
                'role_id' => 5
            ],
            [
                'permission_id' => 85,
                'role_id' => 1
            ],
            [
                'permission_id' => 85,
                'role_id' => 2
            ],
            [
                'permission_id' => 85,
                'role_id' => 5
            ],
            [
                'permission_id' => 86,
                'role_id' => 1
            ],
            [
                'permission_id' => 86,
                'role_id' => 2
            ],
            [
                'permission_id' => 86,
                'role_id' => 5
            ],
            [
                'permission_id' => 87,
                'role_id' => 1
            ],
            [
                'permission_id' => 87,
                'role_id' => 2
            ],
            [
                'permission_id' => 87,
                'role_id' => 5
            ],
            [
                'permission_id' => 88,
                'role_id' => 1
            ],
            [
                'permission_id' => 88,
                'role_id' => 2
            ],
            [
                'permission_id' => 88,
                'role_id' => 5
            ],
            /** Reports */
            [
                'permission_id' => 89,
                'role_id' => 1
            ],
            [
                'permission_id' => 89,
                'role_id' => 2
            ],
            [
                'permission_id' => 90,
                'role_id' => 1
            ],
            [
                'permission_id' => 90,
                'role_id' => 2
            ],
            [
                'permission_id' => 91,
                'role_id' => 1
            ],
            [
                'permission_id' => 91,
                'role_id' => 2
            ],
            [
                'permission_id' => 92,
                'role_id' => 1
            ],
            [
                'permission_id' => 92,
                'role_id' => 2
            ],
            /** Schedules */
            [
                'permission_id' => 93,
                'role_id' => 1
            ],
            [
                'permission_id' => 93,
                'role_id' => 2
            ],
            [
                'permission_id' => 93,
                'role_id' => 4
            ],
            [
                'permission_id' => 93,
                'role_id' => 5
            ],
            [
                'permission_id' => 94,
                'role_id' => 1
            ],
            [
                'permission_id' => 94,
                'role_id' => 2
            ],
            [
                'permission_id' => 94,
                'role_id' => 4
            ],
            [
                'permission_id' => 94,
                'role_id' => 5
            ],
            [
                'permission_id' => 95,
                'role_id' => 1
            ],
            [
                'permission_id' => 95,
                'role_id' => 2
            ],
            [
                'permission_id' => 95,
                'role_id' => 4
            ],
            [
                'permission_id' => 95,
                'role_id' => 5
            ],
            [
                'permission_id' => 96,
                'role_id' => 1
            ],
            [
                'permission_id' => 96,
                'role_id' => 2
            ],
            [
                'permission_id' => 96,
                'role_id' => 4
            ],
            [
                'permission_id' => 96,
                'role_id' => 5
            ],
            [
                'permission_id' => 97,
                'role_id' => 1
            ],
            [
                'permission_id' => 97,
                'role_id' => 2
            ],
            [
                'permission_id' => 97,
                'role_id' => 4
            ],
            [
                'permission_id' => 97,
                'role_id' => 5
            ],
            /** Reading Schedule */
            [
                'permission_id' => 98,
                'role_id' => 1
            ],
            [
                'permission_id' => 98,
                'role_id' => 2
            ],
            [
                'permission_id' => 98,
                'role_id' => 4
            ],
            [
                'permission_id' => 99,
                'role_id' => 1
            ],
            [
                'permission_id' => 99,
                'role_id' => 2
            ],
            [
                'permission_id' => 99,
                'role_id' => 4
            ],
            [
                'permission_id' => 100,
                'role_id' => 1
            ],
            [
                'permission_id' => 100,
                'role_id' => 2
            ],
            [
                'permission_id' => 100,
                'role_id' => 4
            ],
            [
                'permission_id' => 101,
                'role_id' => 1
            ],
            [
                'permission_id' => 101,
                'role_id' => 2
            ],
            [
                'permission_id' => 101,
                'role_id' => 4
            ],
            [
                'permission_id' => 102,
                'role_id' => 1
            ],
            [
                'permission_id' => 102,
                'role_id' => 2
            ],
            [
                'permission_id' => 102,
                'role_id' => 4
            ],
            /** Management Reports 103 */
            [
                'permission_id' => 103,
                'role_id' => 1
            ],
            [
                'permission_id' => 103,
                'role_id' => 2
            ],
            /** Management Condominium Reports 104 */
            [
                'permission_id' => 104,
                'role_id' => 1
            ],
            [
                'permission_id' => 104,
                'role_id' => 2
            ],
            /** Management Meter Readers 105 */
            [
                'permission_id' => 105,
                'role_id' => 1
            ],
            [
                'permission_id' => 105,
                'role_id' => 2
            ],
        ]);
    }
}
