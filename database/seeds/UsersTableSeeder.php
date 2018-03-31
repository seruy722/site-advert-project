<?php

use Advert\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $active = [true, false];
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 20; $i++) {
            User::create([
                'name' => $faker->name,
                'surname' => $faker->colorName,
                'email' => $faker->email,
                'phone' => $faker->unixTime($max = 'now'),
                'password' => bcrypt('user123'),
                'blocked' => array_rand($active, 1),
                'role' => 'user',
            ]);
        }
    }
}
