<?php
namespace App;

use App\Models\Shop\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Helper
{
    /**
     * Fetch Cached settings from database
     *
     * @return string
     */
    public static function settings($key)
    {
        return Cache::get('settings')->where('key', $key)->first()->value;
    }
    public static function searchUrl($data)
    {
        $query = strip_tags(htmlspecialchars($data));
        $getSubCategoryUrl = ProductCategory::where('id', '=', $query)->first();
        if ($getSubCategoryUrl->parent_id != 0){
            $getCategoryUrl = ProductCategory::where('id', '=', $getSubCategoryUrl->parent_id)->first();
            $fullUrl = '/katalog/' . $getCategoryUrl->slug . '/' . $getSubCategoryUrl->slug . '/' . $query . '/';
        }else {
            $fullUrl = '/katalog/' . $getSubCategoryUrl->slug . '/' . $query . '/';
        }
        return $fullUrl;
    }
}
