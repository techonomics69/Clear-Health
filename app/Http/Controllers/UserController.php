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
    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC');
        $data = User::whereHas('roles', function($q){$q->where('name', '!=', 'Customer');})->with('roles')->orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data','roles'))
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
        return view('users.create',compact('roles'));
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
            'name' => 'required',
            'mobile' => 'required|unique:users,mobile|digits:10',
            'email' => 'required|email|unique:users,email',
            'roles' => 'required|not_in:0',            
            'gender' => 'required',            
            'address' => 'required',            
            'state' => 'required',            
            'city' => 'required',            
            'pincode' => 'required|numeric|digits:5',
            'passwords' => 'required|same:confirm-password|between:5,15',
        ],[
            'pincode.required' => 'The Zipcode field is required.',
            'pincode.between' => 'The Zipcode must be 5 digit number.',
            'passwords.required' => 'The Password field is required.',
            'passwords.same' => 'The password and confirm-password must match.',
            'passwords.between' => 'The password must be between 5 and 15 characters.'
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
            'name'=>$request->name,
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
            'status'=>isset($request->is_active) ? 1 : 0
          ));
        $user->assignRole($request->roles);
    
        toastr()->success('User created successfully');

        return redirect()->route('users.index');
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
        return view('users.show',compact('user'));
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
    
        return view('users.edit',compact('user','roles','userRole'));
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
            'name' => 'required',
            'mobile' => 'required|unique:users,mobile,'.$user->id.'|digits:10',
            'email' => 'required|unique:users,email,'.$user->id,
            'roles' => 'required|not_in:0',            
            'gender' => 'required',    
            'address' => 'required',            
            'state' => 'required',            
            'city' => 'required',         
            'pincode' => 'required|numeric|digits:5'
        ],[
            'pincode.required' => 'The Zipcode field is required.',
            'pincode.digits' => 'The Zipcode must be 5 digit number.'
        ]);
    
        $input = $request->all();
        
        $user->update(array(
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'address'=>$request->address,
            'state'=>$request->state,
            'city'=>$request->city,
            'zip'=>$request->pincode,
            'gender'=>$request->gender,
            'role'=>$request->roles,
            'status'=>isset($request->is_active) ? 1 : 0
        ));
        
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        toastr()->success('User updated successfully');

        return redirect()->route('users.index');
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
        toastr()->success('User deleted successfully');

        return redirect()->route('users.index');
    }
}