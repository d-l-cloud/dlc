<?php

namespace App\Models\News;

use App\Models\User\Profile;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = ['description','keywords','category_id', 'user_id','title', 'preview', 'text', 'isHidden', 'image'];

    public function category() {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }
    public function user() {
        return $this->belongsTo(Profile::class, 'user_id');
    }

    public static function rules() {
        $tableNameCategory = (new NewsCategory())->getTable();
        return [
            'title' => 'required|min:10|max:255',
            'text' => 'required',
            'preview' => 'required|max:255',
            'category_id' => "required|exists:{$tableNameCategory},id",
            //'image' => 'mimes:jpeg,png,bmp|max:1000',
            'isPrivate' => 'boolean'
        ];
    }

    public static function attributeNames() {
        return [
            'title' => 'Заголовок новости',
            'text' => 'Текст новости',
            'preview' => 'Анонс новости',
            'category_id' => 'Категория новости',
            //'image' => 'Фото новости',
        ];
    }
}
