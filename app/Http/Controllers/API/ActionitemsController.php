<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\IpledgeAgreement;
use App\Models\User;
use App\Models\Mdcases;
use App\Models\Checkout;
use App\Models\CurexaOrder;
use App\Models\Cart;
use Validator;
use Exception;
use Carbon\Carbon;

class ActionitemsController extends BaseController
{
    public function index()
    {
 
    }

    public function getIpledgeAgreement(Request $request)
    {
        try{
            $answer = IpledgeAgreement::where('user_id', $request->user_id)->where('case_id', $request->case_id)->where('md_case_id', $request->md_case_id)->first();
                 return $this->sendResponse($answer, 'Form data retrieved successfully.');
        }catch(\Exception $ex){
            return $this->sendError('Server error', array($ex->getMessage()));
        }

    }

     public function addIpledgeAgreement(Request $request)      
    {
        $data = $request->all();
   
        try{
            $validator = Validator::make($data, [
                'user_id' => 'required',
                'case_id' => 'required',
                'md_case_id' => 'required',
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()->all());       
            }
            $agreement = IpledgeAgreement::where('user_id', $data['user_id'])->where('case_id', $data['case_id'])->where('md_case_id', $data['md_case_id'])->first();
            if(isset($agreement)){
                $agreementUpdate = IpledgeAgreement::where('id',$agreement->id)->update($data);
                return $this->sendResponse($data, 'Form Data Updated Successfully');
            }else{
                $agreementInsert = IpledgeAgreement::create($data);
                return $this->sendResponse($agreementInsert, 'Form Data Added Successfully');
            }
        }catch(\Exception $ex){
            return $this->sendError('Server error',array($ex->getMessage()));
        }
    }


    public function showActionItemsForm(Request $request){

        $user_id = $request['user_id'];
        $case_id = $request['case_id'];
        $md_case_id = $request['md_case_id'];

        $show_ipledge_agreement_form = false;
        $show_blood_work_labs_due = false;
        $show_ipledge_questions_due = false;

        $user_gender = User::select('gender')->where('id', $user_id)->first();

        $order_data = Checkout::where([['user_id', $user_id],['case_id', $case_id],['md_case_id', $md_case_id]])->first();

        $cart_ids = explode(',', $order_data['cart_id']);
        $pharmacy_data  =  Cart::select('pharmacy_pickup')->where('user_id',$user_id)->whereIn('id',$cart_ids)->where('order_type', '!=', 'AddOn')->first();
        $preferred_pharmacy_id = $pharmacy_data['pharmacy_pickup'];


        $curexadata = CurexaOrder::where('order_id',$order_data['order_id'])->first();

        $updated_at = new Carbon($curexadata['updated_at']);
        $now = Carbon::now();
        $difference = ($created->diff($now)->days < 1)
        ? 'today'
        : $created->diffForHumans($now);

        echo "<pre>";
        print_r($order_data);
        echo "<pre>";
        exit();

        //code for ipledge agreement(sign_ipledge_consent) and birthcontrol form (abstinence_form)
        
        $md_case_data = Mdcases::select('status','case_status_reason')->where('case_id', $md_case_id)->first();
        if($user_gender['gender'] =='male' && $md_case_data['status'] == 'completed' ){
            $show_ipledge_agreement_form = true;
        }

        if($user_gender['gender'] =='female' && $md_case_data['case_status_reason'] != NULL ){
            $show_ipledge_agreement_form = true;
        }
        //end of code for ipledge agreement(sign_ipledge_consent) and birthcontrol form (abstinence_form)



        $showscreen = array();
        $showscreen['show_ipledge_agreement_form'] =  $show_ipledge_agreement_form;
        $showscreen['show_blood_work_labs_due'] =  $show_blood_work_labs_due;
        $showscreen['show_ipledge_questions_due'] =  $show_ipledge_questions_due;

        return $this->sendResponse($showscreen,'Show Action Item Screen');
    }

    public function create()
    {

    }


    public function store(Request $request)
    {

    }


    public function show($id)
    {

    }

    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
