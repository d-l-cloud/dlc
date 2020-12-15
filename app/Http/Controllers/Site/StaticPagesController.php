<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Admin\SiteStaticPagesMenu;
use App\Models\Page\StaticPage;
use App\Models\Site\SiteMenu;
use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function index(Request $request)
    {
        $findeMenu = SiteMenu::where('id','=',$request->i)->where('slug','=',$request->route('pagesName'))->firstOrFail();
        $findeStaticPagesId = SiteStaticPagesMenu::where('menuId','=',$findeMenu->id)->firstOrFail();
        $getPagesData = StaticPage::where('id','=',$findeStaticPagesId->pagesId)->firstOrFail();
        return view('site.staticPages')
            ->with('getPagesData', $getPagesData);
    }
}
