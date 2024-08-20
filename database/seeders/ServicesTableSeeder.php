<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('services')->insert([
            [
                'id' => 1,
                'users_id' => 1,
                'title' => 'Motor Repairing',
                'slug' => 'motor-repairing',
                'price' => 1000.00,
                'description' => 'Pakistan, officially the Islamic Republic of Pakistan, is a country in South Asia. It is the fifth-most populous country, with a population of over 241.5 million, having the second-largest Muslim population as of 2023...',
                'email' => 'saqib@gmai.com',
                'contact_name' => 'Saqib',
                'contact_number' => '+3012830912',
                'address' => 'Lahori Nazara, Stockport Road, Levenshulme, Manchester, UK',
                'latitude' => 53.45,
                'longitude' => -2.20,
                'status' => 'Active',
                'created_by' => null,
                'updated_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
