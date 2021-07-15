<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseManagement;
use App\Models\MdMessages;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $mdList = MdMessages::orderBy('id','DESC')->paginate(10);
        echo '<pre>';
        print_r($mdList);
        die;
        dd($mdList); 
        $msg_tab = '';
        $msg_history = [];
        $user_case_management_data['user_id'] = '';
        $user_case_management_data['id'] = '';
        return view('messages.index', compact('msg_tab', 'msg_history', 'user_case_management_data'));
    }
}
