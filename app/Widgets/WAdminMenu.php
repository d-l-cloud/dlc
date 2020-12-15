<?php

namespace App\Widgets;

use App\Models\Admin\AdminMenu;
use Arrilot\Widgets\AbstractWidget;

class WAdminMenu extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $categories = AdminMenu::getCategories()->where('status','=','1');
        return view('widgets.admin_menu', [
            'config' => $this->config,
        ])->with('categoriesTop', $categories);
    }
}
