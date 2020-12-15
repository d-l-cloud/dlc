<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Models\Shop\ProductCategory;
use App\Models\Shop\ProductList;
use App\Models\Site\SiteSettings;

class Helper
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }
    public static function searchUrl($productArt) {
        $query=strip_tags(htmlspecialchars($productArt));
        $getSubCategoryUrl = ProductCategory::where('id', '=', $query)->first();
        if ($getSubCategoryUrl->parent_id!=0) {
            $getCategoryUrl = ProductCategory::where('id', '=', $getSubCategoryUrl->parent_id)->first();
            $fullUrl = '/katalog/'.$getCategoryUrl->slug.'/'.$getSubCategoryUrl->slug.'/';
        }else {
           $fullUrl = '/katalog/'.$getSubCategoryUrl->slug.'/';
        }
        return $fullUrl;
    }
    public static function variable($parentArticle) {
        $findeVariableProduct = ProductList::where('parentArticle', '=', $parentArticle)->get();
        $findeVariableproductCount = $findeVariableProduct->count()-1;
        return $findeVariableproductCount;
    }
    public static function siteSettings($nameSettings,$settingsId) {
        $findesiteSettings = SiteSettings::where('id', '=', $settingsId)->first();
        return $findesiteSettings->$nameSettings;
    }
}
