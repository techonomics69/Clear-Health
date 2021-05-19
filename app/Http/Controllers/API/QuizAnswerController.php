<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\QuizAnswer;
use App\Models\Quiz;
use App\Models\Answers;
use Validator;
use Exception;
use Lcobucci\JWT\Parser;
use App\Models\CaseManagement;

class QuizAnswerController extends BaseController
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
            $data['case_id'] = CaseManagement::where('user_id', $data['user_id'])->OrderBy('id','desc')->first()->id;

        endif;       
        try{
            $validator = Validator::make($data, [
                'user_id' => 'required',
                'question_id' => 'required',
                'answer' => 'required',
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()->all());       
            }
            $answer = QuizAnswer::where('user_id', $data['user_id'])->where('question_id', $data['question_id'])->where('case_id', $data['case_id'])->first();
            if(!empty($answer)):
            	$answer->update($data);
            else:
            	$quizAns = QuizAnswer::create($data);
            endif;
            
            return $this->sendResponse(array(), 'Answer submitted successfully');
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

    public function getAnswerByUser($id)
    {
        try{
            $answer = QuizAnswer::where('user_id', $id)->get();
            return $this->sendResponse($answer, 'Answer retrieved successfully.');
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }

    }

    public function getAnswerByQuestion($id)
    {
        try{
            $answer = QuizAnswer::where('question_id', $id)->get();
            return $this->sendResponse($answer, 'Answer retrieved successfully.');
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }

    }

    public function getAnswerByUserQuestionCaseID(Request $request)
    {
        try{
            $answer = QuizAnswer::where('user_id', $request->user_id)->where('question_id', $request->question_id)->where('case_id', $request->case_id)->first();
            if(!empty($answer)){
                 return $this->sendResponse($answer, 'Answer retrieved successfully.');
            }else{
                return $this->sendResponse($answer =array(), 'No Data Found.');
            }
           
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }

    }

    public function ProductRecommend(Request $request)
    {
        //dd($request->all());
       // try{

        $user_id = $request['user_id'];
        $case_id = $request['case_id'];

            $answer_data = Answers::where('user_id', $user_id)->where('case_id', $case_id)->get();

            echo "<pre>";
            print_r( $answer_data);
            echo "<pre>";
            exit();
            $recommendation = json_decode($answer_data[0]['answer']);

            echo "<pre>";
            print_r($recommendation);
            echo "<pre>";
            exit();

           

            $a1 = 0;
            $a2 = 0;
            $a3 = 0;
            $b1 = 0;
            $b2 = 0;
            $c1 = 0;
            $ts1 = 0;
            $ts2 = 0;
            $data = 'accutane';
            foreach ($recommendation as $key => $value) {

                if($value->recommendation_product == 'recommendation_1'){
                    //dd($request->case_id);
                    //$a1 = 0;
                    //$answer = QuizAnswer::where('user_id', $request->user_id)->where('question_id', $value->id)->where('case_id', $request->case_id)->first();

                     $answer = $value->recommendation_product;

                    if(isset($answer->answer)){
                        if($answer->answer == 'Mild– just a few pimples here and there. Mostly whiteheads and blackheads with a few inflamed bumps here and there.'){
                            $a1 = 1;
                        }else if($answer->answer == 'Moderate– multiple inflamed pimples with new ones popping up. Acne is inflamed and red.'){
                            $a1 = 2;
                        }else if($answer->answer == 'Moderately Severe– a large number of inflamed pimples with some deeper, more painful nodules that do not come to a head. Acne leaves moderate scarring.'){
                            $a1 = 3;
                        }else if($answer->answer == 'Severe– a large number of inflamed pimples with multiple deep, painful nodules that do not come to a head. Acne leaves significant scarring.'){
                            $a1 = 4;
                        }
                    }
                }
                if($value->recommendation_product == 'recommendation_2'){
                    //$a2 = 0;
                    $answer = QuizAnswer::where('user_id', $request->user_id)->where('question_id', $value->id)->where('case_id', $request->case_id)->first();
                    if(isset($answer->answer)){
                        if($answer->answer == 'It doesn’t really bother me'){
                            $a2 = 1;
                        }else if($answer->answer == 'I do notice that it’s there but it doesn’t prevent me from doing day to day things'){
                            $a2 = 2;
                        }else if($answer->answer == 'It bothers me and I do feel self-conscious about it sometimes when other people point it out'){
                            $a2 = 3;
                        }else if($answer->answer == 'It bothers me a lot.I sometimes skip out on things because of my acne and it affects my self-esteem.'){
                            $a2 = 4;
                        }else if($answer->answer == 'My acne is the primary thing that holds back my confidence and I feel like it holds me back from enjoying things as much as I want to.'){
                            $a2 = 5;
                        }
                    }
                }
                if($value->recommendation_product == 'recommendation_3'){
                    //$a3 = 0;
                    $answer = QuizAnswer::where('user_id', $request->user_id)->where('question_id', $value->id)->where('case_id', $request->case_id)->first();
                    if(isset($answer->answer)){
                        if($answer->answer == 'My acne does not scar'){
                            $a3 = 1;
                        }else if($answer->answer == 'I tend to get dark marks and pigmentation from my acne'){
                            $a3 = 2;
                        }else if($answer->answer == 'My skin does tend to scar and causes depressions and bumps after my acne heals'){
                            $a3 = 3;
                        }
                    }
                }
                if($value->recommendation_product == 'recommendation_4'){
                    //$b1 = 0;
                    $answer = QuizAnswer::where('user_id', $request->user_id)->where('question_id', $value->id)->where('case_id', $request->case_id)->first();
                    if(isset($answer->answer)){
                        if($answer->answer == 'Yes'){
                            $b1 = 1;
                        }
                    }
                }
                if($value->recommendation_product == 'recommendation_5'){
                    //$b2 = null;
                    $answer = QuizAnswer::where('user_id', $request->user_id)->where('question_id', $value->id)->where('case_id', $request->case_id)->first();
                    if(isset($answer->answer)){
                        if($answer->answer == 'Topical Retinoids (Differin Retin-A Tazorac etc.)'){
                            $b2 = 0;
                        }else if($answer->answer == 'Topical Antibiotics (Benzaclin Duac etc.)'){
                            $b2 = 0;
                        }else if($answer->answer == 'Combination Antibiotic/Retinoid cream'){
                            $b2 = 0;
                        }else if($answer->answer == 'Oral Antibiotics (Doxycycline Minocycline Azythromycin etc.)'){
                            $b2 = 0;
                        }else if($answer->answer == 'Oral Contraceptives (Yaz Ortho Tri-Cyclen)'){
                            $b2 = 1;
                        }else if($answer->answer == 'Azelaic Acid (Azelex Finacea)'){
                            $b2 = 1;
                        }else if($answer->answer == 'Dapsone (Aczone)'){
                            $b2 = 1;
                        }else if($answer->answer == 'Accutane (Isotretinoin)'){
                            $b2 = 1;
                        }else if($answer->answer == 'Other'){
                            $b2 = 1;
                        }
                    }
                }
                if($value->recommendation_product == 'recommendation_6'){
                    //$c1 = 0;
                    $answer = QuizAnswer::where('user_id', $request->user_id)->where('question_id', $value->id)->where('case_id', $request->case_id)->first();
                    if(isset($answer->answer)){
                        if($answer->answer == 'Yes'){
                            $c1 = 1;
                        }
                    }
                }
                if($value->recommendation_product == 'recommendation_7'){
                    //$ts1 = 0;
                    $answer = QuizAnswer::where('user_id', $request->user_id)->where('question_id', $value->id)->where('case_id', $request->case_id)->first();
                    if(isset($answer->answer)){
                        if($answer->answer == 'Very Dry'){
                            $ts1 = 1;
                        }else if($answer->answer == 'Dry'){
                            $ts1 = 1;
                        }else if($answer->answer == 'Combination'){
                            $ts1 = 2;
                        }else if($answer->answer == 'Oily'){
                            $ts1 = 2;
                        }else if($answer->answer == 'Very Oily'){
                            $ts1 = 2;
                        }
                    }
                }
                if($value->recommendation_product == 'recommendation_8'){
                    //$ts2 = 0;
                    $answer = QuizAnswer::where('user_id', $request->user_id)->where('question_id', $value->id)->where('case_id', $request->case_id)->first();
                    if(isset($answer->answer)){
                        if($answer->answer == 'Yes'){
                            $ts2 = 1;
                        }else if($answer->answer == 'No'){
                            $ts2 = 2;
                        }
                    }
                }
                
                
             } 
             $a = $a1+$a2+$a3;
             $b = $b1+$b2;
             $c = $c1;

             
            /* if($c == 1){
                $data = 'Accutane';
             }else if($a+$b>12){
                $data = 'Accutane';
             }else{
                if($ts1 == 1){
                    $data = 'Topical_low';
                }else if($ts1 == 2){
                    $data = 'Topical_high';
                }
             }*/

              if($a+$b>=11){
                $data = 'Accutane';
             }else if($c == 1){
                $data = 'Accutane';
             }else if($a+$b<11 && $c == 1){
                 $data = 'Accutane';
             }else{
                if($ts1 == 1){
                    $data = 'Topical_low';
                }else if($ts1 == 2){
                    $data = 'Topical_high';
                }
             }


            return $this->sendResponse($data, 'Product recommendation successfully.');   
           // }
           // catch(\Exception $ex){
          //  return $this->sendError('Server error', array($ex->getMessage()));
        // }
    
        }
}
