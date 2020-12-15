<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\ProductCategory;
use App\Models\Shop\ProductList;
use App\Models\Shop\ProductProperty;
use App\Models\Shop\ProductPropertyList;
use Illuminate\Http\Request;

class ShowProductController extends Controller
{
    public function index(Request $request)
    {
        $productArticle = $request->route('productArticle');
        $productData = ProductList::with("vendor")->with("category")->where("article", $productArticle)->firstOrFail();
        $productData->views = $productData->views+1;
        $productData->save();
        $productPropertyList = ProductPropertyList::with("propertyName")->where("productId", $productData->id)->get();
        $productVariable = ProductList::where("parentArticle", $productData->parentArticle)->where("article",'!=', $productData->article)->get();
        $getSubCategoryUrl = ProductCategory::where('id', '=', $productData->productCategoryId)->where('parent_id', '!=', '0')->first();

        if ($getSubCategoryUrl->parent_id!=0) {
            $getCategoryUrl = ProductCategory::where('id', '=', $getSubCategoryUrl->parent_id)->first();
            $productItemLink['link']['cat']['url'] = $getCategoryUrl->slug;
            $productItemLink['link']['cat']['name'] = $getCategoryUrl->name;
            $productItemLink['link']['subCat']['url'] = $getSubCategoryUrl->slug;
            $productItemLink['link']['subCat']['name'] = $getSubCategoryUrl->name;
        }else {
            $productItemLink['link']['cat']['url'] = $getSubCategoryUrl->slug;
            $productItemLink['link']['cat']['name'] = $getSubCategoryUrl->name;
            $productItemLink['link']['subCat']['url'] = '';
            $productItemLink['link']['subCat']['name'] = '';
        }

        $findeImagesPropertyId = ProductProperty::where('name', '=', 'Галерея')->first();

        $findePropertyId[2] = ProductProperty::where('name', '=', 'Цвет')->first();
        $findePropertyId[1] = ProductProperty::where('name', '=', 'Страна производства')->first();
        $findePropertyId[4] = ProductProperty::where('name', '=', 'Гарантия')->first();
        $findePropertyId[500] = ProductProperty::where('name', '=', 'Вес, кг')->first();
        $findePropertyId[600] = ProductProperty::where('name', '=', 'Объем коробки, м3')->first();
        $findePropertyId[700] = ProductProperty::where('name', '=', 'Количество в коробке')->first();
        $findePropertyId[8] = ProductProperty::where('name', '=', 'Гарантированное количество циклов открывания/закрывания ')->first();
        $findePropertyId[3] = ProductProperty::where('name', '=', 'Надежность')->first();
        ksort($findePropertyId);
        $countProp = 0;
        foreach ($findePropertyId as $findePropertyIdItem) {
            $countProp++;
            $findePropertyIdSql[$countProp] = $findePropertyIdItem->id;
        }
        //dd($findePropertyId, $findePropertyIdSql);
        $findePropertyIdSqlOrder = implode(',',$findePropertyIdSql);
        $productPropertyMainList = ProductPropertyList::whereIn('propertyId', $findePropertyIdSql)
            ->with('propertyName')
            ->orderByRaw("find_in_set(propertyId, '$findePropertyIdSqlOrder')")
            ->where("productId", $productData->id)
            ->get();



        foreach ($productPropertyList as $productPropertyListItem) {
            if ($productPropertyListItem['propertyId']==$findeImagesPropertyId->id) {
                $productItemImages = $productPropertyListItem['value'];
            }else {
            }
        }

        if (isset($productItemImages)) {
            $productItemImages=explode(', ',$productItemImages);
        }else{
            $productItemImages='';
        }
        $findePropertyId[1001] = ProductProperty::where('name', '=', 'Комплектующие')->first();
        $findePropertyId[1002] = ProductProperty::where('name', '=', 'Производитель')->first();
        $findePropertyId[1003] = ProductProperty::where('name', '=', 'ВидНоменклатуры')->first();
        $findePropertyId[1004] = ProductProperty::where('name', '=', 'ТипНоменклатуры')->first();
        $findePropertyId[1005] = ProductProperty::where('name', '=', 'Код')->first();
        $findePropertyId[1006] = ProductProperty::where('name', '=', 'Вес')->first();
        $findePropertyId[1007] = ProductProperty::where('name', '=', 'НДС')->first();
        $findePropertyId[10018] = ProductProperty::where('name', '=', 'Сопутствующие товары ')->first();
        $findePropertyId[1008] = ProductProperty::where('name', '=', 'Сопутствующие торговые предложения')->first();
        foreach ($productPropertyList as $productPropertyListSop) {
            if ($productPropertyListSop['propertyId']==$findePropertyId[1008]->id) {
                $productItemSop = $productPropertyListSop['value'];
            }else {
            }
            if ($productPropertyListSop['propertyId']==$findePropertyId[10018]->id) {
                $productItemSop = $productPropertyListSop['value'];
            }else {
            }
        }
        if (isset($productItemSop)) {
            $productItemSop=explode(', ',$productItemSop);
            $prodSopList = ProductList::whereIn('name', $productItemSop)->groupBy('name')->get();
        }else{
            $prodSopList = null;
        }
        $findePropertyId[1013] = ProductProperty::where('name', '=', 'С данным товаром необходимо приобрести')->first();
        foreach ($productPropertyList as $productPropertyListKom) {
            if ($productPropertyListKom['propertyId']==$findePropertyId[1013]->id) {
                $productItemKom = $productPropertyListKom['value'];
            }else {
            }
        }
        if (isset($productItemKom)) {
            $productItemKom=explode(', ',$productItemKom);
            $prodKomList = ProductList::whereIn('name', $productItemKom)->groupBy('name')->get();
        }else{
            $prodKomList = null;
        }

        $findePropertyId[1009] = ProductProperty::where('name', '=', 'Галерея')->first();
        $findePropertyId[1010] = ProductProperty::where('name', '=', 'Количество в упаковке')->first();
        $findePropertyId[1011] = ProductProperty::where('name', '=', 'Скачать')->first();
        foreach ($productPropertyList as $productPropertyListFiles) {
            if ($productPropertyListFiles['propertyId']==$findePropertyId[1011]->id) {
                $productItemFiles = $productPropertyListFiles['value'];
            }else {
            }
        }
        if (isset($productItemFiles)) {
            $productItemFiles=explode(', ',$productItemFiles);
        }else{
            $productItemFiles='';
        }
        $findePropertyId[1012] = ProductProperty::where('name', '=', 'Заводской артикул')->first();
        foreach ($findePropertyId as $findePropertyIdItem) {
            $findePropertyIdSql[] = $findePropertyIdItem->id;
        }
        $productPropertyAllMainList = ProductPropertyList::whereNotIn('propertyId', $findePropertyIdSql)->with("propertyName")->where("productId", $productData->id)->get()->sortBy('propertyName.name');
        $productPropertyAllMainListCount=floor($productPropertyAllMainList->count()/2);

        return view('shop.showProduct')
            ->with('prodSopList', $prodSopList)
            ->with('productItemFiles', $productItemFiles)
            ->with('productPropertyAllMainListCount', $productPropertyAllMainListCount)
            ->with('productPropertyAllMainList', $productPropertyAllMainList)
            ->with('productPropertyMainList', $productPropertyMainList)
            ->with('productItemImages', $productItemImages)
            ->with('productItemLink', $productItemLink)
            ->with('productVariable', $productVariable)
            ->with('productData', $productData)
            ->with('productPropertyList', $productPropertyList);
    }
}
