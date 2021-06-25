<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;

use Exception;
//use App\Payment;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Customer;
use Illuminate\Http\Request;
use App\Models\Checkout;
use App\Models\Subscription;
use Carbon\Carbon;

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
        $amount     = (int)request('amount')*100;
        $currency   = 'USD';

        if(empty(request('stripeToken'))) {
            return $this->sendResponse(back()->withInput(),'Some error while making the payment. Please try again');
        }
        Stripe::setApiKey('sk_test_51J08tDJofjMgVsOdzxZs5Aqlf5A9riwPPwlxUTriC8YPiHvTjlCBoaMjgxiqdIVfvOMPcllgR9JY7EZlihr6TJHy00ixztHFtz');
        try {
            /** Add customer to stripe, Stripe customer */
            $customer = Customer::create([
                'email'     => request('email'),
                'source'    => request('stripeToken')
            ]);

            //Store customer id in DB for future transaction

        } catch (Exception $e) {
            $apiError = $e->getMessage();
        }

        if (empty($apiError) && $customer) {
            /** Charge a credit or a debit card */
            try {
                /** Stripe charge class */
                $charge = Charge::create(array(
                    'customer'      => $customer->id,
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
                    Checkout::where('order_id',request('order_id'))->update(['transaction_id'=>$paymentDetails['balance_transaction'],'customer'=>$paymentDetails['customer'],'payment_method'=>$paymentDetails['payment_method'],'payment_status'=>$paymentDetails['status'],'transaction_complete_details'=>json_encode($paymentDetails)]);

                    $data['order_id']= request('order_id');
                    $data['amount']= request('amount');
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

    public function subscribe_store()
    {
        request()->validate([
            'email' => 'required|email',
        ]);
       // Plan info 

        $plans = array( 
            '1' => array( 
                'name' => 'Weekly Subscription', 
                'price' => 25, 
                'interval' => 'week' 
            ), 
            '2' => array( 
                'name' => 'Monthly Subscription', 
                'price' => request('plan_price'), 
                'interval' => 'month' 
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
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        try {
            /** Add customer to stripe, Stripe customer */
            $customer = Customer::create([
                'email'     => request('email'),
                'source'    => request('stripeToken')
            ]);
        } catch (Exception $e) {
            $apiError = $e->getMessage();
        }

        if (empty($apiError) && $customer) {

            //Store customer id in DB for future transaction

            /** Charge a credit or a debit card */
            // Convert price to cents 
            $priceCents = round($planPrice*100); 

            // Create a plan 
            try { 
                $plan = \Stripe\Plan::create(array( 
                    "product" => [ 
                        "name" => $planName 
                    ], 
                    "amount" => $priceCents, 
                    "currency" => $currency, 
                    "interval" => $planInterval, 
                    "interval_count" => 2 
                )); 
            }catch(Exception $e) { 
                $apiError = $e->getMessage(); 
            }

            if (empty($apiError) && $plan) {
                try { 
                    $subscription = \Stripe\Subscription::create(array( 
                        "customer" => $customer->id, 
                        "items" => array( 
                            array( 
                                "plan" => $plan->id, 
                            ), 
                        ), 
                    )); 
                }catch(Exception $e) { 
                    $apiError = $e->getMessage(); 
                }
                if(empty($apiError) && $subscription){ 
                    // Retrieve charge details 
                    $subsData = $subscription->jsonSerialize();
                    if($subsData['status'] == 'active'){ 
                       // Subscription info 
                        $input_subscr = array();

                        $input_subscr['user_id'] = request('user_id');
                        $input_subscr['case_id'] = request('case_id');
                        $input_subscr['md_case_id'] = request('md_case_id');
                        $input_subscr['subscr_id'] = $subsData['id']; 
                        $input_subscr['product_id'] = request('product_id'); 
                        $input_subscr['customer'] = $subsData['customer'];
                        $input_subscr['plan_id'] = $subsData['plan']['id'];
                        $input_subscr['plan_amount'] = ($subsData['plan']['amount']/100);
                        $input_subscr['plan_currency'] = $subsData['plan']['currency'];
                        $input_subscr['plan_interval'] = $subsData['plan']['interval'];
                        $input_subscr['plan_interval_count'] =$subsData['plan']['interval_count'];
                        $input_subscr['created'] = date("Y-m-d H:i:s", $subsData['created']);
                        $input_subscr['current_period_start'] = date("Y-m-d H:i:s", $subsData['current_period_start']); 
                        $input_subscr['current_period_end'] = date("Y-m-d H:i:s", $subsData['current_period_end']); 
                        $input_subscr['subscribed_at'] = Carbon::now();
                        $input_subscr['status'] = $subsData['status'];

                        $add_subscr = Subscription:: create($input_subscr);

                        return $this->sendResponse($input_subscr, 'Subscription done successfully');
                    } else {
                        return $this->sendResponse(back()->withInput(), 'Subscription activation failed');
                    }
                }else{
                   return $this->sendResponse(back()->withInput(), 'Subscription creation failed! ' . $apiError);
               } 
           } else {
            return $this->sendResponse(back()->withInput(), 'Error in capturing amount: ' . $apiError);
        }
    } else {
       return $this->sendResponse(back()->withInput(), 'Invalid card details: ' . $apiError);
   }
}

    public function cancel_subscription() {
        $sub_id = request('subscr_id');
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $subscription = \Stripe\Subscription::retrieve($sub_id);
        $cancle = $subscription->cancel();

        if($cancle['status'] == 'canceled'){ 

            $subscription_status = Subscription::where('subscr_id',request('subscr_id'))->update(['status'=>'canceled']);

            if($subscription_status){
                return $this->sendResponse(array(), 'Subscription cancleded successfully.');
            }else{
                return $this->sendResponse(array(), 'Something went wrong.');
            }

        }else{
         return $this->sendResponse(back()->withInput(), 'Subscription creation failed! ');
     }

    }

    public function customer_payment_methods() {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $paymentDetails = \Stripe\PaymentMethod::all([
            'customer' => request('customer'),
            'type' => 'card',
        ]);
        return $this->sendResponse($paymentDetails,'Customer payment method received successfully ');
    }

    public function customer_make_direct_payment() {
        $customer_id = request('customer');
        $payment_method_id = request('payment_method');
        $amount = request('amount');

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

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

            
            Checkout::where('order_id',request('order_id'))->update(['transaction_id'=>$transaction_id,'customer'=>$customer,'payment_method'=>$payment_method,'payment_status'=>$payment_status,'transaction_complete_details'=>$transaction_complete_details]);

                    $data['order_id']= request('order_id');
                    $data['amount']= request('amount');
                    $data['transaction_id'] = $transaction_id;
                    $data['payment_status'] = $payment_status;
                    $data['customer'] = $customer; 
                    $data['payment_method'] = $payment_method;
                    $data['transaction_complete_details'] = $transaction_complete_details;

                    return $this->sendResponse($data, 'Payment done successfully.');
        } catch (\Stripe\Exception\CardException $e) {
               return $this->sendResponse($e->getError()->payment_intent->id, 'Error code is:'.$e->getError()->code);
           // $payment_intent_id = $e->getError()->payment_intent->id;
            //$payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        }

    }
}