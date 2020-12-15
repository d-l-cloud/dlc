<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News\News;
use App\Models\News\NewsCategory;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminNewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $category = NewsCategory::with(['news'])->orderBy('title', 'desc')->get();
        return view('admin.news.categoryList')
            ->with('category', $category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.categoryAdd', [
                'category'=>new NewsCategory()]
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
        $this->validate($request, NewsCategory::rulesAdd(), [], NewsCategory::attributeNames());

        $category = new NewsCategory();
        $category->title = $request->title;
        $category->slug = Str::slug($request->slug, '_');
        $category->save();
        return redirect()->route('admin.news-categories.index')->with('success','Категория успешно добавлена');
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


        $category = NewsCategory::find($id);
        if (!$category){
            return redirect()->route('admin.news-categories.index')->with('warning','Категория с данным id не найдена');
        }
        return view('admin.news.categoryAdd',[
            'category' => $category
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
        $category = NewsCategory::find($id);
        $this->validate($request, NewsCategory::rulesEdit($id), [], NewsCategory::attributeNames());
        $category->title = $request->title;
        $category->slug = Str::slug($request->slug, '_');
        $category->updated_at = now();
        $category->save();
        return redirect()->route('admin.news-categories.index')->with('success','Категория успешно изменена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = NewsCategory::find($id);
        if ($category) {
            $category->delete();
        }
        return redirect()->route('admin.news-categories.index')->with('delete','Категория и связанные новости успешно удалены.');
    }

    public function updateCategorySlug(Request $request)
    {
        $slug = Str::slug($request->title, '_');
        return response()->json(['slug' => $slug]);
    }
}
