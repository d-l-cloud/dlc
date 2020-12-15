<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News\NewsCategory;
use App\Models\News\News;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(storage_path());

        $news = News::with(['category','user'])->get();
        return view('admin.news.list')
            ->with('news', $news);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.add', [
                'categories' => NewsCategory::all(),
                'news'=>new News()]
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
        $this->validate($request, News::rules(), [], News::attributeNames());
        $news = new News();
        $news->fill($request->all())->save();
        return redirect()->route('admin.news-list.index')->with('success','Новость успешно добавлена');
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
        $news = News::find($id);
        if (!$news){
            return redirect()->route('admin.news-list.index')->with('warning','Новость с данным id не найдена');
        }
        return view('admin.news.add',[
            'categories' => NewsCategory::all(),
            'news'=>$news
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
        $news = News::find($id);
        $this->validate($request, News::rules(), [], News::attributeNames());
        $news->fill($request->all())->save();
        return redirect()->route('admin.news-list.index')->with('success','Новость успешно отредактирована');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::find($id);
        if ($news) {
            if ($news->image) {
                Storage::delete('public' . $news->image);
            }
            $news->delete();
        }
        return redirect()->route('admin.news-list.index')->with('delete','Новость успешно удалена');
    }

    public function getNewsById($id)
    {
        $news = News::find($id);
        return response()->json($news);
    }

    public function updateHiddenStatus(Request $request)
    {
        $news = News::find($request->newsId);
        $hiddenStatus = $news->isHidden;
        if ($hiddenStatus==0) {
            $news->isHidden=1;
        }else {
            $news->isHidden=0;
        }
        $news->save();
        return response()->json($news);
    }
}
