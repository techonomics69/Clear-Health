<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseManagement;
use App\Models\MdMessages;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Reflector;
use App\Models\Messages;

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
        $adminMsg = Messages::join('users', 'users.id', '=', 'messages.user_id')
            ->select(
                DB::raw('count(*) as user_count, messages.user_id, users.first_name, users.last_name, messages.case_id'),
                DB::raw('(SELECT m.text from messages as m where m.user_id=users.id order by m.id desc limit 1) as last_msg'),
                DB::raw('(SELECT m.created_at from messages as m where m.user_id=users.id order by m.id desc limit 1) as msg_time')
            )
            ->groupBy('messages.user_id')
            ->orderBy('messages.id', 'DESC')
            ->get();
        foreach ($adminMsg as $key => $value) :
            $createdAt = Carbon::parse($value->msg_time);
            $value->msg_time =  $createdAt->format('H:i:s m/d/Y');
        endforeach;

        $user_case_management_data['user_id'] = '';
        $user_case_management_data['id'] = '';
        return view('messages.index', compact('user_case_management_data', 'mdList', 'adminMsg'));
    }

    public function getMedicalMessage(Request $request)
    {
        $data = $request->all();
        $message = DB::table('md_messages')
            ->where('case_id', $data['case_id'])
            ->join('users', 'users.id', '=', 'md_messages.user_id')
            ->get();
        $username = '<b>' . $message[0]->first_name . ' ' . $message[0]->last_name . '</b>';

        $html = '';
        foreach ($message as $key => $value) :
            $createdAt = Carbon::parse($value->message_created_at);
            $time =  $createdAt->format('H:i:s m/d/Y');
            if ($value->from == 'patient') :
                $class =  'left';
            else :
                $class =  'right';
            endif;
            $html .= '<li class="' . $class . '">
                    <div class = "time_messages" > 
                        <p class = "text_mesg">' . $value->text . '</p>
                        <h5>' . $time . '</h5>
                    </div>
                </li>';
        endforeach;

        $data['html'] = $html;
        $data['username'] = $username;
        return json_encode($data);
    }
    public function getNonMedicalMessage(Request $request)
    {
        $data = $request->all();
        $message = DB::table('messages')
            ->where('user_id', $data['user_id'])
            ->join('users', 'users.id', '=', 'messages.user_id')
            ->select('users.first_name, users.last_name, messages.*')
            ->get();
        $username = '<b>' . $message[0]->first_name . ' ' . $message[0]->last_name . '</b>';
        $user_id = $message[0]->user_id;
        $html = '';
        foreach ($message as $key => $value) :
            echo '<pre>';
            print_r($value);
            die;
            $createdAt = Carbon::parse($value->created_at);
            $time =  $createdAt->format('H:i:s m/d/Y');
            if ($value->sender == 'user') :
                $class =  'left';
            else :
                $class =  'right';
            endif;
            $html .= '<li class="' . $class . '">
                    <div class = "time_messages" > 
                        <p class = "text_mesg">' . $value->text . '</p>
                        <h5>' . $time . '</h5>
                    </div>
                </li>';
        endforeach;

        $data['html'] = $html;
        $data['username'] = $username;
        $data['userId'] = $user_id;
        return json_encode($data);
    }
    public function sendNonMedicalMessage(Request $request)
    {
        $data = $request->all();
        $data['case_id'] = null;
        $data['md_case_id'] = 0;
        $data['users_message_type'] = 'Non-Medical';
        $data['sender'] = 'admin';

        $message = Messages::create($data);
        $createdAt = Carbon::now();
        $time =  $createdAt->format('H:i:s m/d/Y');
        $html = '<li class="right">
                    <div class="time_messages"> 
                        <p class="text_mesg">' . $data['text'] . '</p>
                        <h5>'.$time.'</h5>
                    </div>
                </li>';
        if ($message) {
            return json_encode($html);
        } else {
            return false;
        }
    }
}
