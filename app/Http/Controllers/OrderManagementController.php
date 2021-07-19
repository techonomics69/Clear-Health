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
use App\Helper\shipStationHelper;
use GuzzleHttp\Guzzle;
use LaravelShipStation;
use LaravelShipStation\ShipStation;
use Illuminate\Support\Facades\App;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Refund;
use App\Models\Notifications;


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
        ->select('users.email','checkout.case_id','checkout.created_at','checkout.order_id',
        'checkout.medication_type','checkout.id','checkout.cart_id','carts.product_price',
        'checkout.case_id','checkout.gift_code_discount','checkout.status as orderstatus',
        'checkout.cancel_request')
        ->orderBy('checkout.id', 'DESC')->get();
        foreach($order as $key=>$val)
        {
            $cart_ids = explode(',', $val['cart_id']);
            $product_name = array();
            $product_details  = Cart::join('products', 'products.id', '=', 'carts.product_id')->whereIn('carts.id', $cart_ids)->select('products.name AS product_name')->get();

            foreach( $product_details as $product_key=>$product_value){
               $product_name[] = $product_value['product_name'];  
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

       $app= App::getFacadeRoot();
       $app->make('LaravelShipStation\ShipStation');
       $shipStation = $app->make('LaravelShipStation\ShipStation');
       if($order_non_prescribed[0]->shipstation_order_id !='' || $order_non_prescribed[0]->shipstation_order_id !=null){
        $getOrder = $shipStation->orders->get([], $endpoint = $order_non_prescribed[0]->shipstation_order_id);
        $trackOrder = $shipStation->shipments->get(['orderId'=>$order_non_prescribed[0]->shipstation_order_id], $endpoint = '');
       }else{
        $getOrder = array();
        $trackOrder = array();
       }
       

       foreach($order_non_prescribed as $key=>$val)
       {
            $cart_ids = explode(',', $val['cart_id']);
            $product_name = array();
            $product_details  = Cart::join('products', 'products.id', '=', 'carts.product_id')->whereIn('carts.id', $cart_ids)->select('products.name AS product_name')->get()->toArray();
            foreach($product_details as $product_key=>$product_value){
                $product_name[] = $product_value['product_name'];   
            }   
            
           
            $order_non_prescribed[$key]->shipstation = $getOrder;
            $order_non_prescribed[$key]->shipments = $trackOrder;
            $order_non_prescribed[$key]->product_name = implode(', ' ,$product_name);    
        }


  
   return view('ordermanagement.view',compact('order_non_prescribed'));
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

public function cancelOrder(Request $request){
    try{
        $data = $request->all();
        $updateData = array();
        $validator = \Validator::make($request->all(),[ 
            'order_id'  =>  'required',
            // 'charge_id' =>  'required',
            // 'shipstation_order_id'  =>  'required',
        ], [
            'order_id.required' =>  'Request has missing order id',
            // 'charge_id.required' =>  'Request has missing charge id',
            // 'shipstation_order_id'  =>  'Request has missing shipstation order id',
        ]);
        if($validator->fails()){
            toastr()->error($validator->errors()->first());
            return redirect()->back();
        }
        $chargeId = Checkout::select('transaction_complete_details')->where('id',$request->order_id)->get();
        if(count($chargeId) > 0){
            if(!empty($chargeId[0]->transaction_complete_details)){
                $charge = json_decode($chargeId[0]->transaction_complete_details);
                dd($charge['id']);
                $chId = $charge['id'];
                Stripe::setApiKey('sk_test_51J08tDJofjMgVsOdzxZs5Aqlf5A9riwPPwlxUTriC8YPiHvTjlCBoaMjgxiqdIVfvOMPcllgR9JY7EZlihr6TJHy00ixztHFtz'); 
                    
                $refund = \Stripe\Refund::create(array(
                    'charge' => $chId,
                ));
            
                $refundData = $refund->jsonSerialize();
                $updateData['strip_refund_object'] = $refundData;

                $updateData['status'] = 'cancelled';
                $updateData['cancelled_date'] = date("Y-m-d h:i:s");    
                $updateOrder = Checkout::where('id',$data['order_id'])->update($updateData);
                toastr()->success('Order Cancelled Successfully');

                return redirect()->back();
                                        
            }else{
                toastr()->error("Something went wrong! please try again");
                return redirect()->back();
            }
        }else{
            toastr()->error("Something went wrong! please try again");
            return redirect()->back();
        } 
        
    }catch(\Exception $ex){
        toastr()->error($ex->getMessage());
        return redirect()->back();
    }
}

public function showCancelOrder($id){
    $order_non_prescribed =  checkout::join('users', 'users.id', '=', 'checkout.user_id')
       ->join('carts','carts.id', '=', 'checkout.cart_id')
       ->join('checkout_address', 'checkout_address.user_id', '=','checkout.user_id')
       ->select('checkout.*','users.email',
       'checkout.case_id','checkout.created_at',
       'checkout.order_id','checkout.medication_type',
       'checkout.id as checkoutId','checkout.cart_id',
       'carts.product_price',
       'users.first_name','users.last_name','users.email',
       'users.mobile','checkout_address.addressline1','checkout_address.addressline2',
       'checkout_address.city','checkout_address.state','checkout_address.zipcode',
       'carts.quantity')
       ->orderBy('checkout.id', 'DESC')
       ->where('checkout.id',$id)
       ->get();

       

       $app= App::getFacadeRoot();
       $app->make('LaravelShipStation\ShipStation');
       $shipStation = $app->make('LaravelShipStation\ShipStation');
       if($order_non_prescribed[0]->shipstation_order_id !='' || $order_non_prescribed[0]->shipstation_order_id !=null){
        $getOrder = $shipStation->orders->get([], $endpoint = $order_non_prescribed[0]->shipstation_order_id);
        $trackOrder = $shipStation->shipments->get(['orderId'=>$order_non_prescribed[0]->shipstation_order_id], $endpoint = '');
       }else{
        $getOrder = array();
        $trackOrder = array();
       }
       

    //    foreach($order_non_prescribed[0] as $key=>$val)
    //    {
            $cart_ids = explode(',', $order_non_prescribed[0]->cart_id);
            $product_name = array();
            $productData = array();
            $product_details  = Cart::join('products', 'products.id', '=', 'carts.product_id')->whereIn('carts.id', $cart_ids)
                        ->select('products.id',
                        'products.name AS product_name',
                        'products.discount_price',
                        'carts.quantity as cqty',
                        'carts.product_price as cprice')
                        ->get()->toArray();
            foreach($product_details as $product_key=>$product_value){
                $product_name[] = $product_value['product_name'];   
                $productData[] = $product_details[$product_key];
            }   
            
           
            $order_non_prescribed[0]->shipstation = $getOrder;
            $order_non_prescribed[0]->shipments = $trackOrder;
            $order_non_prescribed[0]->product_name = implode(', ' ,$product_name);
            $order_non_prescribed[0]->productData = $productData;

        // }

        // dd($order_non_prescribed[0]);
       
  
   return view('ordermanagement.cancelorder',compact('order_non_prescribed'));   

}

}