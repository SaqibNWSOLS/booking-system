<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServiceImagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('service_images')->insert([
            [
                'id' => 1,
                'users_id' => 1,
                'services_id' => 1,
                'path' => 'what-factors-affect-property-value-1724184778.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
