<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CaseManagement;
use App\Models\QuizCategory;
use App\Models\QuizAnswer;
use App\Models\Quiz;
use Session;


class CaseManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_case_management_data = CaseManagement::join('users','case_managements.user_id', '=', 'users.id')->select('case_managements.*','users.first_name','users.last_name','users.email')->get();
        return view('casemanagement.index', compact('user_case_management_data'))->with('i', ($request->input('page', 1) -1) * 5);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_case_management_data = CaseManagement::join('users','case_managements.user_id', '=', 'users.id')->select('case_managements.*','users.first_name','users.last_name','users.email')->where('case_managements.id',$id)->first();
        $category = QuizCategory::pluck('name', 'id')->toArray();

      /*  echo "<pre>";
        print_r($user_case_management_data);
        echo "<pre>";
        exit();*/
        //foreach ($user_case_management_data as $key => $value) {
        $quiz= QuizAnswer::join('quizzes','quiz_answers.question_id', '=', 'quizzes.id')->select('quiz_answers.*','quizzes.question','quizzes.category_id')->where('case_id', $user_case_management_data['id'])->OrderBy('id', 'ASC')->get();

        return view('casemanagement.view',compact('user_case_management_data','category','quiz'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     public function upload_pregnancy_test_report(Request $request)
    {


         $documents = $request->file('pregnancy_test');

        $this->validate($request, [
                'pregnancy_test' => 'required|mimes:jpg,jpeg,png,pdf',
        ],[
        'pregnancy_test.required' => 'Pregnancy Test file field is required.' ,
        'pregnancy_test.mimes' => 'Pregnancy Test File must be a file of type:jpg,jpeg,png,pdf' ,
        
      ]);

          

        if(!empty($documents)){

          $file =  $documents->getClientOriginalName();
          $doc_file_name =  time().'-'.$file;
          //$doc_file_name = time() . '-' . $doc->getClientOriginalExtension();

          if (!file_exists(public_path('/ipledgeimports/pregnancy_test'))) {
            File::makeDirectory(public_path('/ipledgeimports/pregnancy_test'), 0777, true, true);
          }

          $destinationPath = public_path('/ipledgeimports/pregnancy_test');
          $documents->move($destinationPath, $doc_file_name);

          //$input = array();
          //$input = request()->except(['_token']);
          //$input['files'] = 'public/ipledgeimports/' .$doc_file_name;
          //$input = $request->all();
          $input['pregnancy_test'] = $doc_file_name;

          CaseManagement::whereId($request['case_id'])->update($input);
          toastr()->success('Test Report Uploaded Successfully');

          return redirect()->back();
           
    }
}


 public function upload_blood_test_report(Request $request)
    {


         $documents = $request->file('blood_work');

        $this->validate($request, [
                'blood_work' => 'required|mimes:jpg,jpeg,png,pdf',
        ],[
        'blood_work.required' => 'Blood Work Test file field is required.' ,
        'blood_work.mimes' => 'Blood Work  File must be a file of type:jpg,jpeg,png,pdf' ,
        
      ]);

          

        if(!empty($documents)){

          $file =  $documents->getClientOriginalName();
          $doc_file_name =  time().'-'.$file;
          //$doc_file_name = time() . '-' . $doc->getClientOriginalExtension();

          if (!file_exists(public_path('/ipledgeimports/blood_work'))) {
            File::makeDirectory(public_path('/ipledgeimports/blood_work'), 0777, true, true);
          }

          $destinationPath = public_path('/ipledgeimports/blood_work');
          $documents->move($destinationPath, $doc_file_name);

          //$input = array();
          //$input = request()->except(['_token']);
          //$input['files'] = 'public/ipledgeimports/' .$doc_file_name;
          //$input = $request->all();
          $input['blood_work'] = $doc_file_name;

          CaseManagement::whereId($request['case_id'])->update($input);
          toastr()->success('Blood Work Report Uploaded Successfully');

          return redirect()->back();
           
    }
}

 public function i_pledge_agreement(Request $request)
    {
        $this->validate($request, [
                'i_pledge_agreement' => 'required',
        ]);

        if($request['i_pledge_agreement']!="" &&  $request['i_pledge_agreement'] ="Verify"){
                $input['i_pledge_agreement'] = "verified";
        }
          CaseManagement::whereId($request['case_id'])->update($input);
          toastr()->success('I Pledge Agreement Verified Successfully');

          return redirect()->back();
           
    
}

}
