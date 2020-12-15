<?php

namespace App\Widgets;

use App\Models\Site\SiteMenu;
use Arrilot\Widgets\AbstractWidget;

class menuFooter extends AbstractWidget
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
        $getMenu = SiteMenu::getCategories('bottom');
        $menuCount=ceil($getMenu->count()/3);
        return view('widgets.menu_footer', [
            'config' => $this->config,
        ])->with('menuCount', $menuCount)
            ->with('getMenu', $getMenu);
    }
}
