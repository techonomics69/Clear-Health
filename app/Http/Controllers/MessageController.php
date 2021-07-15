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
        DB::enableQueryLog();
        $mdList = DB::table('md_messages')
                    ->join('users', 'users.id', '=', 'md_messages.user_id')
                    ->select(DB::raw('count(*) as user_count, md_messages.user_id, users.first_name, users.last_name, md_messages.case_id'),
                    DB::raw('(SELECT m.text from md_messages as m where m.user_id=users.id group by m.user_id) as last_msg'))                    
                    ->groupBy('md_messages.user_id')
                    ->get();
                //  DB::table('md_messages')
                // ->groupBy('case_id')                
                // ->get(); 
                dd(DB::getQueryLog());
                dd($mdList);       
        $msg_tab = '';
        $msg_history = [];
        $user_case_management_data['user_id'] = '';
        $user_case_management_data['id'] = '';
        return view('messages.index', compact('msg_tab', 'msg_history', 'user_case_management_data', 'mdList'));
    }
}
