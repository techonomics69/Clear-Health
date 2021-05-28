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

   $order_prescribed = CaseManagement::join('users','case_managements.user_id', '=', 'users.id')
   ->select('case_managements.*','users.first_name','users.last_name','users.email','users.mobile','users.address')
   ->where('case_managements.id',$id)
   ->first();

   $category = QuizCategory::pluck('name', 'id')->toArray();

   $quiz= QuizAnswer::join('quizzes','quiz_answers.question_id', '=', 'quizzes.id')
   ->select('quiz_answers.*','quizzes.question','quizzes.category_id')
   ->where('case_id', $order_prescribed['id'])
   ->OrderBy('id', 'ASC')
   ->get();

   return view('ordermanagement.view',compact('order_non_prescribed','order_prescribed','category','quiz'));
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