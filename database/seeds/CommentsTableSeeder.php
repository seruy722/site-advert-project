<?php

use Advert\Comment;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Comment::truncate();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 100; $i++) {
            Comment::create([
                'user_name' => $faker->name,
                'comment' => $faker->sentence,
                'advert_id' => rand(1, 50),
                'user_id' => rand(1, 20),
            ]);
        }
    }
}
