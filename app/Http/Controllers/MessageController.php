<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseManagement;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $user_case_management_data = CaseManagement::join('users', 'case_managements.user_id', '=', 'users.id')
            ->select('case_managements.*', 'users.first_name', 'users.last_name', 'users.email', 'users.mobile', 'users.gender')
            ->where('case_managements.id', $id)->first();

        $msg_tab = '';
        // Medical msg

        $r = get_token();
        $token_data = json_decode($r);
        $token = $token_data->access_token;
        $case_id = $user_case_management_data['md_case_id'];
        $channel = 'patient';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/cases/' . $case_id . '/messages?channel=' . $channel,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token,
                'Cookie: __cfduid=da01d92d82d19a6cccebfdc9852303eb81620627650'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        $msg_history = array();
        $i = 0;
        if (isset($data)) {
            foreach ($data as $key => $value) {
                $msg_history[$i]['message'] = $value->text;
                $date = strtotime($value->created_at);
                $msg_history[$i]['msg_date'] = date('M j', $date);
                $msg_history[$i]['created_at'] = $value->created_at;
                $msg_history[$i]['read_at'] = $value->created_at;
                $msg_history[$i]['messageStatus'] = 'sent';

                if (!empty($value->message_files)) {
                    $msg_history[$i]['message_files'] = $value->message_files;
                }

                if (!empty($value->clinician)) {
                    $i++;
                    $msg_history[$i]['message'] = $value->text;
                    $date1 = strtotime($value->created_at);
                    $msg_history[$i]['msg_date'] = date('M j', $date);
                    $msg_history[$i]['created_at'] = $value->created_at;
                    $msg_history[$i]['read_at'] = $value->read_at;
                    $msg_history[$i]['messageStatus'] = 'received';
                }

                $i++;
            }
        }
        $msg_history = [];
        $user_case_management_data['user_id'] = '';
        $user_case_management_data['id'] = '';
        return view('messages.index', compact('msg_tab', 'msg_history', 'user_case_management_data'));
    }
}
