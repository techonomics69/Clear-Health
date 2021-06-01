<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Checkout;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CaseManagement;
use App\Models\QuizCategory;
use App\Models\QuizAnswer;
use App\Models\Quiz;


//use Illuminate\Support\Facades\File;
//use App\Http\Controllers\Controller;

class OrderManagementController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*function __construct()
    {

    }*/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $order = checkout::join('users', 'users.id', '=', 'checkout.user_id')
        ->join('carts','carts.id', '=', 'checkout.cart_id')
        ->select('users.email','checkout.case_id','checkout.created_at','checkout.order_id','checkout.medication_type','checkout.id','checkout.cart_id','carts.product_price')->orderBy('checkout.id', 'DESC')->get();
        foreach($order as $key=>$val)
        {
            $cart_ids = explode(',', $val['cart_id']);
            $product_name = array();
            $product_details  = Cart::join('products', 'products.id', '=', 'carts.product_id')->whereIn('carts.id', $cart_ids)->select('products.name AS product_name')->get();

            foreach( $product_details as $k=>$v){
               $product_name[] = $v['product_name'];  
           }
           $order[$key]->product_name = implode(',',$product_name);
       }

       return view('ordermanagement.index',compact('order'));
   }

   public function create()
   {

   }

   public function store(Request $request)
   {   

   }

   public function show($id)
   {

       $order_non_prescribed =  checkout::join('users', 'users.id', '=', 'checkout.user_id')
       ->join('carts','carts.id', '=', 'checkout.cart_id')
       ->join('checkout_address', 'checkout_address.user_id', '=','checkout.user_id')
       ->select('checkout.*','users.email','checkout.case_id','checkout.created_at','checkout.order_id','checkout.medication_type','checkout.id','checkout.cart_id','carts.product_price','users.first_name','users.last_name','users.email','users.mobile','checkout_address.addressline1','checkout_address.addressline2','checkout_address.city','checkout_address.state','checkout_address.zipcode','carts.quantity')->orderBy('checkout.id', 'DESC')
       ->where('checkout.id',$id)
       ->get();


       foreach($order_non_prescribed as $key=>$val)
       {
        $cart_ids = explode(',', $val['cart_id']);
        $product_name = array();
        $product_details  = Cart::join('products', 'products.id', '=', 'carts.product_id')->whereIn('carts.id', $cart_ids)->select('products.name AS product_name')->get()->toArray();
        foreach($product_details as $product_key=>$product_value){
           $product_name[] = $product_value['product_name'];  
       }
       $order_non_prescribed[$key]->product_name = implode(', ' ,$product_name);    
   }


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

   $general = Answers::where('case_id',$user_case_management_data['id'])->where('user_id',$user_case_management_data['user_id'])->where('category_id',7)->get();
   if(!empty($general[0])){
    $general_que=json_decode($general[0]["answer"]);
  } else {
    $general_que = [];
  }

  $accutane = Answers::where('case_id',$user_case_management_data['id'])->where('user_id',$user_case_management_data['user_id'])->where('category_id',8)->get();
  if (!empty($accutane[0])) {
   $accutane_que=json_decode($accutane[0]["answer"]);
 }else{
  $accutane_que = [];
}


$topical = Answers::where('case_id',$user_case_management_data['id'])->where('user_id',$user_case_management_data['user_id'])->where('category_id',9)->get();
if(!empty($topical[0])) {
 $topical_que=json_decode($topical[0]["answer"]);

}else{
  $topical_que =[];
}
  
   return view('ordermanagement.view',compact('order_non_prescribed','order_prescribed','category','user_case_management_data'));
}

public function edit($id)
{

}

public function update(Request $request, $id)
{

}

public function destroy($id)
{

}
}