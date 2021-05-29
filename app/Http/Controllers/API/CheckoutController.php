<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Checkout;
use App\Models\Checkoutaddress;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use Validator;
use Exception;

class CheckoutController extends BaseController
{
    public function index()
    {

    }


    public function orderList(Request $request)
    {

        try{
         $orderlist = checkout::join('users', 'users.id', '=', 'checkout.user_id')
         ->join('carts','carts.id', '=', 'checkout.cart_id')
         ->select('checkout.id','checkout.order_id','checkout.md_status','checkout.status','checkout.created_at','checkout.updated_at','carts.order_type','checkout.cart_id','checkout.case_id')
         ->where('checkout.user_id',$request->user_id)
         ->OrderBy('id', 'DESC')
         ->get();



         foreach($orderlist as $key=>$val)
         {
            $cart_ids = explode(',', $val['cart_id']);
            $product_name = array();
            $product_details  = Cart::join('products', 'products.id', '=', 'carts.product_id')->whereIn('carts.id', $cart_ids)->select('products.name AS product_name')->get()->toArray();
            foreach($product_details as $product_key=>$product_value){
             $product_name[] = $product_value['product_name'];  
         }
         $orderlist[$key]->product_name = implode(', ' ,$product_name);    
     }


     if(!empty($orderlist)){
         return $this->sendResponse($orderlist, 'Order data retrieved successfully.');
     }else{
        return $this->sendResponse( $orderlist =array(), 'No Data Found.');
    }

}catch(\Exception $ex){
    return $this->sendError('Server error', array($ex->getMessage()));
} 
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
        $data = $request->all();

        $last_checkout_id = Checkout::OrderBy('id','desc')->first();
        $order_id = "00000001";
        if(!empty($last_checkout_id)){
            $year = substr($last_checkout_id['order_id'],4, -9);
            $current_year = date("Y");

            if(!empty($last_checkout_id['order_id']) && ($year == $current_year)){
                $id = number_format(substr($last_checkout_id['order_id'], 9)) + 1;
                $order_id = str_pad($id,8,'0',STR_PAD_LEFT);
            }
        }    
        else{
            $order_id = "00000001";
        }

        $order_id = "ORD-".date("Y")."-".$order_id;
        $data['order_id'] = $order_id;

        if(empty($data['user_id'])):
            if(isset($data['token']) && !empty($data['token'])):

                $data['user_id'] = (new Parser())->parse($data['token'])->getClaims()['sub']->getValue();

        endif;  
    endif;     
   // try{
        $validator = Validator::make($data, [
            'user_id' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->all());       
        }

        $checkoutdata = Checkout::create($data);
        $checkcout_address = Checkoutaddress::where('user_id', $data['user_id'])->OrderBy('id','DESC')->first();
        
        if(!empty($checkcout_address))
        {
        
            $update_checkout_address  =  Checkoutaddress::where('id',$checkcout_address['id'])->update(['order_id' => $order_id]);
        }

        return $this->sendResponse($checkoutdata, 'Order Created Successfully');
}

public function addCheckoutAddress(Request $request)
{
    $data = $request->all();

    if(empty($data['user_id'])):
        if(isset($data['token']) && !empty($data['token'])):

            $data['user_id'] = (new Parser())->parse($data['token'])->getClaims()['sub']->getValue();

    endif;  
endif;     
try{
    $validator = Validator::make($data, [
        'user_id' => 'required',
        'patient_firstname' => 'required',
        'patient_lastname' => 'required',
        'addressline1' => 'required',
        'addressline2' => '',
        'city' => 'required',
        'state' => 'required',
        'zipcode' => 'required',
        'email' => 'required',
        'phone' => '',
        'address_type'=> 'required',
    ]);
    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors()->all());       
    }
    $checkoutaddressdata = Checkoutaddress::create($data);

    return $this->sendResponse($checkoutaddressdata, 'Address added Successfully');
}catch(\Exception $ex){
    return $this->sendError('Server error',array($ex->getMessage()));
}




}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*try{ 
            $caseUser = CaseManagement::where('user_id', $id)->OrderBy('id','desc')->first();
            return $this->sendResponse($caseUser, 'Data recieved Successfully');
        }catch(\Exception $ex){
            return $this->sendError('Server error',array($ex->getMessage()));
        }*/
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

  public function getCheckoutdetail(Request $request)
  {
    //try{

     $orderlist = checkout::join('users', 'users.id', '=', 'checkout.user_id')
     ->join('carts','carts.id', '=', 'checkout.cart_id')
     ->join('checkout_address', 'checkout_address.order_id', '=','checkout.order_id')
     ->select('checkout.id','checkout_address.patient_firstname','checkout_address.patient_lastname','checkout.order_id','carts.quantity','carts.order_type','checkout.cart_id','checkout_address.addressline1','checkout_address.addressline2','checkout_address.city','checkout_address.state','checkout_address.zipcode','checkout_address.email','checkout_address.phone','checkout.total_amount','checkout.created_at','checkout.status as order_status','checkout.md_status','checkout.shipping_fee','checkout.ipladege_id','checkout.delivery_date','checkout.telemedicine_fee','checkout.handling_fee','checkout.tax','checkout.address_type')
     ->where('checkout.id',$request->id)
     ->OrderBy('id', 'DESC')
     ->get();

     foreach($orderlist as $key=>$val)
     {
        $cart_ids = explode(',', $val['cart_id']);
        $orderlist[$key]['order_item'] = count($cart_ids);
        
        $products=array();
        $product_details  = Cart::join('products', 'products.id', '=', 'carts.product_id')->whereIn('carts.id', $cart_ids)->select('products.name AS product_name','products.image','carts.quantity','carts.order_type','carts.pharmacy_pickup','carts.product_price as price')->get()->toArray();

        
        $s_total = 0;
        $pro_amount = 0;
        $ord_total = 0;
        $shipping_fee = ($val['shipping_fee']!="" || $val['shipping_fee']!= null)?$val['shipping_fee']:0;

        $telemedicine_fee = ($val['telemedicine_fee']!= '' || $val['telemedicine_fee']!= null)?$val['telemedicine_fee']:0;

        $handling_fee = ($val['handling_fee']!='' || $val['handling_fee']!= null)?$val['handling_fee']:0;

        $tax = ($val['tax']!='' || $val['tax']!= null)?$val['tax']:0;

        foreach($product_details as $product_key => $product_value)
        {
           
         $product_name[] = $product_value['product_name'];
         $products[$product_key]['name'] = $product_value['product_name'];
         $products[$product_key]['price'] = $product_value['price'];
         $products[$product_key]['image'] = $product_value['image'];
         $products[$product_key]['quantity'] = $product_value['quantity'];
         $products[$product_key]['order_type'] = $product_value['order_type'];

         $pro_amount = $pro_amount + $product_value['quantity'] * $product_value['price'];

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
                $products[$product_key]['pharmacy_pickup'] =  $response1->name; 
            }else{
               $products[$product_key]['pharmacy_pickup'] = 'cash';
           }

         //$products[$product_key]['pharmacy_pickup'] = '';
       }

   }
   $orderlist[$key]->product_name = implode(', ' ,$product_name);

   $orderlist[$key]->products = $products;

   $orderlist[$key]['sub_total'] = $pro_amount;

   $orderlist[$key]['order_total'] =  $pro_amount + $shipping_fee + $telemedicine_fee + $handling_fee +$tax ;

}

if(!empty($orderlist)){
 return $this->sendResponse($orderlist, 'Checkout data retrieved successfully.');
}else{
    return $this->sendResponse($orderlist =array(), 'No Data Found.');
}

//}catch(\Exception $ex){
   // return $this->sendError('Server error', array($ex->getMessage()));
//}

}

public function getCheckoutAddress(Request $request)
{
    try{
        $checkout_data = Checkoutaddress::where('user_id', $request->user_id)->OrderBy('id', 'desc')->first();
            //$checkout_data = Checkout::where('user_id', $request->user_id)->where('cart_id', $request->cart_id)->first();
        if(!empty($checkout_data)){
         return $this->sendResponse($checkout_data, 'Checkout Address data retrieved successfully.');
     }else{
        return $this->sendResponse($checkout_data =array(), 'No Data Found.');
    }

}catch(\Exception $ex){
    return $this->sendError('Server error', array($ex->getMessage()));
}

}
}
