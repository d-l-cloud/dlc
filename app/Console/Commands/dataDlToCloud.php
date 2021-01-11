<?php

namespace App\Console\Commands;

use App\Models\Shop\ProductCategory;
use App\Models\Shop\ProductList;
use App\Models\Shop\ProductProperty;
use App\Models\Shop\ProductPropertyList;
use App\Models\Shop\ProductVendor;
use App\Models\User\User;
use App\Notifications\SendDocLinkNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Orchestra\Parser\Xml\Facade as XmlParser;

class dataDlToCloud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getdata:dltocloud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получить данные с сайта doorlock.ru';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $productList = ProductList::get();
        foreach ($productList as $productList) {
            if ($productList->source == 'DL') {
                $allProductPropId = ProductPropertyList::where('productId', '=', $productList->id)->get();
                if ($allProductPropId) {
                    foreach ($allProductPropId as $allProductPropIdItem) {
                        $allProductPropIdItem->delete();
                    }
                }
                $productList->delete();
            }
        }
        $userId = 3;
        $xml = XmlParser::load('https://www.doorlock.ru/bitrix/catalog_export/yandex_24112020.php');
        $dlProdList = $xml->getContent();
        //Категории
        $CatArrayXml = $dlProdList->shop->categories;
        $catalogItem='';
        foreach ($CatArrayXml->category as $listXml) {
            $catId = $listXml->attributes()->id;
            $parentId = $listXml->attributes()->parentId;
            if (!$parentId) {
                $parentId = 0;
            }
            $catName = $listXml;
            $catSlugName = Str::slug($catName, '_');
            $catalogItem.=$catId.$parentId.$catName.$catSlugName;
            $checkTrueParent = ProductCategory::where('id', '=', $parentId)->where('parent_id', '!=', 0)->first();
            if ($checkTrueParent) {
                $findeTrueParent = ProductCategory::where('id', '=', $parentId)->where('parent_id', '!=', 0)->first();
                $parentId = $findeTrueParent->parent_id;
            }else{}
            $findeCategory = ProductCategory::where('id', '=', $catId)->where('parent_id', '=', $parentId)->first();
            if (!$findeCategory) {
                $category =  new ProductCategory();
                $category->id = $catId;
                $category->parent_id = $parentId;
                $category->name = $catName;
                $category->slug = $catSlugName;
                $category->text = '';
                $category->user_id = $userId;
                $category->save();
            }

        }

        //Свойства товара
        $propertiesProductArrayXml = $dlProdList->shop->offers;
        foreach ($propertiesProductArrayXml->offer as $listXml) {
            $poductVendorList[] = $listXml->vendor;
            $poductParamArray = $listXml->param;
            foreach ($poductParamArray as $poductParamItem) {
                $poductParamList[] = $poductParamItem->attributes()->name;
            }
        }
        $propertiesProductArray = array_unique($poductParamList);
        foreach ($propertiesProductArray as $propertiesItem) {
            $propertiesName = $propertiesItem;
            $propertiesSlugName = Str::slug($propertiesName, '_');
            $findeProperty = ProductProperty::where('slug', '=', $propertiesSlugName)->where('name', '=', $propertiesName)->first();
            if (!$findeProperty) {
                $property = new ProductProperty();
                $property->name = $propertiesName;
                $property->slug = $propertiesSlugName;
                $property->user_id = $userId;
                $property->save();
            }
        }

        //Производители
        $poductVendorArray = array_unique($poductVendorList);
        foreach ($poductVendorArray as $vendorItem) {
            $vendorName = $vendorItem;
            $vendorSlugName = Str::slug($vendorName, '_');
            $findeVendor = ProductVendor::where('slug', '=', $vendorSlugName)->where('name', '=', $vendorName)->first();
            if (!$findeVendor) {
                $vendor = new ProductVendor();
                $vendor->name = $vendorName;
                $vendor->slug = $vendorSlugName;
                $vendor->text = '';
                $vendor->user_id = $userId;
                $vendor->save();
            }
        }
        $vendorSlugName = Str::slug('NoName', '_');
        $findeVendor = ProductVendor::where('slug', '=', $vendorSlugName)->where('name', '=', 'NoName')->first();
        if (!$findeVendor) {
            $vendor = new ProductVendor();
            $vendor->name = 'NoName';
            $vendor->slug = $vendorSlugName;
            $vendor->text = '';
            $vendor->user_id = $userId;
            $vendor->save();
        }
        //Товар
        $productListArrayXml = $dlProdList->shop->offers;
        foreach ($productListArrayXml->offer as $productListXml) {
            $productPrice = $productListXml->price;
            $productCategoryId = $productListXml->categoryId;
            $findeVendor = ProductVendor::where('name', '=', $productListXml->vendor)->first();
            if ($findeVendor) {
                $productVendorId = $findeVendor->id;
            }else {
                $productVendorId = 0;
            }
            $productArticle = $productListXml->manufacturer_warranty;
            $productParentArticle = $productListXml->vendorCode;
            $productName = $productListXml->model;
            $productPicture = $productListXml->picture;
            $productSlug = Str::slug($productName, '_');
            $findeProduct = ProductList::where('article', '=', str_replace('*', '',$productArticle))->first();
            $findeProductCategory = ProductCategory::where('id', '=', $productCategoryId)->where('parent_id', '!=', 0)->first();
            if ($findeProductCategory) {
                if (!$findeProduct) {
                    $product = new ProductList();
                    $product->images = $productPicture;
                    $product->name = $productName;
                    $product->slug = $productSlug;
                    $product->article = str_replace('*', '',$productArticle);
                    $product->parentArticle = $productParentArticle;
                    $product->vendorCode = $productVendorId;
                    $product->productCategoryId = $productCategoryId;
                    $product->price = $productPrice;
                    $product->text = '';
                    $product->user_id = $userId;
                    //$product->save();
                }
            }else{}
            $poductParamArrayOne = $productListXml->param;
            foreach ($poductParamArrayOne as $poductPropertyItemOne) {
                $poductParamName = $poductPropertyItemOne->attributes()->name;
                $findePoductParamName = ProductProperty::where('name', '=', $poductParamName)->first();
                if ($findePoductParamName) {
                    $poductPropertyId = $findePoductParamName->id;
                }else {
                    $poductPropertyId = 0;
                }
                $findePoductID = ProductList::where('article', '=', str_replace('*', '',$productArticle))->first();
                if ($findePoductID) {
                    $poductId = $findePoductID->id;
                    $poductPropertyValue = $poductPropertyItemOne;
                    $findeProductProperty = ProductPropertyList::where('propertyId', '=', $poductPropertyId)->where('productId', '=', $poductId)->first();
                    if (!$findeProductProperty) {
                        $productProperty = new ProductPropertyList();
                        $productProperty->propertyId = $poductPropertyId;
                        $productProperty->productId = $poductId;
                        $productProperty->value = $poductPropertyValue;
                        $productProperty->user_id = $userId;
                        //$productProperty->save();
                    }
                }else {
                }

            }

        }
        $allProduct = ProductList::groupBy('parentArticle')->get();
        foreach ($allProduct as $productItem) {
            $findeVariableProduct = ProductList::where('parentArticle', '=', $productItem->parentArticle)->get();
            $findeVariableproductCount = $findeVariableProduct->count();
            if ($findeVariableproductCount>1) {
                $variableproductCount=0;
                foreach ($findeVariableProduct as $variableProductItem) {
                    $variableproductCount++;
                    $product = ProductList::find($variableProductItem->id);
                    $product->variable = $variableproductCount;
                    $product->save();
                }
            }else{}
        }
    }

}
