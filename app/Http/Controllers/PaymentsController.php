<?php

/*

For Direct Payment Via Stripe

    /Clear-Health/payments

For Subscription

    /Clear-Health/subscribe

Get Customer Payment Methods

    /Clear-Health/customer_payment_methods

Get Direct Payment
 
    /Clear-Health/customer_make_direct_payment

For Cancel Subscription

    /Clear-Health/cancel_subscription

*/

namespace App\Http\Controllers;

use Exception;
use App\Payment;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Customer;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function create()
    {
        return view('payments.create');
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'terms_conditions' => 'accepted'
        ]);

        /** I have hard coded amount. You may fetch the amount based on customers order or anything */
        $amount     = 1 * 100;
        $currency   = 'usd';

       /* echo "<pre>";
        print_r(request('stripeToken'));
        echo "<pre>";
        exit();*/
        if (empty(request()->get('stripeToken'))) {
            session()->flash('error', 'Some error while making the payment. Please try again');
            return back()->withInput();
        }
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
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
                    'description'   => 'Some testing description'
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
                    //return redirect('/thankyou/?receipt_url=' . $paymentDetails['receipt_url']);
                } else {
                    session()->flash('error', 'Transaction failed');
                    return back()->withInput();
                }
            } else {
                session()->flash('error', 'Error in capturing amount: ' . $apiError);
                return back()->withInput();
            }
        } else {
            session()->flash('error', 'Invalid card details: ' . $apiError);
            return back()->withInput();
        }
    }

    public function subscribe()
    {
        return view('payments.subscribe');
    }

    public function subscribe_store()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'terms_conditions' => 'accepted'
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
                'price' => 85, 
                'interval' => 'month' 
            ), 
            '3' => array( 
                'name' => 'Yearly Subscription', 
                'price' => 950, 
                'interval' => 'year' 
            ) 
        ); 
        $planID = $_POST['subscr_plan']; 
        $planInfo = $plans[$planID]; 
        $planName = $planInfo['name']; 
        $planPrice = $planInfo['price']; 
        $planInterval = $planInfo['interval']; 

        $currency = "USD";  

        if (empty(request()->get('stripeToken'))) {
            session()->flash('error', 'Some error while making the payment. Please try again');
            return back()->withInput();
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
                    "interval_count" => 1 
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
                        $subscrID = $subsData['id']; 
                        $custID = $subsData['customer']; 
                        $planID = $subsData['plan']['id']; 
                        $planAmount = ($subsData['plan']['amount']/100); 
                        $planCurrency = $subsData['plan']['currency']; 
                        $planinterval = $subsData['plan']['interval']; 
                        $planIntervalCount = $subsData['plan']['interval_count']; 
                        $created = date("Y-m-d H:i:s", $subsData['created']); 
                        $current_period_start = date("Y-m-d H:i:s", $subsData['current_period_start']); 
                        $current_period_end = date("Y-m-d H:i:s", $subsData['current_period_end']); 
                        $status = $subsData['status'];
                        echo "<pre>";
                        print_r($subsData); exit;
                        //Store above details in DB

                       // return redirect('/subscribe_thankyou');
                    } else {
                        session()->flash('error', 'Subscription activation failed');
                        return back()->withInput();
                    }

                }else{
                    session()->flash('error', 'Subscription creation failed! ' . $apiError);
                    return back()->withInput();
                } 
            } else {
                session()->flash('error', 'Error in capturing amount: ' . $apiError);
                return back()->withInput();
            }
        } else {
            session()->flash('error', 'Invalid card details: ' . $apiError);
            return back()->withInput();
        }
    }

    public function thankyou()
    {
        return view('payments.thankyou');
    }

    public function subscribe_thankyou()
    {
        return view('payments.subscribe_thankyou');
    }

    public function customer_payment_methods() {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $paymentDetails = \Stripe\PaymentMethod::all([
        'customer' => 'cus_Jh5EsatVSsheJY',
        'type' => 'card',
        ]);
        echo "<pre>";
        print_r($paymentDetails);
    }

    public function customer_make_direct_payment() {
        $customer_id = 'cus_Jh5EsatVSsheJY';
        $payment_method_id = 'card_1J3h46JofjMgVsOdn9MBOGIm';

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            \Stripe\PaymentIntent::create([
                'amount' => 1099,
                'currency' => 'usd',
                'customer' => $customer_id,
                'payment_method' => $payment_method_id,
                'off_session' => true,
                'confirm' => true,
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            // Error code will be authentication_required if authentication is needed
            echo 'Error code is:' . $e->getError()->code;
            $payment_intent_id = $e->getError()->payment_intent->id;
            $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        }

    }

    public function cancel_subscription() {
        $sub_id = 'sub_JhQUwWwEfGdRc7';
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $subscription = \Stripe\Subscription::retrieve($sub_id);
        $subscription->cancel();

    }
}