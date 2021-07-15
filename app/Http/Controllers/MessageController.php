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
                    ->join('users', 'users.id', '=', 'md_messages.user_id')
                    ->select(DB::raw('count(*) as user_count, md_messages.user_id'))
                    ->groupBy('md_messages.user_id')
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
