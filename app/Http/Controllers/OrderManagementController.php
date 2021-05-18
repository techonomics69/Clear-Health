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

  $order = checkout::join('users', 'users.id', '=', 'checkout.user_id')
            ->leftjoin("carts",\DB::raw("FIND_IN_SET(carts.id, checkout.cart_id)") ,">",\DB::raw("'0'"))
            //->join('carts','carts.id', '=', 'checkout.cart_id')
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->select('users.first_name','users.last_name', 'users.mobile', 'products.name AS product_name' , 'products.price', 'checkout.total_amount','checkout.case_id','checkout.created_at')->orderBy('checkout.id', 'DESC')->get();
    
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