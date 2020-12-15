<?php

namespace App\Widgets;

use App\Models\Shop\ProductVendor;
use Arrilot\Widgets\AbstractWidget;

class vendor extends AbstractWidget
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
        $vendor = ProductVendor::orderBy('name')->where("isHidden",'!=', 1)->get();
        return view('widgets.vendor', [
            'config' => $this->config,
        ])->with('vendor', $vendor);
    }
}
