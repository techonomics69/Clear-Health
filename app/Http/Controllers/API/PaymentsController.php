<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;

use Exception;
//use App\Payment;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\Checkout;
use App\Models\User;
use App\Models\Subscription;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\SubscriptionLog;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class PaymentsController extends BaseController
{

    public function index()
    {
        //
    }

    public function create()
    {
        //return view('payments.create');
    }

    public function store()
    {
        /* echo "<pre>";
        print_r(env('STRIPE_SECRET_KEY'));
        echo "<pre>";
        exit();
*/
        /*
        order_id
        username
        user email
        amount
        user_id

        */


        request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            //'terms_conditions' => 'accepted'
        ]);

        /** I have hard coded amount. You may fetch the amount based on customers order or anything */
        $amount     = (int)request('amount') * 100;
        $currency   = 'USD';

        if (empty(request('stripeToken'))) {
            return $this->sendResponse(back()->withInput(), 'Some error while making the payment. Please try again');
        }
        Stripe::setApiKey('sk_test_51J08tDJofjMgVsOdzxZs5Aqlf5A9riwPPwlxUTriC8YPiHvTjlCBoaMjgxiqdIVfvOMPcllgR9JY7EZlihr6TJHy00ixztHFtz');

        $user_data = User::select('id', 'customer_id')->where('email', request('email'))->first();
        $user_id = $user_data['id'];

        if ($user_data['customer_id'] != NULL) {
            $customer_id = $user_data['customer_id'];
        } else {
            try {
                /** Add customer to stripe, Stripe customer */
                $customer = Customer::create([
                    'email'     => request('email'),
                    'source'    => request('stripeToken')
                ]);

                //Store customer id in DB for future transaction
                $customer_id = $customer->id;
                User::where('id', $user_id)->update(['customer_id' => $customer_id]);
            } catch (Exception $e) {
                $apiError = $e->getMessage();
            }
        }

        if (empty($apiError) && $customer_id) {
            /** Charge a credit or a debit card */
            try {
                /** Stripe charge class */
                $charge = Charge::create(array(
                    'customer'      => $customer_id,
                    'amount'        => $amount,
                    'currency'      => $currency,
                    //'description'   => 'Some testing description'
                ));
            } catch (Exception $e) {
                $apiError = $e->getMessage();
            }



            if (empty($apiError) && $charge) {
                // Retrieve charge details 
                $paymentDetails = $charge->jsonSerialize();



                if ($paymentDetails['amount_refunded'] == 0 && empty($paymentDetails['failure_code']) && $paymentDetails['paid'] == 1 && $paymentDetails['captured'] == 1) {
                    /** You need to create model and other implementations */
                    /*
                    Payment::create([
                        'name'                          => request('name'),
                        'email'                         => request('email'),
                        'amount'                        => $paymentDetails['amount'] / 100,
                        'currency'                      => $paymentDetails['currency'],
                        'transaction_id'                => $paymentDetails['balance_transaction'],
                        'payment_status'                => $paymentDetails['status'],
                        'receipt_url'                   => $paymentDetails['receipt_url'],
                        'transaction_complete_details'  => json_encode($paymentDetails)
                    ]);
                    */
                    Checkout::where('id', request('order_id'))->update(['transaction_id' => $paymentDetails['balance_transaction'], 'customer' => $paymentDetails['customer'], 'payment_method' => $paymentDetails['payment_method'], 'payment_status' => $paymentDetails['status'], 'transaction_complete_details' => json_encode($paymentDetails)]);

                    $data['id'] = request('order_id');
                    $data['amount'] = request('amount');
                    $data['transaction_id'] = $paymentDetails['balance_transaction'];
                    $data['payment_status'] = $paymentDetails['status'];
                    $data['customer'] = $paymentDetails['customer'];
                    $data['payment_method'] = $paymentDetails['payment_method'];
                    $data['transaction_complete_details'] = json_encode($paymentDetails);


                    //return redirect('/thankyou/?receipt_url=' . $paymentDetails['receipt_url']);
                    return $this->sendResponse($data, 'Payment done successfully.');
                } else {
                    //session()->flash('error', 'Transaction failed');
                    //return back()->withInput();
                    return $this->sendResponse(back()->withInput(), 'Transaction failed.');
                }
            } else {
                //session()->flash('error', 'Error in capturing amount: ' . $apiError);
                //return back()->withInput();
                return $this->sendResponse(back()->withInput(), 'Error in capturing amount: ' . $apiError);
            }
        } else {
            //session()->flash('error', 'Invalid card details: ' . $apiError);
            //return back()->withInput();
            return $this->sendResponse(back()->withInput(), 'Invalid card details:' . $apiError);
        }
    }

    public function updateMyPlan(Request $request){
        $validator = \Validator::make($request->all(),[  
            'user_id'       =>  'required',
            'case_id'       =>  'required',
            'md_case_id'    =>  'required',
            'products'      =>  'required',
            'plan_price'    =>  'required',
            'current_subscription_id'   =>  'required',
        ], [
            'user_id.required'  =>  'Request has missing User id',
            'case_id.required'  =>  'Request has missing Case id',
            'md_case_id.required'  =>  'Request has missing Md Case id',
            'products.required'  =>  'Request has missing Products',
            'plan_price.required'  =>  'Request has missing Plan price',
            'current_subscription_id.required'   =>  'Request has missing Current subscription id',
        ]);
      
        if($validator->fails()){
            return $this->sendError($validator->errors()->first());
        } 
        $products = (strpos($request->products, ",") !== false) ? (!empty($request->products)) ? explode(",", $request->products) : array() : (!empty($request->products)) ? explode(",", $request->products) : array();
        Stripe::setApiKey('sk_test_51J08tDJofjMgVsOdzxZs5Aqlf5A9riwPPwlxUTriC8YPiHvTjlCBoaMjgxiqdIVfvOMPcllgR9JY7EZlihr6TJHy00ixztHFtz'); 
        $storePreviousData = [];
        $previousData = Subscription::find($request->current_subscription_id);
        if(!empty($previousData)){
            $getTable = new Subscription;
            $table = $getTable->getTable();
            $getColumns = Schema::getColumnListing($table);
            foreach($getColumns as $key => $value){
                //echo $previousData[$value]."<br>";
                $storePreviousData[$value] = $previousData[$value];
            }    
            $storePreviousData['subscription_id'] = $previousData['id'];
            $product_id = explode(",",$previousData['product_id']);
            $products = explode(",",$request->products);
            $diff = array_diff($product_id, $products);
            dd($diff);
            if(count($diff)>0){
            }else{
                return $this->sendError('Can not update plan! please select new products');    
            }
        }else{
            return $this->sendError('Subscriptions data not found');
        }
        

        $plans = array(
            '1' => array(
                'name' => 'Weekly Subscription',
                'price' => 25,
                'interval' => 'week'
            ),
            '2' => array(
                'name' => 'Daily Subscription',
                'price' => request('plan_price'),
                'interval' => 'day'
            ),
            '3' => array(
                'name' => 'Yearly Subscription',
                'price' => 950,
                'interval' => 'year'
            )
        );

        $planID = 2;
        $planInfo = $plans[$planID];
        $planName = $planInfo['name'];
        $planPrice = $planInfo['price'];
        $planInterval = $planInfo['interval'];

        $customer = User::select('customer_id')->where('id',$request->user_id)->first();
        if(!empty($customer)){
            $priceCents = round($planPrice * 100);
            $currency = "USD";
            try {
                $plan = \Stripe\Plan::create(array(
                    "product" => [
                        "name" => $planName
                    ],
                    "amount" => $priceCents,
                    "currency" => $currency,
                    "interval" => $planInterval,
                    "interval_count" => 1
                ));
            } catch (Exception $e) {
                $apiError = $e->getMessage();
            }
            if (empty($apiError) && $plan) {
                try {
                    $subscription = \Stripe\Subscription::create(array(
                        "customer" => $customer['customer_id'],
                        "items" => array(
                            array(
                                "plan" => $plan->id,
                            ),
                        ),
                    ));
                } catch (Exception $e) {
                    $apiError = $e->getMessage();
                }
                if (empty($apiError) && $subscription) {
                    // Retrieve charge details 
                    $subsData = $subscription->jsonSerialize();
                    if ($subsData['status'] == 'active') {
                        // Subscription info 
                        $input_subscr = array();

                        $input_subscr['user_id'] = request('user_id');
                        $input_subscr['case_id'] = request('case_id');
                        $input_subscr['md_case_id'] = request('md_case_id');
                        $input_subscr['subscr_id'] = $subsData['id'];
                        $input_subscr['product_id'] = request('product_id');
                        $input_subscr['customer'] = $subsData['customer'];
                        $input_subscr['plan_id'] = $subsData['plan']['id'];
                        $input_subscr['plan_amount'] = ($subsData['plan']['amount'] / 100);
                        $input_subscr['plan_currency'] = $subsData['plan']['currency'];
                        $input_subscr['plan_interval'] = $subsData['plan']['interval'];
                        $input_subscr['plan_interval_count'] = $subsData['plan']['interval_count'];
                        $input_subscr['created'] = date("Y-m-d H:i:s", $subsData['created']);
                        $input_subscr['current_period_start'] = date("Y-m-d H:i:s", $subsData['current_period_start']);
                        $input_subscr['current_period_end'] = date("Y-m-d H:i:s", $subsData['current_period_end']);
                        $input_subscr['subscribed_at'] = Carbon::now();
                        $input_subscr['status'] = $subsData['status'];
                        $input_subscr['renew_flag'] = true;

                        
                        $add_subscr = Subscription::where('id',$request->current_subscription_id)->update($input_subscr);

                        $updatePrevious = SubscriptionLog::create($storePreviousData);

                        return $this->sendResponse($input_subscr, 'Subscription done successfully');
                    } else {
                        return $this->sendError('Subscription activation failed');
                    }
                } else {
                    return $this->sendError('Subscription creation failed! ' . $apiError);
                }
            }else{
                return $this->sendError('Error in capturing amount: ' . $apiError);
            }
        }else{
            return $this->sendError('Customer id is not found in system');
        }
    }

    public function subscribe_store()
    {
        request()->validate([
            'email' => 'required|email',
        ]);
        // Plan info 

        // $plans = array(
        //     '1' => array(
        //         'name' => 'Weekly Subscription',
        //         'price' => 25,
        //         'interval' => 'week'
        //     ),
        //     '2' => array(
        //         'name' => 'Monthly Subscription',
        //         'price' => request('plan_price'),
        //         'interval' => 'month'
        //     ),
        //     '3' => array(
        //         'name' => 'Yearly Subscription',
        //         'price' => 950,
        //         'interval' => 'year'
        //     )
        // );

        $plans = array(
            '1' => array(
                'name' => 'Weekly Subscription',
                'price' => 25,
                'interval' => 'week'
            ),
            '2' => array(
                'name' => 'Daily Subscription',
                'price' => request('plan_price'),
                'interval' => 'day'
            ),
            '3' => array(
                'name' => 'Yearly Subscription',
                'price' => 950,
                'interval' => 'year'
            )
        );
        //$planID = request('subscr_plan'); 
        $planID = 2;
        $planInfo = $plans[$planID];
        $planName = $planInfo['name'];
        $planPrice = $planInfo['price'];
        $planInterval = $planInfo['interval'];

        $currency = "USD";

        if (empty(request('stripeToken'))) {
            return $this->sendResponse(back()->withInput(), 'Some error while making the payment. Please try again');
        }
        Stripe::setApiKey('sk_test_51J08tDJofjMgVsOdzxZs5Aqlf5A9riwPPwlxUTriC8YPiHvTjlCBoaMjgxiqdIVfvOMPcllgR9JY7EZlihr6TJHy00ixztHFtz');
        // try {
        //     /** Add customer to stripe, Stripe customer */
        //     $customer = Customer::create([
        //         'email'     => request('email'),
        //         'source'    => request('stripeToken')
        //     ]);
        // } catch (Exception $e) {
        //     $apiError = $e->getMessage();
        // }

        $user_data = User::select('id', 'customer_id')->where('email', request('email'))->first();
        $user_id = $user_data['id'];

        if ($user_data['customer_id'] != NULL) {
            $customer_id = $user_data['customer_id'];
        } else {
            try {
                /** Add customer to stripe, Stripe customer */
                $customer = Customer::create([
                    'email'     => request('email'),
                    'source'    => request('stripeToken')
                ]);

                //Store customer id in DB for future transaction
                $customer_id = $customer->id;
                User::where('id', $user_id)->update(['customer_id' => $customer_id]);
            } catch (Exception $e) {
                $apiError = $e->getMessage();
            }
        }

        if (empty($apiError) && $customer_id) {

            //Store customer id in DB for future transaction

            /** Charge a credit or a debit card */
            // Convert price to cents 
            $priceCents = round($planPrice * 100);

            // Create a plan 
            try {
                $plan = \Stripe\Plan::create(array(
                    "product" => [
                        "name" => $planName
                    ],
                    "amount" => $priceCents,
                    "currency" => $currency,
                    "interval" => $planInterval,
                    "interval_count" => 1
                ));
            } catch (Exception $e) {
                $apiError = $e->getMessage();
            }

            if (empty($apiError) && $plan) {
                try {
                    $subscription = \Stripe\Subscription::create(array(
                        "customer" => $customer_id,
                        "items" => array(
                            array(
                                "plan" => $plan->id,
                            ),
                        ),
                    ));
                } catch (Exception $e) {
                    $apiError = $e->getMessage();
                }
                if (empty($apiError) && $subscription) {
                    // Retrieve charge details 
                    $subsData = $subscription->jsonSerialize();
                    if ($subsData['status'] == 'active') {
                        // Subscription info 
                        $input_subscr = array();

                        $input_subscr['user_id'] = request('user_id');
                        $input_subscr['case_id'] = request('case_id');
                        $input_subscr['md_case_id'] = request('md_case_id');
                        $input_subscr['subscr_id'] = $subsData['id'];
                        $input_subscr['product_id'] = request('product_id');
                        $input_subscr['customer'] = $subsData['customer'];
                        $input_subscr['plan_id'] = $subsData['plan']['id'];
                        $input_subscr['plan_amount'] = ($subsData['plan']['amount'] / 100);
                        $input_subscr['plan_currency'] = $subsData['plan']['currency'];
                        $input_subscr['plan_interval'] = $subsData['plan']['interval'];
                        $input_subscr['plan_interval_count'] = $subsData['plan']['interval_count'];
                        $input_subscr['created'] = date("Y-m-d H:i:s", $subsData['created']);
                        $input_subscr['current_period_start'] = date("Y-m-d H:i:s", $subsData['current_period_start']);
                        $input_subscr['current_period_end'] = date("Y-m-d H:i:s", $subsData['current_period_end']);
                        $input_subscr['subscribed_at'] = Carbon::now();
                        $input_subscr['status'] = $subsData['status'];
                        $input_subscr['renew_flag'] = false;

                        $add_subscr = Subscription::create($input_subscr);

                        return $this->sendResponse($input_subscr, 'Subscription done successfully');
                    } else {
                        return $this->sendResponse(back()->withInput(), 'Subscription activation failed');
                    }
                } else {
                    return $this->sendResponse(back()->withInput(), 'Subscription creation failed! ' . $apiError);
                }
            } else {
                return $this->sendResponse(back()->withInput(), 'Error in capturing amount: ' . $apiError);
            }
        } else {
            return $this->sendResponse(back()->withInput(), 'Invalid card details: ' . $apiError);
        }
    }

    public function cancel_subscription()
    {
        $sub_id = request('subscr_id');
        Stripe::setApiKey('sk_test_51J08tDJofjMgVsOdzxZs5Aqlf5A9riwPPwlxUTriC8YPiHvTjlCBoaMjgxiqdIVfvOMPcllgR9JY7EZlihr6TJHy00ixztHFtz');

        $subscription = \Stripe\Subscription::retrieve($sub_id);
        $cancle = $subscription->cancel();

        if ($cancle['status'] == 'canceled') {

            $subscription_status = Subscription::where('subscr_id', request('subscr_id'))->update(['status' => 'canceled']);

            if ($subscription_status) {
                return $this->sendResponse(array(), 'Subscription cancleded successfully.');
            } else {
                return $this->sendResponse(array(), 'Something went wrong.');
            }
        } else {
            return $this->sendResponse(back()->withInput(), 'Subscription creation failed! ');
        }
    }

    public function customer_payment_methods()
    {
        Stripe::setApiKey('sk_test_51J08tDJofjMgVsOdzxZs5Aqlf5A9riwPPwlxUTriC8YPiHvTjlCBoaMjgxiqdIVfvOMPcllgR9JY7EZlihr6TJHy00ixztHFtz');

        $paymentDetails = \Stripe\PaymentMethod::all([
            'customer' => request('customer'),
            'type' => 'card',
        ]);
        return $this->sendResponse($paymentDetails, 'Customer payment method received successfully ');
    }

    public function customer_make_direct_payment()
    {
        $customer_id = request('customer');
        $payment_method_id = request('payment_method');
        $amount = request('amount');

        Stripe::setApiKey('sk_test_51J08tDJofjMgVsOdzxZs5Aqlf5A9riwPPwlxUTriC8YPiHvTjlCBoaMjgxiqdIVfvOMPcllgR9JY7EZlihr6TJHy00ixztHFtz');

        try {
            $direct_payment = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'usd',
                'customer' => $customer_id,
                'payment_method' => $payment_method_id,
                'off_session' => true,
                'confirm' => true,
            ]);

            $paymentDetails = $direct_payment->charges->jsonSerialize();

            $transaction_id = $paymentDetails['data'][0]['balance_transaction'];
            $customer = $paymentDetails['data'][0]['customer'];
            $payment_method = $paymentDetails['data'][0]['payment_method'];
            $payment_status = $paymentDetails['data'][0]['status'];
            $transaction_complete_details = json_encode($paymentDetails);


            Checkout::where('id', request('order_id'))->update(['transaction_id' => $transaction_id, 'customer' => $customer, 'payment_method' => $payment_method, 'payment_status' => $payment_status, 'transaction_complete_details' => $transaction_complete_details]);

            $data['id'] = request('order_id');
            $data['amount'] = request('amount');
            $data['transaction_id'] = $transaction_id;
            $data['payment_status'] = $payment_status;
            $data['customer'] = $customer;
            $data['payment_method'] = $payment_method;
            $data['transaction_complete_details'] = $transaction_complete_details;

            return $this->sendResponse($data, 'Payment done successfully.');
        } catch (\Stripe\Exception\CardException $e) {
            return $this->sendResponse($e->getError()->payment_intent->id, 'Error code is:' . $e->getError()->code);
            // $payment_intent_id = $e->getError()->payment_intent->id;
            //$payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        }
    }

    public function getSubscriptionByUser()
    {
        $subscription = Subscription::where('user_id', request('user_id'))->where('status', 'active')->orderBy('id', 'desc')->first();
        if (!empty($subscription)) {
            $product_id = explode(",", $subscription['product_id']);
            $productArray = [];
            foreach ($product_id as $key => $value) {
                $product = Product::find($value);
                array_push($productArray, $product);
            }
            $subscription['product'] = $productArray;
            return $this->sendResponse($subscription, 'subscription retrieve successfully.');
        } else {
            return $this->sendResponse([], 'subscription not found.');
        }
    }

    public function changeMyPlan(Request $request){
        
        $productsArr = [];
        $subscription = Subscription::where('user_id', request('user_id'))->where('status', 'active')->orderBy('id', 'desc')->first();
        if(!empty($subscription)){
            $product_id = explode(",", $subscription['product_id']);
            if(count($product_id)>0){
                foreach ($product_id as $pkey => $pvalue) {
                    $product = Product::find($pvalue);
                    $product['isAdded'] = true;
                    array_push($productsArr, $product);
                }
            }
        }

        $products = Product::where('category_id','6')->get();
        if(count($products)>0){
            foreach($products as $key => $value){
                $subscription = Subscription::where('user_id', request('user_id'))->where('status', 'active')->orderBy('id', 'desc')->first();
                $cnt = 0;
                if(!empty($subscription)){
                    $product_id = explode(",", $subscription['product_id']);
                    if(count($product_id)>0){
                        foreach ($product_id as $pkey => $pvalue) {
                            if($value->id == $pvalue){
                                $cnt++;
                            }
                        }
                    }
                }
                if($cnt == 0){
                    $products[$key]['isAdded'] = false;
                    array_push($productsArr, $products[$key]);
                }
                
            }
        }
                
            
        if (count($productsArr)>0) {
            return $this->sendResponse($productsArr, 'Records found');
        }else{
            return $this->sendResponse([], 'No records found');
        }
    }

    

    public function changePaymentMethod(Request $request)
    {
        $customer_id = request('customer');
        $number = request('number');
        $exp = explode("/",request('exp'));
        $cvc = request('cvc');

        
        	Stripe::setApiKey("sk_test_51J08tDJofjMgVsOdzxZs5Aqlf5A9riwPPwlxUTriC8YPiHvTjlCBoaMjgxiqdIVfvOMPcllgR9JY7EZlihr6TJHy00ixztHFtz");
        	try{
        		$create = \Stripe\PaymentMethod::create([
        			'type' => 'card',
        			'card' => [
        				'number' => $number,
        				'exp_month' => $exp[0],
        				'exp_year' => $exp[1],
        				'cvc' => $cvc
        			],
        		]);

        		$payment_method_id = $create->id;
        		$customer_id = $customer_id; //Take From Database
        
	            $payment_method = \Stripe\PaymentMethod::retrieve($payment_method_id);
	            $payment_method->attach(['customer' => $customer_id]);

	            \Stripe\Customer::update(
	                $customer_id,
	                ['invoice_settings' => ['default_payment_method' => $payment_method_id]]
	              );
        		return $this->sendResponse($create, 'success');
        	} catch (\Stripe\Exception\CardException $e) {
	            return $this->sendResponse($e, 'error');
	        }

    }
}
