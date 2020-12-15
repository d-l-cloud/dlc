<?php
namespace App\Http\Controllers\Manufacturer;

use App\Http\Controllers\Controller;
use App\Models\Shop\ProductCategory;
use App\Models\Shop\ProductList;
use App\Models\Shop\ProductVendor;
use Illuminate\Http\Request;

class ShowManufacturerController extends Controller
{
    public function index()
    {
        $vendorList = ProductVendor::where("isHidden",'!=', 1)->get();;
        return view('manufacturer.showVendorList')
            ->with('vendorList',$vendorList);
    }
    public function show(Request $request)
    {
        $manufacturerId=$request->route('id');
        $manufacturerData = ProductVendor::where("id", $manufacturerId)->where("isHidden",'!=', 1)->firstOrFail();
        $manufacturerData->views = $manufacturerData->views+1;
        $manufacturerData->save();
        $getAllCategory = ProductList::with("category")->where('vendorCode','=',$manufacturerId)->groupBy('productCategoryId')->get()->sortBy('category.name');
        $getParentCategoryArray[]=null;
        foreach ($getAllCategory as $getAllCategoryList) {
            if ($getAllCategoryList->category->parent_id!=0) {
                $getParentCategoryData = ProductCategory::where('id', '=', $getAllCategoryList->category->parent_id)->first();
                $getParentCategoryArray[$getAllCategoryList->category->parent_id] = $getParentCategoryData->name;
            }
        }
        asort($getParentCategoryArray);
        return view('manufacturer.showVendor')
            ->with('manufacturerData',$manufacturerData)
            ->with('getAllCategory',$getParentCategoryArray);
    }
}
