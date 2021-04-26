<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
    
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete', ['only' => ['index','store']]);
         $this->middleware('permission:customer-create', ['only' => ['create','store']]);
         $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC');
        $data = User::where('role', '19')->orderBy('id','DESC')->get();
        return view('customers.index',compact('data','roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','id')->all();
        return view('customers.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            // 'name' => 'required',            
            'email' => 'required|email|unique:users,email',            
            'passwords' => 'required|same:confirm-password',
        ]);        

        $n = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $tempPass = ''; 

        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $tempPass .= $characters[$index]; 
        }
    
        $input = $request->all();
        $user = User::create(array(
            // 'name'=>$request->name,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'password'=>Hash::make($request->passwords),
            'address'=>$request->address,
            'state'=>$request->state,
            'city'=>$request->city,
            'zip'=>$request->pincode,
            'gender'=>$request->gender,
            'role'=>$request->roles,
            'temp_password'=>$tempPass,
            'role'=>'19',
            'status'=>isset($request->is_active) ? 1 : 0
          ));
        $user->assignRole(19);
    
        toastr()->success('Customer created successfully');

        return redirect()->route('customers.index');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('customers.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','id')->all();
        $userRole = $user->roles->pluck('name','id')->all();
    
        return view('customers.edit',compact('user','roles','userRole'));
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
        $user = User::find($id);
        $this->validate($request, [
            // 'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,           
            //'email' => 'required|unique:users,email,'.$user->id,           
        ]);
    
        $input = $request->all();
        
        $user->update(array(
            // 'name'=>$request->name,
            'role'=>'19',
            'email'=>$request->email,
        ));
        
       
    
        toastr()->success('Customer updated successfully');

        return redirect()->route('customers.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        toastr()->success('Customer deleted successfully');

        return redirect()->route('customers.index');
    }
}