<?php
    
namespace App\Http\Controllers;
    
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
    
class ProductController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->latest()->OrderBy('id', 'ASC')->paginate(50);        
        return view('products.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Categories = Category::pluck('name', 'id')->toArray();
        return view('products.create',compact('Categories'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $this->validate($request, [
            'status' => 'required|not_in:0',
            'available_date' => 'required',
            'name' => 'required|unique:products,name|regex:/^[\pL\s\-]+$/u',
            'sub_title' => 'required|unique:products,title|regex:/^[\pL\s\-]+$/u',
            'category_id' => 'required|not_in:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'image_detail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'retails_price' => 'required|numeric|min:1', 
            'detail' => 'required',
            'quantity' => 'required|numeric|min:1', 
            'min_quantity_alert' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            'product_active' => 'required|not_in:0',
            'weight' => 'required|numeric|min:1', 
            'weight_unit' => 'required',  
            'url' => ['regex:'.$regex,'nullable'],

        ]);
        $data = $request->all();

        if(!empty($request->image)):
            $imageName = time().'.'.$request->image->extension();

            $path = public_path().'/images/Products';

            if (! File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            $request->image->move(public_path('images/Products'), $imageName);            
            
            $data['image'] = $imageName;
        endif;

         if(!empty($request->image_detail)):
            $image_detail_Name = time().'image_detail'.'.'.$request->image_detail->extension();

        $path = public_path().'/images/Products';

            if (! File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            $request->image_detail->move(public_path('images/Products'), $image_detail_Name);            
            
            $data['image_detail'] = $image_detail_Name;
        endif;

        $Products = Product::create($data);
                
        toastr()->success('Product created successfully');

        return redirect()->route('products.index');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(isset($product)):
            return view('products.show',compact('product'));
        else:
            return redirect()->away('http://'.$id);
        endif;
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $date = date('Y-m-d', strtotime($product->available_date));
        $Categories = Category::pluck('name', 'id')->toArray();
        return view('products.edit',compact('product','Categories','date'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $data = $request->all();
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $this->validate($request, [
            'status' => 'required|not_in:0',
            'available_date' => 'required',
            'name' => 'required|unique:products,name,'.$product->id.'|regex:/^[\pL\s\-]+$/u',
            'sub_title' => 'required|unique:products,title,'.$product->id.'|regex:/^[\pL\s\-]+$/u', 
            'category_id' => 'required|not_in:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'retails_price' => 'required|numeric|min:1', 
            'detail' => 'required',
            'quantity' => 'required|numeric|min:1', 
            'min_quantity_alert' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            'product_active' => 'required|not_in:0',
            'weight' => 'required|numeric|min:1',   
            'weight_unit' => 'required',
            'url' => ['regex:'.$regex,'nullable'],
         
        ]);
        if(!empty($request->image)):
            $imageName = time().'.'.$request->image->extension();

            $path = public_path().'/images/Products';

            if (! File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            $request->image->move(public_path('images/Products'), $imageName);

            $oldImg = $path.'/'.$product->image;

            if (File::exists($oldImg)) : // unlink or remove previous image from folder
                unlink($oldImg);
            endif;

            $data['image'] = $imageName;              
        endif;

        if(!empty($request->image_detail)):
            $image_detail_Name = time().'image_detail'.'.'.$request->image_detail->extension();

            $path = public_path().'/images/Products';

            if (! File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            $request->image_detail->move(public_path('images/Products'), $image_detail_Name);  
            //echo $image_detail_Name;
        chmod($path."/".$image_detail_Name, 0777);
            $oldImg = $path.'/'.$product->image_detail;


if(isset($product->image_detail)&&$product->image_detail !='')
{
if (File::exists($oldImg)) : // unlink or remove previous image from folder
                unlink($oldImg);
            endif;
}
            

            $data['image_detail'] = $image_detail_Name;
        endif;

        $product->update($data);       
                
        toastr()->success('Category updated successfully');

        return redirect()->route('products.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        // unlink or remove previous image from folder
        $path = public_path().'/images/Products';
        
        //Images List
        $oldImg = $path.'/'.$product->image;
            if (File::exists($oldImg)) : 
                unlink($oldImg);
            endif;
        //Image Detail
         $oldImg = $path.'/'.$product->image_detail;
            if (File::exists($oldImg)) : 
                unlink($oldImg);
            endif;
            
        toastr()->success('Product deleted successfully');
        return redirect()->route('products.index');
    }

    public function upsell(Request $request)
    {
        $id=$request['id'];
        $product = Product::find($id);
        
      product::where('id','<>',$id)->update(['upsell' => 'No']);
      product::where('id',$id)->update(['upsell' => 'Yes']);

}
}
