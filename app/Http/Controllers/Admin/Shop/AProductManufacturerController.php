<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\ProductList;
use App\Models\Shop\ProductVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AProductManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendorList = ProductVendor::with(['user','product'])->orderBy('name')->get();
        return view('admin.shop.productManufacturerList')
            ->with('vendorList', $vendorList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shop.productManufacturerAdd', [
            'vendor'=>new ProductVendor()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ProductVendor::rules(), [], ProductVendor::attributeNames());
        $vendor = new ProductVendor();
        $vendor->fill($request->all())->save();
        return redirect()->route('admin.product-manufacturer.index')->with('success','Производитель успешно добавлен');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = ProductVendor::find($id);
        if (!$vendor){
            return redirect()->route('admin.product-manufacturer.index')->with('warning','Производитель с данным id не найден');
        }
        return view('admin.shop.productManufacturerAdd',[
            'vendor'=>$vendor
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
        $vendor = ProductVendor::find($id);
        $this->validate($request, ProductVendor::rulesEdit($id), [], ProductVendor::attributeNames());
        $vendor->fill($request->all())->save();
        return redirect()->route('admin.product-manufacturer.index')->with('success','Производитель успешно отредактирован');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = ProductVendor::find($id);
        if ($vendor->source!='DL') {
            if ($vendor->images) {

                            }
            $findeRaznoeId = ProductVendor::where('name', '=','NoName')->first();
            if ($findeRaznoeId){
                $allProductDeleteId = ProductList::where('vendorCode', '=',$id)->get();
                if ($allProductDeleteId){
                    foreach ($allProductDeleteId as $allProductDeleteIdItem) {
                        $allProductDeleteIdItem->vendorCode = $findeRaznoeId->id;
                        $allProductDeleteIdItem->save();
                    }
                }
            }
            $vendor->delete();

        }
        return redirect()->route('admin.product-manufacturer.index')->with('delete','Производитель успешно удален');
    }

    public function updateHiddenStatus(Request $request)
    {
        $vendor = ProductVendor::find($request->manId);
        $hiddenStatus = $vendor->isHidden;
        if ($hiddenStatus==0) {
            $vendor->isHidden=1;
        }else {
            $vendor->isHidden=0;
        }
        $vendor->save();
        return response()->json($vendor);
    }
}
