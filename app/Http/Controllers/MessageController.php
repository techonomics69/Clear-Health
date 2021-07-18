<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseManagement;
use App\Models\MdMessages;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Reflector;
use App\Models\Messages;
use App\Models\MessageFiles;

class MessageController extends Controller
{
    public function index(Request $request)
    {

        $user_case_management_data = CaseManagement::join('users', 'case_managements.user_id', '=', 'users.id')->leftjoin('case_histories', 'case_managements.id', '=', 'case_histories.case_id')->select('case_managements.*', 'users.email', 'users.first_name', 'users.last_name', 'users.gender', 'case_histories.case_status')->OrderBy('id', 'DESC')->get();
        //generate_ipledge, store_ipledge, verify_pregnancy, prior_auth, check_off_ipledge, trigger, blood_work
        return view('messages.index', compact('user_case_management_data'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function show(Request $request)
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
            ->orderBy('msg_time', 'desc')
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
                DB::raw('(SELECT m.created_at from messages as m where m.user_id=users.id order by m.id desc limit 1) as msg_time'),
            )
            ->groupBy('messages.user_id')
            ->orderBy('msg_time', 'DESC')
            ->get();
        foreach ($adminMsg as $key => $value) :
            $createdAt = Carbon::parse($value->msg_time);
            $value->msg_time =  $createdAt->format('H:i:s m/d/Y');
        endforeach;

        $user_case_management_data['user_id'] = '';
        $user_case_management_data['id'] = '';
        return view('messages.view', compact('user_case_management_data', 'mdList', 'adminMsg'));
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
            if (isset($value->text)) :
                $createdAt = Carbon::parse($value->message_created_at);
                //$time =  $createdAt->format('H:i:s m/d/Y');
                $time =  $createdAt->diffForHumans();
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
            endif;
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
            ->join('users', 'messages.user_id', '=', 'users.id')
            ->join('message_files', 'messages.id', '=', 'message_files.msg_id')
            ->select('users.first_name', 'users.last_name', 'messages.user_id', 'messages.created_at', 'messages.text', 'messages.sender', 'message_files.file_path', 'message_files.mime_type')
            ->get();
          
        $username = '<b>' . $message[0]->first_name . ' ' . $message[0]->last_name . '</b>';
        $user_id = $message[0]->user_id;
        $html = '';
        foreach ($message as $key => $value) :            
            if (isset($value->text)) :
                $createdAt = Carbon::parse($value->created_at);
                // $time =  $createdAt->format('H:i:s m/d/Y');
                $time =  $createdAt->diffForHumans();
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
            endif;

            if(isset($value->file_path) && !empty($value->file_path)):
                $createdAt = Carbon::parse($value->created_at);
                // $time =  $createdAt->format('H:i:s m/d/Y');
                $time =  $createdAt->diffForHumans();
                if ($value->sender == 'user') :
                    $class =  'left';
                else :
                    $class =  'right';
                endif;
                $html .= '<li class="' . $class . '">
                    <div class = "time_messages" > 
                        <p class = "text_mesg">
                            <a href='.url('').'/'.$value->file_path.' target="_blank">
                            <img src='.url('').'/'.$value->file_path.' style="width:50px; height:50px; object-fit: contain;
                        }">
                            </a>
                        </p>
                        <h5>' . $time . '</h5>
                    </div>
                </li>';
            endif;
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
        $documents = $request->file('file');
        $message = Messages::create($data);
        //dd($request->file('file')->getSize());
        if (!empty($documents)) {
            $file =  $documents->getClientOriginalName();
            $doc_file_name =  time() . '-' . $file;
            $filesize = $this->convertToReadableSize($documents->getSize());
            if (count($filesize) > 0) {
                if ($filesize['sizin'] == "" || $filesize['sizin'] == "KB") {
                } else if ($filesize['sizin'] == "GB" || $filesize['sizin'] == "TB") {
                    return array("status" => false, "data" => '', "message" => "Please upload file less than 5MB");
                    exit();
                } else if ($filesize['sizin'] == "MB") {
                    if ($filesize['size'] > 5) {
                        return array("status" => false, "data" => '', "message" => "Please upload file less than 5MB");
                        exit();
                    }
                }
            }
            $file = $request['file'];
            if (!file_exists(public_path('/Message_files'))) {
                File::makeDirectory(public_path('/Message_files'), 0777, true, true);
            }
            $destinationPath = public_path('/Message_files');
            $documents->move($destinationPath, $doc_file_name);

            chmod($destinationPath . "/" . $doc_file_name, 0777);

            $file_path = 'public/Message_files/' . $doc_file_name;

            $file_mimeType = $documents->getClientMimeType();

            $message_file_data = array();
            $message_file_data['file_name'] = $doc_file_name;
            $message_file_data['file_path'] = $file_path;
            $message_file_data['mime_type'] = $file_mimeType;
            $message_file_data['msg_id'] = $message['id'];
            $message_file_data = MessageFiles::create($message_file_data);
        }


        $createdAt = Carbon::now();
        //$time =  $createdAt->format('H:i:s m/d/Y');
        $time =  $createdAt->diffForHumans();
        // $html = '';
        // $html .= '<li class="right">
        //             <div class="time_messages"> 
        //                 <p class="text_mesg">' . $data['text'] . '</p>
        //                 <h5>' . $time . '</h5>
        //             </div>
        //         </li>';
        // if (isset($message_file_data) && !empty($message_file_data)) :
            
            $html = '<li class="right">
                        <div class="time_messages"> 
                            <p class="text_mesg">img</p>
                            <h5>' . $time . '</h5>
                        </div>
                    </li>';
        // endif;

        if ($message) {
            return json_encode($html);
        } else {
            return false;
        }
    }

    function convertToReadableSize($size)
    {
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        $return = array("size" => round(pow(1024, $base - floor($base)), 1), "sizin" => $suffix[$f_base]);
        return $return;
    }
}
