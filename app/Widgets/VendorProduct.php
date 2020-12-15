<?php

namespace App\Widgets;

use App\Models\Shop\ProductCategory;
use App\Models\Shop\ProductList;
use Arrilot\Widgets\AbstractWidget;

class vendorProduct extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'vendorCode' => 5,
        'productCategoryId' => 5
    ];
    public function placeholder()
    {
        return 'Загрузка...';
    }
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $getAllCategory=ProductCategory::where('parent_id', '=', $this->config['productCategoryId'])->get();
        foreach ($getAllCategory as $getAllCategoryList){
            $getAllCategoryListArray[]=$getAllCategoryList->id;
        }
        $productList = ProductList::inRandomOrder()->where("isHidden",'!=', 1)->where("vendorCode",'=', $this->config['vendorCode'])->whereIn("productCategoryId", $getAllCategoryListArray)->limit(4)->groupBy('name')->get();
        return view('widgets.vendor_product', [
            'config' => $this->config,
        ])->with('productList', $productList);
    }
}
