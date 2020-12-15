<?php

namespace App\Widgets;

use App\Models\Site\SiteMenu;
use Arrilot\Widgets\AbstractWidget;

class menuHeader extends AbstractWidget
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
        $getMenu = SiteMenu::getCategories('top');
        return view('widgets.menu_header', [
            'config' => $this->config,
        ])->with('getMenu', $getMenu);
    }
}
