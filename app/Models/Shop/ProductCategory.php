<?php

namespace App\Models\Shop;

use App\Models\User\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\ProductList;
use Illuminate\Http\Request;

class ProductCategory extends Model
{
    use HasFactory;
    protected $fillable = ['description','keywords','name','slug','text','images','isHidden','views','user_id','source'];

    public function user() {
        return $this->belongsTo(Profile::class, 'user_id');
    }
    public function productList() {
        return $this->hasMany(ProductList::class, 'productCategoryId')->where('variable', '<=', '1');
    }

    public static function getCategories() {
        // Получаем одним запросом все разделы
        $arr = self::orderBy('name')->where('isHidden', '=' , '0')->with(['productList','user'])->get();
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

    public function searchUrl(Request $request) {
        $query=strip_tags(htmlspecialchars($request->route('query')));
        $getSubCategoryUrl = ProductCategory::where('id', '=', $query)->first();
        $getCategoryUrl = ProductCategory::where('id', '=', $getSubCategoryUrl->parent_id)->first();
        $fullUrl = '/katalog/'.$getCategoryUrl->slug.'/'.$getSubCategoryUrl->slug.'/'.$query.'/';
        return $fullUrl;
    }
    public function searchUrlProduct($article) {
        $query=strip_tags(htmlspecialchars($article));
        $getSubCategoryUrl = ProductCategory::where('id', '=', $query)->first();

        $getCategoryUrl = ProductCategory::where('id', '=', $getSubCategoryUrl->parent_id)->first();
        $fullUrl = '/katalog/'.$getCategoryUrl->slug.'/'.$getSubCategoryUrl->slug.'/'.$query.'/';
        return $fullUrl;
    }
    public static function rulesAdd() {
        return [
            'name' => 'required|unique:product_categories,name',
            'slug' => "required|unique:product_categories,slug",
        ];
    }
    public static function rulesEdit($id) {
        return [
            'name' => "required|unique:product_categories,name,$id",
            'slug' => "required|unique:product_categories,slug,$id",
        ];
    }
    public static function attributeNames() {
        return [
            'title' => 'Название категории',
            'slug' => 'ЧПУ категории',
        ];
    }

}
