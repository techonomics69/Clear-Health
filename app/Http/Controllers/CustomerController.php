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

        //$now = Carbon::now();

        $dateS = Carbon::now()->startOfMonth()->subMonth(3);
        $dateE = Carbon::now()->startOfMonth();


        /*filters*/
        switch ($filterValue) {
          case 'Current Month':
          $filterIn = $now->month;
          break;
          case 'Action by admin':
          $filterIn = array(
              'generate_ipledge', 'store_ipledge', 'verify_pregnancy',
              'prior_auth', 'check_off_ipledge', 'trigger', 'blood_work',
              'low_income_program'
          );
          break;
          case 'Action by Patient':
          $filterIn = array('submission_of_iPledge', 'complete_follow_up', 'picks_up_medication', 'complete_bloodwork');
          break;
          case 'No action required':
          $filterIn = array('NULL', 'finish');
          break;
          default:
          $filterIn = array();
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

      $user_data =User::where('role', '19')->orderBy('id','DESC')->get();

      if ($searchValue != '') {
        $user_data = $user_data->where('id', 'like', "%{$searchValue}%")
          ->orWhere('first_name', 'like', "%{$searchValue}%")->orWhere('last_name', 'like', "%{$searchValue}%")
          ->orWhere('gender', 'like', "%{$searchValue}%")->orWhere('email', 'like', "%{$searchValue}%")
          ->orWhere('dob', 'like', "%{$searchValue}%")->orWhere('address', 'like', "%{$searchValue}%");

        /*$usercase_count = DB::table('case_managements as cm')->join('users as u', 'cm.user_id', '=', 'u.id')
          ->leftjoin('case_histories as ch', 'cm.id', '=', 'ch.case_id')
          ->select(
            'cm.*',
            'u.email',
            'u.first_name',
            'u.last_name',
            'u.gender',
            'ch.case_status as caseStatus'
          )->where('cm.created_at', 'like', "%{$searchValue}%")
          ->orWhere('cm.ref_id', 'like', "%{$searchValue}%")->orWhere('u.first_name', 'like', "%{$searchValue}%")
          ->orWhere('u.last_name', 'like', "%{$searchValue}%")->orWhere('u.gender', 'like', "%{$searchValue}%")
          ->orWhere('cm.md_case_id', 'like', "%{$searchValue}%");*/

        if (!empty($filterValue)) {
          if (count($filterIn)) {
            $user_data = $user_data->whereIn('created_at', $filterIn);
            //$usercase_count = $usercase_count->whereIn('ch.case_status', $filterIn);
          }
        }

        $user_count = $user_data->get()->count();
      } else {
        $user_count = User::where('role', '19')->orderBy('id','DESC')->get();

        if (!empty($filterValue)) {
          if (count($filterIn)) {
            $user_data = $user_data->whereIn('created_at', $filterIn);
            //$usercase_count = $usercase_count->whereIn('ch.case_status', $filterIn);
          }
        }

        $user_count = $usercase_count->get()->count();
      }
      $user_data = $user_data->orderBy($columnName, $columnSortOrder)
        ->offset($row)->limit($rowperpage)->get();

        foreach ($user_case_management_data as $key => $value) {

            echo "<pre>";
            print_r($value);
            echo "<pre>";
            exit();
            $value = json_decode(json_encode($value), true);

            if ($columnSortOrder == "asc") {
                $counter = ($row == 0) ? ($usercase_count - ($key)) : ($usercase_count - ($key + $row));
            } else {
                $counter = ($row == 0) ? ($key + 1) : (($key + 1) + $row);
            }

            $action1 = '<div class="d-flex">
                <a class="icons edit-icon" href="{{'. route('customers.show',$user->id).'}}"><i class="fa fa-eye"></i></a> <a class="icons edit-icon" href="{{'. route('customers.edit',$user->id) .'}}"><i class="fa fa-edit"></i></a>{!! Form::open(["method" => "DELETE","route" => ["customers.destroy", $user->id],"style"=>"display:inline"]) !!}<a class="icons edit-icon customer_delete" href="#" id="{{$user->id}}" onclick="deleteCustomer({{$user->id}})"><i class="fa fa-trash" aria-hidden="true"></i></a><button type="submit" class="btn_delete{{$user->id}}" style="display:none;"></button>{!! Form::close() !!}
                    </div>'
            $data[] = array(
                'no' => $counter,
                'firstname' => $value['first_name'],
                'lastname' => $value['last_name'],
                'gender' => (!empty($value['gender'])) ? strtoupper($value['gender'][0]) : '',

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