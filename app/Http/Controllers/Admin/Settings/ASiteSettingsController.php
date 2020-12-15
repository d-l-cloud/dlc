<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Site\SiteSettings;
use Illuminate\Http\Request;

class ASiteSettingsController extends Controller
{
    public function index(){
        $settingsList = SiteSettings::first();
        return view('admin.settings.site-settings')
            ->with('settingsList', $settingsList);
    }
    public function edit(Request $request){
        $settings = SiteSettings::find($request->setId);
        $settings->city = $request->city;
        $settings->address = $request->address;
        $settings->emailNotifications = $request->emailNotifications;
        $settings->phone = $request->phone;
        $settings->workingHours = $request->workingHours;
        $settings->javaCode = $request->javaCode;
        $settings->user_id  = $request->user_id;
        $settings->updated_at = now();
        $settings->save();
        return redirect()->route('admin.settings.site')->with('success','Настройки сохранены');
    }
}
