<?php

namespace App\Widgets;

use App\Models\Shop\ProductCategory;
use Arrilot\Widgets\AbstractWidget;

class mobileSiteCatalogMenu extends AbstractWidget
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
        $categories = ProductCategory::getCategories();
        return view('widgets.mobile_site_catalog_menu', [
            'config' => $this->config,
        ])->with('categories', $categories);
    }
}
