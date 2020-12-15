<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MenuAdmin::class);
        $this->call(CategorySeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(SiteMenu::class);
        $this->call(StaticPage::class);
        $this->call(SiteSettings::class);
    }
}
