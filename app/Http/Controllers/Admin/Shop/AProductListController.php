<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\ProductCategory;
use App\Models\Shop\ProductList;
use App\Models\Shop\ProductProperty;
use App\Models\Shop\ProductPropertyList;
use App\Models\Shop\ProductVendor;
use Illuminate\Http\Request;

class AProductListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productList = ProductList::with(['category','vendor'])->orderBy('name')->get();
        return view('admin.shop.productList')
            ->with('productList', $productList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendorList = ProductVendor::orderBy('name')->get();
        $catList = ProductCategory::getCategories();
        return view('admin.shop.productListAdd', [
            'vendorList'=>$vendorList,
            'catList'=>$catList,
            'productList'=>new ProductList()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ProductList::rules(), [], ProductList::attributeNames());
        $productList = new ProductList();
        if ($request->parentArticle == null) {
            $request->merge(["parentArticle"=>$request->article]);
        }else{}
        $productList->fill($request->all())->save();
        return redirect()->route('admin.product-list.index')->with('success','Товар успешно добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productList = ProductList::find($id);
        if (!$productList){
            return redirect()->route('admin.product-list.index')->with('warning','Товар с данным id не найден');
        }
        $vendorList = ProductVendor::orderBy('name')->get();
        $propertyList = ProductProperty::orderBy('name')->where('name', '!=', 'Галерея')->get();
        $catList = ProductCategory::getCategories();
        $imagesList = ProductProperty::where('name', '=', 'Галерея')->first();
        $findeProductPropId = ProductPropertyList::where('propertyId', '=', $imagesList->id)->where('productId', '=', $id)->first();
        $propertyProductList = ProductPropertyList::where('productId', '=', $id)->where('propertyId', '!=', $imagesList->id)->get();
        return view('admin.shop.productListAdd',[
            'propertyProductList'=>$propertyProductList,
            'propertyList'=>$propertyList,
            'findeProductPropId'=>$findeProductPropId,
            'vendorList'=>$vendorList,
            'catList'=>$catList,
            'productList'=>$productList
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $productList = ProductList::find($id);
        $this->validate($request, ProductList::rulesEdit($id), [], ProductList::attributeNames());
        $productList->fill($request->all())->save();
        return redirect()->route('admin.product-list.index')->with('success','Товар успешно отредактирован');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productList = ProductList::find($id);
        if ($productList->source!='DL') {
                $allProductPropId = ProductPropertyList::where('productId', '=',$id)->get();
                if ($allProductPropId){
                    foreach ($allProductPropId as $allProductPropIdItem) {
                        $allProductPropIdItem->delete();
                    }
                }
            $productList->delete();

        }
        return redirect()->route('admin.product-list.index')->with('delete','Товар успешно удален');
    }

    public function savePhoto (Request $request, $id) {
        $findeImagesPropertyId = ProductProperty::where('name', '=', 'Галерея')->first();
        $findeProductPropId = ProductPropertyList::where('propertyId', '=', $findeImagesPropertyId->id)->where('productId', '=', $id)->first();
        if ($findeProductPropId) {
            $findeProductPropId->value = $request->images;
            $findeProductPropId->user_id = $request->user_id;
            $findeProductPropId->source = $request->source;
            $findeProductPropId->save();
        }else{
            $findeProductPropId = new ProductPropertyList();
            $findeProductPropId->propertyId = $findeImagesPropertyId->id;
            $findeProductPropId->productId = $id;
            $findeProductPropId->value = $request->images;
            $findeProductPropId->user_id = $request->user_id;
            $findeProductPropId->source = $request->source;
            $findeProductPropId->save();
        }
        if ($request->images == '') {
            $findeProductPropId->delete();
        }else{}
        return redirect('/cpa/shop/product-list/'.$id.'/edit')->with('success','Товар успешно отредактирован');
    }

    public function saveProp (Request $request, $id) {
        $imagesPropId = ProductProperty::where('name', '=', 'Галерея')->first();
        if($request->productPropertyId) {
            $allProductPropId = ProductPropertyList::where('productId', '=', $id)->where('propertyId', '!=', $imagesPropId->id)->get();
            if ($allProductPropId) {
                foreach ($allProductPropId as $allProductPropIdItem) {
                    $allProductPropIdItem->delete();
                }
            }
            $countProp = 0;
            foreach ($request->productPropertyId as $productPropertyItem) {
                $productPropertyList = new ProductPropertyList();
                $productPropertyList->propertyId = $productPropertyItem;
                $productPropertyList->productId = $id;
                $productPropertyList->value = $request->productPropertyValue[$countProp];
                $productPropertyList->user_id = $request->user_id;
                $productPropertyList->source = $request->source;
                $productPropertyList->save();
                $countProp++;
            }
        }else {
            $allProductPropId = ProductPropertyList::where('productId', '=', $id)->where('propertyId', '!=', $imagesPropId->id)->get();
            if ($allProductPropId) {
                foreach ($allProductPropId as $allProductPropIdItem) {
                    $allProductPropIdItem->delete();
                }
            }
        }
        return redirect('/cpa/shop/product-list/'.$id.'/edit')->with('success','Товар успешно отредактирован');
    }

    public function updateHiddenStatus(Request $request)
    {
        $product = ProductList::find($request->prodId);
        $hiddenStatus = $product->isHidden;
        if ($hiddenStatus==0) {
            $product->isHidden=1;
        }else {
            $product->isHidden=0;
        }
        $product->save();
        return response()->json($product);
    }
}
