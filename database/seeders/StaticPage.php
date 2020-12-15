<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StaticPage extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ru_RU');
        $data = [
            ['description'=>$faker->realText(rand(20, 50)),'keywords'=>$faker->realText(rand(20, 50)),'title'=>'О компании','text'=>$faker->realText(rand(2000, 5000)),'user_id'=>rand(1, 4)],
            ['description'=>$faker->realText(rand(20, 50)),'keywords'=>$faker->realText(rand(20, 50)),'title'=>'Вакансии','text'=>$faker->realText(rand(2000, 5000)),'user_id'=>rand(1, 4)],
        ];
        DB::table('static_pages')->insert($data);
    }
}
