<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usercasemanagement;
use App\Models\Fees;
use Session;


class FeesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    function __construct()
    {
        /* $this->middleware('permission:quiz-list|quiz-create|quiz-edit|quiz-delete', ['only' => ['index','store']]);
         $this->middleware('permission:quiz-create', ['only' => ['create','store']]);
         $this->middleware('permission:quiz-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:quiz-delete', ['only' => ['destroy']]);*/
    }

     public function index(Request $request)
    {

    	$data = array();
        //echo "hello";
        $fees_data = Fees::orderBy('id','DESC')->get();

        return view('fees.index', compact('fees_data'))->with('i', ($request->input('page', 1) -1) * 5);
    }

    public function create()
    {
        return view('fees.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',  
            'fee_type' => 'required',          
            'amount' => 'required|numeric|min:0',         
        ]);        

        $fees = Fees::create($request->all());
                
        toastr()->success('Fees created successfully');

        return redirect()->route('fees.index');
  
    }

     public function show($id)
    {  
       
        $user_case_management_data = Usercasemanagement::join('users','user_case_management.user_id', '=', 'users.id')->select('user_case_management.*','users.first_name','users.last_name','users.email')->where('user_case_management.id',$id)->first();

        $category = QuizCategory::pluck('name', 'id')->toArray();

        foreach ($category as $key => $value) {
            $quiz[$key][] = Quiz::where('category_id', $key)->OrderBy('id', 'ASC')->get();
        }

        return view('casemanagement.view',compact('user_case_management_data','category','quiz'));
    }

    public function edit($id)
    {
       $fees = Fees::find($id);  
              
        return view('fees.edit',compact('fees')); 
    }

    public function update(Request $request, $id)
    {
       $this->validate($request, [
            'title' => 'required',
            'fee_type' => 'required', 
            'amount' => 'required|numeric|min:0'                        
        ]); 
        
        $fee = Fees::find($id);
        $fee->update($request->all());       
                
        toastr()->success('Fee updated successfully');

        return redirect()->route('fees.index');
    }

     public function destroy($id)
    {
        $fee = Fees::find($id);
        $fee->delete();       
            
        toastr()->success('Fee deleted successfully');
        return redirect()->route('fees.index');
    }

   



}
