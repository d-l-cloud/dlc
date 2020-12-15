<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            [
                "title" => "Спорт",
                "slug" => "sport",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "title" => "Авто",
                "slug" => "auto",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "title" => "Наука",
                "slug" => "science",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
        ];

        DB::table('news_categories')->insert($category);
    }
}
