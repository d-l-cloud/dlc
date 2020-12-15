<?php

namespace Database\Seeders;
use App\Models\User\Profile;
use App\Models\User\Role;
use App\Models\User\User;
use App\Models\User\Permission;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developer = Role::where('slug','web-developer')->first();
        $manager = Role::where('slug', 'project-manager')->first();
        $superAdmin = Role::where('slug', 'super-admin')->first();
        $admin = Role::where('slug', 'admin')->first();
        $createTasks = Permission::where('slug','create-tasks')->first();
        $manageUsers = Permission::where('slug','manage-users')->first();
        $user1 = new User();
        $user1->name = 'Jhon Deo';
        $user1->email = 'jhon@deo.com';
        $user1->password = bcrypt('secret');
        $user1->save();
        $user1->roles()->attach($developer);
        $user1->permissions()->attach($createTasks);
        $user2 = new User();
        $user2->name = 'Mike Thomas';
        $user2->email = 'mike@thomas.com';
        $user2->password = bcrypt('secret');
        $user2->save();
        $user2->roles()->attach($manager);
        $user2->permissions()->attach($manageUsers);
        $user3 = new User();
        $user3->name = 'Смирнов Вадим';
        $user3->email = 'dabsurd@gmail.com';
        $user3->password = bcrypt('aplir1917');
        $user3->save();
        $user3->roles()->attach($superAdmin);
        $user3->roles()->attach($admin);
        $user3->permissions()->attach($manageUsers);
        $user4 = new User();
        $user4->name = 'Администратор';
        $user4->email = 'admin@d-l.cloud';
        $user4->password = bcrypt('BLgKXk1VYn');
        $user4->save();
        $user4->roles()->attach($superAdmin);
        $user4->roles()->attach($admin);
        $user4->permissions()->attach($manageUsers);
        $faker = Faker::create('ru_RU');
        for ($i = 1; $i <= 4; $i++) {
            $news = new Profile();
            $news->user_id = $i;
            $news->name = $faker->firstName;
            $news->surname = $faker->lastName;
            $news->middle_name = $faker->titleMale;
            $news->male_female_other = $faker->randomElement([1,2]);
            $news->day_birth = rand(1,28);
            $news->month_birth = rand(1,12);
            $news->year_birth = rand(1942,1994);
            $news->phone = $faker->phoneNumber;
            $news->city = $faker->city;
            $news->country = $faker->country;
            $news->time_zone = $faker->timezone;
            $news->save();
        }
    }
}
