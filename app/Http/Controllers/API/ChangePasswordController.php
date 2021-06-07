<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

        $request->validate([
            'email' => ['required'],
            'current_password' => ['required'],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        if(!empty($request->email)){
            $user = User::where('email',$request->email) -> first();
            if(empty($user)){
                return $this->sendError('Unauthorised.', array('Invalid email or user'));
            }
        }
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->current_password])){  
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['user_id'] =  $user->id; 
            $newpassword = User::find($user->id)->update(['password'=> Hash::make($request->new_password)]);
            echo "<pre>";
            print_r($newpassword);
            echo "</pre>";
            die();
            return $this->sendResponse($newpassword, 'Password Change Successfully');
        }
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
