<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\ProductCategory;
use App\Models\Shop\ProductList;
use App\Models\Shop\ProductVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Collection;

class ShowCategoryController extends Controller
{



    public function index(Request $request)
    {

        $subCategorySlug = $request->route('subCategory');
        $categorySlug = $request->route('category');
        if ($subCategorySlug) {
            $getCategoryInfo = ProductCategory::where('slug', '=', $subCategorySlug)->where('parent_id', '!=', '0')->where('isHidden', '=', '0')->firstOrFail();
            $getCategoryId[1] = $getCategoryInfo->id;

            $getCategoryUrl = ProductCategory::where('id', '=', $getCategoryInfo->parent_id)->first();
            $productItemLink['link']['cat']['url'] = $getCategoryUrl->slug;
            $productItemLink['link']['cat']['name'] = $getCategoryUrl->name;
            $productItemLink['link']['subCat']['url'] = $getCategoryInfo->slug;
            $productItemLink['link']['subCat']['name'] = $getCategoryInfo->name;
            $getAllSubCategories = '';

        }elseif ((!$subCategorySlug) AND ($categorySlug)) {
            $getCategoryParent = ProductCategory::where('slug', '=', $categorySlug)->where('parent_id', '=', '0')->where('isHidden', '=', '0')->firstOrFail();
            $getAllCategoryId = ProductCategory::where('parent_id', '=', $getCategoryParent->id)->where('isHidden', '=', '0')->get();

            $productItemLink['link']['cat']['url'] = $getCategoryParent->slug;
            $productItemLink['link']['cat']['name'] = $getCategoryParent->name;
            $productItemLink['link']['subCat']['url'] = '';
            $productItemLink['link']['subCat']['name'] = '';

            foreach ($getAllCategoryId as $getAllCategoryIdItem) {
                $getCategoryId[] = $getAllCategoryIdItem->id;
            }
            if ($getAllCategoryId->count()==0) {
                $getCategoryId[]=null;
            }else{}
            $getAllSubCategories = ProductCategory::orderBy('name')->with(['productList','user'])->where('parent_id', '=', $getCategoryParent->id)->get();

        }elseif ((!$subCategorySlug) AND (!$categorySlug)){
            $getAllCategoryId = ProductCategory::where('isHidden', '=', '0')->get();
            $productItemLink['link']['cat']['url'] = '';
            $productItemLink['link']['cat']['name'] = '';
            $productItemLink['link']['subCat']['url'] = '';
            $productItemLink['link']['subCat']['name'] = '';
            foreach ($getAllCategoryId as $getAllCategoryIdItem) {
                $getCategoryId[] = $getAllCategoryIdItem->id;
            }
            $getAllSubCategories = '';
        }
        if (((session('catalogPage')!=$request->segment(2)) AND (session('catalogSubPage')!=$request->segment(3)))
            OR
            ((session('catalogPage')==$request->segment(2)) AND (session('catalogSubPage')!=$request->segment(3))))
        {
            $request->session()->forget('minPrice');
            $request->session()->forget('maxPrice');
            $request->session()->forget('vendorList');
        }else{}

        $productListPrep = ProductList::whereIn('productCategoryId', $getCategoryId)->orderBy('name')->orderBy('price')->get();
        if ($productListPrep->count() > 0) {

            $allVendor = ProductList::
                    whereIn('productCategoryId', $getCategoryId)
                        ->select('vendorCode')
                        ->distinct()
                        ->get();
            $filterData['minPrice'] = $productListPrep->where('price', $productListPrep->min('price'))->first();
            $filterData['minPrice'] = $filterData['minPrice']->price;
            $filterData['maxPrice'] = $productListPrep->where('price', $productListPrep->max('price'))->first();
            $filterData['maxPrice'] = $filterData['maxPrice']->price;
            if ($allVendor->count() > 0) {
            $vendorCount = 0;
            foreach ($allVendor as $allVendorItem) {
                $vendorCount++;
                $vendorId[$vendorCount]['vendorId'] = $allVendorItem->vendorCode;
                $vendorId[$vendorCount]['vendorName'] = $allVendorItem->vendor->name;
                $vendorIdSql[] = $allVendorItem->vendorCode;

            }}
            $filterData['vendorList']=(collect($vendorId)->sortBy('vendorName'))->toArray();
            if (session('vendorList')) {
                $filterVendorCount=0;
                foreach (session('vendorList') as $allVendorFiltred){

                    $getVendorName = ProductVendor::where('id', $allVendorFiltred)->first();
                    $allVendorFiltredList[$filterVendorCount]['name']=$getVendorName->name;
                    $allVendorFiltredList[$filterVendorCount]['id']=$allVendorFiltred;
                    $filterVendorCount++;
                }
            }else{
                $allVendorFiltredList[] = null;
            }
            if (session('minPrice')!='') {
                $minPriceSet = session('minPrice');
            }else {
                $minPriceSet = $filterData['minPrice'];
            }
            if (session('maxPrice')!='') {
                $maxPriceSet = session('maxPrice');
            }else {
                $maxPriceSet = $filterData['maxPrice'];
            }

            if ((session('minPrice')!='') AND (session('minPrice')!=$filterData['minPrice'])) {
                $percentPriceMin=(session('minPrice')/$filterData['maxPrice'])*100;
                $percentPriceMinMax=100-$percentPriceMin;
            }else{
                $percentPriceMin=0;
                $percentPriceMinMax=100;
            }
            if ((session('maxPrice')!='') AND (session('maxPrice')!=$filterData['maxPrice'])) {
                $percentPriceMax=(session('maxPrice')/$filterData['maxPrice'])*100;
                $percentPriceMinMax=$percentPriceMax-$percentPriceMin;
            }else{
                $percentPriceMax=100;
            }
            $request->session()->put('percentPriceMin', $percentPriceMin);
            $request->session()->put('percentPriceMax', $percentPriceMax);
            $request->session()->put('percentPriceMinMax', $percentPriceMinMax);
            if (session('vendorList')!='') {
                $vendorFiltrList = session('vendorList');
            }else {
                $vendorFiltrList = $vendorIdSql;
            }
        }else{
            $filterData['minPrice']='1';
            $filterData['maxPrice']='2';
            $minPriceSet=0;
            $maxPriceSet=0;
            $vendorFiltrList[]=1;
            $allVendorFiltredList='';
            $filterData=0;
        }


        $productList = ProductList::whereIn('productCategoryId', $getCategoryId)
            ->orderBy('price')
            ->orderBy('name')
            ->where('variable', '<=', 1)
            ->where('price', '>=', $minPriceSet)
            ->where('price', '<=', $maxPriceSet)
            ->whereIn('vendorCode', $vendorFiltrList)
            ->paginate(12);

        return view('shop.showCategory')
            ->with('getAllSubCategories',$getAllSubCategories)
            ->with('productList',$productList)
            ->with('productItemLink', $productItemLink)
            ->with('allVendorFiltredList', $allVendorFiltredList)
            ->with('filterData', $filterData);
    }

    public function setFilterValues(Request $request){
        if ($request->allMinPrice!=$request->minPriceFilter) {
            $request->session()->put('minPrice', $request->minPriceFilter);
        }else{}
        if ($request->allMaxPrice!=$request->maxPriceFilter) {
            $request->session()->put('maxPrice', $request->maxPriceFilter);
        }else{}
        $request->session()->put('catalogPage',$request->catalogPage);
        $request->session()->put('catalogSubPage',$request->catalogSubPage);
        $request->session()->put('vendorList',$request->vendorName);

       if  (($request->catalogPage) AND ($request->catalogSubPage)) {
           return redirect()->route('katalog.katalogSubCategory', [$request->catalogPage, $request->catalogSubPage]);
       }elseif (($request->catalogPage) AND (!$request->catalogSubPage)) {
           return redirect()->route('katalog.katalogCategory', [$request->catalogPage]);
       }else{
           return redirect()->route('katalog.katalogMain');
       }

    }
    public function delFilterValues(Request $request){
        $filterNames = $request->filterNames;
        $catalogPage=session('catalogPage');
        $catalogSubPage=session('catalogSubPage');
        if ($filterNames=='price_from') {
            $request->session()->forget('minPrice');
        }
        if ($filterNames=='price_to') {
            $request->session()->forget('maxPrice');
        }
        if ($filterNames=='vendor') {
            $request->session()->put('vendorList',array_diff(session('vendorList'),[$request->id]));
            $vendorListCount = count(session('vendorList'));
            if ($vendorListCount==0) {
                $request->session()->forget('vendorList');
            }else{}
        }
        if ($filterNames=='all') {
            $request->session()->forget('minPrice');
            $request->session()->forget('maxPrice');
            $request->session()->forget('vendorList');

        }
        if  (($catalogPage) AND ($catalogSubPage)) {
            return redirect()->route('katalog.katalogSubCategory', [$catalogPage, $catalogSubPage]);
        }elseif (($catalogPage) AND (!$catalogSubPage)) {
            return redirect()->route('katalog.katalogCategory', [$catalogPage]);
        }else{
            return redirect()->route('katalog.katalogMain');
        }
    }
}
