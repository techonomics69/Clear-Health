<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CaseManagement;
use App\Models\QuizCategory;
use App\Models\QuizAnswer;
use App\Models\Quiz;
use App\Models\Answers;
use App\Models\Checkoutaddress;
use App\Models\User;
use App\Models\Cart;
use App\Models\CaseHistory;
use App\Models\Messages;
use App\Models\MessageFiles;
use App\Models\FollowUp;
use App\Models\Triggers;
use App\Models\Notifications;
use Redirect;
use Session;
use File;
use Exception;
use App\Helper\shipStationHelper;
use App\Models\Checkout;
use App\Models\UserPics;
use GuzzleHttp\Guzzle;
use LaravelShipStation;
use LaravelShipStation\ShipStation;
use Illuminate\Support\Facades\App;
use App\Models\Subscription;
use DB;


class CaseManagementController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $user_case_management_data = CaseManagement::join('users', 'case_managements.user_id', '=', 'users.id')->leftjoin('case_histories', 'case_managements.id', '=', 'case_histories.case_id')->select('case_managements.*', 'users.email', 'users.first_name', 'users.last_name', 'users.gender', 'case_histories.case_status')->OrderBy('id', 'DESC')->get();
    //generate_ipledge, store_ipledge, verify_pregnancy, prior_auth, check_off_ipledge, trigger, blood_work
    return view('casemanagement.index', compact('user_case_management_data'))->with('i', ($request->input('page', 1) - 1) * 5);
  }

  public function showList(Request $request){
        $draw = $request->draw;
        $row = $request->start;
        $rowperpage = $request->length; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $totalRecords = CaseManagement::join('users', 'case_managements.user_id', '=', 'users.id')
                      ->leftjoin('case_histories', 'case_managements.id', '=', 'case_histories.case_id')
                      ->count();
        
        $data = array();
        $searchValue = $_POST['search']['value']; // search in date, caseid, firstname, lastname, gender, md caseid, 
        
        $user_case_management_data = DB::table('case_managements as cm')->join('users as u', 'cm.user_id', '=', 'u.id')
                    ->leftjoin('case_histories ch', 'cm.id', '=', 'ch.case_id')
                    ->select('cm.*', 'u.email', 'u.first_name', 'u.last_name',
                    'u.gender', 'ch.case_status');
        
        $usercase_count = DB::table('case_managements as cm')->join('users as u', 'cm.user_id', '=', 'u.id')
                        ->leftjoin('case_histories ch', 'cm.id', '=', 'ch.case_id')
                        ->select('cm.*', 'u.email', 'u.first_name', 'u.last_name',
                        'u.gender', 'ch.case_status');

        if($columnName == 'action'){
          if($searchValue!=''){
            $user_case_management_data = $user_case_management_data->where('cm.created_at','like',"%{$searchValue}%")
                                        ->orWhere('cm.ref_id','like',"%{$searchValue}%")->orWhere('u.first_name','like',"%{$searchValue}%")
                                        ->orWhere('u.last_name','like',"%{$searchValue}%")->orWhere('u.gender','like',"%{$searchValue}%")
                                        ->orWhere('cm.md_case_id','like',"%{$searchValue}%");

            $usercase_count = $usercase_count->where('cm.created_at','like',"%{$searchValue}%")
                            ->orWhere('cm.ref_id','like',"%{$searchValue}%")->orWhere('u.first_name','like',"%{$searchValue}%")
                            ->orWhere('u.last_name','like',"%{$searchValue}%")->orWhere('u.gender','like',"%{$searchValue}%")
                            ->orWhere('cm.md_case_id','like',"%{$searchValue}%")->count();                            
          }else{

          }
          $user_case_management_data = $user_case_management_data->orderBy('cm.case_status', $columnSortOrder)
                                      ->offset($row)->limit($rowperpage)->get();
          $usercase_count = $usercase_count->count();

        }else{
          if($searchValue!=''){
            $user_case_management_data = $user_case_management_data->where('cm.created_at','like',"%{$searchValue}%")
                                        ->orWhere('cm.ref_id','like',"%{$searchValue}%")->orWhere('u.first_name','like',"%{$searchValue}%")
                                        ->orWhere('u.last_name','like',"%{$searchValue}%")->orWhere('u.gender','like',"%{$searchValue}%")
                                        ->orWhere('cm.md_case_id','like',"%{$searchValue}%");

            $usercase_count = $usercase_count->where('cm.created_at','like',"%{$searchValue}%")
                            ->orWhere('cm.ref_id','like',"%{$searchValue}%")->orWhere('u.first_name','like',"%{$searchValue}%")
                            ->orWhere('u.last_name','like',"%{$searchValue}%")->orWhere('u.gender','like',"%{$searchValue}%")
                            ->orWhere('cm.md_case_id','like',"%{$searchValue}%")->count();                            
          }else{

          }
          $user_case_management_data = $user_case_management_data->orderBy($columnName, $columnSortOrder)
                                      ->offset($row)->limit($rowperpage)->get();
          $usercase_count = $usercase_count->count();
        }

        foreach($user_case_management_data as $key => $value){
          if ($case_data['md_status'] == 0) {
            $mdStatus = 'pending ';
          } else if ($case_data['md_status'] == 1) {
            $mdStatus = 'support';
          } else {
            $mdStatus = 'accepted';
          }

          switch($value['case_status']){
              case 'generate_ipledge':
                    $action1 = ' <a href="https://www.ipledgeprogram.com/iPledgeUI/home.u" target="_blank">
                                  <span class="badge badge-info">Generate iPledge Credentials</span>
                                </a>';
                    break;
              case 'store_ipledge':
                    $action1 = ' <a href="'.route('casemanagement.show',$case_data['id']).'"?active=action_items">
                                  <span class="badge badge-info">Register Ipledge</span>
                                </a>';
                    break;
              case 'verify_pregnancy':
                    $action1 = '<a href="'.route('casemanagement.show',$case_data['id']).'"?active=pregnancy_test">
                                  <span class="badge badge-info">Review Pregnancy Test & send case to MD</span>
                                </a>';
                    break;
              case 'prior_auth':
                    $action1 = '<a href="'.route('casemanagement.show',$case_data['id']).'"?active=prior_auth">
                                  <span class="badge badge-info">Complete Prior Authorization</span>
                                </a>';
                    break;
              case 'check_off_ipledge':
                    $action1 = ' <a href="https://www.ipledgeprogram.com/iPledgeUI/home.u" target="_blank">
                                  <span class="badge badge-info">Check Off Admin iPledge.com Items</span>
                                </a>';
                    break;
              case 'trigger':
                    $action1 = '<a href="'.route('casemanagement.show',$case_data['id']).'"?active=triggers">
                                  <span class="badge badge-info">Send Prescription Pickup Notification</span>
                                </a>';
                    break;
              case 'blood_work':
                    $action1 = '<a href="'.route('casemanagement.show',$case_data['id']).'"?active=blood_work">
                                  <span class="badge badge-info">Upload Bloodwork Results</span>
                                </a>';
                    break;
              case 'low_income_program':
                    $action1 = '<a href="'.route('casemanagement.show',$case_data['id']).'"?active=blood_work">
                                  <span class="badge badge-info">Enroll Absorica Patient Assistance Program</span>
                                </a>';
                    break;
              case 'finish':
                    $action1 = '<span class="badge badge-info">Finish</span>';
                    break;
              default:  
                    $action1 = '<span class="badge badge-secondary">Action pending from patient</span>';
                    break;      
          }
          $data[] = array(
            'srno' => ($key + 1),
            'date' => $value['created_at']->format('d/m/Y'),
            'caseid' => $case_data['ref_id'],
            'firstname' => $case_data['first_name'],
            'lastname' => $case_data['last_name'],
            'gender' => (!empty($case_data['gender'])) ? strtoupper($case_data['gender'][0]) : '',
            'visitnumber' => (empty($case_data['follow_up']) ? 1 : ($case_data['follow_up'] + 1),
            'mdcaseid' => $case_data['md_case_id'],
            'mdstatus' => $mdStatus,
            'visittype' => (empty($case_data['follow_up'])) ? 'Initial' : 'FollowUp',
            'treatmentplan' => ,
            'pharmacy' => '',
            'action1' => '<div class="d-flex">
                      <a class="icons edit-icon" href="'.route('casemanagement.show',$case_data['id']).'"><i class="fa fa-eye"></i></a>
                      </div>',
            'action' => $action1, 
          );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $usercase_count,
            "aaData" => $data
        );

        echo json_encode($response);

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function show($id)
  {
    $user_case_management_data = CaseManagement::join('users', 'case_managements.user_id', '=', 'users.id')
      ->select('case_managements.*', 'users.first_name', 'users.last_name', 'users.email', 'users.mobile', 'users.gender')
      ->where('case_managements.id', $id)->first();

      $follow_up_data = FollowUp::where([['case_id',$user_case_management_data['id']],['follow_up_status','completed']])->get()->toArray();


      $user_case_management_data['follow_up_data'] = (!empty($follow_up_data))?$follow_up_data:array();
 
  
    $skincare_summary = CaseManagement::join('users', 'case_managements.user_id', '=', 'users.id')
      ->join('checkout', 'checkout.case_id', '=', 'case_managements.id')
      ->join('carts', 'checkout.cart_id', '=', 'carts.id')
      ->join('products', 'products.id', '=', 'carts.product_id')
      ->join('checkout_address', 'checkout_address.order_id', '=', 'checkout.order_id')
      ->select(
        'checkout.order_id',
        'checkout.cart_id',
        'checkout.total_amount',
        'checkout.telemedicine_fee',
        'checkout.tax',
        'checkout_address.addressline1',
        'checkout_address.addressline2',
        'checkout_address.city',
        'checkout_address.state',
        'checkout_address.zipcode',
        'products.price',
        'checkout.gift_code_discount',
        'checkout.shipstation_order_id'
      )
      ->where('case_managements.id', $id)->first();


    $cart_ids = explode(',', $skincare_summary['cart_id']);

    if (isset($skincare_summary['shipstation_order_id'])) {
      $app = App::getFacadeRoot();
      $app->make('LaravelShipStation\ShipStation');
      $shipStation = $app->make('LaravelShipStation\ShipStation');

      if ($skincare_summary['shipstation_order_id'] != '' || $skincare_summary['shipstation_order_id'] != null) {
        $getOrder = $shipStation->orders->get([], $endpoint = $skincare_summary['shipstation_order_id']);
        $trackOrder = $shipStation->shipments->get(['orderId' => $skincare_summary['shipstation_order_id']], $endpoint = '');
      } else {
        $getOrder = array();
        $trackOrder = array();
      }
    } else {
      $getOrder = array();
      $trackOrder = array();
    }


    $skincare_summary['getOrder'] = $getOrder;
    $skincare_summary['trackOrder'] = $trackOrder;

    $product_details  = Cart::join('products', 'products.id', '=', 'carts.product_id')->whereIn('carts.id', $cart_ids)->select('products.name AS product_name', 'products.used_for_plan', 'carts.quantity', 'carts.order_type', 'carts.pharmacy_pickup', 'carts.product_price as price')->get()->toArray();
    //$products=array();
    $product_name = array();
    $addon_product = array();

    
    
    foreach ($product_details as $product_key => $product_value) {
      //$products[$product_key]['order_type'] = $product_value['order_type'];
      //$skincare_summary['order_type'] = $product_value['order_type'];
      if (isset($product_value['pharmacy_pickup']) && $product_value['pharmacy_pickup'] != '' && $product_value['order_type'] == 'Prescribed') {

        if ($product_value['pharmacy_pickup'] != "cash") {
          $r = get_token();
          $token_data = json_decode($r);
          $token = $token_data->access_token;
          $pharmacy_id = $product_value['pharmacy_pickup'];

          $curl = curl_init();
          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/pharmacies/' . $pharmacy_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
              'Authorization: Bearer ' . $token,
            ),
          ));

          $response = curl_exec($curl);
          curl_close($curl);
          $response1 = json_decode($response);
          if (isset($response1)) {
            if (count($response1) > 0) {
              $skincare_summary['pharmacy_pickup'] =  $response1->name;
            }
          }
        } else {
          $skincare_summary['pharmacy_pickup'] = 'Clear Health Pharmacy Network';
        }

        //$products[$product_key]['pharmacy_pickup'] = '';
      }

      if ($product_value['used_for_plan'] != "Yes") {
        $product_name[] = $product_value['product_name'];
      }
      if ($product_value['used_for_plan'] == "Yes") {
        $addon_product[] = $product_value['product_name'];
      }
    }

    $skincare_summary['product_name'] = implode(', ', $product_name);
    $skincare_summary["addon_product"] = implode(', ', $addon_product);

    $category = QuizCategory::pluck('name', 'id')->toArray();

    $general = Answers::where('case_id', $user_case_management_data['id'])->where('user_id', $user_case_management_data['user_id'])->where('category_id', 7)->first();

    
    if (isset($general)) {
      $general_que = json_decode($general->answer);
    } else {
      $general_que = [];
    }

    $accutane = Answers::where('case_id', $user_case_management_data['id'])->where('user_id', $user_case_management_data['user_id'])->where('category_id', 8)->first();

    if (isset($accutane)) {
      $accutane_que = json_decode($accutane->answer);
    } else {
      $accutane_que = [];
    }



    $topical = Answers::where('case_id', $user_case_management_data['id'])->where('user_id', $user_case_management_data['user_id'])->where('category_id', 9)->first();

    if (isset($topical)) {
      $topical_que = json_decode($topical->answer);
    } else {
      $topical_que = [];
    }

    $followup_que = FollowUp::join('users','follow_up.user_id','=','users.id')
      ->select('follow_up.*','users.first_name','users.last_name')
      ->where("follow_up.user_id", $user_case_management_data['user_id'])
      ->where("follow_up.case_id", $user_case_management_data['id'])->get();



    //Get Non-medical msg
    $message_details = Messages::join('message_files', 'messages.id', '=', 'message_files.msg_id')->join('users', 'users.id', '=', 'messages.user_id')->select('messages.*', 'message_files.*', 'users.first_name', 'users.last_name')->where('user_id', $user_case_management_data['user_id'])->OrderBy('messages.id', 'asc')->get();

    $message_data = array();
    foreach ($message_details as $key => $value) {
      $message_data[$key]['id'] = $value['id'];
      $message_data[$key]['name'] = $value['first_name'] . ' ' . $value['last_name'];
      $message_data[$key]['message'] = $value['text'];
      $message_data[$key]['sender'] = $value['sender'];

      $date = strtotime($value['created_at']);

      $message_data[$key]['date'] = date('M j', $date);
      $message_data[$key]['created_at'] = $value['created_at'];

      if ($value['sender'] == 'admin') {
        $messageStatus = 'received';
      } else {
        $messageStatus = 'sent';
      }

      $message_data[$key]['messageStatus'] = $messageStatus;

      if ($value['file_path'] != '') {
        $message_data[$key]['file_path'] = $value['file_path'];
        $message_data[$key]['mime_type'] = $value['mime_type'];
      } else {
        $message_data[$key]['file_path'] = null;
        $message_data[$key]['mime_type'] = null;
      }

      if ($value['file_name'] != '') {
        $message_data[$key]['file_name'] = $value['file_name'];
      } else {
        $message_data[$key]['file_name'] = null;
      }
    }


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
          /*echo"<pre>";
print_r( $msg_history[$i]['message_files']);
echo"</pre>";
die();*/
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
    /* if(!empty($msg_history) && count($msg_history)>0 ){
      return $this->sendResponse($msg_history,'Message retrieved successfully');
    }else{
      return $this->sendResponse(array(),'No data found');
    }*/


    //   echo "<pre>";
    // print_r($user_case_management_data->id);
    // echo "</pre>";
    // die();

    if (isset($skincare_summary['order_id'])) {
      if ($skincare_summary['order_id'] != '' || $skincare_summary['order_id'] != null) {
        $prescribe_shipments =  DB::table('checkout as ch')->join('curexa_order as cu', 'cu.order_id', '=', 'ch.order_id')
          ->select('cu.order_status', 'dispached_date')
          ->where('cu.order_id', $skincare_summary['order_id'])
          ->get();
      } else {
        $prescribe_shipments =  array();
      }
    } else {
      $prescribe_shipments =  array();
    }
    $checkout = Checkout::where('case_id', $user_case_management_data['id'])->where('user_id', $user_case_management_data['user_id'])
                ->orderBy("updated_at","desc")->get();
    $user_pic = UserPics::where('case_id', $user_case_management_data['id'])->where('user_id', $user_case_management_data['user_id'])->first();
    
    $subscription_data = Subscription::join('case_managements','subscription.case_id','=','case_managements.id')
                        ->select('subscription.*')
                        ->where('subscription.case_id',$id)
                        ->where('subscription.user_id',$user_case_management_data['user_id'])
                        ->orderBy('subscription.id','desc')
                        ->get();
    $checkout_array = array();
    $sub_array = array();
    if(count($checkout)>0){
      foreach($checkout as $ck => $cval){
        $ckarr1 = array("updated_at"=>$cval->updated_at,"order_id"=>$cval->order_id,"transaction_id"=>$cval->transaction_id,
                "total_amount"=>$cval->total_amount,"payment_status"=>$cval->payment_status);
        array_push($checkout_array, $ckarr1);        
      }
    }
    if(count($subscription_data)>0){
      foreach($subscription_data as $sk => $sval){
        $skarr1 = array("updated_at"=>$sval->created_at,"order_id"=>'',"transaction_id"=>'',
                "total_amount"=>$sval->plan_amount,"payment_status"=>$sval->status);
        array_push($sub_array, $skarr1);        
      }
    }

    if((count($checkout_array)>0) && (count($sub_array)>0)){
      $subscription_data = array_merge($checkout_array, $sub_array);   
    }else if((count($checkout_array)>0) && (count($sub_array)<0)){
      $subscription_data = $checkout_array;   
    }else if((count($checkout_array)<0) && (count($sub_array)>0)){
      $subscription_data = $sub_array;   
    }else{
      $subscription_data = array();   
    }

    

    // dd(json_decode(json_encode($subscription_data), true));

  
    return view('casemanagement.view', compact('user_case_management_data', 'category','general', 'general_que', 'accutane_que', 'topical_que', 'skincare_summary', 'message_data', 'message_details', 'msg_history', 'followup_que', 'prescribe_shipments', 'checkout', 'user_pic','subscription_data'));
  }

  

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  public function upload_pregnancy_test_report(Request $request)
  {


    $documents = $request->file('pregnancy_test');

    $this->validate($request, [
      'pregnancy_test' => 'required|mimes:jpg,jpeg,png,pdf',
    ], [
      'pregnancy_test.required' => 'Pregnancy Test file field is required.',
      'pregnancy_test.mimes' => 'Pregnancy Test File must be a file of type:jpg,jpeg,png,pdf',

    ]);



    if (!empty($documents)) {

      $file =  $documents->getClientOriginalName();
      $doc_file_name =  time() . '-' . $file;
      //$doc_file_name = time() . '-' . $doc->getClientOriginalExtension();

      if (!file_exists(public_path('/ipledgeimports/pregnancy_test'))) {
        File::makeDirectory(public_path('/ipledgeimports/pregnancy_test'), 0777, true, true);
      }

      $destinationPath = public_path('/ipledgeimports/pregnancy_test');
      $documents->move($destinationPath, $doc_file_name);

      //$input = array();
      //$input = request()->except(['_token']);
      //$input['files'] = 'public/ipledgeimports/' .$doc_file_name;
      //$input = $request->all();
      $input['pregnancy_test'] = $doc_file_name;

      CaseManagement::whereId($request['case_id'])->update($input);
      toastr()->success('Test Report Uploaded Successfully');

      return redirect()->back();
    }
  }


  public function upload_blood_test_report(Request $request)
  {


    $documents = $request->file('blood_work');

    $this->validate($request, [
      'blood_work' => 'required|mimes:jpg,jpeg,png,pdf',
    ], [
      'blood_work.required' => 'Blood Work Test file field is required.',
      'blood_work.mimes' => 'Blood Work  File must be a file of type:jpg,jpeg,png,pdf',

    ]);


    if (!empty($documents)) {
      $file =  $documents->getClientOriginalName();
      $doc_file_name =  time() . '-' . $file;
      //$doc_file_name = time() . '-' . $doc->getClientOriginalExtension();

      if (!file_exists(public_path('/ipledgeimports/blood_work'))) {
        File::makeDirectory(public_path('/ipledgeimports/blood_work'), 0777, true, true);
      }

      $destinationPath = public_path('/ipledgeimports/blood_work');
      $documents->move($destinationPath, $doc_file_name);

      $input['blood_work'] = $doc_file_name;

      CaseManagement::whereId($request['case_id'])->update($input);
      toastr()->success('Blood Work Report Uploaded Successfully');

      return redirect()->back();
    }
  }

  public function i_pledge_agreement(Request $request)
  {
    $this->validate($request, [
      'i_pledge_agreement' => 'required',
    ]);

    if ($request['i_pledge_agreement'] != "" &&  $request['i_pledge_agreement'] = "Verify") {
      $input['i_pledge_agreement'] = "verified";
    }
    CaseManagement::whereId($request['case_id'])->update($input);
    toastr()->success('I Pledge Agreement Verified Successfully');

    return redirect()->back();
  }

  public function get_token()
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/auth/token',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
      "grant_type": "client_credentials",
      "client_id": "c7a20a90-4db9-42e4-860a-7f41c2a8a0b1",
      "client_secret": "xBsQsgLFhYIFNlKwhJW3wClOmNuJ4WQDX0n8475C",
      "scope": "*"
    }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Cookie: __cfduid=db3bdfa9cd5de377331fced06a838a4421617781226'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
  }

  function convertToReadableSize($size)
  {
    $base = log($size) / log(1024);
    $suffix = array("", "KB", "MB", "GB", "TB");
    $f_base = floor($base);
    $return = array("size" => round(pow(1024, $base - floor($base)), 1), "sizin" => $suffix[$f_base]);
    return $return;
  }

  public function sendMessageNonMedical(Request $request)
  {

    try {


      $user_id = $request['user_id'];

      $case_id = (isset($request['md_case_id']) && $request['md_case_id'] != '') ? $request['md_case_id'] : 0;
      $system_case_id = $request['case_id'];
      $users_message_type = 'Non-Medical';
      $sender = "admin";
      $text = $request['text'];
      $documents = $request->file('file');
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

        if (!file_exists(public_path('/Message_files'))) {
          File::makeDirectory(public_path('/Message_files'), 0777, true, true);
        }
        $destinationPath = public_path('/Message_files');
        $documents->move($destinationPath, $doc_file_name);

        chmod($destinationPath . "/" . $doc_file_name, 0777);

        $file_path = 'public/Message_files/' . $doc_file_name;

        $file_mimeType = $documents->getClientMimeType();
      } else {
        $doc_file_name = "";
        $file_path = "";
        $file_mimeType = "";
      }
      // end of code to upload files ids

      $input_data = array();

      $input_data['md_case_id'] = $case_id;
      $input_data['user_id'] = $user_id;
      $input_data['case_id'] = $system_case_id;
      $input_data['text'] = $text;
      $input_data['users_message_type'] = $users_message_type;
      $input_data['sender'] = $sender;

      $message_data = Messages::create($input_data);
      $message_data['msg_date'] = $message_data['created_at']->format('M j');

      //$message_data['date'] = date('M j', $message_data['created_at']);

      $message_file_data = array();
      $message_file_data['file_name'] = $doc_file_name;
      $message_file_data['file_path'] = $file_path;
      $message_file_data['mime_type'] = $file_mimeType;
      $message_file_data['msg_id'] = $message_data['id'];
      $message_file_data = MessageFiles::create($message_file_data);
      if (!empty($message_file_data)) {
        $message_data['file_name'] = $doc_file_name;
        $message_data['file_path'] = $file_path;
        $message_data['mime_type'] = $file_mimeType;
      }
      // dd(count($message_file_data));

      $message_data['show_non_medical_screen'] = 1;

      /*echo "<pre>";
  print_r($message_data);
  echo "</pre>";
  die();*/
      $response = array("status" => true, "data" => $message_data, "message" => "msg send successfully");
    } catch (\Exception $ex) {
      $response = array("status" => false, "data" => "", "message" => $ex->getMessage());
    }
    return $response;
  }

  public function generateiPledge(Request $request)
  {
    $input_data['case_status'] = 'store_ipledge';
    $caseHistory = CaseHistory::where('case_id', $request['case_id'])->update($input_data);
    return redirect()->back();
  }

  public function saveiPledgeCredentials(Request $request)
  {
    $case_data['ipledge_username'] = $request['email'];
    $case_data['ipledge_password'] = $request['password'];
    $case = CaseManagement::find($request['case_id']);

    if ($case) :
      $case->update($case_data);

      //send sms to user
        $case = CaseManagement::find($request['case_id']);

        $user_data = User::where('id', $case['user_id'])->first();
        $user_phone = $user_data['mobile'];

        $user_data['gender'] = 'female';
        $case['product_type'] = 'Accutane';

        if(($user_data['gender'] == 'male' || $user_data['gender'] == 'female' ) && $case['product_type'] == 'Accutane'){
           $smsdata = array();

          //$user = array($user_phone);
          $user = array('+917874257069');
          $smsdata['users'] = $user;
          $smsdata['body'] = "Your iPledge ID:".$case['ipledge_id']." iPledge Username:".$case['iledge_username']."iPledge Password:".$case['ipledge_password'];
          $sms_sent = sendsms($smsdata);


          $ipledge_credentials_input = array();
          $ipledge_credentials_input['user_id'] = $user_id;
          $ipledge_credentials_input['case_id'] = $system_case_id;
          $ipledge_credentials_input['md_case_id'] = $case_id;
          $ipledge_credentials_input['name'] = "ipledge_credentials_sent_notification";
          $ipledge_credentials_input['month'] = 1;

          $ipledge_credentials_input_data = Triggers::create($ipledge_credentials_input);
        }

      //end of code to send smas to user
      toastr()->success('Credentials saved');
    else :
      toastr()->error('Credentials not saved');
    endif;
    return redirect()->back();
  }


  public function verifyPregnancy(Request $request)
  {
    $follow_up = FollowUp::find($request->id);

    $data['pregnancy_test_verify'] = 'true';
    
    //code for md case
    /*$user_id = $request['user_id'];
    $case_id = $request['case_id'];
    $followup_no = $request['follow_up_no'];
    $preferred_pharmacy_id = getPickupPharmacy($user_id,$case_id);
    $order_data = Checkout::where([['user_id', $user_id],['case_id', $case_id]])->select('id','order_id')->first();

    $response = CreateFollowUPCase($user_id,$case_id,$preferred_pharmacy_id,$order_data['order_id'],$followup_no);*/

    //end of code to create md case

  
    $update = $follow_up->update($data);

    if ($update) :
      toastr()->success('Verified Successfully');
    else :
      toastr()->error('Verification Failed');
    endif;
    return redirect()->back();
    // $input_data['case_status'] = 'prior_auth';
    // $caseHistory = CaseHistory::whereId($request['id'])->update($input_data);
  }

  public function priorAuth(Request $request)
  {
    $documents = $request->file('file');

    $this->validate($request, [
      'file' => 'required|mimes:jpg,jpeg,png,pdf',
    ], [
      'file.required' => 'Prior Auth Test file field is required.',
      'file.mimes' => 'Prior Auth  File must be a file of type:jpg,jpeg,png,pdf',

    ]);


    if (!empty($documents)) {
      $file =  $documents->getClientOriginalName();
      $doc_file_name =  time() . '-' . $file;
      //$doc_file_name = time() . '-' . $doc->getClientOriginalExtension();

      if (!file_exists(public_path('/ipledgeimports/prior_auth'))) {
        File::makeDirectory(public_path('/ipledgeimports/prior_auth'), 0777, true, true);
      }

      $destinationPath = public_path('/ipledgeimports/prior_auth');
      $documents->move($destinationPath, $doc_file_name);

      $input['prior_auth'] = $doc_file_name;
      $input['prior_auth_date'] = $request['date'];

      CaseManagement::whereId($request['case_id'])->update($input);
      $input_data['case_status'] = 'check_off_ipledge';
      $caseHistory = CaseHistory::where('case_id', $request['case_id'])->update($input_data);
      toastr()->success('Prior Auth Uploaded Successfully');

      return redirect()->back();
    }
  }

  public function checkOffIpledge(Request $request)
  {
    $input_data['case_status'] = 'trigger';
    $caseHistory = CaseHistory::whereId($request['id'])->update($input_data);
  }
  public function trigger(Request $request)
  {

    

    // if(isset($request->send_nitification)){
         

         $user_id = $request->user_id;
         $case_id = $request->case_id;
         $md_case_id = $request->md_case_id;
         $follow_up = $request->follow_up;
         $follow_up_id = $request->follow_up_id;


      $user_case_management_data = CaseManagement::join('users', 'case_managements.user_id', '=', 'users.id')
      ->select('case_managements.*', 'users.first_name', 'users.last_name', 'users.email', 'users.mobile', 'users.gender')
      ->where('case_managements.id',$case_id)->first();

      

       $preferred_pharmacy_id = getPickupPharmacy($user_id,$case_id,$md_case_id);


         $noti_input_data = array();
         $noti_input_data['user_id'] = $user_id;
         $noti_input_data['case_id'] = $case_id;
         $noti_input_data['md_case_id'] = $md_case_id;

         $noti_input_data['noti_message'] = getNotificationMessageFromKey('pickup_medication_notification_for_female');
         $noti_input_data['for_month'] = $follow_up;

         $trigger_input = array();
         $trigger_input['user_id'] = $user_id;
         $trigger_input['case_id'] = $case_id;
         $trigger_input['md_case_id'] = $md_case_id;
         $trigger_input['name'] = "pickup_medication_notification";
         $trigger_input['month'] = $follow_up;



       if($user_case_management_data['product_type']== "Accutane"){

        // dd('here 1');

        if($user_case_management_data['gender']=="female"  && $preferred_pharmacy_id !='13012' && $user_case_management_data['prior_auth_date']!= NULL){

          if(isset($follow_up_id)){

            // dd('here 2');
            
            //$follow_up_data = FollowUp::where([['case_id',$user_case_management_data['id'],['id',$follow_up_id]],['follow_up_status','completed']])->get()->toArray();

            $iPledge_items = $request->follow_ipledge;
          }else{
            $iPledge_items = $user_case_management_data['ipledge_items'];
          }

          // dd('here 3');

          

          if($iPledge_items == 'on') {

            // dd('here 4');
             $noti_data = Notifications::create($noti_input_data);

              $trigger_data = Triggers::create($trigger_input);

              

              toastr()->success('Notification sent successfully.');
              return redirect()->back();
          }else{

            toastr()->error('Please verify ipledge items first.');
            return redirect()->back();
          }
             
        }


        if($user_case_management_data['gender']=="male"  && $preferred_pharmacy_id !='13012' && $user_case_management_data['prior_auth_date']!= NULL){
          // dd('here 5');
             $noti_data = Notifications::create($noti_input_data);

              $trigger_data = Triggers::create($trigger_input);

              toastr()->success('Notification sent successfully.');
              return redirect()->back();
          }
             
        }

        if(isset($request->prior_auth) || isset($request->ipledge)){
          if ($request->prior_auth) :
            $input['verify_prior_auth'] = $request->prior_auth;
          endif;
          if ($request->ipledge) :
            $input['ipledge_items'] = $request->ipledge;
          endif;
          
          CaseManagement::whereId($request['case_id'])->update($input);
          $input_data = array();
          $input_data['case_status'] = 'trigger';
          $caseHistory = CaseHistory::where('case_id', $request['case_id'])->update($input_data);
          toastr()->success('Notification sent successfully.');
          return redirect()->back();
        }

        if(isset($follow_up_id)){
          $iPledge_items = $request->follow_ipledge;
          $updateFollowup = FollowUp::where('id',$follow_up_id)->update(['ipledge_items'=>$iPledge_items]);
          $noti_data = Notifications::create($noti_input_data);

              $trigger_data = Triggers::create($trigger_input);
          toastr()->success('Notification sent successfully.');
          return redirect()->back();
        }else{
          return redirect()->back();
        }

        // dd('here 6');
        
        // return redirect()->back();

        

        


      //  }
          

    // }else{
    //   if ($request->prior_auth) :
    //   $input['verify_prior_auth'] = $request->prior_auth;
    // endif;
    // if ($request->ipledge) :
    //   $input['ipledge_items'] = $request->ipledge;
    // endif;
    // if ($request->prior_auth && $request->ipledge) :
    //   toastr()->success('Prior Auth & Ipledge Items Verified Successfully');
    // elseif ($request->prior_auth) :
    //   toastr()->success('Prior Auth Verified Successfully');
    // elseif ($request->ipledge) :
    //   toastr()->success('Ipledge Items Verified Successfully');
    // endif;
    // CaseManagement::whereId($request['case_id'])->update($input);
    // $input_data['case_status'] = 'trigger';
    // $caseHistory = CaseHistory::where('case_id', $request['case_id'])->update($input_data);
    // return redirect()->back();
    // $input_data['case_status'] = 'blood_work';
    // $caseHistory = CaseHistory::whereId($request['id'])->update($input_data);
    // }
    
  }
  public function bloodWork(Request $request)
  {


    $documents = $request->file('file');

    $this->validate($request, [
      'file' => 'required|mimes:jpg,jpeg,png,pdf',
    ], [
      'file.required' => 'Blood Work Test file field is required.',
      'file.mimes' => 'Blood Work  File must be a file of type:jpg,jpeg,png,pdf',

    ]);


    if (!empty($documents)) {
      $file =  $documents->getClientOriginalName();
      $doc_file_name =  time() . '-' . $file;
      //$doc_file_name = time() . '-' . $doc->getClientOriginalExtension();

      if (!file_exists(public_path('/ipledgeimports/blood_work'))) {
        File::makeDirectory(public_path('/ipledgeimports/blood_work'), 0777, true, true);
      }

      $destinationPath = public_path('/ipledgeimports/blood_work');
      $documents->move($destinationPath, $doc_file_name);

      $input['blood_work'] = $doc_file_name;
      $input['bloodwork_date'] = $request['date'];

      CaseManagement::whereId($request['case_id'])->update($input);
      toastr()->success('Blood Work Report Uploaded Successfully');

      return redirect()->back();
    }
    // $input_data['case_status'] = 'finish';
    // $caseHistory = CaseHistory::whereId($request['id'])->update($input_data);
  }
}
