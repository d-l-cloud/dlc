<?php

namespace App\Http\Controllers;

use App\Models\Shop\ProductList;
use Illuminate\Http\Request;
use App\Models\Site\SiteForm;

class SiteFormRecaptcha extends Controller
{
    public function index(Request $request)
    {
        if ($request->route('questionType')==1) {
            $questionTypeName = 'Оптовые цены';
        }elseif($request->route('questionType')==2) {
            $questionTypeName = 'Обратный звонок';
        }else {
            $questionTypeName = 'Связаться с нами';
        }
        if ($request->route('productName')!=0) {
            $getProductName = ProductList::where('article', '=', $request->route('productName'))->firstOrFail();
            $productName=$getProductName->name;
        }else{
           $productName='Без товара';
        }

        return view('form')
            ->with('questionTypeName', $questionTypeName)
            ->with('productName', $productName);
    }
    public function store(Request $request)
    {

        $this->validate($request, SiteForm::rules(), [], SiteForm::attributeNames());
        $save = new SiteForm();
        $save->questionType = $request->questionType;
        $save->productName = $request->productName;
        $save->name = $request->name;
        $save->email = $request->email;
        $save->phone = $request->phone;
        $save->text = $request->text;
        $save->save();
        return redirect('siteform/0/0')->with('status', 'Запрос успешно отправлен, менеджер свяжется с вами в ближайшее время');
    }
}
