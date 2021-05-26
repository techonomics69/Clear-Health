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
    try{
        $validator = Validator::make($data, [
            'user_id' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->all());       
        }
        $checkoutdata = Checkout::create($data);

        return $this->sendResponse($checkoutdata, 'Order Created Successfully');
    }catch(\Exception $ex){
        return $this->sendError('Server error',array($ex->getMessage()));
    }




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
    try{

       $orderlist = checkout::join('carts','carts.id', '=', 'checkout.cart_id')
       ->select('checkout.id','checkout.order_id','carts.quantity','carts.order_type','checkout.cart_id')
       ->where('checkout.order_id',$request->order_id)
       ->OrderBy('id', 'DESC')
       ->get();

       foreach($orderlist as $key=>$val)
       {
        $cart_ids = explode(',', $val['cart_id']);
        $products=array();
        $product_details  = Cart::join('products', 'products.id', '=', 'carts.product_id')->whereIn('carts.id', $cart_ids)->select('products.name AS product_name','products.price','products.image','carts.quantity','carts.order_type','carts.pharmacy_pickup')->get()->toArray();

        foreach($product_details as $product_key => $product_value)
        {
           $products[$product_key]['name'] = $product_value['product_name'];
           $products[$product_key]['price'] = $product_value['price'];
           $products[$product_key]['image'] = $product_value['image'];
           $products[$product_key]['quantity'] = $product_value['quantity'];
           $products[$product_key]['order_type'] =$product_value['order_type'];
           $products[$product_key]['pharmacy_pickup']='';

           if(isset($product_value['pharmacy_pickup']) && $product_value['pharmacy_pickup'] != '' && $product_value['order_type'] == 'Prescribed'){

            if($product_value['pharmacy_pickup'] != "cash"){
                $r = $this->get_token();
                $token_data = json_decode($r);
                $token = $token_data->access_token;

                $pharmacy_id = $request['pharmacy_pickup'];
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
                return $response;

            }else{

             $products[$product_key]['pharmacy_pickup'] = 'cash';
         }

         $products[$product_key]['pharmacy_pickup'] = '';
     }

 }
 $orderlist[$key]->products = $products;

}

if(!empty($orderlist)){
   return $this->sendResponse($orderlist, 'Checkout data retrieved successfully.');
}else{
    return $this->sendResponse($orderlist =array(), 'No Data Found.');
}

}catch(\Exception $ex){
    return $this->sendError('Server error', array($ex->getMessage()));
}

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
