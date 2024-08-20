<?php

namespace Database\Seeders;

use App\Models\User;
use DB;
use Hash;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        // User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = [
            'Admin' => [
                [ //1
                    'email' => 'admin@gmail.com',
                    'password' => '12345678',
                    'name' => 'Admin',

                ],
            ],
            'Client' => [
                [ //2
                    'email' => 'client@gmail.com',
                    'password' => '12345678',
                    'name' => 'Client',

                ],
            ],

        ];

        foreach ($users as $role_name => $accounts) {
            foreach ($accounts as $seq_no => $account) {
                $checkAccount = User::where('email', $account['email'])->exists();
                if (!$checkAccount) {
                    $user = User::create([
                        'email' => ($account['email']),
                        'name' => ($account['name']),
                        'password' => Hash::make($account['password']),
                        'email_verified_at' => date("Y-m-d H:i:s"),
                    ]);

                    $role_id = getRoleByName($role_name);
                    // create new profile with role

                    $user->assignRole($role_id);

                }
            }
        }
    }
}
