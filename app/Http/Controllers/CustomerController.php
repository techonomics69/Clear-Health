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
use Carbon\Carbon;

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

    public function showList(Request $request)
    {

        $draw = $request->draw;
        $row = $request->start;
        $rowperpage = $request->length; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $totalRecords = User::where('role', '19')->count();
        $filterValue = $request->filterValue;


        /*filters*/
        switch ($filterValue) {
          case 'Current Month':
            $dateS = Carbon::now()->startOfMonth();
            $dateE = Carbon::now()->endOfMonth();
          break;
          case 'Last 3 Months':
           $dateS = Carbon::now()->startOfMonth()->subMonth(3);
            $dateE = Carbon::now()->endOfMonth();
          break;
          case 'Last 6 Months':
           $dateS = Carbon::now()->startOfMonth()->subMonth(6);
           $dateE = Carbon::now()->endOfMonth();
          break;
          case 'Custome Dates':
           $dateS = Carbon::now()->startOfMonth()->subMonth(2);
           $dateE = Carbon::now()->endOfMonth();
          break;
          default:
           $dateS = Carbon::now()->startOfMonth();
           $dateE = Carbon::now()->endOfMonth();
          break;
      }
      /*end filters*/

      /*for sorting*/
      switch ($columnName) {
          case 'no':
          $columnName = 'id';
          break;
          case 'firstname':
          $columnName = 'first_name';
          break;
          case 'lastname':
          $columnName = 'last_name';
          break;
          case 'gender':
          $columnName = 'gender';
          break;
          case 'email':
          $columnName = 'email';
          break;
          case 'dob':
          $columnName = 'dob';
          break;
          case 'address':
          $columnName = 'address';
          break;
          default:
          $columnName = $columnName;
          break;
      }

      if ($columnName == 'no') {
          $columnName = 'id';
      } else {
          $columnName = $columnName;
      }

      /*end of sorting*/

      $data = array();
      $searchValue = $_POST['search']['value'];

      $user_data = DB::table('users')->where('role', '19');

      if ($searchValue != '') {
        $user_data = $user_data->where('role', '19')->where('id', 'like', "%{$searchValue}%")
          ->orWhere('first_name', 'like', "%{$searchValue}%")->orWhere('last_name', 'like', "%{$searchValue}%")
          ->orWhere('gender', 'like', "%{$searchValue}%")->orWhere('email', 'like', "%{$searchValue}%")
          ->orWhere('dob', 'like', "%{$searchValue}%")->orWhere('address', 'like', "%{$searchValue}%");

        $usercase_count = DB::table('users')->where('role', '19')
          ->where('id', 'like', "%{$searchValue}%")
          ->orWhere('first_name', 'like', "%{$searchValue}%")->orWhere('last_name', 'like', "%{$searchValue}%")
          ->orWhere('gender', 'like', "%{$searchValue}%")->orWhere('email', 'like', "%{$searchValue}%")
          ->orWhere('dob', 'like', "%{$searchValue}%")->orWhere('address', 'like', "%{$searchValue}%");

        if (!empty($filterValue)) {
          //if (count($filterIn)) {
            $user_data = $user_data->whereBetween('created_at',[$dateS,$dateE]);
            $usercase_count = $usercase_count->whereBetween('created_at',[$dateS,$dateE]);
          //}
        }

        $user_count = $usercase_count->get()->count();
      } else {
       $usercase_count = DB::table('users')->where('role', '19');

        if (!empty($filterValue)) {
          //if (count($filterIn)) {
            $user_data = $user_data->whereBetween('created_at',[$dateS,$dateE])->toSql();


             echo "<pre>";
            print_r($dateS);
            echo "<pre>";
            
             echo "<pre>";
            print_r($dateE);
            echo "<pre>";

            echo "<pre>";
            print_r($user_data);
            echo "<pre>";
            exit();
            $usercase_count = $usercase_count->whereBetween('created_at',[$dateS,$dateE]);
          //}
        }

        $user_count = $usercase_count->get()->count();
      }

      $user_data = $user_data->orderBy($columnName, $columnSortOrder)
        ->offset($row)->limit($rowperpage)->get();

        foreach ($user_data as $key => $value) {

            $value = json_decode(json_encode($value), true);

            if ($columnSortOrder == "asc") {
                $counter = ($row == 0) ? ($usercase_count - ($key)) : ($usercase_count - ($key + $row));
            } else {
                $counter = ($row == 0) ? ($key + 1) : (($key + 1) + $row);
            }

            $action1 = '<div class="d-flex">
                <a class="icons edit-icon" href="'. route('customers.show',$value['id']).'"><i class="fa fa-eye"></i></a> <a class="icons edit-icon" href="'. route('customers.edit',$value['id']) .'"><i class="fa fa-edit"></i></a><form method="DELETE" action="'.route('customers.destroy',$value['id']).'" style="display:inline"><a class="icons edit-icon customer_delete" href="#" id="'.$value["id"].'" onclick="deleteCustomer('.$value["id"].')"><i class="fa fa-trash" aria-hidden="true"></i></a><button type="submit" class="btn_delete'.$value["id"].'" style="display:none;"></button></form>
                    </div>';
            $data[] = array(
                'no' => $counter,
                'firstname' => $value['first_name'],
                'lastname' => $value['last_name'],
                'gender' => (!empty($value['gender'])) ? strtoupper($value['gender']) : '',
                'email' => $value['email'],
                'dob' => $value['dob'],
                'address' => $value['address'],

               /* 'action1' => '<div class="d-flex">
                <a class="icons edit-icon" href="' . route('casemanagement.show', $value['id']) . '"><i class="fa fa-eye"></i></a>
                </div>',*/
                'action' => $action1,
            );
        }

         $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $usercase_count,
      "aaData" => $data
    );

    echo json_encode($response);

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
            //'passwords' => 'required|same:confirm-password',
            'first_name' => 'required',            
            'last_name' => 'required',
            'gender' => 'required',            
            'address' => 'required',
            'dob' => 'required',
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
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'address'=>$request->address,
            'gender'=>$request->gender,
            'dob'=>$request->dob,
            'role'=>'19'
            //'mobile'=>$request->mobile,
            //'password'=>Hash::make($request->passwords),
            //'state'=>$request->state,
            //'city'=>$request->city,
           // 'zip'=>$request->pincode,
            //'role'=>$request->roles,
            //'temp_password'=>$tempPass,
            //'status'=>isset($request->is_active) ? 1 : 0
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
            'first_name' => 'required',            
            'last_name' => 'required',
            'gender' => 'required',            
            'address' => 'required',
            'dob' => 'required',          
        ]);

        $input = $request->all();
        
        $user->update(array(
            // 'name'=>$request->name,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'address'=>$request->address,
            'gender'=>$request->gender,
            'dob'=>$request->dob,
            'role'=>'19'
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