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
use DB;
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

        echo "<pre>";
        print_r(request('stripeToken'));
        echo "<pre>";
        exit();

        if (empty(request()->get('stripeToken'))) {
            session()->flash('error', 'Some error while making the payment. Please try again');
            return back()->withInput();
        }
        Stripe::setApiKey("sk_test_51J08tDJofjMgVsOdzxZs5Aqlf5A9riwPPwlxUTriC8YPiHvTjlCBoaMjgxiqdIVfvOMPcllgR9JY7EZlihr6TJHy00ixztHFtz");
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
                    return redirect('/thankyou/?receipt_url=' . $paymentDetails['receipt_url']);
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
            $direct_payment = \Stripe\PaymentIntent::create([
                'amount' => 1099,
                'currency' => 'usd',
                'customer' => $customer_id,
                'payment_method' => $payment_method_id,
                'off_session' => true,
                'confirm' => true,
            ]);
            echo "<pre>";
            print_r($direct_payment);
            echo "<pre>";
            exit();
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

    public function card()
    {
        return view('payments.card');
    }

    public function card_update() {
        
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        if (empty(request()->get('paymentMethodId'))) {
            session()->flash('error', 'Some error while saving the card. Please try again');
            return back()->withInput();
        }

        $payment_method_id = request('paymentMethodId');
        $customer_id = "cus_JjcflGnrVfeUmz"; //Take From Database
        try {
            $payment_method = \Stripe\PaymentMethod::retrieve($payment_method_id);
            $payment_method->attach(['customer' => $customer_id]);

            \Stripe\Customer::update(
                $customer_id,
                ['invoice_settings' => ['default_payment_method' => $payment_method_id]]
              );

              session()->flash('error',"Card Updated Successfully");
              return back()->withInput();

        } catch (\Stripe\Exception\CardException $e) {
            session()->flash('error', $e->getError()->message);
            return back()->withInput();
        }

    }

    public function stripe_webhook()
    {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        $payload = @file_get_contents('php://input');
        $event = null;
        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'customer.subscription.updated':
                $paymentIntent = $event->data->object;
                
                
                $customer_id = $paymentIntent->customer;
                $subscription_id = $paymentIntent->id;
                $status = $paymentIntent->status;
                //$data_log = json_encode(["customer_id" =>$customer_id,"subscription_id" =>$subscription_id,"status" =>$status]);
                //DB::insert('insert into logs (type,data) values(?,?)',["customer.subscription.updated",$data_log]);

                if($status=="active") {
                    //update db entries based on $cutomer_id,$subscription_id
                }
                else if($status=="past_due")
                {
                    //Notify customer about faild transaction
                }
                
                break;
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }
}