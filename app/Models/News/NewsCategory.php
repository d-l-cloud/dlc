<?php

namespace App\Models\News;

use App\Models\News\News;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    use HasFactory;
    protected $fillable = ['title','slug'];

    public function news() {
        return $this->hasMany(News::class, 'category_id');
    }

    public static function rulesAdd() {
        return [
            'title' => 'required|unique:news_categories,title',
            'slug' => "required|unique:news_categories,slug",
        ];
    }
    public static function rulesEdit($id) {
        return [
            'title' => "required|unique:news_categories,title,$id",
            'slug' => "required|unique:news_categories,slug,$id",
        ];
    }

    public static function attributeNames() {
        return [
            'title' => 'Название категории',
            'slug' => 'ЧПУ URL',
        ];
    }
}
