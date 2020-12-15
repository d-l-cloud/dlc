<?php

namespace App\Models\Page;

use App\Models\Admin\SiteStaticPagesMenu;
use App\Models\Site\SiteMenu;
use App\Models\User\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    use HasFactory;
    protected $fillable = ['description','keywords','user_id','title', 'preview', 'text', 'isHidden'];

    public function user() {
        return $this->belongsTo(Profile::class, 'user_id');
    }
    public function siteMenus() {
        return $this->belongsTo(SiteMenu::class, 'menu_id');
    }
    public function siteStaticPagesMenus() {
        return $this->hasMany(SiteStaticPagesMenu::class, 'pagesId');
    }

    public static function rules() {
        return [
            'title' => 'required|min:5|max:255',
            'text' => 'required',
            'isPrivate' => 'boolean',
            'menu_id' => 'required|array',
        ];
    }


    public static function attributeNames() {
        return [
            'title' => 'Название страницы',
            'text' => 'Содержание страницы',
            'preview' => 'Анонс новости',
        ];
    }

}
