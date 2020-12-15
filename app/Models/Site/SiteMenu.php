<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteMenu extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'place',
        'role_id',
        'status',
        'sorting',
    ];

    public static function getCategories($place) {
        // Получаем одним запросом все разделы
        $arr = self::orderBy('sorting')->where('place',$place)->where('slug','!=','news')->where('id','!=','1')->get();
        // Запускаем рекурсивную постройку дерева и отдаем на выдачу
        return self::buildTree($arr, 0);
    }
    public static function buildTree($arr, $pid = 0) {
        // Находим всех детей раздела
        $found = $arr->filter(function($item) use ($pid){return $item->parent_id == $pid; });

        // Каждому детю запускаем поиск его детей
        foreach ($found as $key => $cat) {
            $sub = self::buildTree($arr, $cat->id);
            $cat->sub = $sub;
        }
        return $found;
    }

}
