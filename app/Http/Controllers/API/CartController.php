<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Validator;
use Exception;
use Lcobucci\JWT\Parser;

class CartController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if(isset($data['token']) && !empty($data['token'])):

            $data['user_id'] = (new Parser())->parse($data['token'])->getClaims()['sub']->getValue();

    endif;       
    try{
        $validator = Validator::make($data, [
            'user_id' => 'required',
            'product_id' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->all());       
        }
        $cart = Cart::where(['user_id' => $data['user_id'], 'product_id' => $data['product_id'],'status' => 'pending'])->first();
        if(!empty($cart)):
            $newQuantity['quantity'] = $cart->quantity + $data['quantity'];                
            $cartUpdate = Cart::where('id',$cart->id)->update($newQuantity);

        else:
            $quizAns = Cart::create($data);
        endif;
        return $this->sendResponse(array(), 'Item Added Successfully');
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
        //
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
        $data = $request->all();
        try{
            $cart = Cart::find($id); 
            if(!empty($cart)):
                $cart = Cart::where('id',$id)->update($data);
            else:
                return $this->sendError('Server error', array('Item Not Found'));
            endif;
            return $this->sendResponse(array(), 'Cart Updated Successfully');
        }catch(\Exception $ex){
            return $this->sendError('Server error',array($ex->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $cart = Cart::find($id); 
            if(!empty($cart)):
                $cart->delete();
            else:
                return $this->sendError('Server error', array('Item Not Found'));
            endif;
            return $this->sendResponse(array(), 'Item removed successfully.');
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }
    }

    public function getCartByUser($id)
    {
        try{
            //$cart = Cart::where('user_id', $id)->where('order_type', '!=', 'Prescribed')->get();

            $cart = Cart::where('user_id', $id)->where('order_type', null)->where('status','pending')->get();
            $data=array();
            foreach ($cart as $key => $value) {

                $data[$key]['id'] = $value->id;
                $data[$key]['pharmacy_pickup'] = $value->pharmacy_pickup;
                $data[$key]['product_id'] = $value->product->id;
                $data[$key]['order_type'] = $value->order_type;
                $data[$key]['product_name'] = $value->product->name;
                $data[$key]['product_quantity'] = $value->quantity;
                $data[$key]['product_image'] = $value->product->image;
                $data[$key]['product_price'] = $value->product->price;
                $data[$key]['product_category'] = $value->product->category->name;


            }
            return $this->sendResponse($data, 'Item retrieved successfully.');
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }

    }

    public function getCartByUserPrescribed($id)
    {
        try{
            $cart = Cart::where('user_id', $id)->where('order_type','Prescribed')->where('status','pending')->OrderBy('id','desc')->get();
            $data = array();
            foreach ($cart as $key => $value) {
                $data[$key]['id'] = $value->id;
                $data[$key]['pharmacy_pickup'] = $value->pharmacy_pickup;
                $data[$key]['product_id'] = $value->product->id;
                $data[$key]['order_type'] = $value->order_type;
                $data[$key]['product_name'] = $value->product->name;
                $data[$key]['product_quantity'] = $value->quantity;
                $data[$key]['product_image'] = $value->product->image;
                $data[$key]['product_price'] = $value->product->price;
                $data[$key]['product_category'] = $value->product->category->name;
            }
            return $this->sendResponse($data, 'Item retrieved successfully.');
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }

    }
    public function getCartByUserAddOn($id)
    {
        try{
            $cart = Cart::where('user_id', $id)->where('order_type','AddOn')->where('status','purchased')->OrderBy('id','desc')->get();
            $data = array();
            foreach ($cart as $key => $value) {
                $data[$key]['id'] = $value->id;
                $data[$key]['pharmacy_pickup'] = $value->pharmacy_pickup;
                $data[$key]['product_id'] = $value->product->id;
                $data[$key]['order_type'] = $value->order_type;
                $data[$key]['product_name'] = $value->product->name;
                $data[$key]['product_quantity'] = $value->quantity;
                $data[$key]['product_image'] = $value->product->image;
                $data[$key]['product_price'] = $value->product->price;
                $data[$key]['product_category'] = $value->product->category->name;
            }
            return $this->sendResponse($data, 'Item retrieved successfully.');
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }
    }
    public function addonItemUpdate(Request $request, $id)
    {
        $data = $request->all();
            /*echo "<pre>";
            print_r($data);
            echo "</pre>";
            die();*/
        $cart = Cart::where('user_id', $id)->where('order_type','AddOn')->where('status','pending')->OrderBy('id','desc')->get();
            if(isset($cart))
            {
                echo "<pre>";
            print_r($cart);
            echo "</pre>";
            die();
                $InsertAddon = Cart::create($data);
            }else {
                $UpdateAddon = Cart::update($data);
            }

            return $this->sendResponse($data, 'Item retrieved successfully.');
    }

}
