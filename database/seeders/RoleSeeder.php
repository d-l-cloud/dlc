<?php

namespace Database\Seeders;

use App\Models\User\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = new Role();
        $manager->name = 'Пользователь';
        $manager->slug = 'user';
        $manager->save();
        $developer = new Role();
        $developer->name = 'Web Developer';
        $developer->slug = 'web-developer';
        $developer->save();
        $admin = new Role();
        $admin->name = 'Aдминистратор';
        $admin->slug = 'admin';
        $admin->save();
        $superAdmin = new Role();
        $superAdmin->name = 'Супер администратор';
        $superAdmin->slug = 'super-admin';
        $superAdmin->save();
    }
}
