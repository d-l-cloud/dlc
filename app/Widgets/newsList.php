<?php

namespace App\Widgets;

use App\Models\News\News;
use Arrilot\Widgets\AbstractWidget;

class newsList extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    public function placeholder()
    {
        return 'Загрузка...';
    }
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //
        $newsList = News::orderByDesc('id')->where("isHidden",'!=', 1)->limit(4)->get();
        return view('widgets.news_list', [
            'config' => $this->config,
        ])->with('newsList', $newsList);
    }
}
