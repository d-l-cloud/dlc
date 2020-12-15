<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\ProductProperty;
use App\Models\Shop\ProductPropertyList;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AProductPropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $property = ProductProperty::with(['user'])->orderBy('name')->get();
        return view('admin.shop.productPropertyList')
            ->with('property', $property);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shop.productPropertyAdd', [
                'property'=>new ProductProperty()]
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
        $this->validate($request, ProductProperty::rulesAdd(), [], ProductProperty::attributeNames());
        $property = new ProductProperty();
        $property->name = $request->name;
        $property->slug = Str::slug($request->slug, '_');
        $property->user_id = $request->user_id;
        $property->source = $request->source;
        $property->save();
        return redirect()->route('admin.product-properties.index')->with('success','Свойство успешно добавлено');
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
        $property = ProductProperty::find($id);
        if (!$property){
            return redirect()->route('admin.product-properties.index')->with('warning','Свойство с данным id не найдено');
        }
        return view('admin.shop.productPropertyAdd',[
            'property' => $property
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
        $property = ProductProperty::find($id);
        $this->validate($request, ProductProperty::rulesEdit($id), [], ProductProperty::attributeNames());
        $property->name = $request->name;
        $property->slug = Str::slug($request->slug, '_');
        $property->user_id = $request->user_id;
        $property->updated_at = now();
        $property->save();
        return redirect()->route('admin.product-properties.index')->with('success','Свойство успешно изменено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = ProductProperty::find($id);
        if ($property->source!='DL') {
            $findeProductPropertyId = ProductPropertyList::where('propertyId', '=',$id)->get();
                if ($findeProductPropertyId){
                    foreach ($findeProductPropertyId as $findeProductPropertyId) {
                        $findeProductPropertyId->delete();
                    }
                }
            $property->delete();
        }
        return redirect()->route('admin.product-properties.index')->with('delete','Свойство успешно удалено');
    }

    public function updatePropertiesSimilar(Request $request)
    {
        $res=null;
        $similar = ProductProperty::where('name','like','%'.$request->title.'%')->limit(5)->get();
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
