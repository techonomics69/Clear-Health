<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Exception;

class ChangePasswordController extends BaseController
{

    public function __construct()
    {
        //
    }
    
    public function index()
    {
        return view('changePassword');
    }

    public function create()
    {

    }


    public function changePassword(Request $request)
    {
        /*die("test");*/
        $request->validate([
            'email' => ['required'],
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   

  /* echo "<pre>";
   print_r($request->all());
   echo "</pre>";
   die();*/
        $user = Auth::user(); 
        $success['token'] =  $user->createToken('MyApp')->accessToken; 
        //$newpassword = User::find($id)->update(['password'=> Hash::make($request->new_password)]);
                        $newpassword=User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
    return $this->sendResponse($newpassword, 'Password Change Successfully');
        //return redirect()->route('change.index')->with('message', 'Password change successfully.');
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

}
