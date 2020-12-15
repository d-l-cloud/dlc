<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\News\News;
use Illuminate\Http\Request;

class ShowNewsController extends Controller
{
    public function index()
    {
        $NewsList = News::where("isHidden",'!=', 1)->paginate(8);;
        return view('news.showNewsList')
            ->with('NewsList',$NewsList);
    }
    public function show(Request $request)
    {
        $newsId=$request->route('id');
        $NewsData = News::where("id", $newsId)->where("isHidden",'!=', 1)->firstOrFail();
        $NewsData->views = $NewsData->views+1;
        $NewsData->save();
        return view('news.showNews')
            ->with('NewsData',$NewsData);
    }
}
