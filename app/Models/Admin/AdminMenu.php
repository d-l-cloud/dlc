<?php

namespace App\Models\Admin;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AdminMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'role_id',
        'status',
    ];


    public static function userRoleId() {
        $user = User::find(Auth::user()->id);
        foreach ($user->roles as $role)  {
            $userRoleList[]=$role->id;
        }
        $userRoleList=implode(",", $userRoleList);
        return $userRoleList;
    }

    public static function getCategories() {
        // Получаем одним запросом все разделы
        $arr = self::orderBy('sorting')->where('status','=','1')->get();
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
