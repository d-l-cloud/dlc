<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Profile;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId=Auth::user()->id;
        $userMainInfo = User::find($userId);
        $userProfileInfo = $userMainInfo->profile;
        return view('user.profile')
            ->with('userMainInfo', $userMainInfo)
            ->with('userProfileInfo', $userProfileInfo);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function profileAjaxEdit(Request $request){
        $userMainInfo = User::where('id', '=', Auth::user()->id)->firstOrFail();
        if($userMainInfo) {
            $userProfileInfo = $userMainInfo->profile;
            $userProfileInfo->name = !empty($request->name)? $request->name : 'Залупа коня';
            $userProfileInfo->surname = $request->surname;
            $userProfileInfo->middle_name = $request->middle_name;
            $userProfileInfo->phone = $request->phone;
            $userProfileInfo->save();
            return response()->json($userProfileInfo);
        }
        $userProfileInfo = $userMainInfo->profile;
        return response()->json($userProfileInfo,404);
    }
}
