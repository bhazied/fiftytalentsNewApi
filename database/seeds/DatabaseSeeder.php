<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = DB::table('countries')->insert([
            'name' => 'Italie',
            'code' => 'IT',
            'long_code' => 'ITA',
            'prefix' => str_random(2),
            'picture' => 'Italie.png'
        ]);

        for ($i=0; $i<10; $i++) {
            DB::table('users')->insert([
                'name' => str_random(10),
                'email' => str_random(10).'@gmail.com',
                'password' =>  bcrypt('secret'),
                'remember_token' => str_random(10),
                'country_id' => rand(1, 3)
            ]);
        }
    }
}
