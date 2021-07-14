<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $msg_tab = '';
        $msg_history = [];
        $user_case_management_data = [];
        return view('messages.index',compact('msg_tab', 'msg_history', 'user_case_management_data'));
    }
}
