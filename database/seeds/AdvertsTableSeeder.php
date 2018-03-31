<?php

use Advert\Advert;
use Illuminate\Database\Seeder;

class AdvertsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rubric = ['Детский мир','Недвижимость','Транспорт','Запчасти для транспорта','Работа','Животные','Электроника','Бизнес и услуги','Мода и стиль','Хобби отдых и спорт'];
        $active = [true,false];
        $phone = [];
        for($i = 1000000000; $i < 1000000051; $i++){
            $phone[]=$i;
        }
                
        Advert::truncate();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            Advert::create([
                'title' => $faker->sentence,
                'rubric' => array_rand($rubric),
                'description' => $faker->text,
                'image_names' => 'nofoto.jpg',
                'region' => $faker->city,
                'phone' => $faker->unixTime($max = 'now'),
                'user_id' => rand(1, 20),
                'price' => $faker->randomNumber(3),
                'active' => array_rand($active, 1),
            ]);
        }

    }
}
