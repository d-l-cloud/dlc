<?php

namespace Database\Seeders;

use App\Models\Admin\AdminMenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            ['id'=>'1','parent_id'=>'0','name'=>'Новости','slug'=>'','icon'=>'la la-newspaper-o','role_id'=>'3','status'=>'1','sorting'=>'2'],
            ['id'=>'2','parent_id'=>'0','name'=>'Товары','slug'=>'','icon'=>'la la-shopping-cart','role_id'=>'3','status'=>'1','sorting'=>'1'],
            ['id'=>'3','parent_id'=>'0','name'=>'Пользователи','slug'=>'user','icon'=>'la la-users','role_id'=>'3','status'=>'0','sorting'=>'4'],
            ['id'=>'4','parent_id'=>'0','name'=>'Настройки','slug'=>'','icon'=>'icon-wrench','role_id'=>'3','status'=>'1','sorting'=>'6'],
            ['id'=>'5','parent_id'=>'0','name'=>'Оплата','slug'=>'payment','icon'=>'la la-rub','role_id'=>'3','status'=>'0','sorting'=>'5'],
            ['id'=>'6','parent_id'=>'0','name'=>'Статичные страницы','slug'=>'list.index','icon'=>'la la-sticky-note','role_id'=>'3','status'=>'1','sorting'=>'3'],
            ['id'=>'7','parent_id'=>'1','name'=>'Список новостей','slug'=>'news-list.index','icon'=>'la la-list-ul','role_id'=>'3','status'=>'1','sorting'=>'1'],
            ['id'=>'8','parent_id'=>'1','name'=>'Категории новостей','slug'=>'news-categories.index','icon'=>'la la-list-ul','role_id'=>'3','status'=>'1','sorting'=>'2'],
            ['id'=>'9','parent_id'=>'2','name'=>'Список товаров','slug'=>'product-list.index','icon'=>'fas fa-list-ol','role_id'=>'3','status'=>'1','sorting'=>'1'],
            ['id'=>'10','parent_id'=>'2','name'=>'Категории товаров','slug'=>'product-categories.index','icon'=>'fas fa-list-ol','role_id'=>'3','status'=>'1','sorting'=>'2'],
            ['id'=>'11','parent_id'=>'2','name'=>'Свойства товаров','slug'=>'product-properties.index','icon'=>'fas fa-project-diagram','role_id'=>'3','status'=>'1','sorting'=>'4'],
            ['id'=>'12','parent_id'=>'2','name'=>'Производитель товаров','slug'=>'product-manufacturer.index','icon'=>'fas fa-industry','role_id'=>'3','status'=>'1','sorting'=>'3'],
            ['id'=>'13','parent_id'=>'4','name'=>'Настройки дизайна','slug'=>'settings.design','icon'=>'fas fa-paint-brush','role_id'=>'3','status'=>'0','sorting'=>'4'],
            ['id'=>'14','parent_id'=>'4','name'=>'Настройки почты','slug'=>'settings.mail','icon'=>'fas fa-paper-plane','role_id'=>'3','status'=>'0','sorting'=>'3'],
            ['id'=>'15','parent_id'=>'4','name'=>'Настройки сайта','slug'=>'settings.site','icon'=>'fas fa-cogs','role_id'=>'3','status'=>'1','sorting'=>'2'],
            ['id'=>'16','parent_id'=>'4','name'=>'Меню сайта','slug'=>'settings.menu','icon'=>'fas fa-bars','role_id'=>'3','status'=>'1','sorting'=>'1'],
            ['id'=>'17','parent_id'=>'0','name'=>'Обновить сайт','slug'=>'clear-all','icon'=>'fas fa-sync-alt','role_id'=>'3','status'=>'1','sorting'=>'7'],
        ];
        DB::table('admin_menus')->insert($data);
    }
}
