<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use Validator;
use App\Http\Resources\Product as ProductResource;
   
class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('product_active', '1')->get();
        $product = array();
        $today = date("Y-m-d");
        foreach ($products as $key => $value) {
            $availDate = date("Y-m-d",strtotime($value->available_date));
            if($availDate <= $today){
                $value->category_name = $value->category->name;
                $value->available_date = $availDate;
                array_push($product, $products);
            }
        }
    //return json_encode($products);
        return $this->sendResponse($product, 'Products retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $product = Product::create($input);
   
        return $this->sendResponse(new ProductResource($product), 'Product created successfully.');*/
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $product->category_name = $product->category->name;
        $product->section1_image = asset('public/images/Products/'.$product->section1_image);
        $product->section2_image = asset('public/images/Products/'.$product->section2_image);
        $product->section3_image = asset('public/images/Products/'.$product->section3_image);
  
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
   
        return $this->sendResponse($product, 'Product retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        /*$input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();
   
        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');*/
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        /*$product->delete();
   
        return $this->sendResponse([], 'Product deleted successfully.');*/
    }


    public function getUpsellProductDetails()
    {
        $upsellproduct = Product::where('upsell','Yes')->first();
        $upsellproduct['image'] = url('/public/images/Products/').'/'.$upsellproduct['image'];
  
        if (is_null($upsellproduct)) {
            return $this->sendError('Upsell Product Not Found.');
        }
        return $this->sendResponse($upsellproduct, 'Product Retrieved Successfully.');
    }


    public function getskincareplan()
    {
        $skincareplan = Product::where('used_for_plan','Yes')->OrderBy('plan_id', 'ASC')->get();

        foreach($skincareplan as $key=>$val){
            $val['image'] = url('/public/images/Products/').'/'.$val['image'];

        }
        
  
        if (is_null($skincareplan)) {
            return $this->sendError('Skin Care Plan Not Found.');
        }
        return $this->sendResponse($skincareplan, 'Skin Care Plan Retrieved Successfully.');
    }
}