<?php

namespace App\Models\Shop;

use App\Models\User\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVendor extends Model
{
    use HasFactory;
    protected $fillable = ['description','keywords','name','slug','text','images','isHidden','views','user_id','source'];

    public function user() {
        return $this->belongsTo(Profile::class, 'user_id');
    }
    public function product() {
        return $this->hasMany(ProductList::class, 'vendorCode');
    }

    public static function rules() {
        return [
            'name' => 'required|min:1|max:255|unique:product_vendors,name',
            'text' => 'required',
            'slug' => "required|unique:product_vendors,slug",
            //'image' => 'mimes:jpeg,png,bmp|max:1000',
            'isPrivate' => 'boolean'
        ];
    }
    public static function rulesEdit($id) {
        return [
            'name' => "required|min:1|max:255|unique:product_vendors,name,$id",
            'text' => 'required',
            'slug' => "required|unique:product_vendors,slug,$id",
            //'image' => 'mimes:jpeg,png,bmp|max:1000',
            'isPrivate' => 'boolean'
        ];
    }
    public static function attributeNames() {
        return [
            'name' => 'Название производителя',
            'slug' => 'ЧПУ',
            'text' => 'Описание',
        ];
    }
}
