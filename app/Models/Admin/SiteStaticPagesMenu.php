<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteStaticPagesMenu extends Model
{
    use HasFactory;
    protected $fillable = ['menuId', 'pagesId', 'user_id', 'isHidden'];
}
