<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SiteStaticPagesMenu;
use App\Models\Page\StaticPage;
use App\Models\Site\SiteMenu;
use Illuminate\Http\Request;




class AdminStaticPage extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $categoriesTop = SiteMenu::getCategories('top');
        $categoriesBottom = SiteMenu::getCategories('bottom');
        $getAllMenuName = SiteMenu::get();
        $staticPage = StaticPage::with(['user','siteMenus','siteStaticPagesMenus'])->get();
        return view('admin.page.static')
            ->withgetAllMenuName($getAllMenuName)
            ->withcategoriesTop($categoriesTop)
            ->withcategoriesBottom($categoriesBottom)
            ->with('staticPage', $staticPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $getAllStaticPageMenuId = SiteStaticPagesMenu::get()->where('id','!=',1);
        if ($getAllStaticPageMenuId->count()!=0) {
            foreach ($getAllStaticPageMenuId as $getAllStaticPageMenuId) {
                $getAllStaticPageMenuIdArray[]=$getAllStaticPageMenuId->menuId;
            }
        }else{
            $getAllStaticPageMenuIdArray[]=null;
        }
        $getThisStaticPageMenuIdArray[]=null;
        $categoriesTop = SiteMenu::getCategories('top');
        $categoriesBottom = SiteMenu::getCategories('bottom');

        return view('admin.page.addStatic')
            ->withgetAllStaticPageMenuIdArray($getAllStaticPageMenuIdArray)
            ->withgetThisStaticPageMenuIdArray($getThisStaticPageMenuIdArray)
            ->withcategoriesTop($categoriesTop)
            ->withcategoriesBottom($categoriesBottom)
            ->with('staticPage', new StaticPage());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, StaticPage::rules(), [], StaticPage::attributeNames());
        $staticPage = new StaticPage();
        if(($request->menu_id) AND ($staticPage->fill($request->except('menu_id'))->save())) {
            foreach ($request->menu_id as $menuItem) {
                $menuPagesList = new SiteStaticPagesMenu();
                $menuPagesList->menuId = $menuItem;
                $menuPagesList->pagesId = $staticPage->id;
                $menuPagesList->user_id = $request->user_id;
                $menuPagesList->save();
            }
        }else{}
        return redirect()->route('admin.list.index')->with('success','Страница успешно добавлена');
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

        $getAllStaticPageMenuId = SiteStaticPagesMenu::get();
        if ($getAllStaticPageMenuId->count()!=0) {
            foreach ($getAllStaticPageMenuId as $getAllStaticPageMenuId) {
                $getAllStaticPageMenuIdArray[]=$getAllStaticPageMenuId->menuId;
            }
        }else{
            $getAllStaticPageMenuIdArray[]=null;
        }

        $getThisStaticPageMenuId = SiteStaticPagesMenu::where('pagesId','=',$id)->get();
        if ($getThisStaticPageMenuId->count()!=0) {
            foreach ($getThisStaticPageMenuId as $getThisStaticPageMenuId) {
                $getThisStaticPageMenuIdArray[]=$getThisStaticPageMenuId->menuId;
            }
        }else{
            $getThisStaticPageMenuIdArray[]=null;
        }


        $categoriesTop = SiteMenu::getCategories('top');
        $categoriesBottom = SiteMenu::getCategories('bottom');

        $staticPage = StaticPage::find($id);
        if (!$staticPage){
            return redirect()->route('admin.list.index')->with('warning','страница с данным id не найдена');
        }
        return view('admin.page.addStatic')
            ->withgetAllStaticPageMenuIdArray($getAllStaticPageMenuIdArray)
            ->withgetThisStaticPageMenuIdArray($getThisStaticPageMenuIdArray)
            ->withcategoriesTop($categoriesTop)
            ->withcategoriesBottom($categoriesBottom)
            ->with('staticPage', $staticPage);
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
        $staticPage = StaticPage::find($id);
        $this->validate($request, StaticPage::rules(), [], StaticPage::attributeNames());
        if(($request->menu_id) AND ($staticPage->fill($request->except('menu_id'))->save())) {
            $allPageMenuId = SiteStaticPagesMenu::where('pagesId', '=', $id)->get();
            if ($allPageMenuId) {
                foreach ($allPageMenuId as $allPageMenuIdIdItem) {
                    $allPageMenuIdIdItem->delete();
                }
            }
            foreach ($request->menu_id as $menuItem) {
                $menuPagesList = new SiteStaticPagesMenu();
                $menuPagesList->menuId = $menuItem;
                $menuPagesList->pagesId = $staticPage->id;
                $menuPagesList->user_id = $request->user_id;
                $menuPagesList->save();
            }
        }else{}
        return redirect()->route('admin.list.index')->with('success','Страница успешно отредактирована');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staticPage = StaticPage::find($id);
        if ($staticPage) {
            $staticPage->delete();
        }
        return redirect()->route('admin.list.index')->with('delete','Страница успешно удалена');
    }

    public function updateHiddenStatus(Request $request)
    {
        $staticPage = StaticPage::find($request->newsId);
        $hiddenStatus = $staticPage->isHidden;
        if ($hiddenStatus==0) {
            $staticPage->isHidden=1;
        }else {
            $staticPage->isHidden=0;
        }
        $staticPage->save();
        return response()->json($staticPage);
    }
}
