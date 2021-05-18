<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class OrderManagementController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
/*
      $order = checkout::join('users', 'users.id', '=', 'checkout.user_id')
      ->leftjoin("carts",\DB::raw("FIND_IN_SET(carts.id, checkout.cart_id)") ,">",\DB::raw("'0'"))
            //->join('carts','carts.id', '=', 'checkout.cart_id')
      ->join('products', 'products.id', '=', 'carts.product_id')
      ->select('users.first_name','users.last_name', 'users.mobile', 'products.name AS product_name' , 'products.price','checkout.order_id', 'checkout.total_amount','checkout.case_id','checkout.created_at')->orderBy('checkout.id', 'DESC')->get();*/

            $order = checkout::join('users', 'users.id', '=', 'checkout.user_id')
            //->leftjoin("carts",\DB::raw("FIND_IN_SET(carts.id, checkout.cart_id)") ,">",\DB::raw("'0'"))
            ->join('carts','carts.id', '=', 'checkout.cart_id')
            //->join('products', 'products.id', '=', 'carts.product_id')
            ->select('users.first_name', 'users.last_name','users.mobile', 'checkout.total_amount','checkout.case_id','checkout.created_at','checkout.order_id','checkout.medication_type','checkout.id','checkout.cart_id')->orderBy('checkout.id', 'DESC')->get();//'products.name AS product_name' , 'products.price'

foreach($order as $key=>$val){
    $cart_ids = explode(',', $val['cart_id']);

   
    $product_name = array();
   $product_details  = Cart::join('products', 'products.id', '=', 'carts.product_id')->whereIn('carts.id', $cart_ids)->select('products.name AS product_name')->get();//'products.name AS product_name' , 'products.price'

    foreach( $product_details as $k=>$v){
         $product_name[] = $v['product_name'];  
    }
    
   $order[$key]['product_name'] = implode(',',$product_name);

}



echo "<pre>";
    print_r($order);
    echo "<pre>";
exit();
    

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