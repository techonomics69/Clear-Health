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
use App\Models\SupportMessages;
use App\Models\SupportMessagesFiles;
use Illuminate\Support\Facades\Validator;


class MessageController extends Controller
{
    public function index(Request $request)
    {

        $user_case_management_data = CaseManagement::join('users', 'case_managements.user_id', '=', 'users.id')->leftjoin('case_histories', 'case_managements.id', '=', 'case_histories.case_id')->select('case_managements.*', 'users.email', 'users.first_name', 'users.last_name', 'users.gender', 'case_histories.case_status')->OrderBy('id', 'DESC')->get();
        //generate_ipledge, store_ipledge, verify_pregnancy, prior_auth, check_off_ipledge, trigger, blood_work
        return view('messages.index', compact('user_case_management_data'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function show($case_id, Request $request)
    {
        // DB::enableQueryLog();
        $case = CaseManagement::find($case_id);
        $md_case_id = $case->md_case_id;
        $mdList = DB::table('md_messages')
            ->where('case_id', $case_id)
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
            ->where('case_id', $case_id)
            ->select(
                DB::raw('count(*) as user_count, messages.user_id, users.first_name, users.last_name, messages.case_id'),
                DB::raw('(SELECT m.text from messages as m where m.user_id=users.id order by m.id desc limit 1) as last_msg'),
                DB::raw('(SELECT count(m.read_at) from messages as m where m.user_id=users.id and m.read_at="false" ) as new_msg'),
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
        return view('messages.view', compact('user_case_management_data', 'mdList', 'adminMsg', 'case_id', 'md_case_id'));
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
            ->leftjoin('message_files', 'messages.id', '=', 'message_files.msg_id')
            ->select('users.first_name', 'users.last_name', 'messages.user_id', 'messages.created_at', 'messages.text', 'messages.sender', 'message_files.file_path', 'message_files.mime_type')
            ->orderBy('messages.id')
            ->get();
        $update['read_at'] = 'true';
        $updateMsg = DB::table('messages')->where('user_id', $data['user_id'])->update($update);
        $username = '<b>' . $message[0]->first_name . ' ' . $message[0]->last_name . '</b>';
        $user_id = $message[0]->user_id;
        $html = '';
        foreach ($message as $key => $value) :

            if (isset($value->file_path) && !empty($value->file_path)) :
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
                            <a href=' . url('') . '/' . $value->file_path . ' target="_blank">
                            <img src=' . url('') . '/' . $value->file_path . ' style="width:50px; height:50px; object-fit: contain;
                        }">
                            </a>
                        </p>
                        <h5>' . $time . '</h5>
                    </div>
                </li>';
            endif;
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


        endforeach;

        $data['html'] = $html;
        $data['username'] = $username;
        $data['userId'] = $user_id;
        return json_encode($data);
    }
    public function sendNonMedicalMessage(Request $request)
    {
        $data = $request->all();
        $data['md_case_id'] = 0;
        $data['users_message_type'] = 'Non-Medical';
        $data['sender'] = 'admin';
        $documents = $request->file('file');
        $message = Messages::create($data);
        //dd($request->file('file')->getSize());
        $file_path = '';
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
        $time =  $createdAt->diffForHumans();     
        $result['time'] = $time;
        $result['file'] = $file_path;
        $result['text'] = $data['text'];
        $result['url'] = url('') . '/';
        if ($message) {
            return json_encode($result);
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


    public function sendSupportMessage(Request $request){
        
        $r = get_token();
        $token_data = json_decode($r);
        $token = $token_data->access_token;       
        $documents = $request->file('file');
        $name = $request->name;
        $user_id = $request->user_id;
        $case_id = $request->case_id;
        $system_case_id = $request->system_case_id;
    
        //validation 
        $data = $request->all(); 
        //$data['from'] = 'support';
        // $validator = Validator::make($data, [
        //   'user_id' => 'required',
        //   'case_id' => 'required',
        //   'system_case_id' => 'required',
        //   'text' => 'required',
        //   'from' => 'required',
        // ]);
        // if($validator->fails()){
        //   return $this->sendError('Validation Error.', $validator->errors()->all());       
        // }
        //end of validation
        // if(!empty($documents)){
        //   $file =  $documents->getClientOriginalName();
        //   $doc_file_name =  time().'-'.$file;
          
        //   if (!file_exists(public_path('/Message_files'))) {
        //     File::makeDirectory(public_path('/Message_files'),0777,true,true);
        //   }
        //   $destinationPath = public_path('/Message_files');
        //   $documents->move($destinationPath, $doc_file_name);
    
        //   chmod($destinationPath."/".$doc_file_name, 0777);
    
        //   $file_path = 'public/Message_files/' .$file;
    
        //   $fields = [
        //     'name' => $name,
        //     'file' => new \CurlFile($destinationPath."/".$doc_file_name)
        //   ];
    
    
        //   $input_data = $request->all();
    
    
        //   $curl = curl_init();
    
        //   curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/files',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS =>  $fields,
        //     CURLOPT_HTTPHEADER => array(
        //       'Content: multipart/form-data;',
        //       'Authorization: Bearer '.$token,
        //       'Cookie: __cfduid=db3bdfa9cd5de377331fced06a838a4421617781226'
        //     ),
        //   ));
    
        //   $response = curl_exec($curl);
    
        //   $message_file_data = json_decode($response);
        //   $input_data = array();
    
        //   $input_data['md_case_id'] = $case_id;
        //   $input_data['system_file'] = $file_path;
        //   $input_data['user_id'] = $user_id;
        //   $input_data['case_id'] = $system_case_id;
        //   $input_data['name'] = $message_file_data->name;
        //   $input_data['mime_type'] = $message_file_data->mime_type;
        //   $input_data['url'] = $message_file_data->url;
        //   $input_data['url_thumbnail'] = $message_file_data->url_thumbnail;
        //   $input_data['file_id'] = $message_file_data->file_id;
    
        //   $message_file_data = SupportMessagesFiles::create($input_data);
    
        // //create message
    
        // }
        $request1 = $request->except('_token');    
       
        echo '<pre>';
        print_r($request1->all());
        die;
        //code to get files ids
    
        $file_ids = array();
    
        if(!empty($message_file_data) && $message_file_data->file_id !=''){
          $file_ids[] = $message_file_data->file_id;
        }
        // end of code to get files ids
    
        $postfields = array();
        $postfields['from'] = $request->from;
        $postfields['text'] = $request->text; 
        if($request->prioritized == "true"){
          $postfields['prioritized'] =  true;
        }else{
          $postfields['prioritized'] =  false;
        }
        $postfields['prioritized_reason'] = $request->prioritized_reason;
        $postfields['message_files'] = $file_ids;
    
        $postfields = json_encode($postfields);
    
        $curl = curl_init();
    
       
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/cases/'.$case_id.'/messages',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$postfields,
        //   CURLOPT_HTTPHEADER => array(
        //     'Content-Type: application/json',
        //     'Authorization: Bearer '.$token,
        //     'Cookie: __cfduid=da01d92d82d19a6cccebfdc9852303eb81620627650'
        //   ),
        ));
    
        $response = curl_exec($curl);
    
       
        $message_data = json_decode($response);
        $input_data1 = array();
    
        $input_data1['md_case_id'] = $case_id;
        $input_data1['user_id'] = $user_id;
        $input_data1['case_id'] = $system_case_id;
        $input_data1['text'] = $message_data->text;
        $input_data1['from'] = $message_data->from;
        $input_data1['channel'] = $message_data->channel;
        $input_data1['prioritized_at'] = $message_data->prioritized_at;
        $input_data1['prioritized_reason'] = $message_data->prioritized_reason;
            $input_data1['read_at'] = NULL ;//$message_data->read_at;
            $input_data1['message_created_at'] = $message_data->created_at;
            $input_data1['case_message_id'] = $message_data->case_message_id;
            //$input_data['message_files_ids'] = json_encode($file_ids);
            $input_data1['clinician  '] = $message_data->clinician ;
            $message_data = SupportMessages::create($input_data1);
            if(isset($message_file_data) && !empty($message_file_data)){
             $message_data['message_file_data'] = $message_file_data;
           }
           
    
           if(!empty( $message_data)){
            $message_data['date'] = date("M j H:i");
            return $this->sendResponse($message_data,'Message created successfully');
          }else{
            return $this->sendResponse(array(),'Some thing went wrong.');
          }
    
    
        //end of create message
    
    
    
        }
}
