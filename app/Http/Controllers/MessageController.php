<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseManagement;
use App\Models\MdMessages;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Reflector;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        // DB::enableQueryLog();
        $mdList = DB::table('md_messages')
            ->join('users', 'users.id', '=', 'md_messages.user_id')
            ->select(
                DB::raw('count(*) as user_count, md_messages.user_id, users.first_name, users.last_name, md_messages.case_id'),
                DB::raw('(SELECT m.text from md_messages as m where m.user_id=users.id order by m.id desc limit 1) as last_msg'),
                DB::raw('(SELECT m.created_at from md_messages as m where m.user_id=users.id order by m.id desc limit 1) as msg_time')
            )
            ->groupBy('md_messages.user_id')
            ->orderBy('md_messages.id', 'desc')
            ->get();
        foreach ($mdList as $key => $value) :
            $createdAt = Carbon::parse($value->msg_time);
            $value->msg_time =  $createdAt->format('H:i:s m/d/Y');
        endforeach;
        //dd($mdList);               
        $msg_tab = '';
        $msg_history = [];
        $user_case_management_data['user_id'] = '';
        $user_case_management_data['id'] = '';
        return view('messages.index', compact('msg_tab', 'msg_history', 'user_case_management_data', 'mdList'));
    }

    public function getMedicalMessage(Request $request)
    {
        $data = $request->all();
        $message = MdMessages::where('case_id', $data['case_id'])->get();

        $html = '';
        foreach($message as $key => $value):
            dd($value);
            $html.= '<li class="left">
                    <div class = "time_messages" > 
                        <p class = "text_mesg">'.$value->text.'</p>
                        <h5></h5>
                    </div>
                </li>';
        endforeach;
        
                    
        return json_encode($html);
    }
}
