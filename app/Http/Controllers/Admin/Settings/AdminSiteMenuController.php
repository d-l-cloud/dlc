<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminMenu;
use App\Models\Admin\SiteStaticPagesMenu;
use App\Models\Page\StaticPage;
use App\Models\Site\SiteMenu;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSiteMenuController extends Controller
{
    public function index()
    {$categoriesTop = SiteMenu::getCategories('top');
        $categoriesBottom = SiteMenu::getCategories('bottom');
        return view('admin.settings.menu.list')
            ->withcategoriesTop($categoriesTop)
            ->withcategoriesBottom($categoriesBottom);

    }
    public function create()
    {
        return view('admin.settings.menu.add')
            ->with('SiteMenu', new SiteMenu());

    }
    public function store(Request $request)
    {
        $menuList = new SiteMenu();
        $menuList->name = $request->name;
        $menuList->parent_id = 0;
        $menuList->slug = $request->slug;
        $menuList->place = $request->place;
        $menuList->sorting = 1;
        $menuList->save();
        return redirect()->route('admin.settings.menu')->with('success','Пункт меню успешно добавлен');

    }

    public function deleteMenu(Request $request)
    {
        $menuId = SiteMenu::where('id', '=', $request->menuId)->first();
        if ($menuId) {
            /*if ($menuId->parent_id!=0) {
                $staticPages = SiteStaticPagesMenu::where('menuId', '=', $menuId->id)->first();
                if ($staticPages) {
                    $staticPages->menu_id = 1;
                    $staticPages->save();
                    $menuId->delete();
                }
            }
            else {
                $childFindeAll = SiteMenu::where('parent_id', '=', $request->menuId)->first();
                if ($childFindeAll) {
                    $childFinde = SiteMenu::where('parent_id', '=', $request->menuId)->get();
                    foreach ($childFinde as $childItem) {
                        $staticPages = SiteStaticPagesMenu::where('menuId', '=', $childItem->id)->first();
                        if ($staticPages) {
                            $staticPages->menu_id = 1;
                            $staticPages->save();
                            $subMenuId = SiteMenu::where('id', '=', $childItem->id)->first();
                            if ($subMenuId) {
                                $subMenuId->parent_id = 0;
                                $subMenuId->save();
                            }

                        }
                    }
                    $staticPagesParent = SiteStaticPagesMenu::where('menuId', '=', $menuId->id)->get();
                    if ($staticPagesParent->count()>0) {
                        foreach ($staticPagesParent as $staticPagesParent) {
                            $staticPagesParent->menu_id = 1;
                            $staticPagesParent->save();
                        }
                    }
                }
                $staticPagesParent = SiteStaticPagesMenu::where('menuId', '=', $menuId->id)->get();
                if ($staticPagesParent->count()>0) {
                    foreach ($staticPagesParent as $staticPagesParent) {
                        $staticPagesParent->menu_id = 1;
                        $staticPagesParent->save();
                    }
                }
                $menuId->delete();
            }*/
            $staticPagesParent = SiteStaticPagesMenu::where('menuId', '=', $menuId->id)->get();
            if ($staticPagesParent->count()>0) {
                foreach ($staticPagesParent as $staticPagesParent) {
                    $staticPagesParent->delete();
                }
            }
            $menuId->delete();
            $categoriesTop = SiteMenu::getCategories('top');
            $returnData = ['status'=>'error', 'megfhs' => '<li>Ok!</li>', 'menu' => $categoriesTop];
            return response()->json($returnData,200);
        }
        $categoriesTop = SiteMenu::getCategories('top');
        $returnData = ['status'=>'error', 'megfhs' => 'Ok!', 'data' => $categoriesTop];
        return response()->json($returnData,422);
    }

    public function sortingMenu(Request $request)
    {
        $menuId = SiteMenu::where('id', '=', $request->menuId)->first();
        if ($menuId) {
            $menuId->sorting = $request->menuSorting;
            $menuId->save();
            $categoriesTop = SiteMenu::getCategories('top');
            $categoriesBottom = SiteMenu::getCategories('bottom');
            $returnData = ['status'=>'error', 'megfhs' => '<li>Ok!</li>', 'menuTop' => $categoriesTop, 'menuBottom' => $categoriesBottom];
            return response()->json($returnData,200);
        }
        $categoriesTop = SiteMenu::getCategories('top');
        $returnData = ['status'=>'error', 'megfhs' => 'Ok!', 'data' => $categoriesTop];
        return response()->json($returnData,422);
    }
}
