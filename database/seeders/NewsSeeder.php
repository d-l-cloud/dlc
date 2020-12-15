<?php

namespace Database\Seeders;


use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\News\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ru_RU');
        for ($i = 1; $i <= 20; $i++) {
            $news = new News();
            $news->category_id = rand(1, 3);
            $news->description = $faker->realText(rand(20, 50));
            $news->keywords = $faker->realText(rand(20, 50));
            $news->title = $faker->realText(rand(20, 50));
            $news->preview = $faker->realText(rand(200, 255));
            $news->text = $faker->realText(rand(500, 1500));
            $news->user_id = rand(1, 3);
            $news->save();
        }
    }
}
