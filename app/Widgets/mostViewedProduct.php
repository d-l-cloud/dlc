<?php

namespace App\Widgets;

use App\Models\Shop\ProductList;
use Arrilot\Widgets\AbstractWidget;

class mostViewedProduct extends AbstractWidget
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
        $productList = ProductList::orderByDesc('views')->where("isHidden",'!=', 1)->limit(10)->get();
        return view('widgets.most_viewed_product', [
            'config' => $this->config,
        ])->with('productList', $productList);
    }
}
