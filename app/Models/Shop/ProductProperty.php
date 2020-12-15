<?php

namespace App\Models\Shop;

use App\Models\User\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductProperty extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','user_id','source'];

    public function user() {
        return $this->belongsTo(Profile::class, 'user_id');
    }
    public static function rulesAdd() {
        return [
            'name' => 'required|unique:product_properties,name',
            'slug' => "required|unique:product_properties,slug",
        ];
    }
    public static function rulesEdit($id) {
        return [
            'name' => "required|unique:product_properties,name,$id",
            'slug' => "required|unique:product_properties,slug,$id",
        ];
    }
    public static function attributeNames() {
        return [
            'title' => 'Название свойства',
            'slug' => 'ЧПУ URL',
        ];
    }
}
