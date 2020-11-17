<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
//        $this->call(UserSeeder::class);
        DB::table('permissions')->insert([
            'name' => $faker->name,
            'guard_name' => $faker->lastName
        ]);
    }
}
