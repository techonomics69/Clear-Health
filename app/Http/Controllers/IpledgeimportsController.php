<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ipledge;
use App\Models\Ipledgehistory;
use App\Imports\IpledgeImport;
use Maatwebsite\Excel\Facades\Excel;
use Session;


class IpledgeimportsController extends Controller
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

        //echo "hello";
        //$ipledge_data = Ipledge::pluck('patient_id', 'id')->toArray();
        $ipledge_data = Ipledge::orderBy('id','DESC')->get();
        $ipledgehistory_data = Ipledgehistory::orderBy('id','DESC')->get();
        //$ipledge_data  =array();
        return view('ipledgeimports.index', compact('ipledge_data','ipledgehistory_data'))->with('i', ($request->input('page', 1) -1) * 5);
    }

    public function create()
    {
        //$category = QuizCategory::where('status','1')->pluck('name', 'id')->toArray();

        return view('ipledgeimports.create');
    }

    public function store(Request $request)
    {
        /*$this->validate($request, [
            'question' => 'required',  
            'status' => 'required|not_in:0',         
        ]);

        $quiz = Quiz::create($request->all());
                
        toastr()->success('Quiz created successfully');

        Session::put('que_current_tab', $request['category_id']);

        return redirect()->route('quiz.index');*/
    }

     public function show($id)
    {
       /* $quiz = Quiz::find($id);
        //$tags = Tag::pluck('tag', 'id')->toArray();
        return view('quiz.show',compact('quiz'));*/
    }

    public function edit($id)
    {
       /* $quiz = Quiz::find($id);
        $category = QuizCategory::where('status','1')->pluck('name', 'id')->toArray();
        return view('quiz.edit',compact('category','quiz'));*/
    }

    public function update(Request $request, $id)
    {
       /* $this->validate($request, [
            'question' => 'required',  
            'status' => 'required|not_in:0',          
        ]); 
        
        $quiz = Quiz::find($id);
        
        $quiz->update($request->all());  

        Session::put('que_current_tab', $request['category_id']);     
                
        toastr()->success('Quiz updated successfully');

        return redirect()->route('quiz.index');*/
    }

     public function destroy($id)
    {
        /*$quiz = Quiz::find($id);

        Session::put('que_current_tab', $quiz['category_id']);  

        $quiz->delete();       
            
        toastr()->success('Question deleted successfully');
        return redirect()->route('quiz.index');*/
    }

    public function import(Request $request) 
    {

       
        $documents = $request->file('files');

        $this->validate($request, [
                'files' => 'required|mimes:xlsx,xls,csv',//in:xlsx,xls,csv
                'imported_by'=>'required',
                'patients_type'=>'required',

        ],[
        'files.required' => 'The ipledge file field is required.' ,
        'files.mimes' => 'File must be a file of type: xlsx, xls, csv' ,
        
      ]);


         Excel::import(new IpledgeImport($request->patients_type),$request->file('files'));  


        if(!empty($documents)){

          $file =  $documents->getClientOriginalName();
          $doc_file_name =  time().'-'.$file;
          //$doc_file_name = time() . '-' . $doc->getClientOriginalExtension();

          if (!file_exists(public_path('/ipledgeimports'))) {
            File::makeDirectory(public_path('/ipledgeimports'), 0777, true, true);
          }

          $destinationPath = public_path('/ipledgeimports');
          $documents->move($destinationPath, $doc_file_name);

          //$input = array();
          $input = request()->except(['_token']);
          //$input['files'] = 'public/ipledgeimports/' .$doc_file_name;
          $input['files'] = $doc_file_name;
          $input['imported_by'] = $request->imported_by; 
          $input['patients_type'] = $request->patients_type; 
         

          Ipledgehistory::insert($input);
        }

        toastr()->success('Ipledge imported successfully');

        //Session::put('que_current_tab', $request['category_id']);

        //return redirect()->route('quiz.index');  
        return back();
    }

    public function downloaddocuments($id)
    {

      //PDF file is stored under project/public/download/info.pdf
      $document = Ipledgehistory::whereId($id)->first();
      
      $doc_file= 'public/ipledgeimports/'.$document->files;
   

    /*  $headers = array(
                'Content-Type: application/pdf',
            );*/


      //return response()->download($file, 'Invoice.pdf', $headers);
            return response()->download($doc_file);
        }



}
