<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::statement('TRUNCATE TABLE permissions');
        DB::statement('TRUNCATE TABLE role_has_permissions');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $permissions = [
            [
                'id' => 1,
                'name' => 'view_bookings',
                'guard_name' => 'web',
                'created_at' => '2024-08-19 19:28:43',
                'updated_at' => '2024-08-19 19:28:43',
            ],
            [
                'id' => 2,
                'name' => 'view_services',
                'guard_name' => 'web',
                'created_at' => '2024-08-19 19:28:43',
                'updated_at' => '2024-08-19 19:28:43',
            ],
            [
                'id' => 3,
                'name' => 'create_services',
                'guard_name' => 'web',
                'created_at' => '2024-08-19 19:28:43',
                'updated_at' => '2024-08-19 19:28:43',
            ],
        ];

        DB::table('permissions')->insert($permissions);

        $roleHasPermissions = [
            ['permission_id' => 1, 'role_id' => 1],
            ['permission_id' => 1, 'role_id' => 2],
            ['permission_id' => 2, 'role_id' => 1],
            ['permission_id' => 3, 'role_id' => 1],
        ];

        DB::table('role_has_permissions')->insert($roleHasPermissions);

    }
}
