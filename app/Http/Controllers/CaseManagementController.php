<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CaseManagement;
use App\Models\QuizCategory;
use App\Models\QuizAnswer;
use App\Models\Quiz;
use App\Models\Answers;
use App\Models\Checkoutaddress;
use App\Models\Checkout;
use App\Models\Cart;
use App\Models\Product;
use Session;


class CaseManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $user_case_management_data = CaseManagement::join('users','case_managements.user_id', '=', 'users.id')->select('case_managements.*','users.email')->OrderBy('id' ,'DESC')->get();
      return view('casemanagement.index', compact('user_case_management_data'))->with('i', ($request->input('page', 1) -1) * 5);
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
      $user_case_management_data = CaseManagement::join('users','case_managements.user_id', '=', 'users.id')
      ->select('case_managements.*','users.first_name','users.last_name','users.email','users.mobile','users.gender')
      ->where('case_managements.id',$id)->first();

      $skincare_summary = CaseManagement::join('users','case_managements.user_id', '=', 'users.id')
      ->join('checkout','checkout.case_id','=', 'case_managements.id')
      ->join('carts', 'checkout.cart_id', '=', 'carts.id')
      ->join('products', 'products.id', '=', 'carts.product_id')
      ->join('checkout_address', 'checkout_address.order_id', '=', 'checkout.order_id')
      ->select('checkout.order_id','checkout.cart_id','checkout.total_amount','checkout.telemedicine_fee','checkout.tax','checkout_address.addressline1','checkout_address.addressline2','checkout_address.city','checkout_address.state','checkout_address.zipcode','products.price')
      ->where('case_managements.id',$id)->first();

      $cart_ids = explode(',', $skincare_summary['cart_id']);

      $product_details  = Cart::join('products', 'products.id', '=', 'carts.product_id')->whereIn('carts.id', $cart_ids)->select('products.name AS product_name','products.used_for_plan','carts.quantity','carts.order_type','carts.pharmacy_pickup','carts.product_price as price')->get()->toArray();
      //$products=array();
      $product_name=array();
      $addon_product=array();

      foreach($product_details as $product_key => $product_value)
      {
         //$products[$product_key]['order_type'] = $product_value['order_type'];
//$skincare_summary['order_type'] = $product_value['order_type'];
        if(isset($product_value['pharmacy_pickup']) && $product_value['pharmacy_pickup'] != '' && $product_value['order_type'] == 'Prescribed'){

          if($product_value['pharmacy_pickup'] != "cash"){
            $r = get_token();
            $token_data = json_decode($r);
            $token = $token_data->access_token;
            $pharmacy_id = $product_value['pharmacy_pickup'];

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/pharmacies/'.$pharmacy_id,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token,
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $response1 = json_decode($response);
            $skincare_summary['pharmacy_pickup'] =  $response1->name; 
          }else{
           $skincare_summary['pharmacy_pickup'] = 'Clear Health Pharmacy Network';
         }

         //$products[$product_key]['pharmacy_pickup'] = '';
       }

       if($product_value['used_for_plan'] != "Yes") {
        $product_name[] = $product_value['product_name']; 
      }
      if($product_value['used_for_plan'] == "Yes"){
       $addon_product[] = $product_value['product_name']; 
     }

   }
   $skincare_summary['product_name'] = implode(', ' ,$product_name);
   $skincare_summary["addon_product"] =implode(', ', $addon_product);
   
   $category = QuizCategory::pluck('name', 'id')->toArray();

   $general = Answers::where('case_id',$user_case_management_data['id'])->where('user_id',$user_case_management_data['user_id'])->where('category_id',7)->first();

   //$general_que=json_decode($general->answer);

   if(isset($general))
   {
     $general_que = json_decode($general->answer); 
   }else{
    $general_que = [];
   }
foreach ($general_que as $key => $value) {
  if(isset($value) && $value->question='Hey there! First, we need to know your legal name111.'){
echo "<pre>";
print_r($value->question);
echo "</pre>";
}
}
$accutane = Answers::where('case_id',$user_case_management_data['id'])->where('user_id',$user_case_management_data['user_id'])->where('category_id',8)->first();

//$accutane_que=json_decode($accutane->answer); 

if(isset($accutane))
{
 $accutane_que=json_decode($accutane->answer); 
}else{
   $accutane_que = [];
}


$topical = Answers::where('case_id',$user_case_management_data['id'])->where('user_id',$user_case_management_data['user_id'])->where('category_id',9)->first();

/*$topical_que=json_decode($topical->answer);*/

if(isset($topical))
{
 $topical_que=json_decode($topical->answer);
}else{
  $topical_que=[];
}

return view('casemanagement.view',compact('user_case_management_data','category','general_que','accutane_que','topical_que','skincare_summary'));

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
    ],[
      'pregnancy_test.required' => 'Pregnancy Test file field is required.' ,
      'pregnancy_test.mimes' => 'Pregnancy Test File must be a file of type:jpg,jpeg,png,pdf' ,
      
    ]);

     

     if(!empty($documents)){

      $file =  $documents->getClientOriginalName();
      $doc_file_name =  time().'-'.$file;
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
  ],[
    'blood_work.required' => 'Blood Work Test file field is required.' ,
    'blood_work.mimes' => 'Blood Work  File must be a file of type:jpg,jpeg,png,pdf' ,
    
  ]);

   

   if(!empty($documents)){

    $file =  $documents->getClientOriginalName();
    $doc_file_name =  time().'-'.$file;
          //$doc_file_name = time() . '-' . $doc->getClientOriginalExtension();

    if (!file_exists(public_path('/ipledgeimports/blood_work'))) {
      File::makeDirectory(public_path('/ipledgeimports/blood_work'), 0777, true, true);
    }

    $destinationPath = public_path('/ipledgeimports/blood_work');
    $documents->move($destinationPath, $doc_file_name);

          //$input = array();
          //$input = request()->except(['_token']);
          //$input['files'] = 'public/ipledgeimports/' .$doc_file_name;
          //$input = $request->all();
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

  if($request['i_pledge_agreement']!="" &&  $request['i_pledge_agreement'] ="Verify"){
    $input['i_pledge_agreement'] = "verified";
  }
  CaseManagement::whereId($request['case_id'])->update($input);
  toastr()->success('I Pledge Agreement Verified Successfully');

  return redirect()->back();
  
  
}

public function get_token(){
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
    CURLOPT_POSTFIELDS =>'{
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

public function getCaseStatus(){

  $data = CaseManagement::all();

  $r = $this->get_token();
  $token_data = json_decode($r);
  $token = $token_data->access_token;
  $user_id = $request->user_id;
  $case_id = $request->case_id;
  $system_case_id = $request->system_case_id;

  /*$current_status = "completed"

  if($current_status == "dosespot confirmed"){
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mdintegrations.xyz/v1/partner/cases/'.$case_id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$token,
        'Cookie: __cfduid=da01d92d82d19a6cccebfdc9852303eb81620627650'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
  }
*/
    /*echo "<pre>";
    print_r($data);
    echo "<pre>";
    exit();*/
  }

}
