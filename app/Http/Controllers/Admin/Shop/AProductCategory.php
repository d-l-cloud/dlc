<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\ProductList;
use Illuminate\Http\Request;
use App\Models\Shop\ProductCategory;
use Illuminate\Support\Str;

class AProductCategory extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productParentCategories = ProductCategory::where('parent_id', '=', '0')->orderBy('name')->get();
        foreach ($productParentCategories as $productParentCategories){
            $productParentCategoriesData[$productParentCategories->id]['id'] = $productParentCategories->id;
            $productParentCategoriesData[$productParentCategories->id]['name'] = $productParentCategories->name;
        }
        $productCategories = ProductCategory::with(['user','productList'])->orderBy('name')->get();
        return view('admin.shop.productCategoriesList')
            ->with('productParentCategoriesData', $productParentCategoriesData)
            ->with('productCategories', $productCategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productParentCategories = ProductCategory::where('parent_id', '=', '0')->orderBy('name')->get();
        return view('admin.shop.productCategoriesAdd', [
                'productParentCategories'=>$productParentCategories,
                'productCategories'=>new ProductCategory()]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ProductCategory::rulesAdd(), [], ProductCategory::attributeNames());
        $category= new ProductCategory();
        $category->parent_id = $request->parentId;
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug, '_');
        $category->user_id = $request->user_id;
        $category->source = $request->source;
        $category->save();
        return redirect()->route('admin.product-categories.index')->with('success','Категория успешно добавлена');
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
        $productParentCategories = ProductCategory::where('parent_id', '=', '0')->orderBy('name')->get();
        $productCategories = ProductCategory::find($id);
        if (!$productCategories){
            return redirect()->route('admin.product-categories.index')->with('warning','Категория с данным id не найдена');
        }
        return view('admin.shop.productCategoriesAdd',[
            'productParentCategories'=>$productParentCategories,
            'productCategories' => $productCategories
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
        $category = ProductCategory::find($id);
        $categoryParentId = (int)$category->parent_id;
        $categoryId = (int)$category->id;
        $this->validate($request, ProductCategory::rulesEdit($id), [], ProductCategory::attributeNames());
        $category->parent_id = (int)$request->parentId;
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug, '_');
        $category->user_id = $request->user_id;
        $category->source = $request->source;
        $category->updated_at = now();
        $category->save();
        if (($categoryParentId==0) AND ($request->parentId!=0)) {

                $findeCategory = ProductCategory::where('parent_id', '=',$categoryId)->get();
                if ($findeCategory){
                    foreach ($findeCategory as $findeCategoryIdItem) {
                        $findeCategoryIdItem->parent_id = 0;
                        $findeCategoryIdItem->save();
                    }
                }
        }

        return redirect()->route('admin.product-categories.index')->with('success','Категория успешно изменена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = ProductCategory::find($id);
        if ($category->source!='DL') {
            if ($category->parent_id==0) {
                $findeCategory = ProductCategory::where('parent_id', '=',$category->id)->get();
                if ($findeCategory){
                    foreach ($findeCategory as $findeCategoryIdItem) {
                        $findeCategoryIdItem->parent_id = 0;
                        $findeCategoryIdItem->save();
                    }
                }
            }
            $findeCategoryId = ProductCategory::where('name', '=', 'Разное')->first();
            $findeProductCategoryId = ProductList::where('productCategoryId', '=',$category->id)->get();
            if ($findeProductCategoryId){
                foreach ($findeProductCategoryId as $findeProductCategoryId) {
                    $findeProductCategoryId->productCategoryId = $findeCategoryId->id;
                    $findeProductCategoryId->save();
                }
            }
            $category->delete();
        }
        return redirect()->route('admin.product-categories.index')->with('delete','Категория успешно удалена');
    }

    public function updateCategoriesSimilar(Request $request)
    {
        $res=null;
        $similar = ProductCategory::where('name','like','%'.$request->title.'%')->where('parent_id','!=','0')->limit(5)->get();
        if ($similar){
            foreach ($similar as $similar){
                $res[]=$similar->name;
            }

        }else{
            $res[]=1;
        }
        $res = implode('<br>', $res);
        return response()->json(['similar' => $res]);
    }
}
