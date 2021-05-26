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
        
            foreach ($cart_ids as $key => $val) {
            $cartid= $val;


            $products_qty = Cart::where('id',$cartid)->select('quantity','order_type')->get();
            //$orderlist[$key]->price = implode(', ' ,$products_qty);
            echo "<pre>";
print_r($products_qty);
echo "</pre>";
die();
            }

            $product_name = array();
            $product_details  = Cart::join('products', 'products.id', '=', 'carts.product_id')->whereIn('carts.id', $cart_ids)->select('products.name AS product_name','products.price','products.image')->get()->toArray();

            foreach($product_details as $product_key => $product_value)
            {
               $product_name[] = $product_value['product_name'];
               $price[] = $product_value['price'];
               $image[] = $product_value['image'];

            }

           $orderlist[$key]->product_name = implode(', ' ,$product_name);
           $orderlist[$key]->price = implode(', ' ,$price);
           $orderlist[$key]->image = implode(', ' , $image);    
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
