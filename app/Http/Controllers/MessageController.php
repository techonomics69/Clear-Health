<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseManagement;
use App\Models\MdMessages;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $mdList = DB::table('md_messages')
                    ->select(DB::raw('count(case_id) as case_id'))
                    ->groupBy('case_id')
                    ->get();
                //  DB::table('md_messages')
                // ->groupBy('case_id')                
                // ->get();
        
        dd($mdList);
        $msg_tab = '';
        $msg_history = [];
        $user_case_management_data['user_id'] = '';
        $user_case_management_data['id'] = '';
        return view('messages.index', compact('msg_tab', 'msg_history', 'user_case_management_data', 'mdList'));
    }
}
