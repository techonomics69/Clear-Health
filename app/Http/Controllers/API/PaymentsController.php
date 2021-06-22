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
        $amount     = (int)request('amount');
        $currency   = 'usd';

        if(empty(request('stripeToken'))) {
            return $this->sendResponse(back()->withInput(),'Some error while making the payment. Please try again');
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
                    Checkout::where('order_id',request('order_id'))->update(['transaction_id'=>$paymentDetails['balance_transaction'],'payment_status'=>$paymentDetails['status'],'transaction_complete_details'=>json_encode($paymentDetails)]);
                    $data['order_id']= request('order_id');
                    $data['amount']= request('amount');
                    $data['transaction_id'] = $paymentDetails['balance_transaction'];
                    $data['payment_status'] = $paymentDetails['status'];
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

   
}