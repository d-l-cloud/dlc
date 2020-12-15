<?php

namespace App\Http\Controllers\Admin;

use App\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;

class AdminIndexController extends Controller
{
    public function index()
    {
        //$user=DB::table('users_roles')->where(Auth::user()->id);

        //dd($user->roles);
        //dd(Helpers::settings('zalup'));


        //dd($userRoleList);
        /*foreach ($user->permissions as $permissions)  {
            //echo $permissions->id;
        }*/
        return view('admin.main');
    }
}
